<?php

namespace App\Livewire;

use App\Models\Revenue;
use App\Models\Expense;
use App\Models\EmployeeSalary;
use App\Models\BusinessSetting;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CashFlow extends Component
{
    public $selectedMonth;
    public $selectedYear;

    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
    }

    public function render()
    {
        $settings = BusinessSetting::getSettings();
        
        // Get data for selected month
        $revenues = Revenue::whereMonth('date', $this->selectedMonth)
            ->whereYear('date', $this->selectedYear)
            ->where('status', 'received')
            ->orderBy('date', 'desc')
            ->get();
        
        $expenses = Expense::whereMonth('date', $this->selectedMonth)
            ->whereYear('date', $this->selectedYear)
            ->with('category')
            ->orderBy('date', 'desc')
            ->get();
        
        $salaries = EmployeeSalary::whereMonth('period', $this->selectedMonth)
            ->whereYear('period', $this->selectedYear)
            ->with('employee')
            ->get();

        // Calculate totals
        $totalRevenue = $revenues->sum('amount');
        $totalExpenses = $expenses->sum('amount');
        $totalSalaries = $salaries->sum('total_salary');
        $totalCashOut = $totalExpenses + $totalSalaries;
        $netCashFlow = $totalRevenue - $totalCashOut;

        // Get monthly data for last 6 months
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;
            
            $monthRevenue = Revenue::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->where('status', 'received')
                ->sum('amount');
            
            $monthExpense = Expense::whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount');
            
            $monthSalary = EmployeeSalary::whereMonth('period', $month)
                ->whereYear('period', $year)
                ->sum('total_salary');
            
            $monthlyData[] = [
                'month' => $date->format('M Y'),
                'revenue' => $monthRevenue,
                'expense' => $monthExpense + $monthSalary,
                'net' => $monthRevenue - ($monthExpense + $monthSalary),
            ];
        }

        return view('livewire.cash-flow', [
            'settings' => $settings,
            'revenues' => $revenues,
            'expenses' => $expenses,
            'salaries' => $salaries,
            'totalRevenue' => $totalRevenue,
            'totalExpenses' => $totalExpenses,
            'totalSalaries' => $totalSalaries,
            'totalCashOut' => $totalCashOut,
            'netCashFlow' => $netCashFlow,
            'monthlyData' => $monthlyData,
        ])->layout('components.layout', ['title' => 'Cash Flow Report']);
    }
}
