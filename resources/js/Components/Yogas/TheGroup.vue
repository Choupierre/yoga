<script setup lang="ts">
const { company, modal } = storeToRefs(useAuthStore());
const { init } = useAuthStore();

const newGroup = reactive({ name: "", ids: [], });

const errorMessage = ref("");

async function addUser() {
  if (company.value!.groups === null)
    company.value!.groups = []
  company.value!.groups.push(newGroup)
  modal.value = true

  try {
    await axios.put("/api/companies/" + company.value!.id, company.value);
    await init()
    newGroup.name = "";
  } catch (error: any) {
    errorMessage.value = error?.response?.data?.message as string;
  }

  modal.value = false
}

async function addToGroup(index: number, id: UserId) {
  company.value!.groups[index].ids.push(id)
  modal.value = true

  try {
    await axios.put("/api/companies/" + company.value!.id, company.value);
    await init()
    newGroup.name = "";
    errorMessage.value=""
  } catch (error: any) {
    await init()
    errorMessage.value = error?.response?.data?.message as string;
  }

  modal.value = false
}

async function deleteFromGroup(index: number, user: UserElement | undefined) {
  company.value!.groups[index].ids = company.value!.groups[index].ids.filter(userId => userId !== user?.id)
  modal.value = true

  try {
    await axios.put("/api/companies/" + company.value!.id, company.value);
    await init()
    newGroup.name = "";
  } catch (error: any) {
    errorMessage.value = error?.response?.data?.message as string;
  }

  modal.value = false
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
    <div v-if="errorMessage" class="p-3 mt-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
      <span class="font-medium">{{ errorMessage }}</span>
    </div>
    <div class="mt-6 bg-white p-2 rounded-lg border shadow-md sm:p-4 dark:bg-gray-800 dark:border-gray-700 flex flex-col items-stretch justify-items-stretch gap-6" v-for="(group, index) in company?.groups" :key="group.ids.length">
      <GroupSlot :group="group" @add="(id) => addToGroup(index, id)" @delete="(user) => deleteFromGroup(index, user)" />
    </div>
  </div>
</template>
