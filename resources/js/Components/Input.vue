<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue']);

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});
</script>

<template>
  <input
    ref="input"  
    class="input"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  >
</template>
