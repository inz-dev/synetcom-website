<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

let isRegister = ref(false);
let errorMessage = ref("");

let login = {
  name: "Login",
  message: "Register",
};
const form = useForm({
  email: "",
  password: "",
  remember: false,
});
const register = () => {
  console.log("register");
};

const submit = () => {
  form.post(route("login"), {
    onError: (e) => {
      console.log("Error:", e);
    },
    onFinish: (f) => {
      console.log("Finish:", f);
    },
    onSuccess: (s) => {
      console.log("success:", s);
    },
  });
};
// const toggleMessage = computed(() => {
//   isRegister ? this.stateObj.register.message : this.stateObj.login.message;
// });
</script>

<template>
  <GuestLayout>
    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>
    <div class="container" style="height: 100vh">
      <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center" style="height: 100vh">
        <div class="col-12 col-lg-6 col-xl-5">
          <!-- <div class="section-left" @click="route('')"> -->
          <v-img src="/images/logo.png" cover />
          <!-- </div> -->
        </div>
        <div class="mx-1 col-12 col-lg-6 col-xl-5">
          <v-card style="height: 80vh">
            <v-card-text>
              <v-toolbar dark color="primary">
                <v-toolbar-title> Page de connexion </v-toolbar-title>
              </v-toolbar>
              <form @submit.prevent="submit" class="mt-8 mx-1">
                <v-text-field
                  v-model="form.email"
                  name="Identifiant"
                  label="Identifiant"
                  type="text"
                  required
                ></v-text-field>

                <v-text-field
                  v-model="form.password"
                  name="Mot de passe"
                  label="Mot de passe"
                  type="password"
                ></v-text-field>

                <div class="red--text">{{ errorMessage }}</div>
                <PrimaryButton
                  class="mt-4"
                  @click="submit"
                  :disabled="form.processing"
                  label="Connexion"
                ></PrimaryButton>
              </form>
            </v-card-text>
          </v-card>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>
<style scoped>
.section-left {
  width: 100%;
  height: 100%;
  /* background-color: #0a0a23; */
  display: flex;
  justify-content: center;
  align-items: center;
}

.section-left img {
  width: 300px;
  height: 180px;
}
</style>
