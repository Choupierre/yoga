<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import NewDate from "./../Components/yoga/NewDate.vue";
import NewUser from "./../Components/yoga/NewUser.vue";
import Date from "./../Components/yoga/Date.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { ref, onMounted } from "vue";

onMounted(() => {
    update()
});

function update() {
    axios.get("/api/store").then((res) => {
        console.log('update')
        dates.value = res.data.dates;
        users.value = res.data.users;
    });
}

let dates = ref([]);
let users = ref([]);
</script>

<template>
    <Head title="Yoga" />
    <BreezeAuthenticatedLayout>
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 m-4" v-if="$page.props.auth.user.admin">
                <NewDate @update="update" />
                <NewUser :users="users" @update="update" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 m-4">
                <Date v-for="(date, key) in dates" :key="key" :date="date" :user="$page.props.auth.user" @update="update" />
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
