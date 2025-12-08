<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manajemen Asset</h2>
            <p class="text-gray-600">Kelola inventaris dan asset perusahaan</p>
        </div>
        <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium">
            + Tambah Asset
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('message') }}</div>
    @endif

    <div class="mb-4">
        <input wire:model.live="search" type="text" placeholder="Cari asset..." 
            class="w-full md:w-96 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Asset</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga/Unit</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kondisi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($assets as $asset)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $asset->asset_code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asset->category }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asset->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($asset->unit_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($asset->purchase_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $asset->condition === 'good' ? 'bg-green-100 text-green-800' : ($asset->condition === 'fair' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($asset->condition) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="edit({{ $asset->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <button wire:click="delete({{ $asset->id }})" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data asset</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $assets->links() }}</div>

    @if($showModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-2xl w-full max-h-screen overflow-y-auto">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $editMode ? 'Edit Asset' : 'Tambah Asset' }}</h3>
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label>
                            <input wire:model="name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                            <input wire:model="category" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembelian *</label>
                            <input wire:model="purchase_date" type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @error('purchase_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Jumlah *</label>
                            <input wire:model.live="quantity" type="number" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Harga per PC *</label>
                            <input wire:model.live="unit_price" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            @error('unit_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Total Harga *</label>
                            <input wire:model="purchase_price" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50" readonly>
                            @error('purchase_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Kondisi *</label>
                            <select wire:model="condition" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="good">Good</option>
                                <option value="fair">Fair</option>
                                <option value="poor">Poor</option>
                            </select>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                            <input wire:model="location" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Ditugaskan ke</label>
                            <select wire:model="assigned_to" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Depresiasi (%)</label>
                            <input wire:model="depreciation_rate" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <textarea wire:model="notes" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" wire:click="closeModal" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">{{ $editMode ? 'Update' : 'Simpan' }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
