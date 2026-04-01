<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'LiveTracker') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            
            function toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.theme = 'light';
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.theme = 'dark';
                }
            }
        </script>
    </head>
    <body class="antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans selection:bg-indigo-500 selection:text-white transition-colors duration-200">
        
        <!-- Navbar -->
        <header class="fixed w-full flex items-center justify-between px-6 py-4 bg-white/80 dark:bg-gray-900/80 backdrop-blur border-b border-gray-100 dark:border-gray-800 z-50 transition-colors duration-200">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/liveTracker%20icon%20black.png') }}" alt="LiveTracker Logo" class="w-9 h-9 rounded-full object-cover bg-white shadow-sm" />
                <span class="text-xl font-bold tracking-tight">{{ config('app.name', 'LiveTracker') }}</span>
            </div>
            
            @if (Route::has('login'))
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">Tableau de Bord</a>
                    @else
                        <button onclick="toggleTheme()" class="p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors mr-2">
                            <!-- Sun icon for dark mode (shows in dark) -->
                            <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <!-- Moon icon for light mode (shows in light) -->
                            <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </button>
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hidden sm:block">Se connecter</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-medium px-4 py-2.5 rounded-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 hover:bg-gray-800 dark:hover:bg-gray-100 transition">S'inscrire</a>
                        @endif
                    @endauth
                </div>
            @endif
        </header>

        <!-- Hero Section -->
        <section class="pt-40 pb-20 px-6 max-w-7xl mx-auto flex flex-col items-center text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-sm font-bold mb-8 border border-indigo-100">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
                Suivi Quotidien d'Habitudes Disponible !
            </div>
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 dark:text-white max-w-4xl leading-tight">
                Atteignez vos objectifs. <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Construisez vos habitudes.</span>
            </h1>
            <p class="mt-6 text-xl text-gray-500 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed font-medium">
                Le moyen le plus simple et le plus puissant d'atteindre le sommet. Découpez vos grands projets, et cochez vos routines au quotidien.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="px-8 py-4 rounded-full bg-indigo-600 text-white font-bold text-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 hover:-translate-y-1 transform">
                    Commencer gratuitement
                </a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-24 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-800 transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">Tout ce qu'il faut pour réussir</h2>
                    <p class="mt-4 text-xl text-gray-500 max-w-2xl mx-auto">Un écosystème conçu pour la progression constante. Dites adieu à la procrastination.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg transition duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Suivi d'Objectifs</h3>
                        <p class="text-gray-500 leading-relaxed">Divisez vos macro-projets en petites étapes. Votre taux de complétion se met à jour automatiquement.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg transition duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Routine Quotidienne</h3>
                        <p class="text-gray-500 leading-relaxed">Cochez vos habitudes tous les jours et construisez d'incroyables séries (Streaks) ininterrompues.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg transition duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Historique Visuel</h3>
                        <p class="text-gray-500 leading-relaxed">Consultez votre timeline d'accomplissements pour rester motivé jour après jour.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg transition duration-300 lg:col-span-2">
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Rappels Automatisés & Notifications</h3>
                        <p class="text-gray-500 leading-relaxed">Ne naviguez plus à l'aveugle. Définissez une heure de notification personnelle pour que l'application vous rappelle directement vos habitudes chaque jour.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg transition duration-300">
                        <div class="w-14 h-14 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Partage Social</h3>
                        <p class="text-gray-500 leading-relaxed">Célébrez vos réussites en envoyant vos Streaks ou votre Objectif complété à vos proches sur WhatsApp ou Twitter.</p>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-10 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 text-center transition-colors duration-200">
            <p class="text-sm font-semibold text-gray-400">&copy; {{ date('Y') }} {{ config('app.name', 'LiveTracker') }}. Créé avec ambition.</p>
        </footer>
    </body>
</html>
