<script setup lang="ts">    
const store = piniaStore();
onMounted(async () => {
    await store.init();
});
</script>

<template>
    <BreezeAuthenticatedLayout>
        <div class="container mx-auto">
            <div
                v-if="store.isAdmin"
                class="grid grid-cols-1 md:grid-cols-2 gap-4 m-4">
                <NewDate />
                <NewUser />
            </div>
            <hr />
            <div
                v-if="store.dateComing.length"
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 m-4">
                <div
                    v-for="(date, key) in store.dateComing"
                    :key="key">
                    <TheDate :date="date" />
                </div>
            </div>
            <hr />
            <div
                v-if="store.dateOld.length"
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 m-4">
                <div
                    v-for="(date, key) in store.dateOld"
                    :key="key">
                    <TheDate :date="date" />
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
hr {
    display: none;
}
.grid + hr:not(:last-child) {
    @apply my-6;
    display: block;
}
</style>
