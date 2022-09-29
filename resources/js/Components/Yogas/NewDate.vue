<script setup>
const store = authStore();

const formDate = {
  date: undefined,
  places:  store.defaultPlaces 
};

let formDatesuccess = ref("");
let formDateError = ref("");

const emit = defineEmits(["update"]);

function addDate() {
  axios
    .post("/api/dates", formDate)
    .then((res) => {
      formDatesuccess.value = "nouvelle date ajoutée";
      formDate.date = undefined;
      emit("update");
      setTimeout(() => {
        formDatesuccess.value = "";
      }, 3000);
    })
    .catch((err) => {
      console.log(err.response);
      formDateError.value = err.response.data.message;
      setTimeout(() => {
        formDateError.value = "";
      }, 3000);
    });
}

</script>

<template>
  <div class="p-6 bg-slate-200 rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Ajouter une date</h5>
    <div class="mb-6">
      <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Date :</label>
      <input type="datetime-local" id="date" v-model="formDate.date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@flowbite.com" required />
    </div>
    <div class="mb-6">
      <label for="number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">nombre de participants : </label>
      <input type="number" id="number" v-model="formDate.places" min="1" max="10" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
    </div>
    <button type="submit" @click="addDate" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">Ajouter</button>
    <div class="p-3 mt-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert" v-if="formDatesuccess">
      <span class="font-medium">{{ formDatesuccess }}</span>
    </div>
    <div class="p-3 mt-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert" v-if="formDateError">
      <span class="font-medium">{{ formDateError }}</span>
    </div>
  </div>
</template>
