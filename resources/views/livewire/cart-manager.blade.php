<div>
    <flux:modal.trigger name="cart-manager">
        <flux:button>{{ __('Carrinho') }}</flux:button>
    </flux:modal.trigger>

    <flux:modal name="cart-manager" class="min-w-[45rem] min-h-[45rem]">

     
            <flux:heading size="lg">{{ __('Carrinho') }}</flux:heading>
            <flux:subheading>{{ __('Itens no carrinho') }}</flux:subheading>
            
            <div >
                @if(empty($cart))
                    <p>{{ __('Carrinho vazio') }}</p>
                @else
                <div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Nome') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Preço') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Quantidade') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Total') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Ações') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($cart as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item['name'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item['price_formatted'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item['quantity'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item['total_row'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                        <flux:button size="xs" wire:click="increaseQuantity({{ $item['product_id'] }})">+</flux:button>
                                        <flux:button size="xs" wire:click="decreaseQuantity({{ $item['product_id'] }})">-</flux:button>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap">
                                    {{ __('Subtotal') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ App\ValueObjects\Money::fromCents($this->subtotal)->formatted() }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap">
                                    {{ __('Frete') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ App\ValueObjects\Money::fromCents($this->freight)->formatted() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
            
 

    </flux:modal>

</div>
