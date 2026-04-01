<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-100 leading-tight">Historique des Habitudes</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Vos statistiques et succès passés.</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700">
                <div class="flex flex-col text-center w-1/2 border-r border-slate-100 dark:border-gray-700">
                    <span class="text-4xl font-black text-indigo-600 dark:text-indigo-400">{{ $totalHabits }}</span>
                    <span class="text-sm font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mt-1">Habitudes en cours</span>
                </div>
                <div class="flex flex-col text-center w-1/2">
                    <span class="text-4xl font-black text-green-500 dark:text-green-400">{{ $totalCompleted }}</span>
                    <span class="text-sm font-bold text-slate-400 dark:text-gray-500 uppercase tracking-widest mt-1">Actions validées</span>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-gray-700 bg-slate-50 dark:bg-gray-800/50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Timeline des réalisations</h3>
                    <a href="{{ route('habits.index') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">&larr; Retour aux habitudes</a>
                </div>

                <div class="p-6 space-y-8 max-h-[600px] overflow-y-auto">
                    @forelse($groupedLogs as $date => $logs)
                        <div class="relative pl-6 border-l-2 border-indigo-100 dark:border-indigo-900/50">
                            <span class="absolute -left-[9px] top-1 bg-indigo-500 w-4 h-4 rounded-full border-4 border-white dark:border-gray-800 shadow-sm"></span>
                            <h4 class="font-bold mb-4 inline-block bg-indigo-50 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 px-3 py-1 rounded-lg text-sm">
                                {{ \Carbon\Carbon::parse($date)->isoFormat('dddd D MMMM YYYY') }}
                            </h4>
                            <div class="space-y-3">
                                @foreach($logs as $log)
                                    <div class="flex items-center space-x-3 bg-slate-50 dark:bg-gray-700/50 border border-slate-100 dark:border-gray-600 p-3 rounded-xl hover:shadow-md dark:hover:shadow-gray-900/50 transition">
                                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 rounded-lg flex items-center justify-center shadow-inner dark:shadow-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <div class="font-bold text-slate-700 dark:text-gray-200">{{ $log->habit->name ?? 'Habitude supprimée' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <h3 class="text-xl font-bold text-slate-700 dark:text-white mb-2">Aucun historique</h3>
                            <p class="text-slate-500 dark:text-gray-400 mb-6 font-medium">Validez au moins une habitude aujourd'hui pour construire votre journal.</p>
                            <a href="{{ route('habits.index') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 shadow-md text-white font-bold rounded-xl transition inline-block">Tableau des habitudes</a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
