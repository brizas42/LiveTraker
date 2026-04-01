<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $goal->title }} - LiveTracker</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Outfit', sans-serif; background: linear-gradient(135deg, #e0e7ff 0%, #ede9fe 100%); min-height: 100vh; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border: 1px solid rgba(255,255,255,0.5); }
        .gradient-text { background: linear-gradient(to right, #4F46E5, #9333EA); -webkit-background-clip: text; color: transparent; }
    </style>
</head>
<body class="antialiased text-gray-800 flex items-center justify-center p-4">
    <div class="max-w-xl w-full">
        <!-- Badge Wow -->
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 mb-2">LiveTracker</h1>
            <p class="text-lg font-medium text-gray-600">Suivi d'Objectifs Personnels</p>
        </div>

        <div class="glass p-8 md:p-10 rounded-3xl shadow-2xl relative overflow-hidden text-center transform hover:scale-[1.02] transition duration-500">
            <!-- Confettis déco virtuels -->
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-yellow-300 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-pulse"></div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-pink-300 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-pulse" style="animation-delay: 1s;"></div>
            
            <p class="text-sm font-bold text-purple-500 uppercase tracking-widest mb-3" style="position:relative; z-index:10;">Félicitations 🌟</p>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4" style="position:relative; z-index:10;">{{ $goal->title }}</h2>
            
            <p class="text-gray-600 italic mb-8" style="position:relative; z-index:10;">"{{ $goal->description }}"</p>
            
            <div class="mb-8" style="position:relative; z-index:10;">
                <div class="text-6xl font-black gradient-text inline-block mb-2">{{ $goal->progress_percentage }}%</div>
                <div class="text-xs uppercase tracking-widest font-bold text-gray-400">Objectif Complété</div>
            </div>
            
            <div class="w-full bg-gray-100 rounded-full h-3 mb-8 shadow-inner" style="position:relative; z-index:10;">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-3 rounded-full transition-all duration-1000" style="width: {{ $goal->progress_percentage }}%"></div>
            </div>

            <div class="pt-6 border-t border-gray-100" style="position:relative; z-index:10;">
                <p class="text-sm text-gray-500 mb-4 font-medium">Vous aussi, tracez votre réussite.</p>
                <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-black transition transform hover:-translate-y-1">
                    Créer mon Compte Gratuit
                </a>
            </div>
        </div>
    </div>
</body>
</html>
