<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-3xl font-bold text-gray-900">Period Closing</h2>
        <p class="text-gray-600">Review dan konfirmasi kas untuk mengunci Modal Inti periode ini</p>
    </div>

    <!-- Step Indicator -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full text-sm font-medium">1</div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">Review Perhitungan</p>
                    <p class="text-xs text-gray-500">Cek kas yang dihitung sistem</p>
                </div>
            </div>
            <div class="hidden md:block w-16 border-t border-gray-300"></div>
            <div class="flex items-center">
                <div class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full text-sm font-medium">2</div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Konfirmasi</p>
                    <p class="text-xs text-gray-400">Sesuaikan dengan saldo bank</p>
                </div>
            </div>
            <div class="hidden md:block w-16 border-t border-gray-300"></div>
            <div class="flex items-center">
                <div class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full text-sm font-medium">3</div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Lock Modal Inti</p>
                    <p class="text-xs text-gray-400">Periode closing final</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Calculation Review -->
    <div class="bg-white rounded-lg shadow p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">📊 Review Perhitungan Kas</h3>
        
        <!-- Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Income -->
            <div class="bg-green-50 rounded-lg p-6">
                <h4 class="text-lg font-semibold text-green-800 mb-4 flex items-center">
                    <span class="bg-green-200 rounded-full p-2 mr-3">💰</span>
                    Cash In
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-green-700">Modal Awal</span>
                        <span class="font-semibold text-green-800">Rp {{ number_format($settings->initial_capital, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-green-700">Total Revenue</span>
                        <span class="font-semibold text-green-800">Rp {{ number_format($totalRevenues, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-green-200 pt-3">
                        <div class="flex justify-between text-lg font-bold">
                            <span class="text-green-800">Total Masuk</span>
                            <span class="text-green-800">Rp {{ number_format($settings->initial_capital + $totalRevenues, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expenses -->
            <div class="bg-red-50 rounded-lg p-6">
                <h4 class="text-lg font-semibold text-red-800 mb-4 flex items-center">
                    <span class="bg-red-200 rounded-full p-2 mr-3">💸</span>
                    Cash Out
                </h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-red-700">Total Expenses</span>
                        <span class="font-semibold text-red-800">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-red-700">Total Salaries</span>
                        <span class="font-semibold text-red-800">Rp {{ number_format($totalSalaries, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-red-200 pt-3">
                        <div class="flex justify-between text-lg font-bold">
                            <span class="text-red-800">Total Keluar</span>
                            <span class="text-red-800">Rp {{ number_format($totalExpenses + $totalSalaries, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calculated Result -->
        <div class="bg-indigo-50 rounded-lg p-6 border-l-4 border-indigo-500">
            <h4 class="text-xl font-bold text-indigo-900 mb-3">🧮 Kas Hasil Perhitungan Sistem</h4>
            <div class="text-4xl font-bold text-indigo-600 mb-2">
                Rp {{ number_format($calculated_cash, 0, ',', '.') }}
            </div>
            <p class="text-indigo-700 text-sm">
                Formula: Modal Awal + Revenue - Expenses - Salaries
            </p>
        </div>
    </div>

    <!-- Confirmation Form -->
    <div class="bg-white rounded-lg shadow p-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-6">✅ Konfirmasi Kas dengan Saldo Bank</h3>
        
        <form wire:submit.prevent="showConfirm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Closing</label>
                    <input wire:model="period_date" type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" 
                           placeholder="YYYY-MM-DD (contoh: 2026-02-28)"
                           pattern="\d{4}-\d{2}-\d{2}"
                           title="Format: YYYY-MM-DD">
                    @error('period_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-1">Format: YYYY-MM-DD. Contoh untuk Feb 2026: 2026-02-28</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kas Sesuai Saldo Bank *</label>
                    <input wire:model="confirmed_cash" type="number" step="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan saldo riil dari bank">
                    @error('confirmed_cash') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <!-- Selisih Alert -->
            @if($confirmed_cash != $calculated_cash)
                @php
                    $difference = $confirmed_cash - $calculated_cash;
                @endphp
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-yellow-800">Ditemukan Selisih!</h4>
                            <p class="text-sm text-yellow-700 mt-1">
                                Kas bank {{ $difference > 0 ? 'lebih besar' : 'lebih kecil' }} 
                                <strong>Rp {{ number_format(abs($difference), 0, ',', '.') }}</strong> 
                                dari perhitungan sistem.
                            </p>
                            <p class="text-xs text-yellow-600 mt-1">
                                Mohon pastikan angka sudah sesuai dengan rekening koran.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                <textarea wire:model="notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="Tambahkan catatan atau penjelasan selisih..."></textarea>
                @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="/" class="text-gray-600 hover:text-gray-800 flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Dashboard
                </a>
                <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                    Review & Konfirmasi →
                </button>
            </div>
        </form>
    </div>

    <!-- Confirmation Modal -->
    @if($showConfirmModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-lg w-full mx-4">
                <h3 class="text-xl font-bold text-gray-900 mb-4">🔒 Konfirmasi Period Closing</h3>
                <div class="mb-6 space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tanggal Closing:</span>
                        <span class="font-semibold">{{ \Carbon\Carbon::parse($period_date)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Kas Dikonfirmasi:</span>
                        <span class="font-semibold text-indigo-600">Rp {{ number_format($confirmed_cash, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Modal Inti akan menjadi:</span>
                        <span class="font-semibold text-purple-600">Rp {{ number_format($confirmed_cash, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-yellow-800">
                        <strong>⚠️ Peringatan:</strong> Setelah dikonfirmasi, Modal Inti akan di-lock dengan nilai ini. 
                        Pastikan semua data sudah benar sebelum melanjutkan.
                    </p>
                </div>

                <div class="flex justify-end space-x-3">
                    <button wire:click="$set('showConfirmModal', false)" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <button wire:click="confirmClosing" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">
                        🔒 Lock Modal Inti
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
