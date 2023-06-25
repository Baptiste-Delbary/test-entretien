<template>
    <div class="bg-white rounded-xl shadow-sm p-4">
        <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ depot.titre }}</span></p>
        <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ depot.description }}</span></p>
        <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ depot.date_creation }}</span></p>
        <div class="my-4 p-2 border border-gray rounded-xl bg-gray-100 flex flex-col gap-2" v-if="depot.reponses.length">
            <Response 
                v-for="reponseDepot in depot.reponses" 
                :key="reponseDepot.id" 
                :responseDepot="reponseDepot"
                @responseSelected="addSelectedResponse($event)"
                @responseDeselected="removeSelectedResponse($event)"
            />
        </div>

        <div class="flex items-center justify-center" v-else>
            <p class="text-base font-semibold">Aucune réponse</p>
        </div>

        <div class="flex flex-col md:flex-row gap-y-2 justify-between mt-2">
            <router-link 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center" 
                :to="`/depots/${depot.id}`"
            >Répondre à la demande</router-link>

            <!-- On affiche le bouton de validation des réponses, seulement si notre dépot a des réponses -->
            <button 
                v-if="depot.reponses.length" 
                type="button" 
                :class="`${selectedResponse.length ? 'bg-green-500 hover:bg-green-700 text-white' : 'bg-gray-200 text-gray-500'} font-bold py-2 px-4 rounded`" 
                :disabled="selectedResponse.length === 0"
                @click="validateAnswer()"
            >Valider les réponses</button>
        </div>
    </div>
</template>

<script>
import Response from '@/components/response.vue'
import EventBus, { EVENT_OPEN_VALIDATION_RESPONSE_MODAL } from '@/eventBus.js';

export default {
    name: 'Depot',
    components: {
        Response
    },
    props: ['depot'],
    data() {
        return {
            selectedResponse: [] // Liste des réponses sélectionnées
        }
    },
    methods: {
        /**
         * Ajoute un id de réponse à la liste des réponses selectionnées
         * @param {object} response
         * @returns {void}
         */
        addSelectedResponse(response) {
            this.selectedResponse.push(response);
        },

        /**
         * Supprime un id de réponse à la liste des réponses selectionnées
         * @param {object} response
         * @returns {void}
         */
        removeSelectedResponse(response) {
            const index = this.selectedResponse.find(element => element.id === response.id);

            if (index > -1) {
                this.selectedResponse.splice(index, 1);
            }
        },

        /**
         * Valide la/les réponses selectionnées
         * @returns {void}
         */
        validateAnswer() {
            // Si on a bien les réponses, alors on ouvre la modal de validation
            if (this.selectedResponse.length) {
                EventBus.$emit(EVENT_OPEN_VALIDATION_RESPONSE_MODAL, this.selectedResponse);
            }
        },
    }
}
</script>