<?php

namespace App\Livewire\Employees;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editMode = false;
    
    public $employeeId;
    public $name;
    public $email;
    public $phone;
    public $position;
    public $department;
    public $join_date;
    public $status = 'active';
    public $salary;
    public $salary_type = 'monthly';
    public $notes;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:20',
        'position' => 'required|string|max:255',
        'department' => 'nullable|string|max:255',
        'join_date' => 'required|date',
        'status' => 'required|in:active,inactive,resigned',
        'salary' => 'required|numeric|min:0',
        'salary_type' => 'required|in:monthly,daily,hourly',
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
        $this->showModal = true;
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $this->employeeId = $employee->id;
        $this->name = $employee->name;
        $this->email = $employee->email;
        $this->phone = $employee->phone;
        $this->position = $employee->position;
        $this->department = $employee->department;
        $this->join_date = $employee->join_date->format('Y-m-d');
        $this->status = $employee->status;
        $this->salary = $employee->salary;
        $this->salary_type = $employee->salary_type;
        $this->notes = $employee->notes;
        
        $this->editMode = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $employee = Employee::findOrFail($this->employeeId);
            $employee->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'position' => $this->position,
                'department' => $this->department,
                'join_date' => $this->join_date,
                'status' => $this->status,
                'salary' => $this->salary,
                'salary_type' => $this->salary_type,
                'notes' => $this->notes,
            ]);
            session()->flash('message', 'Karyawan berhasil diupdate.');
        } else {
            Employee::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'position' => $this->position,
                'department' => $this->department,
                'join_date' => $this->join_date,
                'status' => $this->status,
                'salary' => $this->salary,
                'salary_type' => $this->salary_type,
                'notes' => $this->notes,
            ]);
            session()->flash('message', 'Karyawan berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Employee::findOrFail($id)->delete();
        session()->flash('message', 'Karyawan berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->employeeId = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->position = '';
        $this->department = '';
        $this->join_date = '';
        $this->status = 'active';
        $this->salary = '';
        $this->salary_type = 'monthly';
        $this->notes = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        $employees = Employee::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('employee_number', 'like', '%' . $this->search . '%')
            ->orWhere('position', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.employees.index', [
            'employees' => $employees,
        ])->layout('components.layout', ['title' => 'Manajemen Karyawan']);
    }
}
