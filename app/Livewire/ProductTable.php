<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Component;

#[On('ProductTable::refresh')]
class ProductTable extends Component
{
    use WithPagination;
    public function render()
    {
        return view('livewire.product-table',[
            'products' => Product::with('stock')->paginate(10)
        ]);
    }
}
