<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                {{ __('Tableau de bord') }}
            </h2>
            <a href="{{ route('goals.create') }}" class="px-4 py-2 bg-indigo-600 outline-none text-white rounded-lg shadow uppercase text-sm font-semibold tracking-wide hover:bg-indigo-700 transition transform hover:-translate-y-0.5">
                + Nouvel Objectif
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-6 rounded-2xl shadow-sm text-center transform transition hover:scale-105">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wide font-semibold">Objectifs Actifs</div>
                    <div class="text-4xl font-bold gradient-text mt-2">{{ $activeGoalsCount }}</div>
                </div>
                <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-6 rounded-2xl shadow-sm text-center transform transition hover:scale-105">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wide font-semibold">Objectifs Terminés</div>
                    <div class="text-4xl font-bold text-green-500 mt-2">{{ $completedGoalsCount }}</div>
                </div>
                <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-6 rounded-2xl shadow-sm text-center transform transition hover:scale-105">
                    <div class="text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wide font-semibold">Progression Moyenne</div>
                    <div class="text-4xl font-bold text-purple-600 mt-2">{{ $averageProgress }}%</div>
                </div>
            </div>

            <!-- Graph and List -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-6 rounded-2xl shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-4">Aperçu des progressions</h3>
                    @if(count($chartData['labels']) > 0)
                        <canvas id="progressChart" height="200"></canvas>
                    @else
                        <div class="text-center text-gray-400 dark:text-gray-500 py-10">
                            Aucun objectif pour le moment.
                        </div>
                    @endif
                </div>

                <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-6 rounded-2xl shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Vos Objectifs Récents</h3>
                        <a href="{{ route('goals.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300">Voir tout</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($goals->take(4) as $goal)
                            <a href="{{ route('goals.show', $goal) }}" class="block p-4 bg-white dark:bg-gray-700/50 bg-opacity-50 rounded-xl hover:bg-opacity-100 dark:hover:bg-gray-600/50 transition shadow-sm border border-transparent hover:border-indigo-100 dark:hover:border-gray-600">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $goal->title }}</span>
                                    <span class="text-xs px-2 py-1 rounded-full {{ $goal->status === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-300' : 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300' }}">
                                        {{ $goal->status === 'completed' ? 'Terminé' : 'En cours' }}
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full" style="width: {{ $goal->progress_percentage }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 text-right">{{ $goal->progress_percentage }}% Complété</div>
                            </a>
                        @empty
                            <div class="text-center text-gray-400 dark:text-gray-500 py-6">
                                Commence par créer ton premier objectif !
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('progressChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($chartData['labels']) !!},
                        datasets: [{
                            label: 'Progression (%)',
                            data: {!! json_encode($chartData['progress']) !!},
                            backgroundColor: 'rgba(99, 102, 241, 0.6)',
                            borderColor: 'rgba(99, 102, 241, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
