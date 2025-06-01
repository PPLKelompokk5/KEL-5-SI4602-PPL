<x-filament::page>
    <h1 class="text-2xl font-bold mb-4">Halo Karyawan 👷</h1>
    <p class="mb-6 text-gray-600">Selamat bekerja! Ini dashboard khusus pegawai.</p>

    {{-- PROJECT ANDA --}}
    <h2 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2 text-center">Project Anda</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-10">
        @foreach ($counts as $label => $total)
            <div class="bg-white rounded-xl shadow p-6 border border-orange-100 text-center">
                <div class="text-sm text-gray-500 mb-1 font-medium uppercase">{{ $label }}</div>
                <div class="text-4xl font-bold text-orange-600">{{ $total }}</div>
            </div>
        @endforeach
    </div>

    {{-- KPI AKTUAL --}}
    <h2 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2 text-center">KPI Aktual</h2>
    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Project</label>
            <select wire:model="selectedProject" class="w-full border-gray-300 rounded-md shadow-sm">
                <option value="">Semua Project</option>
                @foreach ($this->projects as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Bulan Tahun</label>
            <select wire:model="selectedMonth" class="w-full border-gray-300 rounded-md shadow-sm">
                <option value="all">Semua</option>
                @foreach ($this->availableMonths as $val => $label)
                    <option value="{{ $val }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- TOTAL SKOR --}}
    <div class="bg-orange-50 rounded-xl p-4 mb-6 shadow">
        <p class="text-sm text-gray-700">Total Skor:</p>
        <p class="text-2xl font-bold text-orange-600">{{ $this->totalScore }}</p>
    </div>

    {{-- KPI GRUP PER BULAN --}}
    @forelse ($this->kpiByMonth as $bulan => $items)
        <div class="bg-white rounded-xl p-4 mb-4 shadow border">
            <h3 class="text-md font-semibold text-gray-800 mb-2">{{ $bulan }}</h3>
            <ul class="list-disc pl-6 text-sm text-gray-700">
                @foreach ($items as $item)
                    <li>{{ $item->kpi->indikator }} - {{ $item->kpi->project_id }} - Nilai: {{ $item->nilai }} - Skor: {{ $item->skor }}</li>
                @endforeach
            </ul>
        </div>
    @empty
        <div class="bg-white rounded-xl p-4 mb-4 shadow border text-sm text-gray-600">
            Tidak ada data KPI Aktual.
        </div>
    @endforelse
</x-filament::page>