<script setup lang="ts">
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeInputError from '@/Components/InputError.vue';
import BreezeLabel from '@/Components/Label.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: true
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
  <BreezeGuestLayout>
    <Head title="Log in" />

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

      <div class="mt-4">
        <BreezeLabel
          for="password"
          value="Password"
          class="label1"
        />
        <BreezeInput
          id="password"
          v-model="form.password"
          type="password" 
          class="input1"         
          required
          autocomplete="current-password"
        />
        <BreezeInputError
          class="mt-2"
          :message="form.errors.password"
        />
      </div>

      <div class="flex items-center justify-end mt-4">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="underline text-sm text-gray-600 hover:text-gray-900"
        >
          Forgot your password?
        </Link>

        <BreezeButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          class="buttonblue"
        >
          Log in
        </BreezeButton>
      </div>
    </form>
  </BreezeGuestLayout>
</template>
