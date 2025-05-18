<div>

    <flux:modal.trigger name="create-product">
        <flux:button>{{ __('Create product') }}</flux:button>
    </flux:modal.trigger>

    <flux:modal name="create-product" class="md:w-96">
        <form wire:submit="save" id="create-product" class=" p-8 rounded-lg shadow-md">
            <flux:input :label="__('Product name')" type="text" placeholder="Product name" wire:model="name"/>

            <flux:input 
                :label="__('Product price')" 
                type="text" 
                placeholder="Product price" 
                wire:model.live="price"
            />
            <flux:input :label="__('Product variations')" type="text" placeholder="Product variations" wire:model="variations"/>
            <flux:input :label="__('Product quantity')" type="number" placeholder="Product quantity" wire:model="quantity"/>
                
            <flux:button type="submit" class="mt-4 w-full">{{ __('Create product') }}</flux:button>
        </form>

    </flux:modal>



</div>


