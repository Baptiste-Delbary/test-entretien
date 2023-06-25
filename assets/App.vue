<template>
  <div class="h-screen flex items-center justify-center" v-if="loading">
    Chargement
  </div> 
  <div class="container mx-auto mt-10 min-h-screen" v-else>
    <router-view></router-view>
  </div>
</template>

<script>
import { mapActions } from 'vuex';
import EventBus, { EVENT_LOAD_DEPOTS } from '@/eventBus.js';

export default {
  name: 'App',
  data: function () {
    return {
      loading: true,
    };
  },
  mounted() {
    this.chargerPageDepots();

    EventBus.$on(EVENT_LOAD_DEPOTS, () => {
      this.chargerPageDepots();
    });
  },
  methods: {
    ...mapActions({
      chargerDepots: 'demande_clinique/chargerDepots',
    }),

    /**
     * Charge la liste des dépots
     * @returns {void}
     */
    async chargerPageDepots() {
      this.loading = true;
      await this.chargerDepots();
      this.loading = false;
    }
  },
};
</script>