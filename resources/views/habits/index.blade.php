<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center py-2">
            <div>
                <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-100 leading-tight">Mes Habitudes</h2>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Votre routine quotidienne.</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <a href="{{ route('habits.history') }}" class="px-5 py-2.5 bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-gray-700 rounded-xl shadow-sm font-semibold hover:bg-indigo-50 dark:hover:bg-gray-700 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Historique
                </a>
                <a href="{{ route('habits.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl shadow-md font-bold hover:bg-indigo-700 transition flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Ajouter
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
            <div class="p-4 bg-green-50 dark:bg-green-900/50 text-green-800 dark:text-green-200 rounded-xl shadow-sm font-bold border border-green-200 dark:border-green-800 mb-6">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700 dark:text-gray-200">À faire aujourd'hui</h3>
                    <span class="text-sm font-semibold text-gray-400 dark:text-gray-500">{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</span>
                </div>
                
                <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($habits as $habit)
                        <li class="flex items-center justify-between p-4 px-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition group {{ $habit->completed_today ? 'bg-gray-50/50 dark:bg-gray-800/50' : '' }}">
                            
                            <!-- Left: Checkbox & Title -->
                            <div class="flex items-start flex-1">
                                <form action="{{ route('habits.toggle', $habit) }}" method="POST" class="mt-0.5">
                                    @csrf
                                    <button type="submit" class="relative group cursor-pointer border-0 bg-transparent p-0 flex items-center justify-center mr-4">
                                        @if($habit->completed_today)
                                            <div class="w-6 h-6 rounded-full bg-indigo-500 border-2 border-indigo-500 flex items-center justify-center flex-shrink-0 transition">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        @else
                                            <div class="w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-500 group-hover:border-indigo-400 dark:group-hover:border-indigo-400 flex items-center justify-center flex-shrink-0 transition">
                                                <svg class="w-4 h-4 text-transparent group-hover:text-indigo-200 dark:group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        @endif
                                    </button>
                                </form>
                                
                                <div>
                                    <h4 class="text-base font-medium {{ $habit->completed_today ? 'text-gray-400 line-through' : 'text-gray-800 dark:text-gray-100' }}">
                                        {{ $habit->name }}
                                    </h4>
                                    @if($habit->description && !$habit->completed_today)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($habit->description, 60) }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Right: Streaks & Actions -->
                            <div class="flex items-center space-x-4 ml-4">
                                
                                <!-- Streak Indicator -->
                                @if($habit->streak > 0)
                                    <div class="flex items-center space-x-1 {{ $habit->completed_today ? 'opacity-50' : '' }}" title="{{ $habit->streak }} jours d'affilée">
                                        <span class="text-orange-500 text-sm">🔥</span>
                                        <span class="font-bold text-gray-600 dark:text-gray-300 text-sm">{{ $habit->streak }}</span>
                                    </div>
                                @endif

                                <!-- Actions (Edit / Delete) -->
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex items-center space-x-2">
                                    <a href="{{ route('habits.edit', $habit) }}" class="text-gray-400 hover:text-indigo-500 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('habits.destroy', $habit) }}" method="POST" onsubmit="return confirm('Supprimer cette habitude ?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Share link if completed -->
                                @if($habit->completed_today && $habit->streak >= 3)
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode('🔥 ' . $habit->streak . ' jours de suite pour mon habitude : ' . $habit->name . ' !') }}" target="_blank" class="text-indigo-400 hover:text-indigo-600" title="Partager">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                    </a>
                                @endif
                                
                            </div>
                        </li>
                    @empty
                        <li class="p-8 text-center bg-white dark:bg-gray-800">
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">Aucune habitude en cours</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4 text-sm">Commencez petit et construisez votre routine quotidienne.</p>
                            <a href="{{ route('habits.create') }}" class="inline-flex px-6 py-2 bg-white dark:bg-gray-800 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-gray-700 font-bold rounded-lg hover:bg-indigo-50 dark:hover:bg-gray-700 transition">Créer une habitude</a>
                        </li>
                    @endforelse
                </ul>
                
                @if($habits->isNotEmpty())
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <span>{{ $habits->where('completed_today', true)->count() }} / {{ $habits->count() }} complétées aujourd'hui</span>
                    
                    @php $progress = $habits->count() > 0 ? round(($habits->where('completed_today', true)->count() / $habits->count()) * 100) : 0; @endphp
                    <div class="flex items-center w-48">
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-2">
                            <div class="bg-indigo-600 dark:bg-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                        </div>
                        <span class="font-bold text-gray-700 dark:text-gray-300 min-w-[32px] text-right">{{ $progress }}%</span>
                    </div>
                </div>
                @endif
                
            </div>
            
        </div>
    </div>
</x-app-layout>
