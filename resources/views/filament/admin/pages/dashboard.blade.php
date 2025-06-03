<x-filament::page>
    <div class="flex flex-col md:flex-row gap-6 mb-8">
        <div class="w-full md:w-2/3">
            <x-filament::section>
                <h2 class="text-lg font-semibold mb-2">Diagram Data MCS ROI</h2>
                <livewire:app.filament.admin.widgets.mcs-roi-chart />
            </x-filament::section>
        </div>
        <div class="w-full md:w-1/3 flex flex-col justify-center items-center bg-white rounded-xl shadow p-6">
            <h1 class="text-2xl font-bold mb-2">Halo Admin <span class="inline-block">👋</span></h1>
            <p class="text-gray-600">Selamat datang di dashboard admin.</p>
        </div>
    </div>
</x-filament::page>