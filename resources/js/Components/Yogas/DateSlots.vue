<script setup lang="ts">
import { PropType } from "vue";
import { DateElement, User } from "../../types";
const store = authStore();
const props = defineProps({
    date: {
        type: Object as PropType<DateElement>,
        required: true,
    },
});
const { date } = toRefs(props);

function liClass(place: User | null): Array<string> {
    const classArray = [];
    classArray.push(
        place === null
            ? "text-gray-400 dark:text-gray-500"
            : "text-blue-600 dark:text-blue-500"
    );
    if (date.value.canReserveSeat(place))
        classArray.push("hover:cursor-pointer hover:bg-blue-100");
    return classArray;
}
</script>

<template>
  <ul
    role="list"
    class="my-7 space-y-2 grow"
  >
    <li
      v-for="(place, key) in date.places"
      :key="key"
      class="flex space-x-3"
      :class="liClass(place)"
      @click="
        date.canReserveSeat(place) ? date.switchReservation(key) : null
      "
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
      <span
        v-if="store.isInsa"
        class="text-base font-normal leading-tight"
      >
        {{ date.hour(key) }}
      </span>
      <span class="text-base font-normal leading-tight">
        {{ place === null ? "place libre" : place.name }}
      </span>
      <button
        v-if="place && store.isAdmin"
        type="button"
        class="text-red-600"
        @click.stop="date.deleteReservation(key)"
      >
        <svg
          class="w-4 h-4"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
        <span class="sr-only">Supprimer</span>
      </button>
    </li>
  </ul>
</template>
