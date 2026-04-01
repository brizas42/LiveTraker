<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ $goal->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('goals.edit', $goal) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm font-semibold hover:bg-gray-200 dark:hover:bg-gray-700 transition">Éditer</a>
                <!-- Share Button -->
                @if($goal->status === 'completed' || $goal->progress_percentage >= 50)
                <button onclick="document.getElementById('shareModal').classList.remove('hidden')" class="px-4 py-2 bg-gradient-to-r from-green-400 to-green-600 text-white rounded-lg shadow-md font-semibold hover:shadow-lg transition">
                    🏆 Partager
                </button>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
            <div class="p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-xl shadow-sm text-sm font-medium">
                {{ session('success') }}
            </div>
            @endif

            <!-- En-tête de l'objectif -->
            <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-8 rounded-3xl shadow-sm relative overflow-hidden flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex-1 w-full">
                    <span class="text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-2 block">{{ $goal->category ?? 'Non catégorisé' }}</span>
                    <p class="text-gray-600 dark:text-gray-300 text-lg mb-4">{{ $goal->description }}</p>
                    <div class="flex space-x-6 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <div class="flex items-center"><svg class="w-4 h-4 mr-1 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ \Carbon\Carbon::parse($goal->start_date)->format('d/m/Y') }}</div>
                        <div class="flex items-center text-indigo-500"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ \Carbon\Carbon::parse($goal->deadline)->format('d/m/Y') }}</div>
                    </div>
                </div>
                
                <div class="text-center bg-white/50 dark:bg-gray-700/50 p-6 rounded-2xl w-full md:w-64 border border-indigo-50 dark:border-gray-600 shadow-inner">
                    <span class="block text-5xl font-extrabold gradient-text dark:text-indigo-400">{{ $goal->progress_percentage }}%</span>
                    <span class="block mt-2 text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide">Achèvement</span>
                </div>
            </div>

            <!-- Grille Milestones & Progression -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Etapes (Milestones) -->
                <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-6 rounded-2xl shadow-sm">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                        <span class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-500 dark:text-indigo-400 rounded p-1.5 mr-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg></span>
                        Étapes (Milestones)
                    </h3>
                    
                    <ul class="space-y-3 mb-6">
                        @foreach($goal->milestones as $milestone)
                        <li class="flex items-center justify-between p-3 bg-white/60 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600 shadow-sm" x-data="{ checking: false, note: '' }">
                            
                            <!-- Section Gauche (Cocher / Formulaire) -->
                            <div class="flex-1 pr-4">
                                @if(!$milestone->completed)
                                    <form action="{{ route('milestones.update', [$goal, $milestone]) }}" method="POST" class="flex items-center">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="completed" value="1">
                                        <input type="checkbox" onchange="this.form.submit()" class="rounded text-green-500 focus:ring-green-500 mr-3 w-5 h-5 border-gray-300 dark:border-gray-500 dark:bg-gray-600 cursor-pointer shadow-sm">
                                        <span class="text-gray-700 dark:text-gray-200 font-medium">{{ $milestone->title }}</span>
                                    </form>
                                @else
                                    <form action="{{ route('milestones.update', [$goal, $milestone]) }}" method="POST" class="flex items-center">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="completed" value="0">
                                        <button type="submit" class="mr-3 w-5 h-5 rounded border-2 border-green-500 bg-green-500 flex items-center justify-center cursor-pointer hover:bg-green-600 shadow-sm transition transform hover:scale-105">
                                            <svg stroke="white" fill="none" viewBox="0 0 24 24" stroke-width="3" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                        <span class="line-through text-gray-400 dark:text-gray-500 italic">{{ $milestone->title }}</span>
                                    </form>
                                @endif
                            </div>

                            <!-- Corbeille -->
                            <form action="{{ route('milestones.destroy', [$goal, $milestone]) }}" method="POST" class="ml-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 transition transform hover:scale-110 p-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            </form>
                        </li>
                        @endforeach
                    </ul>

                    <form action="{{ route('milestones.store', $goal) }}" method="POST" class="flex items-center space-x-2 pt-4 border-t border-gray-100 dark:border-gray-700">
                        @csrf
                        <input type="text" name="title" placeholder="Ajouter une nouvelle étape..." required class="flex-1 rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white dark:placeholder-gray-400 text-sm py-2">
                        <button type="submit" class="px-5 py-2 bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 font-bold rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-800/50 transition shadow-sm whitespace-nowrap">+ Ajouter</button>
                    </form>
                </div>

                <!-- Historique d'avancée -->
                <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-6 rounded-2xl shadow-sm flex flex-col">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center">
                        <span class="bg-purple-100 dark:bg-purple-900/50 text-purple-500 dark:text-purple-400 rounded-lg p-2 mr-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></span>
                        Journal de progression
                    </h3>

                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-6 italic bg-white/50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-600 shadow-inner">
                        La progression (actuellement à <strong>{{ $goal->progress_percentage }}%</strong>) est maintenant automatisée. Cochez simplement les étapes à gauche pour avancer !
                    </div>

                    <div class="space-y-4 overflow-y-auto flex-1 pr-2 mt-2" style="max-height: 400px;">
                        @forelse($goal->progressLogs as $log)
                        <div class="p-4 bg-white/70 dark:bg-gray-700/50 rounded-xl shadow-sm border-l-4 border-indigo-400 dark:border-indigo-500 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-black text-indigo-600 dark:text-indigo-400 text-lg">{{ $log->progress_value }}%</span>
                                <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-600 px-2 py-1 rounded-md">{{ $log->created_at->format('d/m/Y à H:i') }}</span>
                            </div>
                            @if($log->note)
                            <p class="text-gray-700 dark:text-gray-300 italic text-sm mt-1">"{{ $log->note }}"</p>
                            @endif
                        </div>
                        @empty
                        <div class="text-sm text-center text-gray-400 dark:text-gray-500 mt-10 p-6 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                            Aucun historique pour le moment.<br>
                            Commencez par valider votre première étape !
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Modal Share -->
    <div id="shareModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 dark:bg-opacity-80 z-50 flex items-center justify-center backdrop-blur-sm transition-all">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-md shadow-2xl transform scale-100">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2 text-center">Partagez votre Succès ! 🎉</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mb-6">Montrez à vos amis ce que vous accomplissez.</p>
            
            @php $shareUrl = route('share.show', $goal); @endphp
            <div class="flex flex-col space-y-3">
                <a href="https://wa.me/?text={{ urlencode('Je viens d\'accomplir ' . $goal->progress_percentage . '% de mon objectif : ' . $goal->title . '. Regarde ici : ' . $shareUrl) }}" target="_blank" class="px-4 py-3 bg-[#25D366] text-white rounded-xl font-bold flex items-center justify-center hover:opacity-90">
                    Partager sur WhatsApp
                </a>
                <a href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode('Je viens d\'accomplir ' . $goal->progress_percentage . '% de mon objectif : ' . $goal->title) }}" target="_blank" class="px-4 py-3 bg-[#0088cc] text-white rounded-xl font-bold flex items-center justify-center hover:opacity-90">
                    Partager sur Telegram
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode('Regardez ma progression de ' . $goal->progress_percentage . '% pour : ' . $goal->title) }}" target="_blank" class="px-4 py-3 bg-black text-white rounded-xl font-bold flex items-center justify-center hover:opacity-90">
                    Partager sur X (Twitter)
                </a>
            </div>

            <div class="mt-4 pt-4 border-t dark:border-gray-700">
                <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Ou copiez le lien :</p>
                <input type="text" readonly value="{{ $shareUrl }}" class="w-full text-xs p-2 bg-gray-100 dark:bg-gray-700 border-none rounded-lg text-gray-600 dark:text-gray-300 focus:ring-0">
            </div>

            <button onclick="document.getElementById('shareModal').classList.add('hidden')" class="mt-6 w-full py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg font-bold hover:bg-gray-200 dark:hover:bg-gray-600">Fermer</button>
        </div>
    </div>
</x-app-layout>
