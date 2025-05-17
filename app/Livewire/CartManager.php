<?php

namespace App\Livewire;

use App\Models\Product;
use App\ValueObjects\Money;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Component;

class CartManager extends Component
{
    //#[Session(key: 'cart')]
    public array $cart = [];
 
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



    public function render()
    {
        return view('livewire.cart-manager');
    }
}
