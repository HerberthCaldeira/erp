<?php

namespace App\Livewire;

use App\Models\Product;
use App\ValueObjects\Money;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditProduct extends Component
{
    public ?Product $product = null;
    
    #[Validate(['required', 'string', 'max:255'])]
    public $name;

    #[Validate('required')]
    public string $price = '0,00';

    #[Validate('required|numeric')]
    public $quantity;

    #[Validate(['required', 'string', 'max:255'])]
    public $variations;

    #[On('edit-product')]
    public function open(int $id)
    {   
        $this->product = Product::findOrFail($id);

        $this->name = $this->product->name;
        $this->price = Money::formatString($this->product->price);
        $this->variations = $this->product->variations;
        $this->quantity = $this->product->stock->quantity;

        Flux::modal('edit-product')->show();
    }

    public function updatedPrice() {       
       $this->price = Money::formatString($this->price);
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            $this->product->update([
                'name' => $this->name,
                'price' => $this->price,
                'variations' => $this->variations
            ]);
            
            $this->product->stock()->update([
                'quantity' => $this->quantity
            ]);
        });

        $this->dispatch('alert', message: 'Produto atualizado com sucesso', type: 'success');

        $this->dispatch('ProductTable::refresh');
    }

    public function render()
    {
        return view('livewire.edit-product');
    }
}
