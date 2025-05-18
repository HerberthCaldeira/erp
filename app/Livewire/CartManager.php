<?php

namespace App\Livewire;

use App\Jobs\SendOrderConfirmationEmail;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\ValueObjects\Address;
use App\ValueObjects\Money;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CartManager extends Component
{
    #[Session(key: 'cart')]
    public array $cart = [];

    public bool $hasCoupon = false;

    public string $couponCode = '';

    public int $discount = 0;

    #[Validate('required')]
    public string $zipcode = '';

    public ?array $address = null;

    #[Validate('required')]
    public string $addressNumber = '';

    #[Validate('required', 'email')]
    public string $email = '';
 
    public function mount()
    {
        $this->cart = session()->get('cart', []);
    }

    #[On('add-to-cart')]
    public function addToCart($productId)
    {     
        $item = array_filter($this->cart, fn($item) => $item['product_id'] === $productId);
    
        if($item) {        
            return;
        }   
        
        $product = Product::find($productId);

        $this->cart[] = [
            'product_id' => $productId,
            'name' => $product->name,
            'price' => $product->price->toCents(),
            'price_formatted' => Money::formatString($product->price),
            'total_row' => Money::formatString($product->price),
            'quantity' => 1
        ];

    }

    #[On('remove-from-cart')]
    public function removeFromCart($productId)
    {
        $this->cart = array_filter($this->cart, fn($item) => $item['product_id'] !== $productId);
    }

    #[On('increase-quantity')]
    public function increaseQuantity($productId)
    {
        $this->cart = array_map(fn($item) => $item['product_id'] === $productId ? [
            ...$item,
            'quantity' => $item['quantity'] + 1,
            'total_row' => Money::formatString( $item['price'] * ($item['quantity'] + 1))
        ] : $item, $this->cart);
    }

    #[On('decrease-quantity')]
    public function decreaseQuantity($productId)
    {
        $this->cart = array_map(fn($item) => $item['product_id'] === $productId && $item['quantity'] > 0 ? [
            ...$item,
            'quantity' => $item['quantity'] - 1,
            'total_row' => Money::formatString( $item['price'] * ($item['quantity'] - 1))
        ] : $item, $this->cart);
    }

    #[Computed()]
    public function subtotal()
    {
        return array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $this->cart));
    }

    #[Computed()]   
    public function freight()
    {   
        $subtotal = Money::fromCents($this->subtotal?? 0);
        $twoHundred = Money::fromCents(20000);
        $fiftyTwo = Money::fromCents(5200);
        $oneHundredSixtySix = Money::fromCents(16659);
        $fifteen = Money::fromCents(1500);
        $twenty = Money::fromCents(2000);


        if($subtotal->isLessThan($fiftyTwo)) {     
            return $twenty->toCents();
        }

        if(( $subtotal->isGreaterOrEqualsThan($fiftyTwo)) && $subtotal->isLessOrEqualsThan($oneHundredSixtySix)) {
            return $fifteen->toCents();
        }

        if($subtotal->isGreaterThan($oneHundredSixtySix) && $subtotal->isLessThan($twoHundred)) {
            return $twenty->toCents();
        } 
      
        if($subtotal->isGreaterThan($twoHundred)) {
            return 0;
        } 

        return $twenty->toCents();
    }

    #[Computed()]
    public function total()
    {
        return $this->subtotal() + $this->freight() - $this->discount;
    }

    public function applyCoupon()
    {
        $coupon = Coupon::where('code', $this->couponCode)->first();
        
        if(! $coupon instanceof Coupon) {
            $this->hasCoupon = false;
            $this->discount = 0;
            $this->couponCode = '';
            return;
        }

        $this->hasCoupon = true;

        if($coupon->type === 'percent') {
            $this->discount = ($this->subtotal() * $coupon->value) / 100;          
            return;
        }

        if($coupon->type === 'fixed') {
            $this->discount = Money::fromFloat($coupon->value)->toCents();
            return;
        }
    }

    public function removeCoupon()
    {
        $this->hasCoupon = false;
        $this->discount = 0;
        $this->couponCode = '';
    }

    public function updatedZipcode($value)
    {
        $response = Http::get("https://viacep.com.br/ws/{$value}/json/");

        if($response->successful()) {
            $this->address = $response->json();
            return;
        }

        $this->address = null;
    }

    public function checkout()
    {
        $this->validate();

        DB::transaction(function () {
            $order = Order::create([
                'status' => 'pending',
                'freight' => $this->freight(),
                'discount' => $this->discount,
                'total' => $this->total(),
                'email' => $this->email,
                'zipcode' => $this->zipcode,
                'address' => $this->address['logradouro'],
                'address_number' => $this->addressNumber,
                'address_complement' => $this->address['complemento'],
                'address_district' => $this->address['bairro'],
                'address_city' => $this->address['localidade'],
                'address_state' => $this->address['uf'],
            ]);

            foreach($this->cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            session()->forget('cart');
            $this->reset();

            Flux::modal('cart-manager')->close();

            SendOrderConfirmationEmail::dispatch($order);
            
        });
        
    }

    public function render()
    {
        return view('livewire.cart-manager');
    }
}
