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
    return 'bg-blue-300 dark:bg-blue-400 hover:bg-blue-500 dark:hover:bg-blue-400'
  if (user.active)
    return 'bg-blue-100 dark:bg-blue-200 hover:bg-blue-200 dark:hover:bg-blue-300'
  return 'bg-gray-100 dark:bg-gray-200 hover:bg-gray-300 dark:hover:bg-gray-300'
}
</script>

<template>
  <div class="bg-slate-200 rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    <div class="p-6">
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
    </div>
    <div class="text-sm font-medium ">
      <div class="p-2 border-t border-gray-400 border-solid">
        Sont inscrits et se sont connectés au moins 1 fois
        <div class="m-2 flex flex-wrap gap-2">
          <span v-for="user in users.filter(u => u.active && u.activated).sort((a, b) => a.name.localeCompare(b.name))" :key="user.id" :class="activeClass(user)" class="py-1 px-2 rounded hover:cursor-pointer" @click="activeUser(user)">
            {{ user.name }}
          </span>
        </div>
      </div>
      <div class="p-2 border-t border-gray-400 border-solid">
        Sont inscrits et ne se sont jamais connectés
        <div class="m-2 flex flex-wrap gap-2">
          <span v-for="user in users.filter(u => u.active && !u.activated).sort((a, b) => a.name.localeCompare(b.name))" :key="user.id" :class="activeClass(user)" class="py-1 px-2 rounded hover:cursor-pointer" @click="activeUser(user)">
            {{ user.name }}
          </span>
        </div>
      </div>
      <div class="p-2 border-t border-gray-400 border-solid">
        Ne sont plus inscrits
        <div class="m-2 flex flex-wrap gap-2">
          <span v-for="user in users.filter(u => !u.active).sort((a, b) => a.name.localeCompare(b.name))" :key="user.id" :class="activeClass(user)" class="py-1 px-2 rounded hover:cursor-pointer" @click="activeUser(user)">
            {{ user.name }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
