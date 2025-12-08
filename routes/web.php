<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Employees\Index as EmployeesIndex;
use App\Livewire\Assets\Index as AssetsIndex;
use App\Livewire\Expenses\Index as ExpensesIndex;
use App\Livewire\Salaries\Index as SalariesIndex;
use App\Livewire\Revenues\Index as RevenuesIndex;
use App\Livewire\CashFlow;
use App\Livewire\BusinessSettings;
use App\Livewire\PeriodClosing;
use App\Livewire\ClosingReports;

Route::get('/', Dashboard::class)->name('dashboard');
Route::get('/revenues', RevenuesIndex::class)->name('revenues.index');
Route::get('/expenses', ExpensesIndex::class)->name('expenses.index');
Route::get('/employees', EmployeesIndex::class)->name('employees.index');
Route::get('/salaries', SalariesIndex::class)->name('salaries.index');
Route::get('/assets', AssetsIndex::class)->name('assets.index');
Route::get('/cash-flow', CashFlow::class)->name('cash-flow');
Route::get('/period-closing', PeriodClosing::class)->name('period-closing');
Route::get('/closing-reports', ClosingReports::class)->name('closing-reports');
Route::get('/settings', BusinessSettings::class)->name('settings');
