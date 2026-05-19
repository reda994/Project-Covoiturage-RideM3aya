<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;850&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
        
        <style>
            .font-sans {
                font-family: 'Inter', sans-serif !important;
            }
            .font-heading {
                font-family: 'Poppins', sans-serif !important;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 dark:text-white antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-tr from-gray-50 via-gray-100 to-emerald-50/30 dark:from-gray-950 dark:via-gray-900 dark:to-emerald-950/20 px-4">
            <div class="mb-4">
                <a href="/">
                    <div class="flex items-center gap-2 text-2xl font-black font-heading text-emerald-600 dark:text-emerald-450 tracking-tight">
                        <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        <span>Ride<span class="text-indigo-600 dark:text-indigo-400">M3aya</span></span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-lg mt-4 px-8 py-8 bg-white dark:bg-gray-800 shadow-2xl border border-gray-100 dark:border-gray-700/80 overflow-hidden rounded-3xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
