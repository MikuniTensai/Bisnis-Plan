<div>
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manajemen Gaji</h2>
            <p class="text-gray-600">Kelola pembayaran gaji karyawan</p>
        </div>
        <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium">
            + Tambah Gaji
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('message') }}</div>
    @endif

    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <input wire:model.live="search" type="text" placeholder="Cari karyawan..." 
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
        <select wire:model.live="filterStatus" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="paid">Paid</option>
        </select>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Karyawan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gaji Pokok</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tunjangan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Potongan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($salaries as $salary)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $salary->employee->name }}</div>
                            <div class="text-sm text-gray-500">{{ $salary->employee->employee_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $salary->period->format('M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($salary->basic_salary, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">+Rp {{ number_format($salary->allowances + $salary->overtime + $salary->bonus, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">-Rp {{ number_format($salary->deductions, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Rp {{ number_format($salary->total_salary, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $salary->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($salary->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="edit({{ $salary->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <button wire:click="delete({{ $salary->id }})" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 hover:text-red-900">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data gaji</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $salaries->links() }}</div>

    @if($showModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-2xl w-full max-h-screen overflow-y-auto">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $editMode ? 'Edit Gaji' : 'Tambah Gaji' }}</h3>
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Karyawan *</label>
                            <select wire:model.live="employee_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->employee_number }})</option>
                                @endforeach
                            </select>
                            @error('employee_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Periode *</label>
                            <input wire:model="period" type="month" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="YYYY-MM">
                            @error('period') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-500 mt-1">Pilih bulan dan tahun periode gaji</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Gaji Pokok *
                                @if($employee_id && $basic_salary && !$editMode)
                                    @if($basic_salary == 4800000)
                                        <span class="text-xs text-blue-600 font-normal">(Default untuk karyawan baru)</span>
                                    @else
                                        <span class="text-xs text-green-600 font-normal">(Auto-filled dari gaji terakhir)</span>
                                    @endif
                                @endif
                            </label>
                            <input wire:model="basic_salary" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg {{ $employee_id && $basic_salary && !$editMode ? ($basic_salary == 4800000 ? 'bg-blue-50 border-blue-300' : 'bg-green-50 border-green-300') : '' }}">
                            @error('basic_salary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tunjangan
                                @if($employee_id && $allowances > 0 && !$editMode)
                                    <span class="text-xs text-green-600 font-normal">(Auto-filled)</span>
                                @endif
                            </label>
                            <input wire:model="allowances" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg {{ $employee_id && $allowances > 0 && !$editMode ? 'bg-green-50 border-green-300' : '' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Lembur
                                @if($employee_id && $overtime > 0 && !$editMode)
                                    <span class="text-xs text-green-600 font-normal">(Auto-filled)</span>
                                @endif
                            </label>
                            <input wire:model="overtime" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg {{ $employee_id && $overtime > 0 && !$editMode ? 'bg-green-50 border-green-300' : '' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Bonus
                                @if($employee_id && $bonus > 0 && !$editMode)
                                    <span class="text-xs text-green-600 font-normal">(Auto-filled)</span>
                                @endif
                            </label>
                            <input wire:model="bonus" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg {{ $employee_id && $bonus > 0 && !$editMode ? 'bg-green-50 border-green-300' : '' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Potongan
                                @if($employee_id && $deductions > 0 && !$editMode)
                                    <span class="text-xs text-green-600 font-normal">(Auto-filled)</span>
                                @endif
                            </label>
                            <input wire:model="deductions" type="number" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg {{ $employee_id && $deductions > 0 && !$editMode ? 'bg-green-50 border-green-300' : '' }}">
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran</label>
                            <input wire:model="payment_date" type="date" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                        </div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">Status *</label>
                            <select wire:model="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                            </select>
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
