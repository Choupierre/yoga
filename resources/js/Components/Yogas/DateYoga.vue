<script setup lang="ts">
const store = authStore();

const props = defineProps({
  date: {
    type: Object,
    required: true,
  },
});
const { date } = toRefs(props);

const emit = defineEmits(["update"]);

const alreadyReserved = () =>
  !!date.value.places.find((place:{id:number}) => place && place.id === store.id);
  
const freeSeats = () =>
  date.value.places.reduce(
    (prev:number, current:null|object) => prev + (current == null ? 1 : 0),
    0
  );

function deleteDate(id:number) {
  if (window.confirm("voulez vous supprimer cette date?")) {
    axios.delete("/api/dates/" + id).then(() => {
      emit("update");
    });
  }
}

function switchReservation() {
  axios.get("/api/dates/switch/" + date.value.id).then(() => {
    emit("update");
  });
}
</script>

<template>
  <div
    :class="date.old ? 'bg-gray-200' : 'bg-white'"
    class="relative p-4 w-full h-full rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700 flex flex-col items-start"
  >
    <button
      v-if="store.isAdmin"
      type="button"
      class="absolute buttonred -top-2 -right-2"
      @click="deleteDate(date.id)"
    >
      <svg
        class="w-6 h-6"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      ><path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M6 18L18 6M6 6l12 12"
      /></svg>
      <span class="sr-only">Supprimer</span>
    </button>
    <h5 class="text-xl font-medium text-gray-500 dark:text-gray-400">
      {{ date.date }}
    </h5>
    <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">
      {{ freeSeats() }} place(s) libre(s)
    </h5>
    <!-- List -->
    <ul
      role="list"
      class="my-7 space-y-2 grow"
    >
      <li
        v-for="(seat, key) in date.places"
        :key="key"
        class="flex space-x-3"
        :class=" seat === null ? 'text-gray-400 dark:text-gray-500' : 'text-blue-600 dark:text-blue-500' "
      >
        <!-- Icon -->
        <svg
          aria-hidden="true"
          class="flex-shrink-0 w-5 h-5"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg"
        >
          <title>Check icon</title>
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          />
        </svg>
        <span class="text-base font-normal leading-tight">{{
          seat === null ? "place libre" : seat.name
        }}</span>
      </li>
    </ul>
    <div v-if="!date.old">
      <button
        v-if="freeSeats() || alreadyReserved()"
        type="button"
        class="buttonblue"
        @click="switchReservation()"
      >
        {{ alreadyReserved() ? "Annuler" : "Réserver" }}
      </button>
      <button
        v-else
        type="button"
        disabled
        class="text-white bg-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center"
      >
        Complet
      </button>
    </div>    
  </div>
</template>
