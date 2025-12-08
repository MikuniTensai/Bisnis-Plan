<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manajemen Pendapatan</h2>
            <p class="text-gray-600">Kelola pemasukan dan revenue bisnis</p>
        </div>
        <button wire:click="create" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
            + Tambah Pendapatan
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('message') }}</div>
    @endif

    <div class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4">
        <input wire:model.live="search" type="text" placeholder="Cari pendapatan..." 
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
        <select wire:model.live="filterMonth" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
            <option value="">Semua Bulan</option>
            @for($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
            @endfor
        </select>
        <select wire:model.live="filterYear" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
            <option value="">Semua Tahun</option>
            @for($y = now()->year; $y >= now()->year - 5; $y--)
                <option value="{{ $y }}">{{ $y }}</option>
            @endfor
        </select>
        <select wire:model.live="filterStatus" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="received">Received</option>
        </select>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Revenue</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sumber</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($revenues as $revenue)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $revenue->revenue_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $revenue->date->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $revenue->source }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $revenue->customer_name ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">Rp {{ number_format($revenue->amount, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $revenue->status === 'received' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($revenue->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="edit({{ $revenue->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <button wire:click="delete({{ $revenue->id }})" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data pendapatan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $revenues->links() }}</div>

    @if($showModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-2xl w-full max-h-screen overflow-y-auto">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $editMode ? 'Edit Pendapatan' : 'Tambah Pendapatan' }}</h3>
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tanggal *</label>
                            <input wire:model="date" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg" 
                                   placeholder="YYYY-MM-DD (contoh: 2026-01-15)"
                                   pattern="\d{4}-\d{2}-\d{2}"
                                   title="Format: YYYY-MM-DD">
                            @error('date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Format: YYYY-MM-DD. Contoh: 2026-01-15</p>
                            @if($editMode && $date)
                                <p class="text-xs text-blue-600 mt-1">Current: {{ $date }} | Mode: Edit</p>
                            @endif
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Sumber Pendapatan *</label>
                            <input wire:model="source" type="text" placeholder="Penjualan, Jasa, dll" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @error('source') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi *</label>
                            <input wire:model="description" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Jumlah *</label>
                            <input wire:model="amount" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Metode Pembayaran *</label>
                            <select wire:model="payment_method" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                                <option value="card">Card</option>
                            </select>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">No. Referensi/Invoice</label>
                            <input wire:model="reference_number" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama Customer</label>
                            <input wire:model="customer_name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select wire:model="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="pending">Pending</option>
                                <option value="received">Received</option>
                            </select>
                        </div>
                        <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <textarea wire:model="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">{{ $editMode ? 'Update' : 'Simpan' }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
