<?php

namespace App\Livewire\Revenues;

use App\Models\Revenue;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $filterMonth = '';
    public $filterYear = '';
    public $showModal = false;
    public $editMode = false;
    
    public $revenueId;
    public $date;
    public $source;
    public $description;
    public $amount;
    public $payment_method = 'transfer';
    public $reference_number;
    public $customer_name;
    public $status = 'received';
    public $notes;

    protected $rules = [
        'date' => 'required|date|after_or_equal:2020-01-01|before_or_equal:2035-12-31',
        'source' => 'required|string|max:255',
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'payment_method' => 'required|in:cash,transfer,card',
        'reference_number' => 'nullable|string|max:255',
        'customer_name' => 'nullable|string|max:255',
        'status' => 'required|in:pending,received',
        'notes' => 'nullable|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        // Set default date to today
        $this->date = now()->format('Y-m-d');
        $this->showModal = true;
    }

    public function edit($id)
    {
        $revenue = Revenue::findOrFail($id);
        $this->revenueId = $revenue->id;
        $this->date = $revenue->date->format('Y-m-d');
        $this->source = $revenue->source;
        $this->description = $revenue->description;
        $this->amount = $revenue->amount;
        $this->payment_method = $revenue->payment_method;
        $this->reference_number = $revenue->reference_number;
        $this->customer_name = $revenue->customer_name;
        $this->status = $revenue->status;
        $this->notes = $revenue->notes;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'date' => $this->date,
            'source' => $this->source,
            'description' => $this->description,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'reference_number' => $this->reference_number,
            'customer_name' => $this->customer_name,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        if ($this->editMode) {
            Revenue::findOrFail($this->revenueId)->update($data);
            session()->flash('message', 'Pendapatan berhasil diupdate.');
        } else {
            Revenue::create($data);
            session()->flash('message', 'Pendapatan berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Revenue::findOrFail($id)->delete();
        session()->flash('message', 'Pendapatan berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->revenueId = null;
        $this->date = '';
        $this->source = '';
        $this->description = '';
        $this->amount = '';
        $this->payment_method = 'transfer';
        $this->reference_number = '';
        $this->customer_name = '';
        $this->status = 'received';
        $this->notes = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Revenue::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('revenue_number', 'like', '%' . $this->search . '%')
                  ->orWhere('source', 'like', '%' . $this->search . '%')
                  ->orWhere('customer_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterMonth) {
            $query->whereMonth('date', $this->filterMonth);
        }

        if ($this->filterYear) {
            $query->whereYear('date', $this->filterYear);
        }

        $revenues = $query->orderBy('date', 'desc')->paginate(10);

        return view('livewire.revenues.index', [
            'revenues' => $revenues,
        ])->layout('components.layout', ['title' => 'Manajemen Pendapatan']);
    }
}
