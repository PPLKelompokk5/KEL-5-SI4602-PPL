<x-filament::page>
    <div class="flex justify-end mb-6">
        <a href="/about" class="px-5 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition font-semibold flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
            About
        </a>
    </div>
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