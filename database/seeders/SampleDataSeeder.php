<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Business Settings - Modal 2M untuk 5 tahun
        \App\Models\BusinessSetting::create([
            'business_name' => 'PT Tech Startup Indonesia',
            'start_date' => now()->subYears(1), // Bisnis mulai 1 tahun lalu
            'initial_capital' => 2000000000, // 2 Milyar
            'current_cash' => 1650000000, // 1.65 Milyar (masih 82.5%)
            'target_monthly_revenue' => 100000000, // Target 100 juta/bulan
            'minimum_cash_reserve' => 500000000, // Reserve 500 juta
            'notes' => 'Modal awal 2M untuk runway 5 tahun',
        ]);

        // Employees dengan posisi tech (gaji UMR 4.8 juta untuk junior)
        $employees = [
            ['name' => 'Budi Santoso', 'position' => 'Senior Backend Developer', 'department' => 'Engineering', 'salary' => 15000000],
            ['name' => 'Siti Nurhaliza', 'position' => 'Frontend Developer', 'department' => 'Engineering', 'salary' => 8000000],
            ['name' => 'Ahmad Wijaya', 'position' => 'Junior Backend Developer', 'department' => 'Engineering', 'salary' => 4800000],
            ['name' => 'Dewi Lestari', 'position' => 'QA Engineer', 'department' => 'Quality Assurance', 'salary' => 6500000],
            ['name' => 'Rudi Hartono', 'position' => 'DevOps Engineer', 'department' => 'Engineering', 'salary' => 12000000],
            ['name' => 'Ani Kusuma', 'position' => 'UI/UX Designer', 'department' => 'Design', 'salary' => 7000000],
            ['name' => 'Joko Widodo', 'position' => 'Product Manager', 'department' => 'Product', 'salary' => 18000000],
        ];

        foreach ($employees as $emp) {
            \App\Models\Employee::create([
                'name' => $emp['name'],
                'email' => strtolower(str_replace(' ', '.', $emp['name'])) . '@company.com',
                'phone' => '08' . rand(1000000000, 9999999999),
                'position' => $emp['position'],
                'department' => $emp['department'],
                'join_date' => now()->subMonths(rand(1, 5)),
                'status' => 'active',
                'salary' => $emp['salary'],
                'salary_type' => 'monthly',
            ]);
        }

        // Employee Salaries (Gaji bulan ini)
        $employeeList = \App\Models\Employee::all();
        foreach ($employeeList as $employee) {
            \App\Models\EmployeeSalary::create([
                'employee_id' => $employee->id,
                'period' => now()->startOfMonth(),
                'basic_salary' => $employee->salary,
                'allowances' => rand(0, 1) ? 500000 : 0, // Random tunjangan
                'deductions' => rand(0, 1) ? 200000 : 0, // Random potongan
                'overtime' => rand(0, 1) ? 300000 : 0, // Random lembur
                'bonus' => 0,
                'payment_date' => now()->addDays(5),
                'status' => 'paid',
            ]);
        }

        // Assets
        $assets = [
            ['name' => 'Komputer Desktop', 'category' => 'PC', 'qty' => 5, 'unit_price' => 8000000],
            ['name' => 'Laptop Dell', 'category' => 'Laptop', 'qty' => 3, 'unit_price' => 12000000],
            ['name' => 'Printer HP LaserJet', 'category' => 'Printer', 'qty' => 2, 'unit_price' => 3500000],
            ['name' => 'Meja Kantor', 'category' => 'Furniture', 'qty' => 10, 'unit_price' => 1500000],
            ['name' => 'Kursi Kantor', 'category' => 'Furniture', 'qty' => 10, 'unit_price' => 800000],
            ['name' => 'AC 1 PK', 'category' => 'Elektronik', 'qty' => 3, 'unit_price' => 4000000],
        ];

        foreach ($assets as $asset) {
            \App\Models\Asset::create([
                'name' => $asset['name'],
                'category' => $asset['category'],
                'purchase_date' => now()->subMonths(rand(1, 4)),
                'purchase_price' => $asset['qty'] * $asset['unit_price'],
                'quantity' => $asset['qty'],
                'unit_price' => $asset['unit_price'],
                'depreciation_rate' => 10, // 10% per tahun
                'current_value' => $asset['qty'] * $asset['unit_price'] * 0.95, // Depresiasi sedikit
                'condition' => 'good',
                'location' => 'Kantor Pusat',
                'assigned_to' => null,
            ]);
        }

        // Revenues (Pendapatan)
        $revenues = [
            ['source' => 'Penjualan Produk A', 'amount' => 15000000, 'customer' => 'PT ABC'],
            ['source' => 'Penjualan Produk B', 'amount' => 12000000, 'customer' => 'CV XYZ'],
            ['source' => 'Jasa Konsultasi', 'amount' => 8000000, 'customer' => 'PT DEF'],
            ['source' => 'Penjualan Produk C', 'amount' => 10000000, 'customer' => 'Toko 123'],
            ['source' => 'Service & Maintenance', 'amount' => 5000000, 'customer' => 'PT GHI'],
        ];

        foreach ($revenues as $idx => $rev) {
            \App\Models\Revenue::create([
                'date' => now()->subDays(rand(1, 25)),
                'source' => $rev['source'],
                'description' => 'Pendapatan dari ' . $rev['source'],
                'amount' => $rev['amount'],
                'payment_method' => ['cash', 'transfer', 'card'][rand(0, 2)],
                'reference_number' => 'INV-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                'customer_name' => $rev['customer'],
                'status' => 'received',
            ]);
        }

        // Expenses (Pengeluaran)
        $categories = \App\Models\ExpenseCategory::all();
        
        // Listrik & Air
        \App\Models\Expense::create([
            'expense_category_id' => $categories->where('code', 'UTL')->first()->id,
            'date' => now()->subDays(20),
            'description' => 'Tagihan Listrik Bulan ' . now()->format('F'),
            'amount' => 3500000,
            'payment_method' => 'transfer',
            'receipt_number' => 'PLN-' . now()->format('Ym'),
            'paid_to' => 'PLN',
            'status' => 'paid',
        ]);

        // Internet & Telepon
        \App\Models\Expense::create([
            'expense_category_id' => $categories->where('code', 'COM')->first()->id,
            'date' => now()->subDays(15),
            'description' => 'Biaya Internet & Telepon',
            'amount' => 2000000,
            'payment_method' => 'transfer',
            'paid_to' => 'Telkom',
            'status' => 'paid',
        ]);

        // ATK & Supplies
        \App\Models\Expense::create([
            'expense_category_id' => $categories->where('code', 'SUP')->first()->id,
            'date' => now()->subDays(10),
            'description' => 'Pembelian ATK dan Supplies Kantor',
            'amount' => 1500000,
            'payment_method' => 'cash',
            'paid_to' => 'Toko ATK Jaya',
            'status' => 'paid',
        ]);

        // Maintenance
        \App\Models\Expense::create([
            'expense_category_id' => $categories->where('code', 'MNT')->first()->id,
            'date' => now()->subDays(5),
            'description' => 'Service AC dan Perawatan Rutin',
            'amount' => 1200000,
            'payment_method' => 'cash',
            'paid_to' => 'Service AC Pro',
            'status' => 'paid',
        ]);

        // Transport
        \App\Models\Expense::create([
            'expense_category_id' => $categories->where('code', 'TRP')->first()->id,
            'date' => now()->subDays(3),
            'description' => 'Biaya Transport & BBM',
            'amount' => 800000,
            'payment_method' => 'cash',
            'status' => 'paid',
        ]);
    }
}
