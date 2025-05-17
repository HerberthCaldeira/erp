<div>
    <div class="flex justify-center items-center min-h-[calc(100vh-100px)]">
        <div class="w-full max-w-md space-y-4">
            <form wire:submit="save" id="create-product" class=" p-8 rounded-lg shadow-md">
                <flux:input :label="__('Nome do produto')" type="text" placeholder="Nome do produto" wire:model="name"/>

                <flux:input 
                    :label="__('Preço do produto')" 
                    type="text" 
                    placeholder="Preço do produto" 
                    wire:model.live="price"
                
                />
                <flux:input :label="__('Variações do produto')" type="text" placeholder="Variações do produto" wire:model="variations"/>
                <flux:input :label="__('Quantidade do produto')" type="number" placeholder="Quantidade do produto" wire:model="quantity"/>
                
                <flux:button type="submit" class="mt-4 w-full">{{ __('Criar') }}</flux:button>
            </form>
        </div>
    </div>
</div>
