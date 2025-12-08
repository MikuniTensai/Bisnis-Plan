<?php

namespace App\Livewire\Expenses;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';
    public $selectedStatus = '';
    public $filterMonth = '';
    public $filterYear = '';
    public $showModal = false;
    public $editMode = false;
    
    public $expenseId;
    public $expense_category_id;
    public $date;
    public $description;
    public $amount;
    public $payment_method = 'cash';
    public $receipt_number;
    public $paid_to;
    public $status = 'pending';
    public $notes;

    protected $rules = [
        'expense_category_id' => 'required|exists:expense_categories,id',
        'date' => 'required|date|after_or_equal:2020-01-01|before_or_equal:2035-12-31',
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'payment_method' => 'required|in:cash,transfer,card',
        'receipt_number' => 'nullable|string|max:255',
        'paid_to' => 'nullable|string|max:255',
        'status' => 'required|in:pending,approved,rejected,paid',
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
        $expense = Expense::findOrFail($id);
        $this->expenseId = $expense->id;
        $this->expense_category_id = $expense->expense_category_id;
        $this->date = $expense->date->format('Y-m-d');
        $this->description = $expense->description;
        $this->amount = $expense->amount;
        $this->payment_method = $expense->payment_method;
        $this->receipt_number = $expense->receipt_number;
        $this->paid_to = $expense->paid_to;
        $this->status = $expense->status;
        $this->notes = $expense->notes;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'expense_category_id' => $this->expense_category_id,
            'date' => $this->date,
            'description' => $this->description,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'receipt_number' => $this->receipt_number,
            'paid_to' => $this->paid_to,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        if ($this->editMode) {
            Expense::findOrFail($this->expenseId)->update($data);
            session()->flash('message', 'Pengeluaran berhasil diupdate.');
        } else {
            Expense::create($data);
            session()->flash('message', 'Pengeluaran berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Expense::findOrFail($id)->delete();
        session()->flash('message', 'Pengeluaran berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->expenseId = null;
        $this->expense_category_id = '';
        $this->date = '';
        $this->description = '';
        $this->amount = '';
        $this->payment_method = 'cash';
        $this->receipt_number = '';
        $this->paid_to = '';
        $this->status = 'pending';
        $this->notes = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Expense::with('category');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('expense_number', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('paid_to', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedCategory) {
            $query->where('expense_category_id', $this->selectedCategory);
        }

        if ($this->selectedStatus) {
            $query->where('status', $this->selectedStatus);
        }

        if ($this->filterMonth) {
            $query->whereMonth('date', $this->filterMonth);
        }

        if ($this->filterYear) {
            $query->whereYear('date', $this->filterYear);
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(10);
        $categories = ExpenseCategory::where('is_active', true)->get();

        return view('livewire.expenses.index', [
            'expenses' => $expenses,
            'categories' => $categories,
        ])->layout('components.layout', ['title' => 'Manajemen Pengeluaran']);
    }
}
