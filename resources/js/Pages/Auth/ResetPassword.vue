<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeInputError from '@/Components/InputError.vue';
import BreezeLabel from '@/Components/Label.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
  <BreezeGuestLayout>
    <Head title="Reset Password" />

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
          autocomplete="new-password"
        />
        <BreezeInputError
          class="mt-2"
          :message="form.errors.password"
        />
      </div>

      <div class="mt-4">
        <BreezeLabel
          for="password_confirmation"
          value="Confirm Password"
          class="label1"
        />
        <BreezeInput
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          class="input1"
          required
          autocomplete="new-password"
        />
        <BreezeInputError
          class="mt-2"
          :message="form.errors.password_confirmation"
        />
      </div>

      <div class="flex items-center justify-end mt-4">
        <BreezeButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          class="buttonblue"
        >
          Reset Password
        </BreezeButton>
      </div>
    </form>
  </BreezeGuestLayout>
</template>
