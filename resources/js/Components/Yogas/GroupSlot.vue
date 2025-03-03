<script setup lang="ts">
const { users } = storeToRefs(useAuthStore());

const emit = defineEmits<{ add: [UserId], delete: [UserElement | undefined] }>()

const props = defineProps<{ group: { name: string, ids: UserId[] } }>();

const addStudent = ref(null as null | UserId)
watch(addStudent, () => {
    if (!addStudent.value)
        return
    emit('add', addStudent.value)
})

const filteredUser = computed(() => users.value.filter(u => u.active && !props.group.ids.includes(u.id)))

function activeClass(user: UserElement | undefined) {
    if (user?.active && user?.activated)
        return 'bg-blue-300 dark:bg-blue-400'
    if (user?.active)
        return 'bg-blue-200 dark:bg-blue-300'
    return 'bg-gray-200 dark:bg-gray-300 text-gray-500'
}
</script>

<template>
    <div>
        <h5 class="text-lg font-medium text-gray-500 dark:text-gray-400">{{ group.name }} ({{ group.ids.length }} participants)</h5>
        <div class="mt-2 flex flex-wrap gap-2">
            <span v-for="user in group.ids.map(id => users.find(user => user.id === id))" class=" inline-flex items-center py-1 px-2 text-sm font-medium rounded" :class="activeClass(user)">
                {{ user?.name }}
                <button type="button" class="inline-flex items-center p-0.5 ml-2 text-sm bg-transparent rounded-sm hover:bg-red-200 text-red-600 dark:hover:bg-red-300" data-dismiss-target="#badge-dismiss-green" aria-label="Remove" @click="emit('delete', user)">
                    <svg aria-hidden="true" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Delete user</span>
                </button>
            </span>
        </div>
        <select class="input1 mt-6" v-model="addStudent" v-if="filteredUser.length">
            <option :value="null"></option>
            <option v-for="student in filteredUser" :value="student.id">{{ student.name }}</option>
        </select>
    </div>
</template>
