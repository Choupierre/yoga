<script setup lang="ts">
import { PropType } from "vue";
import { DateElement } from "../../types";
const store = authStore();
const props = defineProps({
    date: {
        type: Object as PropType<DateElement>,
        required: true,
    },
});
const { date } = toRefs(props);
</script>

<template>
  <div
    :class="date.old ? 'bg-gray-200' : 'bg-white'"
    class="relative p-4 w-full h-full rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700 flex flex-col items-start"
  >
    <BtnDelete
      v-if="store.isAdmin"    
      class="absolute -top-2 -right-2"
      @click="date.deleteDate()"
    />  
    <h5     
      v-if="store.isInsa"
      class="text-xl font-medium text-gray-500 dark:text-gray-400"
    >
      {{ date.user.name }}
    </h5>
    <h5 class="text-xl font-medium text-gray-500 dark:text-gray-400">
      {{ date.date }}
    </h5>
    <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">
      {{ date.freeSeats() }} place(s) libre(s)
    </h5>
    <!-- List -->
    <DateSlots
      :date="date"
      @update="store.init()"
    />
    <div v-if="!date.old && !store.isInsa">
      <button
        v-if="(date.freeSeats() || date.alreadyReserved()) && !store.isAdmin"
        type="button"
        class="buttonblue"
        @click="date.switchReservation()"
      >
        {{ date.alreadyReserved() ? "Annuler" : "Réserver" }}
      </button>
      <button
        v-if="!date.freeSeats() && !date.alreadyReserved()"
        type="button"
        disabled
        class="text-white bg-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center"
      >
        Complet
      </button>
    </div>      
  </div>
</template>
