<script setup lang="ts">
import { AxiosError, AxiosResponse } from "axios";

const { init } = useAuthStore();
const { users } = storeToRefs(useAuthStore());

const formUser = reactive({
    name: "",
    email: "",
});

const successMessage = ref("");
const errorMessage = ref("");

function userCreated(res: AxiosResponse) {
    console.log(res);
    successMessage.value = "nouvel élève ajouté";
    formUser.name = "";
    formUser.email = "";
    init();
    setTimeout(() => {
        successMessage.value = "";
    }, 3000);
}

function userCreatedError(err: AxiosError<{ message: string }>) {
    errorMessage.value = err?.response?.data?.message as string;
    formUser.name = "";
    formUser.email = "";
    setTimeout(() => {
        errorMessage.value = "";
    }, 3000);
}

function addUser() {
    axios.post("/api/users", formUser).then(userCreated).catch(userCreatedError);
}

async function deleteUser(user: UserElement) {
    if (window.confirm("voulez vous supprimer cet élève?")) {
        await axios.delete("/api/users/" + user.id);
        init();
    }
}

function activeClass(user: UserElement) {
    if (user.active && user.activated)
        return 'text-green-800 bg-green-100 dark:bg-green-200 dark:text-green-800'
    if (!user.active)
        return 'text-red-800 bg-red-100 dark:bg-red-200 dark:text-red-800'
    return 'text-gray-800 bg-gray-100 dark:bg-gray-200 dark:text-gray-800'
}

const sortUsers = computed(() => users.value.sort((a, b) => { 
    if (a.active && b.active && a.activated !== b.activated) 
        return a.activated ? 1 : -1; 
     
    return b.active ? 1 : -1;; 
}))
</script>

<template>
    <div class="p-6 bg-slate-200 rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Ajouter un élève</h5>
        </a>
        <div class="mb-6">
            <label for="name" class="label1">Nom de l'élève :
            </label>
            <input id="name" v-model="formUser.name" type="text" class="input1" placeholder="nom" required />
        </div>
        <div class="mb-6">
            <label for="email" class="label1">Email de l'élève :
            </label>
            <input id="email" v-model="formUser.email" type="email" class="input1" placeholder="email@email.fr" required />
        </div>
        <button type="submit" class="buttonblue" @click="addUser">
            Ajouter
        </button>
        <div v-if="successMessage" class="p-3 mt-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
            <span class="font-medium">{{ successMessage }}</span>
        </div>
        <div v-if="errorMessage" class="p-3 mt-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
            <span class="font-medium">{{ errorMessage }}</span>
        </div>
        <div class="mt-4">
            <span v-for="user in sortUsers" id="badge-dismiss-green" :key="user.id" :class="activeClass(user)" class="inline-flex items-center py-1 px-2 mr-2 mb-2 text-sm font-medium rounded">
                {{ user.name }}
                <button type="button" class="inline-flex items-center p-0.5 ml-2 text-sm bg-transparent rounded-sm hover:bg-gray-200 hover:text-green-900 dark:hover:bg-gray-300" data-dismiss-target="#badge-dismiss-green" aria-label="Remove" @click="deleteUser(user)">
                    <svg aria-hidden="true" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Delete user</span>
                </button>
            </span>
        </div>
    </div>
</template>
