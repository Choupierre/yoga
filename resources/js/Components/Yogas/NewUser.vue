<script setup lang="ts">
const { init } = useAuthStore();
const { users, modal } = storeToRefs(useAuthStore());

const formUser = reactive({ name: "", email: "", });

const errorMessage = ref("");

async function addUser() {
    modal.value = true

    try {
        await axios.post("/api/users", formUser)
        await init()
        formUser.name = "";
        formUser.email = "";
    } catch (error: any) {
        errorMessage.value = error?.response?.data?.message as string;
    }

    modal.value = false
}

async function activeUser(user: UserElement) {
    if (!window.confirm(`voulez vous ${user.active ? 'désactiver' : 'activer'} cet élève?`))
        return

    modal.value = true

    try {
        await axios.delete("/api/users/" + user.id);
        await init()
    } catch (error: any) {
        errorMessage.value = error?.response?.data?.message as string;
    }

    modal.value = false
}

function activeClass(user: UserElement) {
    if (user.active && user.activated)
        return 'text-green-800 bg-green-100 dark:bg-green-200 dark:text-green-800 hover:bg-green-300 hover:text-green-900 dark:hover:bg-green-300 dark:hover:text-green-900'
    if (!user.active)
        return 'text-red-800 bg-red-100 dark:bg-red-200 dark:text-red-800 hover:bg-red-300 hover:text-red-900 dark:hover:bg-red-300 dark:hover:text-red-900'
    return 'text-gray-800 bg-gray-100 dark:bg-gray-200 dark:text-gray-800 hover:bg-gray-300 hover:text-gray-900 dark:hover:bg-gray-300 dark:hover:text-gray-900'
}

const sortUsers = computed(() => users.value.sort((a, b) => {
    if (a.active && b.active && a.activated !== b.activated)
        return a.activated ? 1 : -1;

    return b.active ? 1 : -1;;
}))
</script>

<template>
    <div class="p-6 bg-slate-200 rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">

        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Ajouter un élève</h5>

        <div class="mb-6">
            <label for="name" class="label1">Nom de l'élève </label>
            <input id="name" v-model="formUser.name" type="text" class="input1" placeholder="nom" required />
        </div>
        <div class="mb-6">
            <label for="email" class="label1">Email de l'élève </label>
            <input id="email" v-model="formUser.email" type="email" class="input1" placeholder="email@email.fr" required />
        </div>
        <button type="submit" class="buttonblue" @click="addUser"> Ajouter </button>
        <div v-if="errorMessage" class="p-3 mt-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
            <span class="font-medium">{{ errorMessage }}</span>
        </div>
        <div class="mt-4">
            <span v-for="user in sortUsers" id="badge-dismiss-green" :key="user.id" :class="activeClass(user)" class="inline-flex items-center py-1 px-2 mr-2 mb-2 text-sm font-medium rounded hover:cursor-pointer" @click="activeUser(user)">
                {{ user.name }}
            </span>
        </div>
    </div>
</template>
