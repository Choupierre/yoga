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



function hour(date: string, key:number) {
  let hours = parseInt(date.slice(-5, -3));
  let minutes:number|string = parseInt(date.slice(-2));
  const coef = minutes + 30 >= 60 ? 1 : 0;
  hours = hours + Math.floor((key + coef) / 2);
  minutes = (minutes + 30 * key) % 60;
  minutes = minutes === 0 ? "00" : minutes;
  return hours + "h" + minutes;
}

function deleteDate(id:number) {
  if (window.confirm("voulez vous supprimer cette date?")) {
    axios.delete("/api/dates/" + id).then(() => {
      emit("update");
    });
  }
}

function switchReservation(key:number) {
  if (!date.value.old)
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
      {{ date.user.name }}
    </h5>
    <h5 class="text-xl font-medium text-gray-500 dark:text-gray-400">
      {{ date.date }}
    </h5>
    <!-- List -->
    <ul
      role="list"
      class="mt-5 space-y-2 grow"
    >
      <li
        v-for="(seat, key) in date.places"
        :key="key"
        class="flex space-x-3"
        :class="[seat === null ? 'text-gray-400 dark:text-gray-500' : 'text-blue-600 dark:text-blue-500',(seat && seat.id!==store.user.id) || date.old ? '': 'hover:cursor-pointer hover:bg-red-100']"
        @click="switchReservation(key)"
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
        <span class="text-base font-normal leading-tight">{{ hour(date.date, key) }} - {{ seat === null ? "place libre" : seat.name }}</span>
      </li>
    </ul>    
  </div>
</template>
