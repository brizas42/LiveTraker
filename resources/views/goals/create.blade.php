<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Définir un nouvel objectif') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass dark:bg-gray-800/80 dark:border-gray-700 p-8 rounded-3xl shadow-lg relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-purple-200 dark:bg-purple-900/40 rounded-full blur-3xl opacity-40"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-200 dark:bg-indigo-900/40 rounded-full blur-3xl opacity-40"></div>
                
                <form action="{{ route('goals.store') }}" method="POST" class="relative z-10 space-y-6">
                    @csrf
                    
                    <div>
                        <h3 class="text-lg font-bold text-indigo-700 dark:text-indigo-400 mb-4 uppercase tracking-wider">Informations Globales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Titre de l'objectif <span class="text-red-500">*</span></label>
                                <input type="text" name="title" required class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white" placeholder="Ex: Apprendre l'Espagnol">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Catégorie</label>
                                <input type="text" name="category" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white" placeholder="Ex: Personnel">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="description" rows="3" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white" placeholder="Qu'est-ce que vous souhaitez accomplir ?"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Date de début <span class="text-red-500">*</span></label>
                            <input type="date" name="start_date" required value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Échéance (Deadline) <span class="text-red-500">*</span></label>
                            <input type="date" name="deadline" required class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white">
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700" x-data="{ milestones: [''] }">
                        <h3 class="text-lg font-bold text-indigo-700 dark:text-indigo-400 mb-4 uppercase tracking-wider flex items-center justify-between">
                            <span>Définir les étapes initiales</span>
                            <button type="button" @click="milestones.push('')" class="text-xs bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 px-3 py-1.5 rounded-full font-bold hover:bg-indigo-200 dark:hover:bg-indigo-800/50 transition shadow-sm">+ Ajouter une étape</button>
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Découpez votre objectif en petites étapes. Chaque étape cochée fera progresser automatiquement votre objectif !</p>
                        
                        <div class="space-y-3">
                            <template x-for="(milestone, index) in milestones" :key="index">
                                <div class="flex items-center space-x-2 relative group">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-bold text-sm shadow-inner" x-text="index + 1"></div>
                                    <input type="text" x-model="milestones[index]" name="milestones[]" placeholder="Description courte (ex: S'inscrire à la formation)" class="block w-full rounded-xl border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-white/50 dark:bg-gray-700/50 dark:text-white dark:placeholder-gray-400">
                                    <button type="button" @click="milestones.splice(index, 1)" x-show="milestones.length > 1" class="text-red-400 hover:text-red-600 focus:outline-none p-2 rounded-full hover:bg-red-50 dark:hover:bg-red-900/40 transition transform group-hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>



                    <div class="flex items-center justify-end pt-4 mt-6">
                        <a href="{{ route('goals.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 px-4 font-semibold">Annuler</a>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                            Créer mon objectif
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
