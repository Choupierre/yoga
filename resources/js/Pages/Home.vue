<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { getCurrentInstance, ref, reactive, watch, computed, onMounted } from 'vue';


onMounted(() => {
    axios.get('/api/dates').then(res => {
        places.value = res.data
        console.log(places)
    })
})

const app = getCurrentInstance()
let form = { date: undefined, places: 5 }
let formUser = { name: '', email: '' }
let places = ref([])

function addDate() {
    axios.post('/api/dates', form).then(res => {
        console.log(res)
        places.value = res.data
    })
}

function addUser() {
    axios.post('/api/users', formUser).then(res => {
        console.log(res)
    })
}

function deleteDate(id){
    axios.delete('/api/dates/' + id).then(res => {
        places.value = res.data
        console.log(res)
    })
}

const alreadyPresent = (place) => !!place.places.find(place => place && place.id === app.attrs.auth.user.id)
const freeSeats = (place) => place.places.reduce((prev, current) => prev + (current == null ? 1 : 0), 0)


function switchUser(id) {
    axios.get('/api/dates/switch/' + id).then(res => {
        places.value = res.data
        console.log(res)
    })
}
</script>

<template>

    <Head title="Home" />
    <BreezeAuthenticatedLayout>
        <div class="container mx-auto">
            <div class="border-green-500 bg-green-100 border-2 rounded p-4 m-4" v-if="$page.props.auth.user.admin">
                <div class="mt-2">
                    <input type="datetime-local" v-model="form.date" class="rounded-md" name="" id="" />
                    <input type="number" v-model="form.places" class="ml-2 rounded-md" name="" id="" min="1" max="10" />
                    <button type="button" @click="addDate" class="ml-2">Ajouter une date</button>
                </div>
                <div class="mt-2">
                    <input type="text" v-model="formUser.name" class="rounded-md" name="" id="" />
                    <input type="email" name="email" v-model="formUser.email" class="ml-2 rounded-md" id="" min="1"
                        max="10" />
                    <button type="button" @click="addUser" class="ml-2">Ajouter un élève</button>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-4 m-4">
                <div v-for="(place, key) in places" :key="key" class="border-blue-500 bg-blue-100 border-2 rounded p-4">
                    <div>
                        <button type="button" @click="deleteDate(place.id)" v-if="$page.props.auth.user.admin"
                            class="ml-2 !bg-red-500">supprimer</button><br>
                        {{ place.date }} :
                        {{ freeSeats(place) }} place(s) libre(s)
                        <button type="button" @click="switchUser(place.id)"
                            v-if="freeSeats(place) || alreadyPresent(place)" class="ml-2">{{ alreadyPresent(place) ? '-'
                                    :
                                    '+'
                            }}</button>                      
                    </div>
                    <ul v-for="(seat, key) in place.places" :key="key">
                        <li v-if="seat == null" class="ml-2 text-red-600 underline">{{ key + 1 }} : libre</li>
                        <li v-else="seat==null" class="ml-2"> {{ key + 1 }} : {{ seat.name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
