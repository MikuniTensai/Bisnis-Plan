<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Cash Flow Report</h2>
        <p class="text-gray-600">Laporan arus kas masuk dan keluar</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-1">Modal Awal</p>
            <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($settings->initial_capital, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-1">Kas Saat Ini</p>
            <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($settings->current_cash, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-1">Total Pemasukan</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-sm text-gray-600 mb-1">Total Pengeluaran</p>
            <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalCashOut, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Net Cash Flow -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Net Cash Flow Bulan Ini</h3>
                <p class="text-sm text-gray-500">{{ now()->format('F Y') }}</p>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold {{ $netCashFlow >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $netCashFlow >= 0 ? '+' : '-' }}Rp {{ number_format(abs($netCashFlow), 0, ',', '.') }}
                </p>
                <p class="text-sm text-gray-500">{{ $netCashFlow >= 0 ? 'Surplus' : 'Defisit' }}</p>
            </div>
        </div>
    </div>

    <!-- Monthly Trend -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Trend 6 Bulan Terakhir</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Bulan</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Pemasukan</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Pengeluaran</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-500">Net</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($monthlyData as $data)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $data['month'] }}</td>
                            <td class="px-4 py-3 text-sm text-right text-green-600">Rp {{ number_format($data['revenue'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-right text-red-600">Rp {{ number_format($data['expense'], 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-right font-semibold {{ $data['net'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $data['net'] >= 0 ? '+' : '-' }}Rp {{ number_format(abs($data['net']), 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Transactions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Cash In -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <span class="bg-green-100 text-green-600 rounded-full p-2 mr-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </span>
                Cash In (Pemasukan)
            </h3>
            <div class="space-y-3">
                @forelse($revenues as $revenue)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $revenue->source }}</p>
                            <p class="text-xs text-gray-500">{{ $revenue->date->format('d M Y') }} • {{ $revenue->revenue_number }}</p>
                        </div>
                        <span class="text-sm font-semibold text-green-600">+Rp {{ number_format($revenue->amount, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada pemasukan</p>
                @endforelse
                @if($revenues->count() > 0)
                    <div class="pt-3 border-t-2 border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-900">Total Pemasukan</span>
                            <span class="text-lg font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cash Out -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <span class="bg-red-100 text-red-600 rounded-full p-2 mr-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                    </svg>
                </span>
                Cash Out (Pengeluaran)
            </h3>
            <div class="space-y-3">
                <!-- Expenses -->
                @foreach($expenses as $expense)
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $expense->description }}</p>
                            <p class="text-xs text-gray-500">{{ $expense->date->format('d M Y') }} • {{ $expense->category->name }}</p>
                        </div>
                        <span class="text-sm font-semibold text-red-600">-Rp {{ number_format($expense->amount, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                
                <!-- Salaries -->
                @if($salaries->count() > 0)
                    <div class="bg-yellow-50 p-3 rounded">
                        <p class="text-sm font-medium text-gray-900 mb-2">Gaji Karyawan ({{ $salaries->count() }} orang)</p>
                        <span class="text-sm font-semibold text-red-600">-Rp {{ number_format($totalSalaries, 0, ',', '.') }}</span>
                    </div>
                @endif

                @if($expenses->count() > 0 || $salaries->count() > 0)
                    <div class="pt-3 border-t-2 border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-900">Total Pengeluaran</span>
                            <span class="text-lg font-bold text-red-600">Rp {{ number_format($totalCashOut, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Belum ada pengeluaran</p>
                @endif
            </div>
        </div>
    </div>
</div>
