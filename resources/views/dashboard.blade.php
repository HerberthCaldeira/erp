<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <livewire:create-product />
     
        <livewire:cart-manager />

        <livewire:product-table />
        <livewire:edit-product />


    </div>
</x-layouts.app>
