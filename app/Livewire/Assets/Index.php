<?php

namespace App\Livewire\Assets;

use App\Models\Asset;
use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    
    public $assetId;
    public $name;
    public $category;
    public $purchase_date;
    public $purchase_price;
    public $quantity = 1;
    public $unit_price;
    public $depreciation_rate;
    public $current_value;
    public $condition = 'good';
    public $location;
    public $assigned_to;
    public $notes;

    protected $rules = [
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'purchase_date' => 'required|date',
        'purchase_price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:1',
        'unit_price' => 'required|numeric|min:0',
        'depreciation_rate' => 'nullable|numeric|min:0|max:100',
        'current_value' => 'nullable|numeric|min:0',
        'condition' => 'required|in:good,fair,poor',
        'location' => 'nullable|string|max:255',
        'assigned_to' => 'nullable|exists:employees,id',
        'notes' => 'nullable|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedQuantity()
    {
        if ($this->unit_price) {
            $this->purchase_price = $this->quantity * $this->unit_price;
        }
    }

    public function updatedUnitPrice()
    {
        if ($this->quantity) {
            $this->purchase_price = $this->quantity * $this->unit_price;
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        $this->assetId = $asset->id;
        $this->name = $asset->name;
        $this->category = $asset->category;
        $this->purchase_date = $asset->purchase_date->format('Y-m-d');
        $this->purchase_price = $asset->purchase_price;
        $this->quantity = $asset->quantity;
        $this->unit_price = $asset->unit_price;
        $this->depreciation_rate = $asset->depreciation_rate;
        $this->current_value = $asset->current_value;
        $this->condition = $asset->condition;
        $this->location = $asset->location;
        $this->assigned_to = $asset->assigned_to;
        $this->notes = $asset->notes;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'category' => $this->category,
            'purchase_date' => $this->purchase_date,
            'purchase_price' => $this->purchase_price,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'depreciation_rate' => $this->depreciation_rate,
            'current_value' => $this->current_value ?: $this->purchase_price,
            'condition' => $this->condition,
            'location' => $this->location,
            'assigned_to' => $this->assigned_to,
            'notes' => $this->notes,
        ];

        if ($this->editMode) {
            Asset::findOrFail($this->assetId)->update($data);
            session()->flash('message', 'Asset berhasil diupdate.');
        } else {
            Asset::create($data);
            session()->flash('message', 'Asset berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Asset::findOrFail($id)->delete();
        session()->flash('message', 'Asset berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->assetId = null;
        $this->name = '';
        $this->category = '';
        $this->purchase_date = '';
        $this->purchase_price = '';
        $this->quantity = 1;
        $this->unit_price = '';
        $this->depreciation_rate = '';
        $this->current_value = '';
        $this->condition = 'good';
        $this->location = '';
        $this->assigned_to = null;
        $this->notes = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        $assets = Asset::with('assignedEmployee')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('asset_code', 'like', '%' . $this->search . '%')
            ->orWhere('category', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $employees = Employee::where('status', 'active')->get();

        return view('livewire.assets.index', [
            'assets' => $assets,
            'employees' => $employees,
        ])->layout('components.layout', ['title' => 'Manajemen Asset']);
    }
}
