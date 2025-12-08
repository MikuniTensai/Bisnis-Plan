<?php

namespace App\Livewire;

use App\Models\BusinessSetting;
use Livewire\Component;

class BusinessSettings extends Component
{
    public $business_name;
    public $start_date;
    public $initial_capital;
    public $current_cash;
    public $target_monthly_revenue;
    public $minimum_cash_reserve;
    public $survival_cost_percentage;
    public $notes;
    public $showTipsModal = false;

    protected $rules = [
        'business_name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'initial_capital' => 'required|numeric|min:0',
        'current_cash' => 'required|numeric|min:0',
        'target_monthly_revenue' => 'nullable|numeric|min:0',
        'minimum_cash_reserve' => 'nullable|numeric|min:0',
        'survival_cost_percentage' => 'required|integer|min:5|max:50',
        'notes' => 'nullable|string',
    ];

    public function mount()
    {
        $settings = BusinessSetting::getSettings();
        $this->business_name = $settings->business_name;
        $this->start_date = $settings->start_date->format('Y-m-d');
        $this->initial_capital = $settings->initial_capital;
        $this->current_cash = $settings->current_cash;
        $this->target_monthly_revenue = $settings->target_monthly_revenue;
        $this->minimum_cash_reserve = $settings->minimum_cash_reserve;
        $this->survival_cost_percentage = $settings->survival_cost_percentage ?? 20;
        $this->notes = $settings->notes;
    }

    public function save()
    {
        $this->validate();

        $settings = BusinessSetting::first();
        if ($settings) {
            $settings->update([
                'business_name' => $this->business_name,
                'start_date' => $this->start_date,
                'initial_capital' => $this->initial_capital,
                'current_cash' => $this->current_cash,
                'target_monthly_revenue' => $this->target_monthly_revenue,
                'minimum_cash_reserve' => $this->minimum_cash_reserve,
                'survival_cost_percentage' => $this->survival_cost_percentage,
                'notes' => $this->notes,
            ]);
        } else {
            BusinessSetting::create([
                'business_name' => $this->business_name,
                'start_date' => $this->start_date,
                'initial_capital' => $this->initial_capital,
                'current_cash' => $this->current_cash,
                'target_monthly_revenue' => $this->target_monthly_revenue,
                'minimum_cash_reserve' => $this->minimum_cash_reserve,
                'survival_cost_percentage' => $this->survival_cost_percentage,
                'notes' => $this->notes,
            ]);
        }

        session()->flash('message', 'Settings berhasil disimpan.');
    }

    public function render()
    {
        $settings = BusinessSetting::getSettings();
        return view('livewire.business-settings', [
            'settings' => $settings,
        ])->layout('components.layout', ['title' => 'Business Settings']);
    }
}
