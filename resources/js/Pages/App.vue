<script setup lang="ts">

const { init } = useAuthStore();
const { auth, dateComing, dateOld, modal } = storeToRefs(useAuthStore());

const adminPanel = ref(true)
const newDate = ref(true)

onMounted(async () => { await init(); });
</script>

<template>
    <div class="w-screen h-screen fixed z-10 top-0 left-0 flex justify-center items-center" v-if="modal">
        <div class="bg-black w-screen h-screen fixed top-0 left-0 opacity-75 absolute"></div>
        <div class="loader"></div>
    </div>

    <BreezeAuthenticatedLayout>
        <div class="container mx-auto">
            <div class="flex justify-center gap-4 mt-4 mb-8" v-if="auth?.admin">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" v-model="adminPanel" class="sr-only peer">
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Gestion</span>
                </label>
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" v-model="newDate" class="sr-only peer">
                    <div
                        class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ newDate ? 'Dates à venir' : 'Dates passées' }}</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 m-4" v-if="auth?.admin && adminPanel">
                <NewDate />
                <NewUser />
                <TheGroup class="col-span-1 md:col-span-2 xl:col-span-1" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 m-4" v-if="newDate">
                <div v-for="date in dateComing" v-if="dateComing.length">
                    <TheDate :date="date" />
                </div>
                <h5 class="text-xl font-semibold text-gray-500 dark:text-gray-400" v-else>Aucune date à venir</h5>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 m-4" v-else>
                <div v-for="date in dateOld" v-if="dateOld.length">
                    <TheDate :date="date" />
                </div>
                <h5 class="text-xl font-semibold text-gray-500 dark:text-gray-400" v-else>Aucune date passée</h5>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
/* HTML: <div class="loader"></div> */
.loader {
    width: 100px;
    --b: 16px;
    aspect-ratio: 1;
    border-radius: 50%;
    padding: 1px;
    background: conic-gradient(#0000 10%, #f03355) content-box;
    -webkit-mask:
        repeating-conic-gradient(#0000 0deg, #000 1deg 20deg, #0000 21deg 36deg),
        radial-gradient(farthest-side, #0000 calc(100% - var(--b) - 1px), #000 calc(100% - var(--b)));
    -webkit-mask-composite: destination-in;
    mask-composite: intersect;
    animation: l4 1s infinite steps(10);
}

@keyframes l4 {
    to {
        transform: rotate(1turn)
    }
}
</style>
