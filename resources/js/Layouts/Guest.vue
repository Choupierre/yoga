<script setup>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/inertia-vue3";
</script>

<template>
  <div class="container mx-auto">
    <div class="flex h-screen w-full justify-center items-center">
      <div class="p-6 bg-slate-200 rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700 w-96">
        <slot />
      </div>
    </div>
  </div>
</template>
