<?php

namespace App\Livewire\Salaries;

use App\Models\EmployeeSalary;
use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $showModal = false;
    public $editMode = false;
    
    public $salaryId;
    public $employee_id;
    public $period;
    public $basic_salary;
    public $allowances = 0;
    public $deductions = 0;
    public $overtime = 0;
    public $bonus = 0;
    public $payment_date;
    public $status = 'pending';
    public $notes;

    protected $rules = [
        'employee_id' => 'required|exists:employees,id',
        'period' => 'required|date_format:Y-m',
        'basic_salary' => 'required|numeric|min:0',
        'allowances' => 'nullable|numeric|min:0',
        'deductions' => 'nullable|numeric|min:0',
        'overtime' => 'nullable|numeric|min:0',
        'bonus' => 'nullable|numeric|min:0',
        'payment_date' => 'nullable|date',
        'status' => 'required|in:pending,paid',
        'notes' => 'nullable|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedEmployeeId($value)
    {
        // Auto-fill gaji pokok berdasarkan gaji terakhir karyawan
        if ($value && !$this->editMode) {
            $lastSalary = EmployeeSalary::where('employee_id', $value)
                ->orderBy('period', 'desc')
                ->first();
            
            if ($lastSalary) {
                // Ada gaji sebelumnya, copy semua komponen
                $this->basic_salary = $lastSalary->basic_salary;
                $this->allowances = $lastSalary->allowances;
                $this->overtime = $lastSalary->overtime;
                $this->bonus = $lastSalary->bonus;
                $this->deductions = $lastSalary->deductions;
            } else {
                // Belum ada gaji sebelumnya, reset ke default
                $this->basic_salary = 4800000; // Default 4.8jt untuk karyawan baru
                $this->allowances = 0;
                $this->overtime = 0;
                $this->bonus = 0;
                $this->deductions = 0;
            }
        }
    }

    public function create()
    {
        $this->resetForm();
        $this->editMode = false;
        // Set default periode ke bulan sekarang
        $this->period = now()->format('Y-m');
        $this->showModal = true;
    }

    public function edit($id)
    {
        $salary = EmployeeSalary::findOrFail($id);
        $this->salaryId = $salary->id;
        $this->employee_id = $salary->employee_id;
        $this->period = $salary->period->format('Y-m');
        $this->basic_salary = $salary->basic_salary;
        $this->allowances = $salary->allowances;
        $this->deductions = $salary->deductions;
        $this->overtime = $salary->overtime;
        $this->bonus = $salary->bonus;
        $this->payment_date = $salary->payment_date?->format('Y-m-d');
        $this->status = $salary->status;
        $this->notes = $salary->notes;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        // Convert month format (Y-m) to date (Y-m-01)
        $periodDate = $this->period . '-01';
        
        $data = [
            'employee_id' => $this->employee_id,
            'period' => $periodDate,
            'basic_salary' => $this->basic_salary,
            'allowances' => $this->allowances ?: 0,
            'deductions' => $this->deductions ?: 0,
            'overtime' => $this->overtime ?: 0,
            'bonus' => $this->bonus ?: 0,
            'payment_date' => $this->payment_date,
            'status' => $this->status,
            'notes' => $this->notes,
        ];

        if ($this->editMode) {
            EmployeeSalary::findOrFail($this->salaryId)->update($data);
            session()->flash('message', 'Gaji berhasil diupdate.');
        } else {
            EmployeeSalary::create($data);
            session()->flash('message', 'Gaji berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        EmployeeSalary::findOrFail($id)->delete();
        session()->flash('message', 'Gaji berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->salaryId = null;
        $this->employee_id = '';
        $this->period = '';
        $this->basic_salary = '';
        $this->allowances = 0;
        $this->deductions = 0;
        $this->overtime = 0;
        $this->bonus = 0;
        $this->payment_date = '';
        $this->status = 'pending';
        $this->notes = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = EmployeeSalary::with('employee');

        if ($this->search) {
            $query->whereHas('employee', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('employee_number', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $salaries = $query->orderBy('period', 'desc')->paginate(10);
        $employees = Employee::where('status', 'active')->get();

        return view('livewire.salaries.index', [
            'salaries' => $salaries,
            'employees' => $employees,
        ])->layout('components.layout', ['title' => 'Manajemen Gaji']);
    }
}
