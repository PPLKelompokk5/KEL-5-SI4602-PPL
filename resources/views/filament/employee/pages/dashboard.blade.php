<x-filament::page>
    <h1 class="text-2xl font-bold">
        Halo {{ auth('employee')->user()->name }} !
    </h1>
    <p>Selamat bekerja! Ini dashboard khusus pegawai.</p>
</x-filament::page>