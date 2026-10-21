<x-mhs-layout>
    <x-slot:title>{{ $title }}</x-slot>

    <div class="pt-24 pt-6">
        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 top-4 right-4 z-50">
            <x-stat-card label="Total Bimbingan" :value="$statistik['total']" color="text-blue-600">
                <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                    stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                    class='lucide lucide-book-open'>
                    <path d='M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z' />
                    <path d='M22 8v13a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V3' />
                    <path d='M18 8V3h-6a4 4 0 0 0-4 4v1' />
                </svg>
            </x-stat-card>

            <x-stat-card label="Bimbingan Bulan Ini" :value="$statistik['bulan_ini']" color="text-green-600">
                <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                    stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                    class='lucide lucide-calendar-check'>
                    <rect x='3' y='4' width='18' height='18' rx='2' ry='2' />
                    <line x1='16' y1='2' x2='16' y2='6' />
                    <line x1='8' y1='2' x2='8' y2='6' />
                    <line x1='3' y1='10' x2='21' y2='10' />
                    <path d='m9 16 2 2 4-4' />
                </svg>
            </x-stat-card>

            <x-stat-card label="Bimbingan Valid" :value="$statistik['valid']" color="text-emerald-600">
                <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                    stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                    class='lucide lucide-check-circle'>
                    <path d='M22 11.08V12a10 10 0 1 1-5.93-9.14' />
                    <path d='m9 11 3 3L22 4' />
                </svg>
            </x-stat-card>

            <x-stat-card label="Bimbingan Pending" :value="$statistik['pending']" color="text-orange-600">
                <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                    stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                    class='lucide lucide-clock'>
                    <circle cx='12' cy='12' r='10' />
                    <polyline points='12 6 12 12 16 14' />
                </svg>
            </x-stat-card>
        </div>

        {{-- Dashboard Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
            {{-- Pie Chart Status Bimbingan --}}
            <div class="bg-white p-6 rounded-2xl shadow" x-data="{
                chart: null,
                data: {{ json_encode($chartData) }},
                renderChart() {
                    const ctx = document.getElementById('statusPieChart').getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: this.data.labels,
                            datasets: [{
                                data: this.data.data,
                                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                                borderWidth: 2,
                                borderColor: '#ffffff'
                            }],
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }
            }" x-init="renderChart">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Status Bimbingan</h2>

                <div class="w-full max-w-xs mx-auto">
                    <canvas id="statusPieChart" class="!w-full !h-auto aspect-square"></canvas>
                </div>

                <div class="text-sm text-gray-600 space-y-2 mt-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-sm bg-green-500"></span>
                            <span>Valid</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $statistik['valid'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-sm bg-yellow-500"></span>
                            <span>Pending</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $statistik['pending'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-3 h-3 rounded-sm bg-red-500"></span>
                            <span>Invalid</span>
                        </div>
                        <span class="font-semibold text-gray-800">{{ $statistik['invalid'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Recent Bimbingan --}}
            <div class="bg-white p-6 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Bimbingan Terbaru</h2>
                @if($recentBimbingan->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentBimbingan as $bimbingan)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <h3 class="font-medium text-gray-800">{{ $bimbingan->dosen->nama }}</h3>
                                    <p class="text-sm text-gray-600">NIDN: {{ $bimbingan->nidn }}</p>
                                    <p class="text-xs text-gray-500">{{ $bimbingan->tanggal->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($bimbingan->status_validasi === 'valid') bg-green-100 text-green-800
                                        @elseif($bimbingan->status_validasi === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($bimbingan->status_validasi) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-4 text-gray-300">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                            <path d="M22 8v13a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V3"/>
                            <path d="M18 8V3h-6a4 4 0 0 0-4 4v1"/>
                        </svg>
                        <p>Belum ada data bimbingan</p>
                    </div>
                @endif
            </div>

            {{-- Statistik Bimbingan Per Bulan --}}
            <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow">
                <h2 class="text-lg font-semibold mb-4 text-gray-800">Statistik 12 Bulan Terakhir</h2>
                <div class="w-full h-80 relative">
                    <canvas id="monthlyChart" class="absolute inset-0 w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js Script --}}
    <script>
        // Monthly Bimbingan Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');

        const monthlyData = @json($bimbinganPerBulan);

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthlyData.map(item => item.month_short),
                datasets: [
                    {
                        label: 'Total Bimbingan',
                        data: monthlyData.map(item => item.total),
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3B82F6',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6
                    },
                    {
                        label: 'Valid',
                        data: monthlyData.map(item => item.valid),
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#10B981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#374151',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + ' bimbingan';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6B7280'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(107, 114, 128, 0.1)'
                        },
                        ticks: {
                            color: '#6B7280',
                            callback: function(value) {
                                return value + ' bimbingan';
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-mhs-layout>
