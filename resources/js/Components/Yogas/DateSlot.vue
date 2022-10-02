<script setup lang="ts">
import { PropType } from "vue";
import { Place } from "@/global";
const store = theStore();
const props = defineProps({
    place: {
        type: Object as PropType<Place>,
        required: true,
    },
});
const { place } = toRefs(props);

function liClass(place: Place): string {   
    let classArray: string = place.id ? "text-blue-600 dark:text-blue-500" : "text-gray-400 dark:text-gray-500";
    classArray += place.canReserveSeat ? " hover:cursor-pointer hover:bg-blue-100" : "";
    return classArray;
}
</script>

<template>
    <li
        class="flex space-x-3"
        :class="liClass(place)"
        @click="place.canReserveSeat ? place.switchReservation() : null">
        <CheckIcon />
        <span
            v-if="store.isInsa"
            class="text-base font-normal leading-tight">
            {{ place.hour }}
        </span>
        <span class="text-base font-normal leading-tight">
            {{ place.id ? place.name : "place libre" }}
        </span>
        <BtnDeleteReservation
            v-if="place.id && store.isAdmin"
            @click.stop="place.deleteReservation()" />
    </li>
</template>
