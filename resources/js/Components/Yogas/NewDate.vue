<script setup lang="ts">
const { init } = useAuthStore();
const { auth, company } = storeToRefs(useAuthStore());

const formDate = reactive({
  date: undefined,
  until: undefined,
  places: auth.value?.config.slots,
  group: undefined
});

const formDatesuccess = ref("");
const formDateError = ref("");

function addDate() {
  axios
    .post("/api/dates", formDate)
    .then(() => {
      formDatesuccess.value = "nouvelle date ajoutée";
      formDate.date = undefined;
      init();
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
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
      Ajouter une date
    </h5>
    <div class="mb-6">
      <label for="date" class="label1">Date</label>
      <input id="date" v-model="formDate.date" type="datetime-local" class="input1" placeholder="name@flowbite.com" required>
    </div>
    <div class="mb-6">
      <label for="date" class="label1">Répéter jusqu'au</label>
      <input id="date" v-model="formDate.until" type="datetime-local" class="input1" placeholder="name@flowbite.com" required>
    </div>
    <div class="mb-6">
      <label v-if="!auth?.config.group" for="number" class="label1">Nombre de créneaux (durée {{ auth?.config.duration }} minutes) </label>
      <label v-else for="number" class="label1">nombre de participants</label>
      <input id="number" v-model="formDate.places" type="number" class="input1" min="1" max="10" required>
    </div>
    <div class="mb-6" v-if="company?.groups.length">
      <label for="number" class="label1">Groupes</label>
      <select class="input1 mb-6" v-model="formDate.group">
      <option v-for="group in company?.groups" :value="group.ids">{{ group.name }}</option>
    </select>
    </div>
  
    <button type="submit" class="buttonblue" @click="addDate">
      Ajouter
    </button>
    <div v-if="formDatesuccess" class="p-3 mt-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
      <span class="font-medium">{{ formDatesuccess }}</span>
    </div>
    <div v-if="formDateError" class="p-3 mt-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
      <span class="font-medium">{{ formDateError }}</span>
    </div>
  </div>
</template>
