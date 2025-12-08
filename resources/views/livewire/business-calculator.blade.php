<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                Dashboard Perhitungan Umur Bisnis
            </h1>
            <p class="text-gray-600">Analisis finansial dan proyeksi operasional bisnis Anda</p>
        </div>

        <!-- Input Form Section -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-8 border border-indigo-100">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                </svg>
                Input Parameter
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Jumlah Karyawan -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Jumlah Karyawan</label>
                    <input type="number" wire:model.live="employees" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <!-- Gaji per Karyawan -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Gaji per Karyawan (Rp)</label>
                    <input type="number" wire:model.live="salaryPerEmployee" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <!-- Biaya Operasional -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Biaya Operasional Bulanan (Rp)</label>
                    <input type="number" wire:model.live="operationalCost" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <!-- Harga PC -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Harga PC per Orang (Rp)</label>
                    <input type="number" wire:model.live="pcPrice" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <!-- Modal Awal -->
                <div class="space-y-2 md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700">Modal Awal / Dana Tersedia (Rp)</label>
                    <input type="number" wire:model.live="initialCapital" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Biaya Bulanan -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold opacity-90">Total Biaya Bulanan</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">Rp {{ number_format($this->totalMonthlyExpenses, 0, ',', '.') }}</p>
                <p class="text-xs mt-2 opacity-75">Gaji + Operasional</p>
            </div>

            <!-- Total Biaya PC -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold opacity-90">Total Biaya PC</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">Rp {{ number_format($this->totalPcCost, 0, ',', '.') }}</p>
                <p class="text-xs mt-2 opacity-75">{{ $employees }} PC × Rp {{ number_format($pcPrice, 0, ',', '.') }}</p>
            </div>

            <!-- Sisa Modal -->
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold opacity-90">Sisa Modal</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">Rp {{ number_format($this->remainingCapital, 0, ',', '.') }}</p>
                <p class="text-xs mt-2 opacity-75">Setelah beli PC</p>
            </div>

            <!-- Estimasi Umur Bisnis -->
            <div class="bg-gradient-to-br from-{{ $this->riskLevel === 'red' ? 'red' : ($this->riskLevel === 'yellow' ? 'yellow' : 'green') }}-500 to-{{ $this->riskLevel === 'red' ? 'red' : ($this->riskLevel === 'yellow' ? 'yellow' : 'green') }}-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-sm font-semibold opacity-90">Estimasi Umur Bisnis</h3>
                    <svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-3xl font-bold">{{ $this->lifespanYears['years'] }} Tahun {{ $this->lifespanYears['months'] }} Bulan</p>
                <p class="text-xs mt-2 opacity-75">{{ $this->lifespanMonths }} bulan total</p>
            </div>
        </div>

        <!-- Risk Indicator -->
        <div class="mb-8">
            @if($this->riskLevel === 'red')
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <h4 class="text-red-800 font-bold">Peringatan: Risiko Tinggi!</h4>
                            <p class="text-red-700 text-sm">Umur bisnis kurang dari 2 tahun. Pertimbangkan untuk mengurangi biaya atau menambah modal.</p>
                        </div>
                    </div>
                </div>
            @elseif($this->riskLevel === 'yellow')
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-yellow-800 font-bold">Perhatian: Risiko Sedang</h4>
                            <p class="text-yellow-700 text-sm">Umur bisnis 2-5 tahun. Kondisi cukup stabil, namun tetap perlu monitoring.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-green-800 font-bold">Bagus: Risiko Rendah</h4>
                            <p class="text-green-700 text-sm">Umur bisnis lebih dari 5 tahun. Kondisi finansial sangat sehat!</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Burn Rate Chart -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-indigo-100">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                    Proyeksi Penurunan Modal
                </h3>
                <canvas id="burnRateChart" class="w-full" style="max-height: 300px;"></canvas>
            </div>

            <!-- Monthly Expenses Breakdown -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-indigo-100">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                    Breakdown Biaya Bulanan
                </h3>
                <canvas id="expensesChart" class="w-full" style="max-height: 300px;"></canvas>
            </div>
        </div>

        <!-- Detailed Breakdown Table -->
        <div class="mt-8 bg-white rounded-2xl shadow-xl p-6 border border-indigo-100">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Rincian Perhitungan</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-700">Total Gaji Bulanan</td>
                            <td class="px-6 py-4 text-sm text-right font-semibold text-gray-900">Rp {{ number_format($this->totalMonthlySalary, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-700">Biaya Operasional Bulanan</td>
                            <td class="px-6 py-4 text-sm text-right font-semibold text-gray-900">Rp {{ number_format($this->totalMonthlyOperational, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition bg-indigo-50">
                            <td class="px-6 py-4 text-sm font-bold text-gray-800">Total Biaya Bulanan</td>
                            <td class="px-6 py-4 text-sm text-right font-bold text-indigo-600">Rp {{ number_format($this->totalMonthlyExpenses, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-700">Total Biaya PC</td>
                            <td class="px-6 py-4 text-sm text-right font-semibold text-gray-900">Rp {{ number_format($this->totalPcCost, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition bg-purple-50">
                            <td class="px-6 py-4 text-sm font-bold text-gray-800">Sisa Dana Setelah Beli PC</td>
                            <td class="px-6 py-4 text-sm text-right font-bold text-purple-600">Rp {{ number_format($this->remainingCapital, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="hover:bg-gray-50 transition bg-gradient-to-r from-indigo-100 to-purple-100">
                            <td class="px-6 py-4 text-sm font-bold text-gray-800">Estimasi Umur Operasional</td>
                            <td class="px-6 py-4 text-sm text-right font-bold text-indigo-700">{{ $this->lifespanMonths }} bulan ({{ $this->lifespanYears['years'] }} tahun {{ $this->lifespanYears['months'] }} bulan)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            let burnRateChart, expensesChart;

            function updateCharts() {
                const burnRateData = @json($this->burnRateData);
                const totalSalary = {{ $this->totalMonthlySalary }};
                const totalOperational = {{ $this->totalMonthlyOperational }};

                // Burn Rate Chart
                const ctxBurn = document.getElementById('burnRateChart');
                if (burnRateChart) burnRateChart.destroy();
                
                burnRateChart = new Chart(ctxBurn, {
                    type: 'line',
                    data: {
                        labels: burnRateData.map(d => `Bulan ${d.month}`),
                        datasets: [{
                            label: 'Sisa Modal (Rp)',
                            data: burnRateData.map(d => d.capital),
                            borderColor: 'rgb(99, 102, 241)',
                            backgroundColor: 'rgba(99, 102, 241, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { display: true },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + (value / 1000000).toFixed(0) + 'jt';
                                    }
                                }
                            }
                        }
                    }
                });

                // Expenses Chart
                const ctxExpenses = document.getElementById('expensesChart');
                if (expensesChart) expensesChart.destroy();
                
                expensesChart = new Chart(ctxExpenses, {
                    type: 'doughnut',
                    data: {
                        labels: ['Gaji Karyawan', 'Biaya Operasional'],
                        datasets: [{
                            data: [totalSalary, totalOperational],
                            backgroundColor: [
                                'rgba(99, 102, 241, 0.8)',
                                'rgba(168, 85, 247, 0.8)'
                            ],
                            borderColor: [
                                'rgb(99, 102, 241)',
                                'rgb(168, 85, 247)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return context.label + ': Rp ' + context.parsed.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });
            }

            updateCharts();
            Livewire.on('updated', updateCharts);
        });
    </script>
</div>
