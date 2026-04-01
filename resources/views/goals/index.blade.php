<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Mes Objectifs') }}
            </h2>
            <a href="{{ route('goals.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 outline-none text-white rounded-xl shadow-lg shadow-indigo-200 uppercase text-xs tracking-wider font-bold hover:shadow-xl hover:-translate-y-1 transform transition-all duration-300">
                + Nouvel Objectif
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-8 p-4 bg-green-50 dark:bg-green-900/50 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-xl shadow-sm text-sm font-medium">
                {{ session('success') }}
            </div>
            @endif

            @php
                $activeGoals = $goals->where('status', '!=', 'completed');
                $completedGoals = $goals->where('status', 'completed');
            @endphp

            @if($goals->isEmpty())
                <div class="text-center py-20 px-6 glass dark:bg-gray-800/80 dark:border-gray-700 rounded-2xl shadow-sm">
                    <div class="bg-indigo-50 dark:bg-indigo-900/50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-indigo-400 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">Aucun objectif en vue</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Il est temps de définir votre première étape vers le succès.</p>
                    <a href="{{ route('goals.create') }}" class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl shadow font-semibold hover:shadow-lg transition">Commencer</a>
                </div>
            @else
                @if($activeGoals->count() > 0)
                <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center">
                    <span class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 rounded-lg p-2 mr-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></span>
                    Obj. En Cours
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($activeGoals as $goal)
                        <x-goal-card :goal="$goal" />
                    @endforeach
                </div>
                @endif

                @if($completedGoals->count() > 0)
                <div class="{{ $activeGoals->count() > 0 ? 'pt-8 border-t border-gray-200 dark:border-gray-700' : '' }}">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center opacity-80 dark:opacity-100">
                        <span class="bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 rounded-lg p-2 mr-3"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                        Obj. Terminés
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($completedGoals as $goal)
                            <x-goal-card :goal="$goal" />
                        @endforeach
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
