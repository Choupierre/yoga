<script setup lang="ts">
const store = authStore();
const formUser = {
    name: "",
    email: "",
};
const formUsersuccess = ref("");
const formUserError = ref("");

function addUser() {
    axios
        .post("/api/users", formUser)
        .then((res) => {
            console.log(res);
            formUsersuccess.value = "nouvel élève ajouté";
            formUser.name = "";
            formUser.email = "";
            store.init();
            setTimeout(() => {
                formUsersuccess.value = "";
            }, 3000);
        })
        .catch((err) => {
            console.log(err.response);
            formUserError.value = err.response.data.message;
            setTimeout(() => {
                formUserError.value = "";
            }, 3000);
        });
}
</script>

<template>
  <div
    class="p-6 bg-slate-200 rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700"
  >
    <a href="#">
      <h5
        class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"
      >
        Ajouter un élève
      </h5>
    </a>
    <div class="mb-6">
      <label
        for="name"
        class="label1"
      >Nom de l'élève : </label>
      <input
        id="name"
        v-model="formUser.name"
        type="text"
        class="input1"
        placeholder="nom"
        required
      >
    </div>
    <div class="mb-6">
      <label
        for="email"
        class="label1"
      >Email de l'élève : </label>
      <input
        id="email"
        v-model="formUser.email"
        type="email"
        class="input1"
        placeholder="email@email.fr"
        required
      >
    </div>
    <button
      type="submit"
      class="buttonblue"
      @click="addUser"
    >
      Ajouter
    </button>
    <div
      v-if="formUsersuccess"
      class="p-3 mt-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
      role="alert"
    >
      <span class="font-medium">{{ formUsersuccess }}</span>
    </div>
    <div
      v-if="formUserError"
      class="p-3 mt-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
      role="alert"
    >
      <span class="font-medium">{{ formUserError }}</span>
    </div>
    <div class="mt-4">
      <span
        v-for="user in store.users"
        id="badge-dismiss-green"
        :key="user.id"
        :class="
          user.created_at !== user.updated_at
            ? 'text-green-800 bg-green-100 dark:bg-green-200 dark:text-green-800'
            : 'text-red-800 bg-red-100 dark:bg-red-200 dark:text-red-800'
        "
        class="inline-flex items-center py-1 px-2 mr-2 mb-2 text-sm font-medium rounded"
      >
        {{ user.name }}
        <button
          type="button"
          class="inline-flex items-center p-0.5 ml-2 text-sm bg-transparent rounded-sm hover:bg-gray-200 hover:text-green-900 dark:hover:bg-gray-300"
          data-dismiss-target="#badge-dismiss-green"
          aria-label="Remove"
          @click="user.deleteUser()"
        >
          <svg
            aria-hidden="true"
            class="w-3.5 h-3.5"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            />
          </svg>
          <span class="sr-only">Delete user</span>
        </button>
      </span>
    </div>
  </div>
</template>
