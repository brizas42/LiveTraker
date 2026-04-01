@props(['goal'])
<a href="{{ route('goals.show', $goal) }}" class="block p-6 glass dark:bg-gray-800/80 dark:border-gray-700 rounded-2xl shadow-sm transform transition duration-300 hover:-translate-y-2 hover:shadow-xl group relative overflow-hidden {{ $goal->status === 'completed' ? 'bg-white/40 dark:bg-gray-800/40 border border-green-100 dark:border-green-900/30' : '' }}">
    <!-- Decorative bg -->
    <div class="absolute -right-10 -top-10 w-32 h-32 bg-gradient-to-br from-indigo-300 to-purple-300 rounded-full blur-3xl opacity-20 group-hover:opacity-60 transition duration-500 {{ $goal->status === 'completed' ? 'from-green-100 to-teal-100' : '' }}"></div>
    
    <div class="flex justify-between items-start mb-4 relative z-10">
        <div>
            <span class="text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-1 block">{{ $goal->category ?? 'Non catégorisé' }}</span>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition truncate pr-2 w-48">{{ $goal->title }}</h3>
        </div>
        <span class="text-xs px-2 py-1 rounded-full {{ $goal->status === 'completed' ? 'bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300' : 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300' }} shadow-sm tracking-wide">
            {{ $goal->status === 'completed' ? 'Terminé' : 'En cours' }}
        </span>
    </div>
    
    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-6 relative z-10 h-10">{{ $goal->description ?? 'Aucune description fournie.' }}</p>
    
    <div class="relative z-10">
        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 font-medium mb-1">
            <span>Progression</span>
            <span>{{ $goal->progress_percentage }}%</span>
        </div>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
            <div class="bg-gradient-to-r {{ $goal->status === 'completed' ? 'from-green-400 to-teal-500' : 'from-indigo-500 to-purple-500' }} h-2 rounded-full transition-all duration-1000" style="width: {{ $goal->progress_percentage }}%"></div>
        </div>
    </div>

    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between text-xs text-gray-400 dark:text-gray-500 font-medium relative z-10">
        <span class="flex items-center">
            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            {{ \Carbon\Carbon::parse($goal->deadline)->format('d/m/Y') }}
        </span>
        <span class="flex items-center">
            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            {{ $goal->milestones_count ?? 0 }} étapes
        </span>
    </div>
</a>
