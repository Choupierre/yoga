<script setup lang="ts">

const { init } = useAuthStore();
const { auth, dateComing, dateOld } = storeToRefs(useAuthStore());

onMounted(async () => {
    await init();
});
</script>

<template>
    <BreezeAuthenticatedLayout>
        <div class="container mx-auto">
            <div v-if="auth?.admin" class="grid grid-cols-1 md:grid-cols-2 gap-4 m-4">
                <NewDate />
                <NewUser />
            </div>
            <template v-if="dateComing.length">
                <hr class="my-6" />
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 m-4">
                    <div v-for="date in dateComing">
                        <TheDate :date="date" />
                    </div>
                </div>
            </template>
            <template v-if="dateOld.length">
                <hr class="my-6" />
                <div v-if="dateOld.length" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 m-4">
                    <div v-for="date in dateOld">
                        <TheDate :date="date" />
                    </div>
                </div>
            </template>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style scoped></style>
