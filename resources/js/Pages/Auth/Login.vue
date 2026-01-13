<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { useForm, router } from "@inertiajs/vue3";
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
    <div class="container" style="height: 100vh;   background-color: #fff;">
      <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center" style="height: 100vh">
        <div class="col-12 col-lg-6 col-xl-5">
          <!-- <div class="section-left" @click="route('')"> -->
          <v-img src="/images/logo.png" :width="300" cover />
          <!-- </div> -->
        </div>

          <v-card class="mx-1 col-12 col-lg-6 col-xl-5"  id="form-login">

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

          </v-card>

      </div>
    </div>
  </GuestLayout>
</template>
<style scoped>
 #form-login{
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}

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
