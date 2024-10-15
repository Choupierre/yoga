<script setup lang="ts">

const { init } = useAuthStore();
const { auth, dateComing, dateOld } = storeToRefs(useAuthStore());

const adminPanel = ref(false)

onMounted(async () => { await init(); });
</script>

<template>
    <BreezeAuthenticatedLayout>
        <div class="container mx-auto">
            <div class="flex mt-4" v-if="auth?.admin">
                <label class="inline-flex items-center cursor-pointer mx-auto">
                    <input type="checkbox" v-model="adminPanel" class="sr-only peer">
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Gestion</span>
                </label>
            </div>
            <template v-if="auth?.admin && adminPanel">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 m-4">
                    <NewDate />
                    <NewUser />
                    <TheGroup class="col-span-1 md:col-span-2 xl:col-span-1" />
                </div>

                <hr class="my-6" />
            </template>
            <template v-if="dateComing.length">
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
