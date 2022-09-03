<script setup>
import { ref,toRefs } from "vue";

let formUser = { name: "", email: "" };
let formUsersuccess = ref("");
let formUserError = ref("");

const props = defineProps({
    'users': Array
})

const { users } = toRefs(props);


const emit = defineEmits(['update'])

function addUser() {
    axios.post("/api/users", formUser).then((res) => {
        console.log(res);
        formUsersuccess.value = "nouvel élève ajouté";
        formUser.name = "";
        formUser.email = "";
        emit('update')
        setTimeout(() => {
            formUsersuccess.value = "";
        }, 3000);
    }).catch(err => {
        console.log(err.response);
        formUserError.value = err.response.data.message
        setTimeout(() => {
            formUserError.value = "";
        }, 3000);
    });
}

function deleteUser(id) {
    if (window.confirm('voulez vous supprimer cet élève?')) {
        axios.delete("/api/users/" + id).then((res) => {
            emit('update')
        });
    }
}
</script>

<template>
    <div class="p-6 bg-slate-200 rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Ajouter un élève</h5>
        </a>
        <div class="mb-6">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nom de l'élève : </label>
            <input type="text" id="name" v-model="formUser.name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="nom" required>
        </div>
        <div class="mb-6">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email de l'élève : </label>
            <input type="email" id="email" v-model="formUser.email"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="email@email.fr" required>
        </div>
        <button type="submit" @click="addUser"
            class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">Ajouter</button>
        <div class="p-3 mt-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert" v-if="formUsersuccess"><span class="font-medium">{{
                formUsersuccess
        }}</span> </div>
        <div class="p-3 mt-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert" v-if="formUserError"><span class="font-medium">{{
                formUserError
        }}</span> </div>
        <div class="mt-4">
            <span id="badge-dismiss-green" class="inline-flex items-center py-1 px-2 mr-2 mb-2 text-sm font-medium text-green-800 bg-green-100 rounded dark:bg-green-200 dark:text-green-800"
                v-for="user in users">
                {{ user.name }}
                <button type="button" @click="deleteUser(user.id)"
                    class="inline-flex items-center p-0.5 ml-2 text-sm text-green-400 bg-transparent rounded-sm hover:bg-green-200 hover:text-green-900 dark:hover:bg-green-300 dark:hover:text-green-900"
                    data-dismiss-target="#badge-dismiss-green" aria-label="Remove">
                    <svg aria-hidden="true" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Remove badge</span>
                </button>
            </span>
        </div>
    </div>
</template>
