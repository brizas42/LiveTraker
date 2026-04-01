<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Modifier l\'objectif : ') }} {{ $goal->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-8 rounded-3xl shadow-lg relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-purple-200 dark:bg-purple-900/40 rounded-full blur-3xl opacity-40"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-200 dark:bg-indigo-900/40 rounded-full blur-3xl opacity-40"></div>
                
                <form action="{{ route('goals.update', $goal) }}" method="POST" class="relative z-10 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <h3 class="text-lg font-bold text-indigo-700 dark:text-indigo-400 mb-4 uppercase tracking-wider">Informations Globales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Titre de l'objectif <span class="text-red-500">*</span></label>
                                <input type="text" name="title" value="{{ old('title', $goal->title) }}" required class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Catégorie</label>
                                <input type="text" name="category" value="{{ old('category', $goal->category) }}" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">{{ old('description', $goal->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Date de début <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" required value="{{ old('start_date', optional($goal->start_date)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Échéance (Deadline) <span class="text-red-500">*</span></label>
                            <input type="date" name="deadline" required value="{{ old('deadline', optional($goal->deadline)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Statut</label>
                        <select name="status" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                            <option value="active" {{ $goal->status === 'active' ? 'selected' : '' }}>En cours</option>
                            <option value="completed" {{ $goal->status === 'completed' ? 'selected' : '' }}>Terminé</option>
                            <option value="failed" {{ $goal->status === 'failed' ? 'selected' : '' }}>Échoué / Abandonné</option>
                        </select>
                    </div>

                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-purple-700 dark:text-purple-400 mb-4 uppercase tracking-wider flex items-center">
                            Méthode SMART <span class="ml-2 text-xs bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-300 px-2 py-0.5 rounded-full font-normal">Recommandé</span>
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"><span class="font-bold">S</span>pécifique</label>
                                <input type="text" name="specific" value="{{ old('specific', $goal->specific) }}" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"><span class="font-bold">M</span>esurable</label>
                                <input type="text" name="measurable" value="{{ old('measurable', $goal->measurable) }}" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"><span class="font-bold">A</span>tteignable</label>
                                <input type="text" name="achievable" value="{{ old('achievable', $goal->achievable) }}" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"><span class="font-bold">R</span>éaliste (Relevant)</label>
                                <input type="text" name="relevant" value="{{ old('relevant', $goal->relevant) }}" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300"><span class="font-bold">T</span>emporel (Time-bound)</label>
                                <input type="text" name="time_bound" value="{{ old('time_bound', $goal->time_bound) }}" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="flex items-center justify-between pt-4 mt-6">
                        <button type="submit" form="delete-form" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet objectif ?')" class="text-red-500 hover:text-red-700 dark:hover:text-red-400 text-sm font-semibold">
                            Supprimer cet objectif
                        </button>
                        
                        <div class="flex items-center">
                            <a href="{{ route('goals.show', $goal) }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 px-4 font-semibold">Annuler</a>
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Formulaire de suppression extrait pour la validité W3C -->
                <form id="delete-form" action="{{ route('goals.destroy', $goal) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
