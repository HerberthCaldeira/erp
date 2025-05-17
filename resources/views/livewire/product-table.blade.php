<div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('ID') }}
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Name') }}
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Price') }}
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Variations') }}
                </th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Quantity') }}
                </th>
                  <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    {{ __('Actions') }}
                </th>
            </tr>
        </thead>
        <tbody class=" divide-y divide-gray-200">
            @foreach ($products as $product)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $product->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $product->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $product->price }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $product->variations }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $product->stock->quantity ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <flux:button 
                            wire:click="$dispatch('edit-product', { 'id': {{ $product->id }} })"
                            class="text-indigo-600 hover:text-indigo-900"
                        >
                            {{ __('Editar') }}
                        </flux:button>
                        <!---->
                        
                        <flux:button 
                            wire:click="$dispatch('add-to-cart', { 'productId': {{ $product->id }} })"
                            class="text-indigo-600 hover:text-indigo-900"
                        >
                            {{ __('Adicionar no carrinho') }}
                        </flux:button>
                        <!---->

                        <flux:button 
                            wire:click="$dispatch('remove-from-cart', { 'productId': {{ $product->id }} })"
                            class="text-indigo-600 hover:text-indigo-900"
                        >
                            {{ __('Remover do carrinho') }}
                        </flux:button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>