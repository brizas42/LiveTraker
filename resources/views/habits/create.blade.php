<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Nouvelle Habitude') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-8 rounded-3xl shadow-sm relative overflow-hidden">
                <form action="{{ route('habits.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">Titre de l'habitude <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white" placeholder="Ex: Boire 2L d'eau, Lire 15 mins...">
                    </div>

                    <div>
                        <label class="block font-bold text-sm text-gray-700 dark:text-gray-300 mb-2">Description <span class="text-gray-400 dark:text-gray-500 font-normal">(Optionnel)</span></label>
                        <textarea name="description" rows="3" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white" placeholder="Pourquoi voulez-vous instaurer cette habitude ?"></textarea>
                    </div>

                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-6 rounded-2xl border border-indigo-100 dark:border-indigo-800/50">
                        <label class="block font-bold text-indigo-800 dark:text-indigo-300 mb-2">Rappel Quotidien <span class="font-normal text-indigo-500 dark:text-indigo-400">(Optionnel)</span></label>
                        <p class="text-sm text-indigo-600 dark:text-indigo-400 mb-4">Mettez en place une notification intelligente qui vous rappellera de valider cette habitude tous les jours à l'heure indiquée.</p>
                        <input type="time" name="reminder_time" class="block w-full md:w-1/2 rounded-xl border-indigo-200 dark:border-indigo-800 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white dark:bg-gray-800 text-indigo-900 dark:text-indigo-100 font-bold text-lg p-3">
                    </div>

                    <div class="flex items-center justify-end pt-4">
                        <a href="{{ route('habits.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 px-4 font-semibold">Annuler</a>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-1 transition duration-300">
                            Sauvegarder l'habitude
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
