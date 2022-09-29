<script setup>
const store = authStore();

const props = defineProps({
  date: Object,
});
const { date } = toRefs(props);

const emit = defineEmits(["update"]);

const alreadyReserved = () => !!date.value.places.find((place) => place && place.id === store.id);
const freeSeats = () => date.value.places.reduce((prev, current) => prev + (current == null ? 1 : 0), 0);

function hour(date, key) {
  let hours = parseInt(date.slice(-5, -3));
  let minutes = parseInt(date.slice(-2));
  let coef = minutes + 30 >= 60 ? 1 : 0;
  hours = hours + Math.floor((key + coef) / 2);
  minutes = (minutes + 30 * key) % 60;
  minutes = minutes === 0 ? '00' : minutes
  return hours + "h" + minutes;
}

function deleteDate(id) {
  if (window.confirm("voulez vous supprimer cette date?")) {
    axios.delete("/api/dates/" + id).then((res) => {
      emit("update");
    });
  }
}

function switchReservation(key) {
  axios.post("/api/dates/switch/" + date.value.id, { key }).then((res) => {
    emit("update");
  });
}
</script>

<template>
  <div :class="date.old ? 'bg-gray-200' : 'bg-white'" class="p-4 w-full h-full rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700 flex flex-col">
    <h5 class="text-xl font-medium text-gray-500 dark:text-gray-400">{{ date.user.name }}</h5>
    <h5 class="text-xl font-medium text-gray-500 dark:text-gray-400">{{ date.date }}</h5>   
    <!-- List -->
    <ul role="list" class="my-7 space-y-2 grow">
      <li class="flex space-x-3 hover:cursor-pointer hover:bg-red-100" :class="seat === null ? 'text-gray-400 dark:text-gray-500' : 'text-blue-600 dark:text-blue-500'" v-for="(seat, key) in date.places" :key="key" @click="switchReservation(key)">
        <!-- Icon -->
        <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <title>Check icon</title>
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span class="text-base font-normal leading-tight">{{ hour(date.date, key) }} - {{ seat === null ? "place libre" : seat.name }}</span>
      </li>
    </ul>
    <button type="button" @click="deleteDate(date.id)" v-if="store.isAdmin" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center mt-6">supprimer</button>
  </div>
</template>
