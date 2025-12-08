<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Gaji Karyawan', 'code' => 'SAL', 'type' => 'salary', 'description' => 'Pembayaran gaji karyawan'],
            ['name' => 'Pembelian Asset', 'code' => 'AST', 'type' => 'asset', 'description' => 'Pembelian asset/inventaris'],
            ['name' => 'Listrik & Air', 'code' => 'UTL', 'type' => 'operational', 'description' => 'Biaya utilitas'],
            ['name' => 'Internet & Telepon', 'code' => 'COM', 'type' => 'operational', 'description' => 'Biaya komunikasi'],
            ['name' => 'ATK & Supplies', 'code' => 'SUP', 'type' => 'operational', 'description' => 'Alat tulis kantor dan perlengkapan'],
            ['name' => 'Maintenance', 'code' => 'MNT', 'type' => 'operational', 'description' => 'Biaya perawatan dan perbaikan'],
            ['name' => 'Transport', 'code' => 'TRP', 'type' => 'operational', 'description' => 'Biaya transportasi'],
            ['name' => 'Lain-lain', 'code' => 'OTH', 'type' => 'other', 'description' => 'Pengeluaran lain-lain'],
        ];

        foreach ($categories as $category) {
            \App\Models\ExpenseCategory::create($category);
        }
    }
}
