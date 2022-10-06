<script setup lang="ts">
import { PropType } from "vue";
import { Date1 } from "@/stores/class";
const store = piniaStore();
const props = defineProps({
    date: {
        type: Object as PropType<Date1>,
        required: true,
    },
});
const { date } = toRefs(props);

async function deleteDate() {
    if (window.confirm("voulez vous supprimer cette date?")) {
        await axios.delete("/api/dates/" + date.value.date.id);
        store.init();
    }
}

</script>

<template>
    <div
        :class="date.date.old ? 'bg-gray-200' : 'bg-white'"
        class="relative p-4 w-full h-full rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700 flex flex-col items-start">
        <BtnDelete
            v-if="store.auth?.admin"
            class="absolute -top-2 -right-2"
            @click="deleteDate()" />
        <h5
            v-if="date.date.user.config.display_teacher_name"
            class="text-xl font-medium text-gray-500 dark:text-gray-400">
            {{ date.date.user.name }}
        </h5>
        <h5 class="text-xl font-medium text-gray-500 dark:text-gray-400">
            {{ date.date.date_for_humans }}
        </h5>
        <h5
            v-if="date.date.has_free_seats && !date.date.old"
            class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">
            {{ date.date.has_free_seats }} place(s) libre(s)
        </h5>
        <!-- List -->
        <ul
            role="list"
            class="my-7 space-y-2 grow">
            <DateSlot
                v-for="(place, key) in date.places"
                :key="key"
                :date="date"
                :place="place" />
        </ul>
        <div v-if="!date.date.old && date.date.user.config.group">
            <button
                v-if="(date.date.has_free_seats || date.date.already_reserved) && !store.auth?.admin"
                type="button"
                class="buttonblue"
                @click="date.switchReservation()">
                {{ date.date.already_reserved ? "Annuler" : "Réserver" }}
            </button>
            <button
                v-if="!date.date.has_free_seats && !date.date.already_reserved"
                type="button"
                disabled
                class="text-white bg-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">
                Complet
            </button>
        </div>
    </div>
</template>
