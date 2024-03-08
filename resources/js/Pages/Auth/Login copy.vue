<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <GuestLayout>
    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>
    <v-row>
      <v-col cols="6"></v-col>
      <v-col cols="6">
        <h1 class="m-4">Login page</h1>
        <form @submit.prevent="submit">
          <div>
            <!-- <InputLabel for="email" value="Email" /> -->

            <v-text-field
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              required
              autofocus
              autocomplete="username"
            />

            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
          </div>

          <div class="mt-4">
            <!-- <InputLabel for="password" value="Password" /> -->
            <v-text-field
              id="password"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password"
              required
              autocomplete="current-password"
            />

            <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
          </div>

          <!-- <div class="block mt-4">
        <label class="flex items-center">
          <Checkbox name="remember" v-model:checked="form.remember" />
          <span class="ms-2 text-sm text-gray-600">Remember me</span>
        </label>
      </div> -->

          <PrimaryButton
            @click="submit"
            :disabled="form.processing"
            label="Connexion"
          ></PrimaryButton>
        </form>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="6">
        <form @submit.prevent="submit">
          <div>
            <!-- <InputLabel for="email" value="Email" /> -->

            <v-text-field
              id="email"
              type="email"
              class="mt-1 block w-full"
              v-model="form.email"
              required
              autofocus
              autocomplete="username"
            />

            <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
          </div>

          <div class="mt-4">
            <!-- <InputLabel for="password" value="Password" /> -->
            <v-text-field
              id="password"
              type="password"
              class="mt-1 block w-full"
              v-model="form.password"
              required
              autocomplete="current-password"
            />

            <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
          </div>

          <!-- <div class="block mt-4">
        <label class="flex items-center">
          <Checkbox name="remember" v-model:checked="form.remember" />
          <span class="ms-2 text-sm text-gray-600">Remember me</span>
        </label>
      </div> -->

          <PrimaryButton
            @click="submit"
            :disabled="form.processing"
            label="Connexion"
          ></PrimaryButton>
        </form>
      </v-col>
    </v-row>
  </GuestLayout>
</template>
