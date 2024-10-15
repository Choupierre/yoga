<script setup lang="ts">
import { AxiosError, AxiosResponse } from "axios";

const { company } = storeToRefs(useAuthStore());
const { init } = useAuthStore();

const newGroup = reactive({
    name: "",
    ids: [],
});

const successMessage = ref("");
const errorMessage = ref("");

function userCreated(res: AxiosResponse) {
    console.log(res);
    successMessage.value = "nouveau groupe ajouté";
    newGroup.name = "";
    setTimeout(() => {
        successMessage.value = "";
    }, 3000);
}

function userCreatedError(err: AxiosError<{ message: string }>) {
    errorMessage.value = err?.response?.data?.message as string;
    setTimeout(() => {
        errorMessage.value = "";
    }, 3000);
}

function addUser() {
    if (!company.value)
        return
    if (company.value.groups === null)
        company.value.groups = []
    company.value.groups.push(newGroup)
    axios.put("/api/companies/" + company.value.id, company.value).then(userCreated).catch(userCreatedError).then(init);
}

function addToGroup(index: number, id: UserId) {
    company.value!.groups![index].ids.push(id)
    axios.put("/api/users/" + company.value!.id, company.value);
}

function deleteFromGroup(index: number, id: UserId) {
    company.value!.groups![index].ids = company.value!.groups![index].ids.filter(userId => userId !== id)
    axios.put("/api/users/" + company.value!.id, company.value);
}
</script>

<template>
    <div class="p-6 bg-slate-200 rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Ajouter un groupe</h5>
        </a>
        <div class="mb-6">
            <input id="name" v-model="newGroup.name" type="text" class="input1" placeholder="nom" required />
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
        <div class="mt-6 bg-white p-2 rounded-lg border shadow-md sm:p-4 dark:bg-gray-800 dark:border-gray-700 flex flex-col items-stretch justify-items-stretch gap-6" v-for="(group, index) in company?.groups" :key="group.ids.length">
            <GroupSlot :group="group" @add="(id) => addToGroup(index, id)" @delete="(id) => deleteFromGroup(index, id)" />
        </div>
    </div>
</template>
