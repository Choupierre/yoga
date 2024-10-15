<script setup lang="ts">
const { init } = useAuthStore();
const { auth, users, modal } = storeToRefs(useAuthStore());

const props = defineProps<{ date: DateElement }>();

async function deleteDate() {
    if (!window.confirm("voulez vous supprimer cette date?"))
        return

    modal.value = true

    try {
        await axios.delete("/api/dates/" + props.date.id);
        await init()
    } catch (error: any) { }

    modal.value = false
}

async function switchReservation() {
    modal.value = true

    try {
        await axios.post("/api/dates/switch/" + props.date.id);
        await init()
    } catch (error: any) { }

    modal.value = false
}

async function addWaiting() {
    modal.value = true

    try {
        await axios.post("/api/dates/waiting/" + props.date.id);
        await init()
    } catch (error: any) { }

    modal.value = false
}
</script>


<template>
    <div :class="date.old ? 'bg-gray-200' : 'bg-white'" class="relative p-4 w-full h-full rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700 flex flex-col items-stretch justify-items-stretch gap-6">
        <BtnDelete v-if="auth?.admin" class="absolute -top-2 -right-2" @click="deleteDate()" />
        <div v-if="date.user.config.display_teacher_name">
            <h5 class="text-lg font-medium text-gray-500 dark:text-gray-400">
                {{ date.user.name }}
            </h5>
            <h5 class="text-xl font-semibold text-gray-500 dark:text-gray-400">
                {{ date.date_for_humans }}
            </h5>
            <h5 v-if="date.has_free_seats && !date.old" class="text-base font-medium text-gray-500 dark:text-gray-400">
                - {{ date.has_free_seats }} place(s) libre(s)
            </h5>
        </div>
        <!-- List -->
        <ul role="list" class="space-y-2">
            <DateSlot v-for="(place, key) in date.places" :place-key="key" :date="date" :place="place" />
        </ul>
        <template v-if="!date.old && date.user.config.group">
            <button v-if="(date.has_free_seats || date.already_reserved) && !auth?.admin" type="button" class="buttonblue" @click="switchReservation()">
                {{ date.already_reserved ? "Annuler réservation" : "Réserver" }}
            </button>
            <template v-if="date.waiting.length">
                <h5 class="text-xl font-medium text-gray-500 dark:text-gray-400 mb-1">
                    Liste d'attente
                </h5>
                <ul role="list" class="space-y-1 grow">
                    <li v-for="(place, key) in date.waiting" :key="key" class="flex space-x-3 text-green-600 dark:text-blue-500">
                        <span class="text-base font-normal leading-tight">
                            {{ users.find(u => u.id === place)?.name }}
                        </span>
                    </li>
                </ul>
            </template>
            <button v-if="!date.has_free_seats && !date.already_reserved && !auth?.admin" type="button" class="buttonblue" @click="addWaiting()">
                {{ date.already_waiting ? "Retirer de la liste" : "Liste d'attente" }}
            </button>
        </template>
    </div>
</template>
