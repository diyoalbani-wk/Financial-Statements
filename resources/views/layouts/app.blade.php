<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Financial Statements')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <nav class="bg-gray-800 text-white shadow-lg">
        <div class="container-fluid px-6 py-4">
            <a href="/" class="flex items-center text-xl font-bold">
                <i class="fas fa-chart-line mr-2"></i>Financial Statements
            </a>
        </div>
    </nav>

    <div class="flex">
        <aside class="w-64 min-h-screen bg-gray-100 shadow-md">
            <div class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('incomes.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-200 {{ request()->routeIs('incomes.*') ? 'bg-blue-500 text-white' : '' }}">
                            <i class="fas fa-arrow-down mr-3 text-emerald-500"></i>
                            Pemasukan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('outcomes.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-200 {{ request()->routeIs('outcomes.*') ? 'bg-blue-500 text-white' : '' }}">
                            <i class="fas fa-arrow-up mr-3 text-red-500"></i>
                            Pengeluaran
                        </a>
                    </li>
                    {{-- <li>
                        <a href="/reports" 
                           class="flex items-center px-4 py-2 text-gray-700 rounded-lg hover:bg-gray-200">
                            <i class="fas fa-file-alt mr-3"></i>
                            Laporan
                        </a>
                    </li> --}}
                </ul>
            </div>
        </aside>

        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
