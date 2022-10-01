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

function switchReservation(key?:number) {
  axios.post("/api/dates/switch/" + date.value.id, { key }).then(() => {
    emit("update");
  });
}
</script>

<template>
  <div
    :class="date.old ? 'bg-gray-200' : 'bg-white'"
    class="relative p-4 w-full h-full rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700 flex flex-col items-start"
  >
    <BtnDelete
      v-if="store.isAdmin"    
      class="absolute -top-2 -right-2"
      @click="deleteDate(date.id)"
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
      {{ freeSeats() }} place(s) libre(s)
    </h5>
    <!-- List -->
    <DateSlots
      :date="date"
      @update="emit('update')"
    />
    <div v-if="!date.old && !store.isInsa">
      <button
        v-if="(freeSeats() || alreadyReserved()) && !store.isAdmin"
        type="button"
        class="buttonblue"
        @click="switchReservation()"
      >
        {{ alreadyReserved() ? "Annuler" : "Réserver" }}
      </button>
      <button
        v-if="!freeSeats() && !alreadyReserved()"
        type="button"
        disabled
        class="text-white bg-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center"
      >
        Complet
      </button>
    </div>      
  </div>
</template>
