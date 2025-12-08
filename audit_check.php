<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\BusinessSetting;
use App\Models\Revenue;
use App\Models\Expense;
use App\Models\EmployeeSalary;

echo "=== AUDIT LOGIKA MODAL INTI & KAS ===\n\n";

$modalAwal = BusinessSetting::first()->initial_capital;
$totalRevenue = Revenue::where('status', 'received')->sum('amount');
$totalExpenses = Expense::sum('amount');
$totalSalaries = EmployeeSalary::sum('total_salary');

echo "1. MODAL AWAL:\n";
echo "   Rp " . number_format($modalAwal, 0, ',', '.') . "\n\n";

echo "2. TOTAL REVENUE (All Time):\n";
echo "   Rp " . number_format($totalRevenue, 0, ',', '.') . "\n";
echo "   Jumlah transaksi: " . Revenue::where('status', 'received')->count() . "\n\n";

echo "3. TOTAL EXPENSES (All Time):\n";
echo "   Rp " . number_format($totalExpenses, 0, ',', '.') . "\n";
echo "   Jumlah transaksi: " . Expense::count() . "\n\n";

echo "4. TOTAL SALARIES (All Time):\n";
echo "   Rp " . number_format($totalSalaries, 0, ',', '.') . "\n";
echo "   Jumlah pembayaran: " . EmployeeSalary::count() . "\n\n";

echo "=== PERHITUNGAN KAS ===\n\n";
echo "Formula: Modal Awal + Revenue - Expenses - Salaries\n\n";

$kas = $modalAwal + $totalRevenue - $totalExpenses - $totalSalaries;

echo "  " . number_format($modalAwal, 0, ',', '.') . " (Modal Awal)\n";
echo "+ " . number_format($totalRevenue, 0, ',', '.') . " (Revenue)\n";
echo "- " . number_format($totalExpenses, 0, ',', '.') . " (Expenses)\n";
echo "- " . number_format($totalSalaries, 0, ',', '.') . " (Salaries)\n";
echo "─────────────────────────────\n";
echo "= Rp " . number_format($kas, 0, ',', '.') . "\n\n";

echo "=== VALIDASI LOGIKA ===\n\n";

if ($kas > $modalAwal) {
    $profit = $kas - $modalAwal;
    echo "✅ PROFIT: Rp " . number_format($profit, 0, ',', '.') . "\n";
    echo "   Kas lebih besar dari modal awal\n";
    echo "   Bisnis menghasilkan profit!\n\n";
} elseif ($kas < $modalAwal) {
    $loss = $modalAwal - $kas;
    echo "⚠️  LOSS: Rp " . number_format($loss, 0, ',', '.') . "\n";
    echo "   Kas lebih kecil dari modal awal\n";
    echo "   Bisnis mengalami kerugian\n\n";
} else {
    echo "➖ BREAK EVEN\n";
    echo "   Kas sama dengan modal awal\n\n";
}

echo "=== KESIMPULAN ===\n\n";
echo "Modal Inti = Kas = Rp " . number_format($kas, 0, ',', '.') . "\n";
echo "Persentase dari Modal Awal: " . number_format(($kas / $modalAwal) * 100, 2) . "%\n\n";

if ($kas > 0) {
    echo "✅ Logika BENAR!\n";
    echo "   Modal Inti sudah dikurangi semua pengeluaran\n";
    echo "   Kas menunjukkan saldo riil yang tersisa\n";
} else {
    echo "❌ PERINGATAN!\n";
    echo "   Kas negatif atau nol\n";
    echo "   Periksa data transaksi\n";
}
