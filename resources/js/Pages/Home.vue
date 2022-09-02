<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { getCurrentInstance, ref, reactive, watch, computed, onMounted } from "vue";

onMounted(() => {
   
    updateDates()
    updateUsers()
});

function updateDates(){
    axios.get("/api/dates").then((res) => {
        places.value = res.data;
        console.log(res.data);
    });
}

function updateUsers(){
    axios.get("/api/users").then((res) => {
        users.value = res.data;
        console.log(res.data);
    });
}


const app = getCurrentInstance();
let formDate = { date: undefined, places: 5 };
let formDatesuccess = ref("");
let formDateError = ref("");
let formUser = { name: "", email: "" };
let formUsersuccess = ref("");
let formUserError = ref("");
let places = ref([]);
let users = ref([]);

function addDate() {
    axios.post("/api/dates", formDate).then((res) => {
        console.log(res);
        formDatesuccess.value = "nouvelle date ajoutée";
        formDate.date = undefined;
        setTimeout(() => {
            formDatesuccess.value = "";
        }, 3000);
        places.value = res.data;
    }).catch(err => {
        console.log(err.response);
        formDateError.value = err.response.data.message
        setTimeout(() => {
            formDateError.value = "";
        }, 3000);
    });
}

function addUser() {
    axios.post("/api/users", formUser).then((res) => {
        console.log(res);
        formUsersuccess.value = "nouvel élève ajouté";
        formUser.name = "";
        formUser.email = "";
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

function deleteDate(id) {
    axios.delete("/api/dates/" + id).then((res) => {
        places.value = res.data;
        console.log(res);
    });
}

function deleteUser(id) {
    axios.delete("/api/users/" + id).then((res) => {
        users.value = res.data;
        console.log(res);
        updateDates()
    });
}



const alreadyPresent = (place) =>
    !!place.places.find((place) => place && place.id === app.attrs.auth.user.id);
const freeSeats = (place) =>
    place.places.reduce((prev, current) => prev + (current == null ? 1 : 0), 0);

function switchUser(id) {
    axios.get("/api/dates/switch/" + id).then((res) => {
        places.value = res.data;
        console.log(res);
    });
}
</script>

<template>

    <Head title="Home" />
    <BreezeAuthenticatedLayout>
        <div class="container mx-auto">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 m-4" v-if="$page.props.auth.user.admin">
                <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Ajouter une date</h5>
                    <div class="mb-6">
                        <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Date :</label>
                        <input type="datetime-local" id="date" v-model="formDate.date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="name@flowbite.com" required>
                    </div>
                    <div class="mb-6">
                        <label for="number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">nombre de participants : </label>
                        <input type="number" id="number" v-model="formDate.places" min="1" max="10"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required>
                    </div>
                    <button type="submit" @click="addDate"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">Ajouter</button>
                    <div class="p-3 mt-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert" v-if="formDatesuccess"><span class="font-medium">{{
                            formDatesuccess
                    }}</span> </div>
                    <div class="p-3 mt-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert" v-if="formDateError"><span class="font-medium">{{
                            formDateError
                    }}</span> </div>
                </div>

                <div class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
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



                    <span id="badge-dismiss-green" class="inline-flex items-center py-1 px-2 mr-2 text-sm font-medium text-green-800 bg-green-100 rounded dark:bg-green-200 dark:text-green-800"
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

            <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-4 m-4">
                <div class="p-4 w-full bg-white rounded-lg border shadow-md sm:p-8 dark:bg-gray-800 dark:border-gray-700" v-for="(place, key) in places" :key="key">
                    <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">{{ place.date }} : {{ freeSeats(place) }} place(s) libre(s)</h5>
                    <!-- List -->
                    <ul role="list" class="my-7 space-y-5" v-for="(seat, key) in place.places" :key="key">
                        <li class="flex space-x-3" :class="seat === null ? 'text-gray-400 dark:text-gray-500' : 'text-blue-600 dark:text-blue-500'">
                            <!-- Icon -->
                            <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <title>Check icon</title>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-base font-normal leading-tight">{{ seat === null ? 'place libre' : seat.name }}</span>
                        </li>
                    </ul>
                    <button type="button" @click="switchUser(place.id)" v-if="freeSeats(place) || alreadyPresent(place)"
                        class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">{{
                                alreadyPresent(place) ? "se retirer" : "réserver"
                        }}</button>
                    <button type="button" disabled v-else class="text-white bg-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">complet</button>
                    <button type="button" @click="deleteDate(place.id)" v-if="$page.props.auth.user.admin"
                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-200 dark:focus:ring-red-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center mt-6">
                        supprimer</button>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
