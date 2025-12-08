<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Business Plan Management' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-xl font-bold text-gray-900">Business Plan</h1>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="/" class="{{ request()->is('/') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                📊 Dashboard
                            </a>
                            <a href="/revenues" class="{{ request()->is('revenues') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                💰 Pendapatan
                            </a>
                            <a href="/expenses" class="{{ request()->is('expenses') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                💸 Pengeluaran
                            </a>
                            <div class="relative group">
                                <button class="{{ request()->is('employees') || request()->is('salaries') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium h-16">
                                    👥 SDM
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div class="absolute top-full left-0 mt-0 w-48 bg-white rounded-lg shadow-lg border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <a href="/employees" class="{{ request()->is('employees') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-3 text-sm rounded-t-lg">
                                        👤 Karyawan
                                    </a>
                                    <a href="/salaries" class="{{ request()->is('salaries') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-3 text-sm rounded-b-lg">
                                        💵 Gaji
                                    </a>
                                </div>
                            </div>
                            <a href="/assets" class="{{ request()->is('assets') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                🏢 Asset
                            </a>
                            <div class="relative group">
                                <button class="{{ request()->is('cash-flow') || request()->is('closing-reports') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium h-16">
                                    📈 Reports
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div class="absolute top-full left-0 mt-0 w-48 bg-white rounded-lg shadow-lg border opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <a href="/cash-flow" class="{{ request()->is('cash-flow') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-3 text-sm rounded-t-lg">
                                        💹 Cash Flow
                                    </a>
                                    <a href="/closing-reports" class="{{ request()->is('closing-reports') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }} block px-4 py-3 text-sm rounded-b-lg">
                                        📋 Closing Reports
                                    </a>
                                </div>
                            </div>
                            <a href="/settings" class="{{ request()->is('settings') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                ⚙️ Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-6">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
    @livewireScripts
</body>
</html>
