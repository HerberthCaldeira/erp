<div>
    <flux:modal.trigger name="cart-manager">
        <flux:button>{{ __('Cart') }}</flux:button>
    </flux:modal.trigger>

    <flux:modal name="cart-manager" class="min-w-[45rem] min-h-[45rem]">

     
            <flux:heading size="lg">{{ __('Cart') }}</flux:heading>
            <flux:subheading>{{ __('Items in cart') }}</flux:subheading>
            
            <div >
                @if(empty($cart))
                    <p>{{ __('Cart is empty') }}</p>
                @else
                <div>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Name') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Price') }}
                                </th>
                          
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Total') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Quantity') }}
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Actions') }}
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
                                        {{ $item['total_row'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $item['quantity'] }}
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
                                    {{ __('Freight') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ App\ValueObjects\Money::fromCents($this->freight)->formatted() }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="px-6 py-4 whitespace-nowrap">
                                    {{ __('Coupon') }}
                                </td>
                                <td colspan="2" class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex gap-2 ">
                                        <flux:input type="text" placeholder="Coupon code" wire:model="couponCode" class="w-full"/>
                                        <flux:button :disabled="$hasCoupon" wire:click="applyCoupon">{{ __('Apply') }}</flux:button> 
                                        <flux:button :disabled="!$hasCoupon" wire:click="removeCoupon">{{ __('Remove') }}</flux:button> 
                                    </div>
                                </td>
                                <td colspan="1" class="px-6 py-4 whitespace-nowrap">
                                    {{ $this->discount ? App\ValueObjects\Money::fromCents($this->discount)->formatted() : 'N/A' }}                                  
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="px-6 py-4 whitespace-nowrap">
                                    {{ __('Total') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ App\ValueObjects\Money::fromCents($this->total)->formatted() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr/>
                    
                    <div>

                        <form wire:submit="checkout" class="p-8 rounded-lg shadow-md" id="form-checkout">
                            <flux:input :label="__('Email')" type="email" placeholder="Email" wire:model="email" class="w-full"/>

                            <flux:input :label="__('Zipcode')" type="text" placeholder="Zipcode" wire:model.live="zipcode" class="w-full"/>
                            @if(! is_null($address))
                                <div>
                                    <p>
                                        {{ $address['estado'] }} | {{ $address['logradouro'] }} | {{ $address['bairro'] }} |
                                        {{ $address['localidade'] }} | {{ $address['uf'] }} | {{ $address['cep'] }}
                                    </p>
                                </div>
                            @endif

                            <flux:input :label="__('Number')" type="text" placeholder="Number" wire:model="addressNumber" class="w-full"/>
                            
                            <div class="flex justify-end mt-4">
                                <flux:button :disabled="!$address" form="form-checkout" type="submit">{{ __('Finalize') }}</flux:button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            
 

    </flux:modal>

</div>
