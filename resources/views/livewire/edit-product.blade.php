<div>

    <flux:modal name="edit-product" class="md:w-96">
        <form wire:submit="save" id="edit-product" class=" p-8 rounded-lg shadow-md">
            <flux:input :label="__('Nome do produto')" type="text" placeholder="Nome do produto" wire:model="name"/>

            <flux:input 
                :label="__('Preço do produto')" 
                type="text" 
                placeholder="Preço do produto" 
                wire:model.live="price"
            />
            <flux:input :label="__('Variações do produto')" type="text" placeholder="Variações do produto" wire:model="variations"/>
            <flux:input :label="__('Quantidade do produto')" type="number" placeholder="Quantidade do produto" wire:model="quantity"/>
                
            <flux:button type="submit" class="mt-4 w-full">{{ __('Atualizar') }}</flux:button>
        </form>

    </flux:modal>

</div>


