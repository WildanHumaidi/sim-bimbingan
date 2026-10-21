<x-admin-layout>
    <x-slot:title>{{ $title }}</x-slot>

    {{-- stat card --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <x-stat-card label="Jumlah Pengguna" :value="$statistik_pengguna['total']" color="text-indigo-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-users'>
                <path d='M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2' />
                <path d='M16 3.128a4 4 0 0 1 0 7.744' />
                <path d='M22 21v-2a4 4 0 0 0-3-3.87' />
                <circle cx='9' cy='7' r='4' />
            </svg>
        </x-stat-card>

        <x-stat-card label="Total Admin" :value="$statistik_pengguna['admin']" color="text-green-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-shield-check'>
                <path d='M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z' />
                <path d='m9 12 2 2 4-4' />
            </svg>
        </x-stat-card>

        <x-stat-card label="Total Mahasiswa" :value="$statistik_pengguna['mahasiswa']" color="text-yellow-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-graduation-cap'>
                <path d='M22 10s-6-5-10-5-10 5-10 5 6 5 10 5 10-5 10-5z' />
                <path d='M6 15v2a6 6 0 0 0 12 0v-2' />
            </svg>
        </x-stat-card>

        <x-stat-card label="Total Dosen" :value="$statistik_pengguna['dosen']" color="text-orange-600">
            <svg xmlns='http://www.w3.org/2000/svg' width='28' height='28' viewBox='0 0 24 24' fill='none'
                stroke='currentColor' stroke-width='1.714' stroke-linecap='round' stroke-linejoin='round'
                class='lucide lucide-book-open-check'>
                <path d='M8 3H2v16h6' />
                <path d='M16 3h6v16h-6' />
                <path d='M8 3h8v16H8' />
                <path d='m15 10-4 4-2-2' />
            </svg>
        </x-stat-card>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">

        {{-- Pie chart pengguna --}}
        <div class="md:col-span-1 bg-white p-5 rounded-2xl shadow" x-data="{
            chart: null,
            data: {{ json_encode($statistik_pengguna) }},
            renderChart() {
                const ctx = document.getElementById('pieChart').getContext('2d');
                this.chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Admin', 'Mahasiswa', 'Dosen'],
                        datasets: [{
                            data: [this.data.admin, this.data.mahasiswa, this.data.dosen],
                            backgroundColor: ['#34D399', '#FBBF24', '#FB923C'],
                            borderWidth: 1,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: false,
                        }
                    }
                });
            }
        }" x-init="renderChart">
            <h2 class="text-lg font-semibold mb-4">Statistik Pengguna</h2>

            <div class="w-full max-w-xs mx-auto">
                <canvas id="pieChart" class="!w-full !h-auto aspect-square"></canvas>
            </div>

            <div class="text-sm text-gray-600 space-y-1 mt-4 text-center">
                <div class="flex items-center justify-center gap-2">
                    <span class="inline-block w-3 h-3 rounded-sm bg-green-400"></span>
                    <span>Admin: <span class="font-semibold text-gray-800">{{ $statistik_pengguna['admin'] }}</span></span>
                </div>
                <div class="flex items-center justify-center gap-2">
                    <span class="inline-block w-3 h-3 rounded-sm bg-yellow-400"></span>
                    <span>Mahasiswa: <span class="font-semibold text-gray-800">{{ $statistik_pengguna['mahasiswa'] }}</span></span>
                </div>
                <div class="flex items-center justify-center gap-2">
                    <span class="inline-block w-3 h-3 rounded-sm bg-orange-400"></span>
                    <span>Dosen: <span class="font-semibold text-gray-800">{{ $statistik_pengguna['dosen'] }}</span></span>
                </div>
            </div>
        </div>

        {{-- Statistik Tambahan --}}
        <div class="md:col-span-3 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-lg font-semibold">Statistik Pengguna</h2>
            <div class="w-full h-80 relative">
                <canvas id="keuanganChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>

        <div class="md:col-span-2 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-sm font-medium text-gray-600">Permohonan Terbaru</h2>
            <p class="text-xl font-bold text-gray-800">128</p>
        </div>

        <div class="md:col-span-2 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-sm font-medium text-gray-600">Akun Pengguna Aktif</h2>
            <p class="text-xl font-bold text-green-600">{{ $statistik_pengguna['total'] }}</p>
        </div>

        <div class="md:col-span-1 bg-white p-5 rounded-2xl shadow">
            <h2 class="text-sm font-medium text-gray-600">Pengaduan Masuk</h2>
            <p class="text-xl font-bold text-orange-600">5</p>
        </div>
    </div>

    {{-- Chart Bar --}}
    <script>
        const ctx = document.getElementById('keuanganChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['2021', '2022', '2023', '2024'],
                datasets: [{
                        label: 'Pengguna Aktif',
                        data: [100, 300, 500, {{ $statistik_pengguna['total'] }}],
                        backgroundColor: '#60A5FA'
                    },
                    {
                        label: 'Admin',
                        data: [20, 50, 80, {{ $statistik_pengguna['admin'] }}],
                        backgroundColor: '#34D399'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pengguna'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y;
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-admin-layout>
