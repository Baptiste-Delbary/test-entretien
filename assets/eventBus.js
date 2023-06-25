import Vue from 'vue';

const EventBus = new Vue();

export default EventBus;

export const EVENT_LOAD_DEPOTS = 'chargerDepots';
export const EVENT_OPEN_VALIDATION_RESPONSE_MODAL = 'openValidationResponseModal';