<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 -m-6 p-6" wire:loading.class="opacity-50 pointer-events-none">
    <!-- Loading Indicator -->
    <div wire:loading class="fixed top-20 right-8 bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-3">
        <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="font-medium">Memuat data...</span>
    </div>
    
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900 mb-1">{{ $settings->business_name }}</h1>
            <p class="text-lg text-gray-600">Usia Bisnis: <span class="font-semibold text-indigo-600">{{ $businessAge }} bulan</span> ({{ $businessAgeDays }} hari)</p>
        </div>
        <div class="flex items-center gap-4">
            <!-- Date Range Filter -->
            <div class="flex items-center gap-4">
                <!-- Start Date -->
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <label class="text-sm text-gray-600 mr-3">Dari:</label>
                    <select wire:model.live="startMonth" class="border-0 bg-transparent text-gray-900 font-medium focus:ring-0 cursor-pointer mr-2">
                        <option value="1">Jan</option>
                        <option value="2">Feb</option>
                        <option value="3">Mar</option>
                        <option value="4">Apr</option>
                        <option value="5">Mei</option>
                        <option value="6">Jun</option>
                        <option value="7">Jul</option>
                        <option value="8">Ags</option>
                        <option value="9">Sep</option>
                        <option value="10">Okt</option>
                        <option value="11">Nov</option>
                        <option value="12">Des</option>
                    </select>
                    <select wire:model.live="startYear" class="border-0 bg-transparent text-gray-900 font-medium focus:ring-0 cursor-pointer">
                        @for($y = now()->year + 2; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                
                <span class="text-gray-400">-</span>
                
                <!-- End Date -->
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <label class="text-sm text-gray-600 mr-3">Sampai:</label>
                    <select wire:model.live="endMonth" class="border-0 bg-transparent text-gray-900 font-medium focus:ring-0 cursor-pointer mr-2">
                        <option value="1">Jan</option>
                        <option value="2">Feb</option>
                        <option value="3">Mar</option>
                        <option value="4">Apr</option>
                        <option value="5">Mei</option>
                        <option value="6">Jun</option>
                        <option value="7">Jul</option>
                        <option value="8">Ags</option>
                        <option value="9">Sep</option>
                        <option value="10">Okt</option>
                        <option value="11">Nov</option>
                        <option value="12">Des</option>
                    </select>
                    <select wire:model.live="endYear" class="border-0 bg-transparent text-gray-900 font-medium focus:ring-0 cursor-pointer">
                        @for($y = now()->year + 2; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                
                <!-- Quick Presets -->
                <div class="bg-white px-4 py-3 rounded-lg shadow-sm border border-gray-200">
                    <label class="text-sm text-gray-600 mr-3">Preset:</label>
                    <select wire:model.live="preset" class="border-0 bg-transparent text-gray-900 font-medium focus:ring-0 cursor-pointer">
                        <option value="">Custom</option>
                        <option value="current_month">Bulan Ini</option>
                        <option value="last_month">Bulan Lalu</option>
                        <option value="last_3_months">3 Bulan Terakhir</option>
                        <option value="ytd">Year to Date</option>
                        <option value="last_year">Tahun Lalu</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="/settings" class="bg-white px-6 py-3 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-200 text-gray-700 font-medium">
                    ⚙️ Settings
                </a>
                <a href="/closing-reports" class="bg-green-600 hover:bg-green-700 px-6 py-3 rounded-lg shadow-sm text-white font-medium transition-colors">
                    📋 Closing History
                </a>
                <a href="/period-closing" class="bg-blue-600 hover:bg-blue-700 px-6 py-3 rounded-lg shadow-sm text-white font-medium transition-colors" title="Akses Period Closing kapan saja">
                    📊 Period Closing
                </a>
            </div>
        </div>
    </div>

    <!-- Period Closing Always Available -->
    <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-8 rounded-lg shadow-sm">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-4 flex-1">
                <h3 class="text-lg font-medium text-blue-800">📊 Period Closing Tersedia</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p class="mb-2">Working Capital saat ini: <strong>Rp {{ number_format($calculatedCash, 0, ',', '.') }}</strong></p>
                    @if($latestClosing)
                        <p class="mb-3">
                            Closing terakhir: {{ $latestClosing->period_date->format('d M Y') }} (Modal Inti: Rp {{ number_format($latestClosing->modal_inti, 0, ',', '.') }})<br>
                            Buat closing baru untuk periode apapun - Desember 2025, Januari 2026, Februari 2026, dll.
                        </p>
                    @else
                        <p class="mb-3">Belum ada period closing. Mulai dengan membuat closing pertama untuk mengunci Modal Inti.</p>
                    @endif
                    <a href="/period-closing" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        🚀 Buat Period Closing Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Modal Inti (Equity) -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 text-white transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <p class="text-purple-100 text-xs font-semibold uppercase tracking-wide">Modal Inti (Equity)</p>
                @if($latestClosing)
                    <span class="bg-green-400 text-green-900 text-xs px-2 py-1 rounded-full font-semibold">✓ Locked</span>
                @else
                    <span class="bg-blue-400 text-blue-900 text-xs px-2 py-1 rounded-full font-semibold">🏦 Static</span>
                @endif
            </div>
            <p class="text-4xl font-bold">Rp {{ number_format($modalInti / 1000000000, 2) }}M</p>
            @if($latestClosing)
                <p class="text-sm text-purple-100 mt-2 opacity-80">
                    Dikonfirmasi: {{ $latestClosing->confirmed_at->format('d M Y') }}
                </p>
            @else
                <p class="text-sm text-purple-100 mt-2 opacity-80">
                    Modal Awal (Belum Ada Closing)
                </p>
            @endif
        </div>

        <!-- Working Capital -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 text-white transform hover:-translate-y-1">
            <p class="text-blue-100 text-xs font-semibold uppercase tracking-wide mb-3">Working Capital</p>
            <p class="text-4xl font-bold">Rp {{ number_format($calculatedCash / 1000000000, 2) }}M</p>
            <p class="text-sm text-blue-100 mt-2 opacity-80">Dana Operasional Tersedia</p>
            @php
                $workingCapitalRatio = $settings->initial_capital > 0 ? ($calculatedCash / $settings->initial_capital) * 100 : 0;
            @endphp
            <div class="mt-3 flex items-center">
                <div class="flex-1 bg-blue-400 bg-opacity-30 rounded-full h-2">
                    <div class="bg-white rounded-full h-2" style="width: {{ min($workingCapitalRatio, 100) }}%"></div>
                </div>
                <span class="ml-3 text-sm font-semibold">{{ number_format($workingCapitalRatio, 1) }}%</span>
            </div>
        </div>

        <!-- Profit/Loss -->
        <div class="bg-gradient-to-br {{ $monthlyProfit >= 0 ? 'from-green-500 to-green-600' : 'from-red-500 to-red-600' }} rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 text-white transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-3">
                <p class="text-white text-opacity-90 text-xs font-semibold uppercase tracking-wide">
                    {{ $monthlyProfit >= 0 ? 'Profit' : 'Loss' }} 
                    @php
                        $months = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                        if ($startMonth == $endMonth && $startYear == $endYear) {
                            echo "({$months[$startMonth]} {$startYear})";
                        } else {
                            echo "({$months[$startMonth]} {$startYear} - {$months[$endMonth]} {$endYear})";
                        }
                    @endphp
                </p>
                <button wire:click="$set('showBepModal', true)" class="bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full px-3 py-1 text-[11px] font-medium flex items-center gap-1 transition-all">
                    <span>💡 BEP</span>
                </button>
            </div>
            <p class="text-4xl font-bold">{{ $monthlyProfit >= 0 ? '+' : '-' }}Rp {{ number_format(abs($monthlyProfit) / 1000000, 1) }}jt</p>
            <p class="text-sm text-white text-opacity-80 mt-2">Revenue - Expenses</p>
            <!-- Debug Info -->
            <div class="text-xs text-white text-opacity-60 mt-2 space-y-1">
                <p>Range: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
                <p>Salaries: Rp {{ number_format($monthlySalaries / 1000000, 1) }}M</p>
            </div>
        </div>

        <!-- Estimasi Umur Bisnis (Runway) -->
        <div class="bg-gradient-to-br {{ $burnRate > 0 ? 'from-orange-500 to-orange-600' : 'from-teal-500 to-teal-600' }} rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 p-8 text-white text-center transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <p class="text-white text-opacity-90 text-xs font-semibold uppercase tracking-wide">Runway (Umur Bisnis)</p>
                <button wire:click="$set('showRunwayModal', true)" class="bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full p-2 transition-all duration-200 group">
                    <svg class="h-4 w-4 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            @if($runwayMonths >= 12)
                <div class="flex items-baseline justify-center">
                    <p class="text-7xl font-bold leading-none">{{ round($runwayMonths / 12, 1) }}</p>
                    <p class="text-3xl font-semibold ml-2">thn</p>
                </div>
                <p class="text-sm text-white text-opacity-80 mt-3">({{ round($runwayMonths, 1) }} bulan)</p>
            @else
                <div class="flex items-baseline justify-center">
                    <p class="text-7xl font-bold leading-none">{{ round($runwayMonths, 1) }}</p>
                    <p class="text-3xl font-semibold ml-2">bln</p>
                </div>
                @if($runwayMonths < 1)
                    <p class="text-sm text-white text-opacity-80 mt-3">({{ round($runwayMonths * 30, 0) }} hari)</p>
                @endif
            @endif
            
            <div class="mt-4 text-xs text-white text-opacity-70 space-y-1">
                <p>Working Capital: Rp {{ number_format($calculatedCash/1000000, 1) }}M</p>
                @if($runwayScenario == 'loss')
                    <p>Monthly Loss: Rp {{ number_format($burnRate/1000000, 1) }}M</p>
                    <p class="text-red-200">📉 Loss Mode</p>
                @else
                    <p>Monthly Profit: Rp {{ number_format(abs($burnRate)/1000000, 1) }}M</p>
                    <p class="text-green-200">📈 Survival Mode Calculation</p>
                @endif
                @if($bepMonths && $bepMonths > 0)
                    <p class="text-[11px] text-white text-opacity-80 mt-1">BEP: {{ number_format($bepYears, 1) }} thn (~ {{ number_format($bepMonths, 1) }} bln)</p>
                @else
                    <p class="text-[11px] text-red-100 mt-1">BEP: belum bisa dihitung (profit rata-rata belum positif)</p>
                @endif
            </div>
        </div>
    </div>


    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Karyawan -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Karyawan</dt>
                        <dd class="text-2xl font-semibold text-gray-900">{{ $totalEmployees }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Total Asset -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Asset</dt>
                        <dd class="text-2xl font-semibold text-gray-900">Rp {{ number_format($totalAssets, 0, ',', '.') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Pengeluaran Bulan Ini -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Pengeluaran Bulan Ini</dt>
                        <dd class="text-2xl font-semibold text-gray-900">Rp {{ number_format($monthlyExpenses, 0, ',', '.') }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Revenue Bulan Ini -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Revenue Bulan Ini</dt>
                        <dd class="text-2xl font-semibold text-gray-900">Rp {{ number_format($monthlyRevenues, 0, ',', '.') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Cash Flow Summary -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">Cash Flow Bulan Ini</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="border-l-4 border-green-500 pl-4">
                <p class="text-sm text-gray-600">Total Pemasukan</p>
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($monthlyRevenues, 0, ',', '.') }}</p>
            </div>
            <div class="border-l-4 border-red-500 pl-4">
                <p class="text-sm text-gray-600">Total Pengeluaran</p>
                <p class="text-2xl font-bold text-red-600">Rp {{ number_format($monthlyExpenses, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">Operasional + Gaji</p>
            </div>
            <div class="border-l-4 {{ $monthlyProfit >= 0 ? 'border-blue-500' : 'border-orange-500' }} pl-4">
                <p class="text-sm text-gray-600">Net Cash Flow</p>
                <p class="text-2xl font-bold {{ $monthlyProfit >= 0 ? 'text-blue-600' : 'text-orange-600' }}">
                    {{ $monthlyProfit >= 0 ? '+' : '-' }}Rp {{ number_format(abs($monthlyProfit), 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Pengeluaran per Kategori -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Pengeluaran per Kategori (Bulan Ini)</h3>
            @if($expensesByCategory->count() > 0)
                <div class="space-y-3">
                    @foreach($expensesByCategory as $expense)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">{{ $expense->name }}</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($expense->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($expense->total / $monthlyExpenses) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada pengeluaran bulan ini</p>
            @endif
        </div>

        <!-- Pengeluaran Terbaru -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Pengeluaran Terbaru</h3>
            @if($recentExpenses->count() > 0)
                <div class="space-y-3">
                    @foreach($recentExpenses as $expense)
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $expense->description }}</p>
                                <p class="text-xs text-gray-500">{{ $expense->category->name }} • {{ $expense->date->format('d M Y') }}</p>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($expense->amount, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada pengeluaran</p>
            @endif
        </div>
    </div>

    <!-- Runway Calculation Modal -->
    @if($showRunwayModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-lg">
                    <h3 class="text-2xl font-bold text-gray-900">🧮 Detail Perhitungan Runway</h3>
                    <button wire:click="$set('showRunwayModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-6 space-y-8">
                    <!-- Scenario Explanation -->
                    @if($runwayScenario == 'loss')
                        <div class="bg-red-50 border-l-4 border-red-400 p-6 rounded-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-lg font-semibold text-red-800">📉 Loss Scenario</h4>
                                    <div class="mt-2 text-sm text-red-700 space-y-2">
                                        <p><strong>Situasi:</strong> Bisnis sedang mengalami kerugian setiap bulan.</p>
                                        <p><strong>Perhitungan:</strong> {{ $runwayCalculation }}</p>
                                        <p><strong>Artinya:</strong> Jika kondisi loss terus berlanjut tanpa perubahan, cash akan habis dalam <strong>{{ $runway }}</strong>.</p>
                                        <p class="font-semibold text-red-800">⚠️ Perlu aksi segera untuk mengurangi loss atau meningkatkan revenue!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-green-50 border-l-4 border-green-400 p-6 rounded-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-lg font-semibold text-green-800">📈 Profit Scenario (Worst-Case Analysis)</h4>
                                    <div class="mt-2 text-sm text-green-700 space-y-2">
                                        <p><strong>Situasi:</strong> Bisnis sedang profitable, tapi kita hitung worst-case scenario.</p>
                                        <div class="bg-white p-3 rounded border-l-2 border-green-300">
                                            @foreach(explode("\n", $runwayCalculation) as $line)
                                                @if(!empty(trim($line)))
                                                    <p>{{ $line }}</p>
                                                @endif
                                            @endforeach
                                        </div>
                                        <p><strong>Artinya:</strong> Jika revenue tiba-tiba turun ke 0 dan bisnis masuk survival mode, masih bisa bertahan <strong>{{ $runway }}</strong>.</p>
                                        <p class="font-semibold text-green-800">✅ Financial cushion yang baik untuk menghadapi krisis!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Current Status -->
                        <div class="bg-orange-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-orange-800 mb-4">🔢 Perhitungan Aktual</h4>
                            <div class="space-y-4">
                                <!-- Working Capital -->
                                <div class="bg-white rounded-lg p-4 border border-orange-200">
                                    <p class="text-sm text-orange-600 mb-1">Working Capital:</p>
                                    <p class="text-2xl font-bold text-orange-800">Rp {{ number_format($calculatedCash, 0, ',', '.') }}</p>
                                </div>
                                
                                <!-- Monthly Burn Rate -->
                                <div class="bg-white rounded-lg p-4 border border-orange-200">
                                    @php
                                        $months = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                                        $rangeLabel = ($startMonth == $endMonth && $startYear == $endYear) 
                                            ? "{$months[$startMonth]} {$startYear}" 
                                            : "{$months[$startMonth]} {$startYear} - {$months[$endMonth]} {$endYear}";
                                        $monthsDiff = ($endYear - $startYear) * 12 + ($endMonth - $startMonth) + 1;
                                    @endphp
                                    <p class="text-sm text-orange-600 mb-1">Rata-rata per Bulan ({{ $rangeLabel }}):</p>
                                    <p class="text-xs text-orange-500 mb-3 italic">*Berdasarkan total periode dibagi {{ $monthsDiff }} bulan</p>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span>Avg Expenses:</span>
                                            <span class="text-red-600">Rp {{ number_format($monthlyExpenses / $monthsDiff, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Avg Salaries:</span>
                                            <span class="text-red-600">Rp {{ number_format($monthlySalaries / $monthsDiff, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Avg Revenue:</span>
                                            <span class="text-green-600">Rp {{ number_format($monthlyRevenues / $monthsDiff, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="border-t pt-2 flex justify-between font-bold">
                                            <span>Avg Net Burn Rate:</span>
                                            <span class="text-orange-800">Rp {{ number_format(abs($burnRate / $monthsDiff), 0, ',', '.') }}/bulan</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Final Result -->
                                <div class="bg-gradient-to-r from-orange-100 to-red-100 rounded-lg p-4 border-2 border-orange-300">
                                    <p class="text-sm text-orange-700 mb-2">Hasil Perhitungan:</p>
                                    <div class="text-center">
                                        @if($burnRate > 0)
                                            @php
                                                $monthlyBurnRate = $burnRate / $monthsDiff;
                                                $runwayMonthsCalc = $calculatedCash / $monthlyBurnRate;
                                                $runwayYearsCalc = $runwayMonthsCalc / 12;
                                            @endphp
                                            <div class="text-sm text-orange-600 mb-1">
                                                {{ number_format($calculatedCash, 0, ',', '.') }} ÷ {{ number_format($monthlyBurnRate, 0, ',', '.') }} =
                                            </div>
                                            <div class="text-3xl font-bold text-orange-800">
                                                {{ number_format($runwayYearsCalc, 1) }} tahun
                                            </div>
                                            <div class="text-sm text-orange-600 mt-1">
                                                ({{ number_format($runwayMonthsCalc, 1) }} bulan)
                                            </div>
                                        @else
                                            <div class="text-3xl font-bold text-green-800">∞</div>
                                            <div class="text-sm text-green-600">Profitable!</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Interpretation -->
                    <div class="mt-8 bg-gray-50 rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-3">💡 Interpretasi Hasil</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                            <div class="text-center">
                                @if($runwayMonths && $runwayMonths >= 24)
                                    <div class="text-3xl mb-2">🟢</div>
                                    <p class="font-semibold text-green-700">SANGAT SEHAT</p>
                                    <p class="text-green-600">Runway > 2 tahun</p>
                                    <p class="text-gray-600 mt-1">Bisnis sangat stabil, bisa fokus growth</p>
                                @elseif($runwayMonths && $runwayMonths >= 12)
                                    <div class="text-3xl mb-2">🟡</div>
                                    <p class="font-semibold text-yellow-700">SEHAT</p>
                                    <p class="text-yellow-600">Runway 1-2 tahun</p>
                                    <p class="text-gray-600 mt-1">Kondisi baik, monitor terus</p>
                                @elseif($runwayMonths && $runwayMonths >= 6)
                                    <div class="text-3xl mb-2">🟠</div>
                                    <p class="font-semibold text-orange-700">WASPADA</p>
                                    <p class="text-orange-600">Runway 6-12 bulan</p>
                                    <p class="text-gray-600 mt-1">Mulai perlu strategi penghematan</p>
                                @else
                                    <div class="text-3xl mb-2">🔴</div>
                                    <p class="font-semibold text-red-700">BAHAYA</p>
                                    <p class="text-red-600">Runway < 6 bulan</p>
                                    <p class="text-gray-600 mt-1">Perlu aksi segera!</p>
                                @endif
                            </div>
                            
                            <div>
                                <p class="font-semibold text-gray-700 mb-2">📈 Cara Memperpanjang Runway:</p>
                                <ul class="text-gray-600 space-y-1">
                                    <li>• Tingkatkan revenue</li>
                                    <li>• Kurangi expenses tidak penting</li>
                                    <li>• Optimasi gaji & benefit</li>
                                    <li>• Cari investor baru</li>
                                    <li>• Diversifikasi income stream</li>
                                </ul>
                            </div>
                            
                            <div>
                                <p class="font-semibold text-gray-700 mb-2">⚠️ Red Flags:</p>
                                <ul class="text-gray-600 space-y-1">
                                    <li>• Runway < 12 bulan</li>
                                    <li>• Burn rate terus meningkat</li>
                                    <li>• Revenue stagnan</li>
                                    <li>• Cash flow negatif berturut-turut</li>
                                    <li>• Belum break-even setelah 2 tahun</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endif

    <!-- BEP (Break Even Point) Modal -->
    @if($showBepModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-lg">
                    <h3 class="text-2xl font-bold text-gray-900">📈 Detail Perhitungan BEP (Break Even Point)</h3>
                    <button wire:click="$set('showBepModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-6 space-y-6">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                        <h4 class="text-lg font-semibold text-blue-900 mb-1">🧠 Konsep BEP di Sistem Ini</h4>
                        <p class="text-sm text-blue-800">BEP di sini adalah <strong>waktu</strong> yang dibutuhkan sampai <strong>modal awal / modal inti kembali</strong>, berdasarkan <strong>profit rata-rata per bulan</strong> di periode yang Anda pilih.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <p class="text-xs text-gray-500 font-semibold uppercase mb-1">Modal Awal / Modal Inti</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($modalInti, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <p class="text-xs text-gray-500 font-semibold uppercase mb-1">Profit Rata-rata Per Bulan</p>
                            <p class="text-2xl font-bold {{ $averageMonthlyProfit > 0 ? 'text-green-700' : 'text-red-700' }}">Rp {{ number_format($averageMonthlyProfit, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">Berdasarkan {{ $monthsDiff }} bulan di range filter</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-800 mb-2">🔢 Rumus yang Dipakai</h4>
                        <div class="text-xs text-gray-800 bg-white rounded-md p-3 overflow-x-auto whitespace-pre-line">
BEP (bulan) = Modal Awal ÷ Profit Rata-rata Per Bulan

Modal Awal = Rp {{ number_format($modalInti, 0, ',', '.') }}
Profit Rata-rata = Rp {{ number_format($averageMonthlyProfit, 0, ',', '.') }}/bulan
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-4 border border-indigo-200">
                        <h4 class="text-sm font-semibold text-indigo-900 mb-2">📊 Hasil Perhitungan BEP</h4>
                        @if($bepMonths && $bepMonths > 0)
                            <div class="text-sm text-indigo-800 mb-3 space-y-1">
                                @foreach(explode("\n", $bepExplanation) as $line)
                                    @if(trim($line) !== '')
                                        <p>{{ $line }}</p>
                                    @endif
                                @endforeach
                            </div>
                            <div class="mt-2 flex items-baseline gap-2">
                                <p class="text-4xl font-bold text-indigo-900">{{ number_format($bepYears, 1) }}</p>
                                <p class="text-lg font-semibold text-indigo-700">tahun</p>
                                <p class="text-sm text-indigo-600">(~ {{ number_format($bepMonths, 1) }} bulan)</p>
                            </div>
                        @else
                            <p class="text-sm text-red-700">{{ $bepExplanation }}</p>
                        @endif
                    </div>

                    <!-- Comparison: Runway vs BEP -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h4 class="text-sm font-semibold text-gray-800 mb-3">📊 Perbandingan Runway vs BEP</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="bg-teal-50 rounded-md p-3 border border-teal-100">
                                <p class="text-xs font-semibold text-teal-700 uppercase mb-1">Runway (Worst-Case Profit Scenario)</p>
                                <p class="text-lg font-bold text-teal-900">{{ $runway }}</p>
                                <p class="text-xs text-teal-700 mt-1">Berapa lama bisnis bisa survive dengan kas sekarang jika masuk survival mode.</p>
                            </div>
                            <div class="bg-indigo-50 rounded-md p-3 border border-indigo-100">
                                <p class="text-xs font-semibold text-indigo-700 uppercase mb-1">BEP (Balik Modal)</p>
                                @if($bepMonths && $bepMonths > 0)
                                    <p class="text-lg font-bold text-indigo-900">{{ number_format($bepYears, 1) }} tahun (~ {{ number_format($bepMonths, 1) }} bulan)</p>
                                @else
                                    <p class="text-sm font-semibold text-red-700">Belum bisa dihitung (profit rata-rata belum positif).</p>
                                @endif
                                <p class="text-xs text-indigo-700 mt-1">Berapa lama sampai modal awal kembali dengan profit rata-rata sekarang.</p>
                            </div>
                        </div>

                        @if($bepMonths && $bepMonths > 0)
                            <div class="mt-3 text-xs text-gray-700">
                                @if($bepMonths < ($runwayMonths ?? $bepMonths))
                                    <p>✅ <strong>BEP lebih cepat</strong> daripada habisnya kas (runway). Artinya, jika tren profit bertahan, modal kembali sebelum kas habis.</p>
                                @else
                                    <p>⚠️ <strong>BEP lebih lama</strong> daripada runway. Artinya, jika tidak ada tambahan modal/investor, ada risiko kas habis sebelum modal kembali.</p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                        <h4 class="text-sm font-semibold text-yellow-900 mb-2">💡 Interpretasi Praktis</h4>
                        <ul class="text-xs text-yellow-800 space-y-1">
                            <li>• BEP &lt; 12 bulan → Sangat cepat, bisnis sangat menguntungkan.</li>
                            <li>• 12 &le; BEP &lt; 36 bulan → Masih wajar untuk banyak bisnis.</li>
                            <li>• BEP &ge; 36 bulan → Perlu review model bisnis & struktur biaya.</li>
                            <li>• Jika profit rata-rata masih negatif → Fokus perbaiki profit dulu sebelum mengejar BEP.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
