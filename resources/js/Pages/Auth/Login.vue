<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import { useForm, router } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

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




onMounted(() => {
  console.log(`the component is now mounted.`)

})


</script>

<template>

  <GuestLayout>
   <div class="container mb-3">
    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit" class="col-10 col-lg-4 col-xl-3">
    <div class="row text-center" style="height:50; ">
                <h3>Page de connexion</h3>
<a class="navbar-brand" href="http://127.0.0.1:8000/">
          <img
            src="/images/logo.png"
            width="150"
            height="70"
            class="d-inline-block align-top"
          />
        </a>
    </div>
        <label for="username">Identifiant</label>
        <input type="text" placeholder="Identifiant" id="username"   v-model="form.email">

        <label for="password">Mot de passe</label>
        <input type="password" placeholder="Password" autocomplete="true" id="password" v-model="form.password">

                <PrimaryButton
                  class="button-submit"
                  @click="submit"
                  :disabled="form.processing"
                  label="Connexion"
                ></PrimaryButton>

   <div class="d-flex mt-2" style="font-size:11px">
  <div class="p-1  flex-fill m-1 border rounded border-white">Mot de passe oublié</div>
  <div class="p-1  flex-fill m-1 border  rounded border-white"> Créer un compte</div>

</div>
    </form>


</div>
  </GuestLayout>
</template>
  <style media="screen">
    @import url("https://fonts.gstatic.com");
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css");
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap");

      *,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

form{
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 15px;

}
form *{
    font-family: 'Poppins',sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 22px;
    font-weight: 300;
    line-height: 35px;
    text-align: center;
}

label{
    display: block;
    margin-top: 15px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 40px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 5px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
.button-submit{
    margin-top: 50px;
    width: 100%;
    font-size: 18px;
    font-weight: 700;

    cursor: pointer;
}

.social div:hover{
  background-color: rgba(255,255,255,0.47);
}

    </style>
