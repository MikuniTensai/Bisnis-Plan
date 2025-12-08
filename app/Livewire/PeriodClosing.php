<?php

namespace App\Livewire;

use App\Models\PeriodClosing as PeriodClosingModel;
use App\Models\BusinessSetting;
use App\Models\Revenue;
use App\Models\Expense;
use App\Models\EmployeeSalary;
use Livewire\Component;

class PeriodClosing extends Component
{
    public $period_date;
    public $calculated_cash;
    public $confirmed_cash;
    public $notes;
    public $showConfirmModal = false;

    public function mount()
    {
        $this->period_date = now()->format('Y-m-d');
        
        // Calculate current cash using same logic as Dashboard
        $settings = BusinessSetting::getSettings();
        $latestClosing = PeriodClosingModel::getLatestConfirmed();
        
        if ($latestClosing) {
            // Ada closing, hitung dari closing terakhir + transaksi setelah closing
            $afterClosingRevenues = Revenue::where('status', 'received')
                ->where('date', '>', $latestClosing->period_date)
                ->sum('amount');
            $afterClosingExpenses = Expense::where('date', '>', $latestClosing->period_date)
                ->sum('amount');
            $afterClosingSalaries = EmployeeSalary::where('period', '>', $latestClosing->period_date)
                ->sum('total_salary');
            
            // Working Capital = Last Modal Inti + transaksi after closing
            $this->calculated_cash = $latestClosing->modal_inti + $afterClosingRevenues - $afterClosingExpenses - $afterClosingSalaries;
        } else {
            // Belum ada closing, hitung dari initial capital
            $totalRevenues = Revenue::where('status', 'received')->sum('amount');
            $totalExpenses = Expense::sum('amount');
            $totalSalaries = EmployeeSalary::sum('total_salary');
            
            $this->calculated_cash = $settings->initial_capital + $totalRevenues - $totalExpenses - $totalSalaries;
        }
        
        $this->confirmed_cash = $this->calculated_cash; // Default sama dengan calculated
    }

    public function showConfirm()
    {
        $this->validate([
            'period_date' => 'required|date',
            'confirmed_cash' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $this->showConfirmModal = true;
    }

    public function confirmClosing()
    {
        // Calculate totals
        $totalRevenues = Revenue::where('status', 'received')->sum('amount');
        $totalExpenses = Expense::sum('amount');
        $totalSalaries = EmployeeSalary::sum('total_salary');

        // Create period closing record
        PeriodClosingModel::create([
            'period_date' => $this->period_date,
            'calculated_cash' => $this->calculated_cash,
            'confirmed_cash' => $this->confirmed_cash,
            'modal_inti' => $this->confirmed_cash, // Modal inti = confirmed cash
            'total_revenue' => $totalRevenues,
            'total_expenses' => $totalExpenses,
            'total_salaries' => $totalSalaries,
            'notes' => $this->notes,
            'status' => 'confirmed',
            'confirmed_by' => null, // No user authentication in this demo
            'confirmed_at' => now(),
        ]);

        session()->flash('message', 'Period closing berhasil dikonfirmasi! Modal Inti telah di-update.');
        
        return redirect()->route('dashboard');
    }

    public function render()
    {
        $settings = BusinessSetting::getSettings();
        
        // Calculate breakdown
        $totalRevenues = Revenue::where('status', 'received')->sum('amount');
        $totalExpenses = Expense::sum('amount');
        $totalSalaries = EmployeeSalary::sum('total_salary');

        return view('livewire.period-closing', [
            'settings' => $settings,
            'totalRevenues' => $totalRevenues,
            'totalExpenses' => $totalExpenses,
            'totalSalaries' => $totalSalaries,
        ])->layout('components.layout', ['title' => 'Period Closing']);
    }
}
