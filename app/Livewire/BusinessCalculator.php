<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class BusinessCalculator extends Component
{
    // Input properties with default values
    public $employees = 5;
    public $salaryPerEmployee = 4800000;
    public $operationalCost = 1500000;
    public $pcPrice = 20000000;
    public $initialCapital = 2000000000;

    // Computed: Total monthly salary
    #[Computed]
    public function totalMonthlySalary()
    {
        return $this->employees * $this->salaryPerEmployee;
    }

    // Computed: Total monthly operational cost
    #[Computed]
    public function totalMonthlyOperational()
    {
        return $this->operationalCost;
    }

    // Computed: Total monthly expenses
    #[Computed]
    public function totalMonthlyExpenses()
    {
        return $this->totalMonthlySalary + $this->totalMonthlyOperational;
    }

    // Computed: Total PC costs
    #[Computed]
    public function totalPcCost()
    {
        return $this->employees * $this->pcPrice;
    }

    // Computed: Remaining capital after PC purchase
    #[Computed]
    public function remainingCapital()
    {
        return $this->initialCapital - $this->totalPcCost;
    }

    // Computed: Business lifespan in months
    #[Computed]
    public function lifespanMonths()
    {
        if ($this->totalMonthlyExpenses <= 0) {
            return 0;
        }
        return floor($this->remainingCapital / $this->totalMonthlyExpenses);
    }

    // Computed: Business lifespan in years and months
    #[Computed]
    public function lifespanYears()
    {
        $totalMonths = $this->lifespanMonths;
        $years = floor($totalMonths / 12);
        $months = $totalMonths % 12;
        return ['years' => $years, 'months' => $months];
    }

    // Computed: Risk level (red/yellow/green)
    #[Computed]
    public function riskLevel()
    {
        $years = $this->lifespanYears['years'];
        
        if ($years < 2) {
            return 'red';
        } elseif ($years >= 2 && $years < 5) {
            return 'yellow';
        } else {
            return 'green';
        }
    }

    // Computed: Burn rate data for chart (monthly capital decrease)
    #[Computed]
    public function burnRateData()
    {
        $data = [];
        $capital = $this->remainingCapital;
        $months = min($this->lifespanMonths, 60); // Max 60 months for chart
        
        for ($i = 0; $i <= $months; $i++) {
            $data[] = [
                'month' => $i,
                'capital' => $capital
            ];
            $capital -= $this->totalMonthlyExpenses;
        }
        
        return $data;
    }

    public function render()
    {
        return view('livewire.business-calculator');
    }
}
