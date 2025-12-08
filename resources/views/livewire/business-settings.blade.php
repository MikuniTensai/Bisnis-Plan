<div>
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">⚙️ Business Settings</h1>
                <p class="text-lg text-gray-600">Kelola modal awal dan pengaturan bisnis Anda</p>
            </div>
            <div class="flex items-center gap-4">
                <button wire:click="$set('showTipsModal', true)" class="bg-blue-50 hover:bg-blue-100 border-2 border-blue-200 rounded-xl px-4 py-3 transition-colors group">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-blue-600 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium text-blue-700">💡 Tips & Help</span>
                    </div>
                </button>
                <div class="bg-indigo-50 rounded-lg px-4 py-3">
                    <p class="text-sm text-indigo-600 font-medium">Status: Active</p>
                    <p class="text-xs text-indigo-500">Last updated: {{ now()->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-400 p-6 mb-8 rounded-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-green-800 font-medium">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
        <form wire:submit.prevent="save" class="divide-y divide-gray-100">
            <!-- Business Info Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-blue-100 rounded-full p-3 mr-4">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-blue-900">🏢 Informasi Bisnis</h3>
                        <p class="text-blue-600">Detail dasar perusahaan Anda</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-bold text-blue-900 mb-2">Nama Bisnis *</label>
                        <div class="relative">
                            <input wire:model="business_name" type="text" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white text-lg font-semibold">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                </svg>
                            </div>
                        </div>
                        @error('business_name') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-blue-900 mb-2">Tanggal Mulai Bisnis *</label>
                        <input wire:model="start_date" type="date" class="w-full px-4 py-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        @error('start_date') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                        <div class="mt-2 bg-blue-100 rounded-lg p-3">
                            <p class="text-sm text-blue-800 font-medium">🎂 Usia bisnis: {{ $settings ? $settings->getBusinessAgeInMonths() : 0 }} bulan</p>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg p-4 border-2 border-blue-200">
                        <h4 class="text-sm font-bold text-blue-900 mb-2">📊 Quick Stats</h4>
                        <div class="space-y-1">
                            <p class="text-xs text-blue-600">Business Age: {{ $settings ? $settings->getBusinessAgeInMonths() : 0 }} months</p>
                            <p class="text-xs text-blue-600">Status: {{ $settings ? 'Active' : 'New Setup' }}</p>
                            <p class="text-xs text-blue-600">Last Update: {{ now()->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal & Kas Section -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-green-100 rounded-full p-3 mr-4">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-green-900">💰 Modal & Kas</h3>
                        <p class="text-green-600">Kelola investasi dan cash flow bisnis</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl p-6 border-2 border-green-200 shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 rounded-full p-2 mr-3">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-green-900">Modal Awal *</h4>
                        </div>
                        <div class="relative mb-3">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-green-600 font-bold">Rp</span>
                            </div>
                            <input wire:model="initial_capital" type="number" step="0.01" class="w-full pl-12 pr-4 py-4 border-2 border-green-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-xl font-bold text-green-800">
                        </div>
                        @error('initial_capital') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                        <div class="bg-green-50 rounded-lg p-3">
                            <p class="text-sm text-green-700 font-medium">💡 Total modal yang diinvestasikan di awal bisnis</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-6 border-2 border-green-200 shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 rounded-full p-2 mr-3">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-green-900">Kas Saat Ini *</h4>
                        </div>
                        <div class="relative mb-3">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-green-600 font-bold">Rp</span>
                            </div>
                            <input wire:model="current_cash" type="number" step="0.01" class="w-full pl-12 pr-4 py-4 border-2 border-green-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white text-xl font-bold text-green-800">
                        </div>
                        @error('current_cash') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                        <div class="bg-green-50 rounded-lg p-3">
                            <p class="text-sm text-green-700 font-medium">💳 Saldo kas yang tersedia saat ini di rekening</p>
                        </div>
                    </div>
                </div>
                
                <!-- Cash Flow Indicator -->
                <div class="mt-6 bg-white rounded-xl p-6 border-2 border-green-200">
                    <h4 class="text-lg font-bold text-green-900 mb-4">📊 Cash Flow Overview</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center bg-green-50 rounded-lg p-4">
                            <p class="text-2xl font-bold text-green-600">{{ $settings && $settings->initial_capital ? 'Rp '.number_format($settings->initial_capital/1000000, 1).'M' : 'Rp 0' }}</p>
                            <p class="text-sm text-green-700 font-medium">Modal Awal</p>
                        </div>
                        <div class="text-center bg-blue-50 rounded-lg p-4">
                            <p class="text-2xl font-bold text-blue-600">{{ $settings && $settings->current_cash ? 'Rp '.number_format($settings->current_cash/1000000, 1).'M' : 'Rp 0' }}</p>
                            <p class="text-sm text-blue-700 font-medium">Kas Tersedia</p>
                        </div>
                        <div class="text-center bg-orange-50 rounded-lg p-4">
                            @if($settings && $settings->initial_capital > 0 && $settings->current_cash >= 0)
                                @php
                                    $usage = (($settings->initial_capital - $settings->current_cash) / $settings->initial_capital) * 100;
                                    $usage = max(0, min(100, $usage)); // Clamp between 0-100%
                                @endphp
                                <p class="text-2xl font-bold {{ $usage > 80 ? 'text-red-600' : ($usage > 60 ? 'text-orange-600' : 'text-green-600') }}">{{ number_format($usage, 1) }}%</p>
                            @else
                                <p class="text-2xl font-bold text-gray-400">0%</p>
                            @endif
                            <p class="text-sm text-orange-700 font-medium">Modal Terpakai</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Target & Reserve Section -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-8">
                <div class="flex items-center mb-6">
                    <div class="bg-purple-100 rounded-full p-3 mr-4">
                        <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-purple-900">🎯 Target & Reserve</h3>
                        <p class="text-purple-600">Tetapkan target bisnis dan strategi cash management</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Target Revenue -->
                    <div class="bg-white rounded-xl p-6 border-2 border-purple-200 shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 rounded-full p-2 mr-3">
                                <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-purple-900">Target Revenue Bulanan</h4>
                        </div>
                        <div class="relative mb-3">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-purple-600 font-bold">Rp</span>
                            </div>
                            <input wire:model="target_monthly_revenue" type="number" step="0.01" class="w-full pl-12 pr-4 py-4 border-2 border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white text-xl font-bold text-purple-800" placeholder="0">
                        </div>
                        <div class="bg-purple-50 rounded-lg p-3">
                            <p class="text-sm text-purple-700 font-medium">📈 Target pendapatan yang ingin dicapai per bulan</p>
                        </div>
                        @error('target_monthly_revenue') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                    </div>

                    <!-- Minimum Cash Reserve -->
                    <div class="bg-white rounded-xl p-6 border-2 border-purple-200 shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 rounded-full p-2 mr-3">
                                <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-purple-900">Minimum Kas Reserve</h4>
                        </div>
                        <div class="relative mb-3">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-purple-600 font-bold">Rp</span>
                            </div>
                            <input wire:model="minimum_cash_reserve" type="number" step="0.01" class="w-full pl-12 pr-4 py-4 border-2 border-purple-200 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white text-xl font-bold text-purple-800" placeholder="0">
                        </div>
                        <div class="bg-purple-50 rounded-lg p-3">
                            <p class="text-sm text-purple-700 font-medium">🛡️ Kas minimum yang harus dijaga untuk keamanan</p>
                        </div>
                        @error('minimum_cash_reserve') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Survival Cost Percentage -->
                    <div class="bg-white rounded-xl p-6 border-2 border-orange-200 shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-orange-100 rounded-full p-2 mr-3">
                                <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-orange-900">Survival Mode</h4>
                        </div>
                        <div class="relative mb-3">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-orange-600 font-bold">%</span>
                            </div>
                            <input wire:model="survival_cost_percentage" type="number" min="5" max="50" class="w-full pl-4 pr-12 py-4 border-2 border-orange-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white text-xl font-bold text-orange-800" placeholder="20">
                        </div>
                        <div class="bg-orange-50 rounded-lg p-3">
                            <p class="text-sm text-orange-700 font-medium">🔥 Minimal cost untuk survival (5-50%)</p>
                            <p class="text-xs text-orange-600 mt-1">Untuk runway calculation saat profit</p>
                        </div>
                        @error('survival_cost_percentage') <span class="text-red-500 text-sm font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Notes & Submit Section -->
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 p-8">
                <div class="max-w-3xl mx-auto space-y-6">
                    <!-- Notes -->
                    <div class="bg-white rounded-xl p-6 border-2 border-gray-200 shadow-lg">
                        <div class="flex items-center mb-4">
                            <div class="bg-gray-100 rounded-full p-2 mr-3">
                                <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900">📝 Catatan Bisnis</h4>
                        </div>
                        <textarea wire:model="notes" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" placeholder="Tambahkan catatan tentang bisnis, strategi, atau reminder penting..."></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center pt-4">
                        <button type="submit" class="group relative px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 font-semibold text-lg shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 min-w-[280px]">
                            <div class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-3 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Simpan Pengaturan Bisnis</span>
                            </div>
                            <div class="absolute inset-0 bg-white rounded-xl opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

    <!-- Tips & Help Modal -->
    @if($showTipsModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-8 py-6 flex items-center justify-between rounded-t-2xl">
                    <div class="flex items-center">
                        <div class="bg-blue-100 rounded-full p-3 mr-4">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">💡 Tips & Panduan Penggunaan</h3>
                    </div>
                    <button wire:click="$set('showTipsModal', false)" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Tips Penggunaan -->
                        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 border-2 border-blue-200">
                            <div class="flex items-center mb-6">
                                <div class="bg-blue-100 rounded-full p-3 mr-4">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-blue-900">💡 Tips Penggunaan</h4>
                            </div>
                            <div class="space-y-4">
                                <div class="bg-white rounded-lg p-4 border border-blue-200">
                                    <h5 class="font-bold text-blue-800 mb-2">💰 Modal Awal</h5>
                                    <p class="text-sm text-blue-700">Masukkan total investasi awal bisnis Anda. Angka ini akan menjadi baseline untuk analisis financial.</p>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-blue-200">
                                    <h5 class="font-bold text-blue-800 mb-2">💳 Kas Saat Ini</h5>
                                    <p class="text-sm text-blue-700">Update secara berkala sesuai saldo kas riil di rekening untuk akurasi perhitungan runway.</p>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-blue-200">
                                    <h5 class="font-bold text-blue-800 mb-2">🎯 Target Revenue</h5>
                                    <p class="text-sm text-blue-700">Tetapkan target bulanan untuk mengukur performa bisnis dan progress.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Perhitungan Otomatis -->
                        <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-6 border-2 border-orange-200">
                            <div class="flex items-center mb-6">
                                <div class="bg-orange-100 rounded-full p-3 mr-4">
                                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-orange-900">🧮 Perhitungan Otomatis</h4>
                            </div>
                            <div class="space-y-4">
                                <div class="bg-white rounded-lg p-4 border border-orange-200">
                                    <h5 class="font-bold text-orange-800 mb-2">🛣️ Runway</h5>
                                    <p class="text-sm text-orange-700">Sistem akan otomatis menghitung berapa lama bisnis bisa bertahan dengan kas saat ini berdasarkan burn rate.</p>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-orange-200">
                                    <h5 class="font-bold text-orange-800 mb-2">🔥 Burn Rate</h5>
                                    <p class="text-sm text-orange-700">Dihitung dari total pengeluaran - pendapatan per bulan untuk mengukur efisiensi operasional.</p>
                                </div>
                                <div class="bg-white rounded-lg p-4 border border-orange-200">
                                    <h5 class="font-bold text-orange-800 mb-2">🔥 Survival Mode</h5>
                                    <p class="text-sm text-orange-700">Persentase cost minimal yang dibutuhkan untuk survive tanpa revenue.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
