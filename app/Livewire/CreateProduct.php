<?php

namespace App\Livewire;

use App\Models\Product;
use App\ValueObjects\Money;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateProduct extends Component
{ 
    #[Validate(['required', 'string', 'max:255'])]
    public $name;

    #[Validate('required')]
    public string $price = '0,00';

    #[Validate('required|numeric')]
    public $quantity;

    #[Validate(['required', 'string', 'max:255'])]
    public $variations;

    public function updatedPrice() {       
       $this->price = Money::formatString($this->price);
    }

    public function save()
    {
        $this->validate();
        DB::transaction(function () {
            $product = Product::create([
                'name' => $this->name,
                'price' => $this->price,
                'variations' => $this->variations
            ]);
            
            $product->stock()->create([
                'quantity' => $this->quantity
            ]);
        });

        $this->dispatch('alert', message: 'Produto criado com sucesso', type: 'success');
        $this->reset();
        $this->dispatch('ProductTable::refresh');
    }

    public function render()
    {
        return view('livewire.create-product');
    }
}
