<script setup lang="ts">
import { Place } from "@/stores/class";
import { PropType } from "vue";

const store = piniaStore();
const props = defineProps({
    place: {
        type: Object as PropType<Place>,
        required: true,
    },
});
const { place } = toRefs(props);

function canReserveSeat(place: Place) {   
    if (store.auth?.admin) return false; 
    if (place.place && place.place?.id !== store.auth?.id) return false;   
    return place.date.date.user.config.group && !place.date.date.old;
}

function liClass(place: Place): string {
    let classArray: string = place.place?.id ? "text-blue-600 dark:text-blue-500" : "text-gray-400 dark:text-gray-500";
    classArray += canReserveSeat(place) ? " hover:cursor-pointer hover:bg-blue-100" : "";
    return classArray;
}
</script>

<template>
    <li
        class="flex space-x-3"
        :class="liClass(place)"
        @click="canReserveSeat(place) ? place.switchReservation() : null">
        <CheckIcon />
        <span
            v-if="!place.date.date.user.config.group"
            class="text-base font-normal leading-tight">
            {{ place.hour() }}
        </span>
        <span class="text-base font-normal leading-tight">
            {{ place.place?.id ? place.place.name : "place libre" }}
        </span>
        <BtnDeleteReservation
            v-if="place.place?.id && store.auth?.admin"
            @click.stop="place.deleteReservation()" />
    </li>
</template>
