<script setup lang="ts">
const { auth, users, modal } = storeToRefs(useAuthStore());
const { init } = useAuthStore();

const props = defineProps<{ place: UserId | null, date: DateElement, placeKey: number }>();

const canReserveSeat = computed(() => {
    if (auth.value?.admin) return false;
    if (props.place && props.place !== auth.value?.id) return false;
    if (props.place && props.place === auth.value?.id) return true;
    if (props.date.places.includes(auth.value!.id)) return false;
    return !props.date.user.config.group && !props.date.old;
})

const liClass = computed(() => {
    let classArray: string = "text-gray-400 dark:text-gray-500"
    const user = users.value.find(u => u.id === props.place)
    if (user)
        classArray = user.active ? "text-blue-600 dark:text-blue-500" : "text-red-600 dark:text-red-500"
    //classArray += canReserveSeat.value ? " hover:cursor-pointer hover:bg-blue-100" : "";
    return classArray;
})

const student = ref(props.place)
watchEffect(() => { student.value = props.place })
watch(student, () => {
    if (student.value && student.value !== props.place)
        changeReservation(student.value)
})

const hour = computed(() => {
    const date = new Date(props.date.date).getTime();
    const dateSlot = new Date(date + 1000 * 60 * (auth.value?.config.duration ?? 30) * props.placeKey);
    return ("0" + dateSlot.getHours()).slice(-2) + "h" + ("0" + dateSlot.getMinutes()).slice(-2);
})


async function changeReservation(userId: UserId) {
    modal.value = true

    try {
        await axios.post(`/api/dates/change/${props.date.id}/${userId}`, { key: props.placeKey });
        await init()
    } catch (error: any) { }

    modal.value = false
}

async function deleteReservation() {
    if (!window.confirm("voulez vous supprimer cette réservation?"))
        return

    modal.value = true

    try {
        await axios.put("/api/dates/" + props.date.id, { key: props.placeKey });
        await init()
    } catch (error: any) { }

    modal.value = false
}

async function switchReservation() {
    modal.value = true

    try {
        await axios.post("/api/dates/switch/" + props.date.id, { key: props.placeKey });
        await init()
    } catch (error: any) { }

    modal.value = false
}

const filteredUsers = computed(() => users.value.filter(u => props.date.user.config.group ? student.value === u.id || !props.date.places.includes(u.id) : true))
</script>

<template>
    <li class="flex items-center space-x-3" :class="liClass">
        <CheckIcon />
        <span v-if="!date.user.config.group" class="text-base font-normal leading-tight">
            {{ hour }}
        </span>
        <span class="text-base font-normal leading-tight grow" v-if="!auth?.admin">
            {{ place ? users.find(u => u.id === place)?.name : "place libre" }}
        </span>
        <select v-model="student" v-else class="input1" :key="student ?? 0">
            <option v-for="student2 in filteredUsers" :value="student2.id">{{ student2.name }}</option>
        </select>
        <BtnDeleteReservation class="ml-auto" v-if="place && auth?.admin" @click.stop="deleteReservation()" />
        <BtnDeleteReservation class="ml-auto" v-if="place===auth?.id" @click.stop="switchReservation()" />
    </li>
</template>
