<div>
  
    <form wire:submit="save" id="create-coupon" class=" p-8 rounded-lg shadow-md">

        <flux:select :label="__('Status do cupom')" wire:model="status">
            <flux:select.option value="enable" selected>{{ __('Ativo') }}</flux:select.option>
            <flux:select.option value="disable">{{ __('Inativo') }}</flux:select.option>
        </flux:select>

        <flux:input 
            :label="__('Código do cupom')" 
            type="text"
            placeholder="Código do cupom" 
            wire:model="code"
        />


        <flux:select :label="__('Tipo do cupom')" wire:model="type">
            <flux:select.option value="fixed">{{ __('Fixo') }}</flux:select.option>
            <flux:select.option value="percent">{{ __('Percentual') }}</flux:select.option>
        </flux:select>

        <flux:input 
            :label="__('Valor do cupom')" 
            type="number" 
            placeholder="Valor do cupom" 
            wire:model.live="value"
        /> 

        <flux:input 
            :label="__('Data de início')" 
            type="date" 
            placeholder="Data de início" 
            wire:model="starts_at"            
        />

        <flux:input 
            :label="__('Data de fim')" 
            type="date" 
            placeholder="Data de fim" 
            wire:model="expires_at"
        />

        <flux:button type="submit" class="mt-4 w-full">{{ __('Criar') }}</flux:button>
    </form>





</div>


