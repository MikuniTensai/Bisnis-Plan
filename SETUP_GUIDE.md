# Business Plan Management System

Sistem manajemen bisnis lengkap dengan tracking modal, cash flow, dan estimasi umur bisnis (runway).

## Fitur Utama

### 1. **Dashboard Analytics**
- Total karyawan aktif
- Total nilai asset
- Pengeluaran bulan ini
- Gaji bulan ini
- Grafik pengeluaran per kategori
- Daftar pengeluaran terbaru

### 2. **Manajemen Karyawan**
- CRUD karyawan lengkap
- Auto-generate nomor karyawan (EMP-001, EMP-002, dst)
- Data: nama, email, telepon, posisi, departemen, tanggal bergabung
- Status: active, inactive, resigned
- Gaji pokok dan tipe gaji (monthly/daily/hourly)

### 3. **Manajemen Asset**
- CRUD asset/inventaris
- Auto-generate kode asset (AST-001, AST-002, dst)
- Harga per PC/unit dengan auto-calculate total
- Tracking kondisi asset (good/fair/poor)
- Assignment asset ke karyawan
- Depresiasi asset

### 4. **Manajemen Pengeluaran**
- CRUD pengeluaran operasional
- Auto-generate nomor pengeluaran (EXP-001, EXP-002, dst)
- Kategori pengeluaran (Gaji, Asset, Utilitas, dll)
- Metode pembayaran (cash/transfer/card)
- Status approval

### 5. **Manajemen Gaji**
- History pembayaran gaji karyawan
- Komponen: gaji pokok, tunjangan, potongan, lembur, bonus
- Auto-calculate total gaji
- Status pembayaran

## Teknologi

- **Backend**: Laravel 12
- **Frontend**: Livewire 3, TailwindCSS 4
- **Database**: SQLite
- **Build Tool**: Vite

## Setup & Instalasi

Aplikasi sudah di-setup dan berjalan di:
- **Laravel**: http://127.0.0.1:8001
- **Vite**: http://localhost:5173

### Database
- SQLite database sudah dibuat
- Migrations sudah dijalankan
- Seeder kategori pengeluaran sudah dijalankan

### User Default
- Email: admin@example.com
- Password: password

## Struktur Database

### Tables
1. **employees** - Data karyawan
2. **employee_salaries** - History gaji karyawan
3. **assets** - Inventaris dan asset
4. **expense_categories** - Kategori pengeluaran
5. **expenses** - Transaksi pengeluaran

### Auto-Generate Features
- Employee Number: EMP-001, EMP-002, ...
- Asset Code: AST-001, AST-002, ...
- Expense Number: EXP-001, EXP-002, ...

## Kategori Pengeluaran Default

1. **Gaji Karyawan** (SAL) - salary
2. **Pembelian Asset** (AST) - asset
3. **Listrik & Air** (UTL) - operational
4. **Internet & Telepon** (COM) - operational
5. **ATK & Supplies** (SUP) - operational
6. **Maintenance** (MNT) - operational
7. **Transport** (TRP) - operational
8. **Lain-lain** (OTH) - other

## Navigasi

- **/** - Dashboard
- **/employees** - Manajemen Karyawan
- **/salaries** - Manajemen Gaji
- **/assets** - Manajemen Asset
- **/expenses** - Manajemen Pengeluaran

## Development

Untuk menjalankan development server:
```bash
composer run dev
```

Ini akan menjalankan:
- PHP artisan serve (Laravel server)
- Queue worker
- Vite dev server

## Catatan Pengembangan

### Yang Sudah Dibuat
✅ Database migrations lengkap
✅ Models dengan relationships
✅ Dashboard dengan analytics
✅ CRUD Karyawan (lengkap dengan UI)
✅ CRUD Asset (lengkap dengan UI)
✅ Auto-generate nomor/kode
✅ Seeder kategori pengeluaran
✅ Layout dan navigation

### Yang Perlu Dilengkapi
- [ ] CRUD Expenses (component sudah ada, perlu tambah view)
- [ ] CRUD Salaries (component sudah ada, perlu tambah view)
- [ ] Export laporan (PDF/Excel)
- [ ] Filter dan sorting advanced
- [ ] Approval workflow untuk pengeluaran
- [ ] Notifikasi sistem

## Tips Penggunaan

1. **Tambah Karyawan Dulu** - Sebelum assign asset atau input gaji
2. **Harga per PC** - Saat input asset, masukkan qty dan harga/unit, total akan otomatis terhitung
3. **Auto-Generate** - Nomor karyawan, kode asset, dan nomor expense otomatis tergenerate
4. **Dashboard** - Refresh otomatis menampilkan data terbaru

## Troubleshooting

Jika ada error:
1. Pastikan composer install sudah selesai
2. Pastikan npm install sudah selesai
3. Pastikan database migrations sudah dijalankan
4. Clear cache: `php artisan cache:clear`
5. Restart server: Stop dan jalankan ulang `composer run dev`
