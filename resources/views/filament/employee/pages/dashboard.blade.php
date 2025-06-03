<x-filament::page>
    <h1 class="text-2xl font-bold mb-4">Selamat Datang dan Selamat Berkerja</h1>

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

    {{-- KPI GRAFIK --}}
    <h2 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2 text-center">KPI Aktual (Grafik)</h2>

    <div class="bg-white rounded-xl shadow border p-6 mt-6">
        <canvas id="kpiChart" height="150"></canvas>
    </div>

    @once
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const ctx = document.getElementById("kpiChart").getContext("2d");

                    const chartData = @json($this->kpiChartData);

                    const data = {
                        labels: chartData.map(item => item.bulan),
                        datasets: [
                            {
                                label: "Mandays",
                                backgroundColor: "#34d399",
                                data: chartData.map(item => item.Mandays),
                            },
                            {
                                label: "Budget",
                                backgroundColor: "#f97316",
                                data: chartData.map(item => item.Budget),
                            },
                            {
                                label: "ROI",
                                backgroundColor: "#60a5fa",
                                data: chartData.map(item => item.ROI),
                            },
                        ]
                    };

                    new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Grafik KPI per Bulan (Gabungan Project)'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Skor'
                                    }
                                }
                            }
                        },
                    });
                });
            </script>
        @endpush
    @endonce
</x-filament::page>