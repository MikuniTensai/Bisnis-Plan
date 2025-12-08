<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">📊 Laporan Period Closing</h1>
                <p class="text-gray-600 mt-1">Riwayat dan analisis closing per periode</p>
            </div>
            <div class="flex gap-3">
                <a href="/period-closing" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-white font-medium transition-colors">
                    ➕ New Closing
                </a>
                <a href="/dashboard" class="bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-lg text-white font-medium transition-colors">
                    ← Dashboard
                </a>
            </div>
        </div>

        <!-- Filter -->
        <div class="flex items-center gap-4">
            <div class="bg-gray-50 px-4 py-2 rounded-lg">
                <label class="text-sm text-gray-600 mr-3">Filter Tahun:</label>
                <select wire:model.live="year" class="border-0 bg-transparent text-gray-900 font-medium focus:ring-0 cursor-pointer">
                    <option value="">Semua Tahun</option>
                    @foreach($availableYears as $availableYear)
                        <option value="{{ $availableYear }}">{{ $availableYear }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    @if($summary['total_closings'] > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Closings -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Closing</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $summary['total_closings'] }} periode</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- First vs Latest Modal -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Modal Inti Terkini</dt>
                            <dd class="text-lg font-medium text-gray-900">Rp {{ number_format($summary['latest_closing']->modal_inti ?? 0, 0, ',', '.') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Total Growth -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 {{ $summary['total_growth'] >= 0 ? 'bg-emerald-500' : 'bg-red-500' }} rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Growth</dt>
                            <dd class="text-lg font-medium {{ $summary['total_growth'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $summary['total_growth'] >= 0 ? '+' : '' }}Rp {{ number_format(abs($summary['total_growth']), 0, ',', '.') }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Average Monthly Growth -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 {{ $summary['avg_monthly_growth'] >= 0 ? 'bg-teal-500' : 'bg-orange-500' }} rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Avg Monthly Growth</dt>
                            <dd class="text-lg font-medium {{ $summary['avg_monthly_growth'] >= 0 ? 'text-teal-600' : 'text-orange-600' }}">
                                {{ $summary['avg_monthly_growth'] >= 0 ? '+' : '' }}Rp {{ number_format(abs($summary['avg_monthly_growth']), 0, ',', '.') }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Closing History Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Riwayat Period Closing</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('period_date')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Periode
                            @if($sortBy === 'period_date')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @endif
                        </th>
                        <th wire:click="sortBy('modal_inti')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Modal Inti
                            @if($sortBy === 'modal_inti')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Growth
                        </th>
                        <th wire:click="sortBy('confirmed_cash')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            Confirmed Cash
                            @if($sortBy === 'confirmed_cash')
                                {{ $sortDirection === 'asc' ? '↑' : '↓' }}
                            @endif
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expenses</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salaries</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Profit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $previousModalInti = null; @endphp
                    @forelse($closings as $closing)
                        @php
                            $netProfit = $closing->total_revenue - $closing->total_expenses - $closing->total_salaries;
                            $growth = $previousModalInti ? $closing->modal_inti - $previousModalInti : 0;
                            $previousModalInti = $closing->modal_inti;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $closing->period_date->format('M Y') }}
                                <div class="text-xs text-gray-500">{{ $closing->period_date->format('d M Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                Rp {{ number_format($closing->modal_inti, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($growth != 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $growth >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $growth >= 0 ? '+' : '' }}{{ number_format($growth / 1000000, 1) }}M
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">First</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                Rp {{ number_format($closing->confirmed_cash, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">
                                +Rp {{ number_format($closing->total_revenue, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">
                                -Rp {{ number_format($closing->total_expenses, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-600">
                                -Rp {{ number_format($closing->total_salaries, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $netProfit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $netProfit >= 0 ? '+' : '' }}Rp {{ number_format($netProfit, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                {{ $closing->notes ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada period closing</h3>
                                    <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat period closing pertama.</p>
                                    <div class="mt-6">
                                        <a href="/period-closing" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                            ➕ Buat Period Closing
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($closings->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $closings->links() }}
            </div>
        @endif
    </div>
</div>
