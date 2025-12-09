<?php

namespace App\Livewire;

use App\Models\Employee;
use App\Models\Asset;
use App\Models\Expense;
use App\Models\EmployeeSalary;
use App\Models\ExpenseCategory;
use App\Models\Revenue;
use App\Models\BusinessSetting;
use App\Models\PeriodClosing;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $startMonth;
    public $startYear;
    public $endMonth;
    public $endYear;
    public $preset = 'current_month';
    public $showRunwayModal = false;
    public $showBepModal = false;
    
    public function mount()
    {
        // Default to current month
        $this->startMonth = now()->month;
        $this->startYear = now()->year;
        $this->endMonth = now()->month;
        $this->endYear = now()->year;
    }

    public function updatedPreset()
    {
        if (!$this->preset) return;

        $now = now();
        
        switch($this->preset) {
            case 'current_month':
                $this->startMonth = $now->month;
                $this->startYear = $now->year;
                $this->endMonth = $now->month;
                $this->endYear = $now->year;
                break;
                
            case 'last_month':
                $lastMonth = $now->subMonth();
                $this->startMonth = $lastMonth->month;
                $this->startYear = $lastMonth->year;
                $this->endMonth = $lastMonth->month;
                $this->endYear = $lastMonth->year;
                break;
                
            case 'last_3_months':
                $start = $now->subMonths(2)->startOfMonth();
                $this->startMonth = $start->month;
                $this->startYear = $start->year;
                $this->endMonth = $now->month;
                $this->endYear = $now->year;
                break;
                
            case 'ytd':
                $this->startMonth = 1;
                $this->startYear = $now->year;
                $this->endMonth = $now->month;
                $this->endYear = $now->year;
                break;
                
            case 'last_year':
                $this->startMonth = 1;
                $this->startYear = $now->year - 1;
                $this->endMonth = 12;
                $this->endYear = $now->year - 1;
                break;
        }
    }
    
    public function render()
    {
        $settings = BusinessSetting::getSettings();
        
        // Calculate date range based on start and end month/year
        $startDate = Carbon::create($this->startYear, $this->startMonth, 1)->startOfMonth();
        $endDate = Carbon::create($this->endYear, $this->endMonth, 1)->endOfMonth();
        
        $totalEmployees = Employee::where('status', 'active')->count();
        $totalAssets = Asset::sum('current_value');
        
        // Period data based on filter
        $monthlyExpenses = Expense::whereBetween('date', [$startDate, $endDate])
            ->sum('amount');
        $monthlySalaries = EmployeeSalary::whereBetween('period', [$startDate, $endDate])
            ->sum('total_salary');
        $monthlyRevenues = Revenue::whereBetween('date', [$startDate, $endDate])
            ->where('status', 'received')
            ->sum('amount');

        // Check if there's a confirmed closing first
        $latestClosing = PeriodClosing::getLatestConfirmed();
        
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
            $calculatedCash = $latestClosing->modal_inti + $afterClosingRevenues - $afterClosingExpenses - $afterClosingSalaries;
            
            // Total all time (untuk statistik)
            $totalRevenues = Revenue::where('status', 'received')->sum('amount');
            $totalExpenses = Expense::sum('amount');
            $totalSalaries = EmployeeSalary::sum('total_salary');
        } else {
            // Belum ada closing, hitung dari initial capital
            $totalRevenues = Revenue::where('status', 'received')->sum('amount');
            $totalExpenses = Expense::sum('amount');
            $totalSalaries = EmployeeSalary::sum('total_salary');
            
            // Working Capital = Initial Capital + All revenues - All expenses - All salaries  
            $calculatedCash = $settings->initial_capital + $totalRevenues - $totalExpenses - $totalSalaries;
        }
        
        // Modal Inti = TETAP initial_capital sampai ada closing yang dikonfirmasi
        if ($latestClosing) {
            // Ada closing yang dikonfirmasi, gunakan modal inti dari closing
            $modalInti = $latestClosing->modal_inti;
            $confirmedCash = $latestClosing->confirmed_cash;
        } else {
            // Belum ada closing yang dikonfirmasi, Modal Inti = initial_capital (TETAP)
            $modalInti = $settings->initial_capital;
            $confirmedCash = null;
        }
        
        // Check if there's pending closing
        $hasPendingClosing = PeriodClosing::hasPendingClosing();

        // Financial calculations for period
        $totalMonthlyExpenses = $monthlyExpenses + $monthlySalaries;
        $monthlyProfit = $monthlyRevenues - $totalMonthlyExpenses;
        $burnRate = $totalMonthlyExpenses - $monthlyRevenues; // Negative if profitable

        // Hitung jumlah bulan dalam range untuk rata-rata & BEP
        $monthsDiff = ($this->endYear - $this->startYear) * 12 + ($this->endMonth - $this->startMonth) + 1;
        if ($monthsDiff <= 0) {
            $monthsDiff = 1;
        }
        
        // Business sustainability - Detailed runway calculation
        $runway = null;
        $runwayMonths = null;
        $runwayScenario = '';
        $runwayCalculation = '';
        $minimalOperatingCost = 0;
        
        if ($burnRate > 0) {
            // LOSS SCENARIO: Bisnis rugi setiap bulan
            $runwayScenario = 'loss';
            $runwayMonths = $calculatedCash / $burnRate;
            $runwayCalculation = "Working Capital ÷ Monthly Loss = Rp " . number_format($calculatedCash, 0, ',', '.') . " ÷ Rp " . number_format($burnRate, 0, ',', '.') . " = " . round($runwayMonths, 1) . " bulan";
        } else {
            // PROFIT SCENARIO: Bisnis profit, tapi hitung worst-case scenario
            $runwayScenario = 'profit';
            $currentMonthlyCost = $monthlyExpenses + $monthlySalaries;
            
            // Get custom survival percentage from settings (default 20% jika belum di-set)
            $survivalPercentage = $settings->survival_cost_percentage ?? 20;
            $minimalOperatingCost = max($currentMonthlyCost * ($survivalPercentage / 100), 2000000); // Minimal 2jt per bulan
            $runwayMonths = $calculatedCash / $minimalOperatingCost;
            
            $runwayCalculation = "Scenario: Revenue turun ke 0, bisnis survival mode dengan {$survivalPercentage}% dari cost normal.\n";
            $runwayCalculation .= "Current Monthly Cost: Rp " . number_format($currentMonthlyCost, 0, ',', '.') . "\n";
            $runwayCalculation .= "Minimal Survival Cost: Rp " . number_format($minimalOperatingCost, 0, ',', '.') . " ({$survivalPercentage}% dari normal)\n";
            $runwayCalculation .= "Working Capital ÷ Minimal Cost = Rp " . number_format($calculatedCash, 0, ',', '.') . " ÷ Rp " . number_format($minimalOperatingCost, 0, ',', '.') . " = " . round($runwayMonths, 1) . " bulan";
        }
        
        if ($runwayMonths > 12) {
            $runwayYears = round($runwayMonths / 12, 1);
            $runway = $runwayYears . ' tahun';
        } else {
            $runway = round($runwayMonths, 1) . ' bulan';
        }

        // BEP (Break Even Point) calculation based on profit rata-rata per bulan
        $averageMonthlyProfit = $monthlyProfit / $monthsDiff;
        $bepMonths = null;
        $bepYears = null;
        $bepExplanation = '';

        if ($averageMonthlyProfit > 0 && $modalInti > 0) {
            $bepMonths = $modalInti / $averageMonthlyProfit;
            $bepYears = $bepMonths / 12;

            $bepExplanation = "Konsep: BEP = Berapa lama sampai modal awal kembali.\n";
            $bepExplanation .= "Modal Awal / Modal Inti: Rp " . number_format($modalInti, 0, ',', '.') . "\n";
            $bepExplanation .= "Profit Rata-rata per Bulan: Rp " . number_format($averageMonthlyProfit, 0, ',', '.') . " (berdasarkan {$monthsDiff} bulan terpilih)\n";
            $bepExplanation .= "BEP (bulan) = Modal Awal ÷ Profit Bulanan = Rp " . number_format($modalInti, 0, ',', '.') . " ÷ Rp " . number_format($averageMonthlyProfit, 0, ',', '.') . " = " . round($bepMonths, 1) . " bulan";
        } else {
            if ($averageMonthlyProfit <= 0) {
                $bepExplanation = "Belum bisa menghitung BEP karena bisnis masih rugi atau belum profit secara rata-rata di periode yang dipilih.";
            } elseif ($modalInti <= 0) {
                $bepExplanation = "Modal awal / modal inti belum diisi, sehingga BEP belum bisa dihitung.";
            }
        }

        // Business age
        $businessAge = $settings->getBusinessAgeInMonths();
        $businessAgeDays = $settings->getBusinessAgeInDays();

        // Expense by category this month
        $expensesByCategory = Expense::select('expense_categories.name', DB::raw('SUM(expenses.amount) as total'))
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->whereMonth('expenses.date', now()->month)
            ->whereYear('expenses.date', now()->year)
            ->groupBy('expense_categories.name')
            ->get();

        // Recent transactions
        $recentExpenses = Expense::with('category')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
        
        $recentRevenues = Revenue::orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('livewire.dashboard', [
            'settings' => $settings,
            'totalEmployees' => $totalEmployees,
            'totalAssets' => $totalAssets,
            'monthlyExpenses' => $totalMonthlyExpenses,
            'monthlySalaries' => $monthlySalaries,
            'monthlyRevenues' => $monthlyRevenues,
            'monthlyProfit' => $monthlyProfit,
            'burnRate' => $burnRate,
            'monthsDiff' => $monthsDiff,
            'runway' => $runway,
            'runwayMonths' => $runwayMonths,
            'runwayScenario' => $runwayScenario,
            'runwayCalculation' => $runwayCalculation,
            'minimalOperatingCost' => $minimalOperatingCost,
            'averageMonthlyProfit' => $averageMonthlyProfit,
            'bepMonths' => $bepMonths,
            'bepYears' => $bepYears,
            'bepExplanation' => $bepExplanation,
            'businessAge' => $businessAge,
            'businessAgeDays' => $businessAgeDays,
            'expensesByCategory' => $expensesByCategory,
            'recentExpenses' => $recentExpenses,
            'recentRevenues' => $recentRevenues,
            'calculatedCash' => $calculatedCash,
            'modalInti' => $modalInti,
            'confirmedCash' => $confirmedCash,
            'totalRevenues' => $totalRevenues,
            'totalExpenses' => $totalExpenses,
            'totalSalaries' => $totalSalaries,
            'hasPendingClosing' => $hasPendingClosing,
            'latestClosing' => $latestClosing,
            // Debug date range
            'startDate' => $startDate,
            'endDate' => $endDate,
        ])->layout('components.layout', ['title' => 'Dashboard']);
    }
}
