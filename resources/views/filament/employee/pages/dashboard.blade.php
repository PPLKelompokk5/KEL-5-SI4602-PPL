<x-filament::page>
    <h1 class="text-2xl font-bold mb-4">Halo Karyawan 👷</h1>
    <p class="mb-6 text-gray-600">Selamat bekerja! Ini dashboard khusus pegawai.</p>

    <h2 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2 text-center">Project Anda</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach ($counts as $label => $total)
            <div class="bg-white rounded-xl shadow p-6 border border-orange-100 text-center">
                <div class="text-sm text-gray-500 mb-1 font-medium uppercase">{{ $label }}</div>
                <div class="text-4xl font-bold text-orange-600">{{ $total }}</div>
            </div>
        @endforeach
    </div>
</x-filament::page>