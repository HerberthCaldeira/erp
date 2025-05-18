<div>
  
    <form wire:submit="save" id="create-coupon" class=" p-8 rounded-lg shadow-md">

        <flux:select :label="__('Status do cupom')" wire:model="status">
            <flux:select.option value="enable" selected>{{ __('Active') }}</flux:select.option>
            <flux:select.option value="disable">{{ __('Inactive') }}</flux:select.option>
        </flux:select>

        <flux:input 
            :label="__('Coupon code')" 
            type="text"
            placeholder="Coupon code" 
            wire:model="code"
        />


        <flux:select :label="__('Coupon type')" wire:model="type">
            <flux:select.option value="fixed">{{ __('Fixed') }}</flux:select.option>
            <flux:select.option value="percent">{{ __('Percentage') }}</flux:select.option>
        </flux:select>

        <flux:input 
            :label="__('Coupon value')" 
            type="number" 
            placeholder="Coupon value" 
            wire:model.live="value"
        /> 

        <flux:input 
            :label="__('Start date')" 
            type="date" 
            placeholder="Start date" 
            wire:model="starts_at"            
        />

        <flux:input 
            :label="__('End date')" 
            type="date" 
            placeholder="End date" 
            wire:model="expires_at"
        />

        <flux:button type="submit" class="mt-4 w-full">{{ __('Create') }}</flux:button>
    </form>





</div>


