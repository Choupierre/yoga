<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeInputError from '@/Components/InputError.vue';
import BreezeLabel from '@/Components/Label.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
  <BreezeGuestLayout>
    <Head title="Forgot Password" />

    <div class="mb-4 text-sm text-gray-600">
      Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </div>

    <div
      v-if="status"
      class="mb-4 font-medium text-sm text-green-600"
    >
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <BreezeLabel
          for="email"
          value="Email"
          class="label1"
        />
        <BreezeInput
          id="email"
          v-model="form.email"
          type="email"
          class="input1"
          required
          autofocus
          autocomplete="username"
        />
        <BreezeInputError
          class="mt-2"
          :message="form.errors.email"
        />
      </div>

      <div class="flex items-center justify-end mt-4">
        <BreezeButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          class="buttonblue"
        >
          Email Password Reset Link
        </BreezeButton>
      </div>
    </form>
  </BreezeGuestLayout>
</template>
