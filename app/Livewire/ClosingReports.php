<?php

namespace App\Livewire;

use App\Models\PeriodClosing;
use Livewire\Component;
use Livewire\WithPagination;

class ClosingReports extends Component
{
    use WithPagination;

    public $year = '';
    public $sortBy = 'period_date';
    public $sortDirection = 'desc';
    
    public function mount()
    {
        $this->year = now()->year;
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'desc';
        }
    }

    public function render()
    {
        $query = PeriodClosing::query();
        
        // Filter by year if selected (SQLite compatible)
        if ($this->year) {
            $query->whereRaw('strftime("%Y", period_date) = ?', [$this->year]);
        }
        
        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);
        
        $closings = $query->paginate(12);
        
        // Calculate summary statistics
        $allClosings = PeriodClosing::orderBy('period_date', 'asc')->get();
        $summary = [
            'total_closings' => $allClosings->count(),
            'first_closing' => $allClosings->first(),
            'latest_closing' => $allClosings->last(),
            'avg_monthly_growth' => 0,
            'total_growth' => 0,
        ];
        
        if ($allClosings->count() > 1) {
            $firstAmount = $allClosings->first()->modal_inti;
            $latestAmount = $allClosings->last()->modal_inti;
            $summary['total_growth'] = $latestAmount - $firstAmount;
            $summary['avg_monthly_growth'] = $summary['total_growth'] / max(1, $allClosings->count() - 1);
        }
        
        // Get unique years for filter (SQLite compatible)
        $availableYears = PeriodClosing::selectRaw('strftime("%Y", period_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('livewire.closing-reports', [
            'closings' => $closings,
            'summary' => $summary,
            'availableYears' => $availableYears,
        ])->layout('components.layout', ['title' => 'Laporan Period Closing']);
    }
}
