<script setup lang="ts">  
const store = authStore();
onMounted(() => {
  store.init()
});
</script>

<template>
  <BreezeAuthenticatedLayout>
    <div class="container mx-auto">
      <div
        v-if="store.isAdmin"
        class="grid grid-cols-1 md:grid-cols-2 gap-4 m-4"
      >
        <NewDate />
        <NewUser />
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 m-4">
        <div
          v-for="(date, key) in store.dates"
          :key="key"
        >
          <TheDate          
            :date="date"            
          />         
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>
