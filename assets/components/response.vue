<template>
    <div class="relative border border-dashed border-2 bg-white pr-4 py-2">
        <div class="grid grid-cols-[1fr_10fr] gap-x-1">
            <div class="m-auto">
                <input type="checkbox" v-model="checkboxValue" @change="checkboxChange($event)" :disabled="responseDepot.validate"/>
            </div>
            <div>
                <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(responseDepot.type) }}</span></p>
                <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ responseDepot.titre }}</span></p>
                <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ responseDepot.description }}</span></p>
                <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ responseDepot.date_creation }}</span></p>
            </div>
        </div>

        <!-- Si la réponse est déjà validé, alors on affiche un message par dessus pour notifier qu'elle est validé -->
        <div
            v-if="responseDepot.validate"
            class="absolute top-0 left-0 h-full w-full bg-gray-700/[.5] flex justify-center items-center"
        >
            <span class="text-green-400 font-bold text-xl">Validé</span>
        </div>
    </div>
</template>

<script>
import { getLabel } from '@/enum/demande_clinique/reponse/type';

export default {
    name: 'Response',
    props: ['responseDepot'],
    data() {
        return {
            checkboxValue: false
        }
    },
    methods: {
        getTypeLabel: getLabel,

        /**
         * Envoi au component parent qu'on a sélectionné/déselectionné la checkbox
         * @returns {void}
         */
        checkboxChange() {
            if (this.checkboxValue) {
                this.$emit('responseSelected', this.responseDepot);
            } else {
                this.$emit('responseDeselected', this.responseDepot);
            }
        }
    }
}
</script>