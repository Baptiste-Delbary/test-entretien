<template>
    <div v-show="show" class="modal">
        <form class="bg-white rounded p-4 min-w-[50%]" @submit.prevent="submit()">
            <div class="text-2xl font-bold">Validation des réponses</div>
            <p class="mt-2">Décrivez la raison de la validation</p>
            <textarea v-model="reason" placeholder="Raison" class="border border-gray-300 rounded-lg p-2 w-full mt-1"></textarea>

            <div class="flex flex-col md:flex-row gap-y-2 justify-between mt-2">
                <!-- Bouton d'annulation -->
                <button 
                    type="button" 
                    class="bg-gray-200 text-gray-500 font-bold py-2 px-4 rounded"
                    @click="closeModal()"
                >Annuler</button>
            
                <!-- Bouton de validation -->
                <button 
                    type="submit" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                    :class="{
                        'cursor-not-allowed': loading,
                    }"
                    :disabled="loading"
                >{{ loading ? 'En cours' : 'Valider' }}</button>
            </div>
        </form>
    </div>
</template>

<script>
import EventBus, { EVENT_LOAD_DEPOTS, EVENT_OPEN_VALIDATION_RESPONSE_MODAL } from '@/eventBus.js';
import api from '@/api';

export default {
    name: 'ValidateResponse',
    data() {
        return {
            show: false, // Affichage de la modal
            loading: false,
            reason: '', // Raison de la validation
            selectedResponse: [] // Liste des raisons selectionnées
        }
    },
    mounted() {
        EventBus.$on(EVENT_OPEN_VALIDATION_RESPONSE_MODAL, responses => {
            this.openModal(responses);
        });
    },
    methods: {
        /**
         * Ouvre la modal
         * @param {Array<object>} responses
         * @returns {void}
         */
        openModal(responses) {
            this.selectedResponse = responses;
            this.toggleOverflow(true);
            this.show = true;
        },

        /**
         * Ferme la modal
         * @returns {void}
         */
        closeModal() {
            // On reset les variables
            this.reason = '';
            this.responseIds = [];

            // On ferme la modal
            this.show = false;
            this.toggleOverflow(false);
        },

        /**
         * Ajoute/Enlève l'overflow de la page
         * @param {boolean} toggle
         * @returns {void}
         */
        toggleOverflow(toggle) {
            // On récupère la balise html
            const $html = document.getElementsByTagName('html');

            if ($html[0]) {
                // Et on lui ajoute/enlève l'overflow
                if (toggle) {
                    $html[0].classList.add('overflow-hidden');
                } else {
                    $html[0].classList.remove('overflow-hidden');
                }
            }
        },

        /**
         * Envoie au backend la raison de la validation des réponses
         * @returns {void}
         */
        async submit() {
            if (this.reason.trim().length > 0) {
                this.loading = true;

                const request = [];

                // On envoie nos requetes d'éditions en même temps pour gagner de temps sur le temps de la réponse
                this.selectedResponse.forEach(response => {
                    const apiRequest = api.demande_clinique.reponses.edit(response.id, response.titre, response.description, response.type, true, this.reason);
                    request.push(apiRequest);
                });

                try {
                    await Promise.all(request);
                    this.loading = false;

                    this.closeModal();

                    EventBus.$emit(EVENT_LOAD_DEPOTS);
                } catch (e) {
                    console.error(e);
                    alert('Une erreur est survenue');
                    this.loading = false;
                }
            } else {
                // Il faudrait mettre une notify dans l'idéal
                alert('La raison n\'est pas remplie');
            }
        }
    }
}
</script>