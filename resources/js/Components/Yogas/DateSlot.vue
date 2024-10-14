<script setup lang="ts">
const { auth, users } = storeToRefs(useAuthStore());

const props = defineProps<{ place: Place, date: Date1 }>();

function canReserveSeat(place: Place) {
    if (auth.value?.admin) return false;
    if (place.place && place.place?.id !== auth.value?.id) return false;
    if (place.place && place.place?.id === auth.value?.id) return true;
    if (props.date.places.map(p => p.place?.id).includes(auth.value?.id)) return false;
    return !place.date.date.user.config.group && !place.date.date.old;
}

function liClass(place: Place): string {
    let classArray: string = place.place?.id ? "text-blue-600 dark:text-blue-500" : "text-gray-400 dark:text-gray-500";
    classArray += canReserveSeat(place) ? " hover:cursor-pointer hover:bg-blue-100" : "";
    return classArray;
}

const student = ref<number>()
watchEffect(() => { student.value = props.place.place?.id })
watch(student, () => {
    if (student.value)
        props.place.changeReservation(student.value)
})
</script>

<template>
    <li class="flex items-center space-x-3" :class="liClass(place)" @click="canReserveSeat(place) ? place.switchReservation() : null">
        <CheckIcon />
        <span v-if="!place.date.date.user.config.group" class="text-base font-normal leading-tight">
            {{ place.hour() }}
        </span>
        <span class="text-base font-normal leading-tight" v-if="!auth?.admin">
            {{ place.place?.id ? place.place.name : "place libre" }}
        </span>
        <select v-model="student" v-else class="input1">
            <option v-for="student in users" :value="student.id">{{ student.name }}</option>
        </select>
        <BtnDeleteReservation v-if="place.place?.id && auth?.admin" @click.stop="place.deleteReservation()" />
    </li>
</template>
