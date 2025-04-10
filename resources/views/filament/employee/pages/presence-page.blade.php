<x-filament::page>
    <form wire:submit.prevent="absen" class="space-y-6">
        {{ $this->form }}

        <x-filament::button type="submit" color="success" class="w-full">
            Absen Sekarang
        </x-filament::button>
    </form>

    <div class="mt-8 w-full">
    <h3 class="text-lg font-bold mb-2">Riwayat Presensi Terbaru</h3>

    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Project</th>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->latestPresences as $presence)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $presence->project->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($presence->date)->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($presence->timestamp)->format('H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <div class="mt-4">
            {{ $this->latestPresences->links() }}
        </div>
    </div>
</x-filament::page>