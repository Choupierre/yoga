<script setup lang="ts">  
const store = authStore();

onMounted(() => {
  update();
});

function update() {
  axios.get("/api/store").then((res) => {
    store.dates = res.data.dates;
    store.users = res.data.users;
    store.user = res.data.auth;  
  });
}
</script>

<template>
  <BreezeAuthenticatedLayout>
    <div class="container mx-auto">
      <div
        v-if="store.isAdmin"
        class="grid grid-cols-1 md:grid-cols-2 gap-4 m-4"
      >
        <NewDate @update="update" />
        <NewUser @update="update" />
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 m-4">
        <div
          v-for="(date, key) in store.dates"
          :key="key"
        >
          <TheDate          
            :date="date"
            @update="update"
          />         
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
