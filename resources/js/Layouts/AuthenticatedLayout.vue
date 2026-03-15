<script setup>
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify'; // ou votre bibliothèque préférée
import 'vue3-toastify/dist/index.css';
import SideBar from "@/Components/Authentication/SideBar.vue";
import ErrorToasts from "@/Components/Authentication/Errors/ErrorToasts.vue";

const page = usePage();

// On surveille les messages flash envoyés par Laravel
watch(
  () => page.props.flash,
  (flash) => {
    if (flash && flash.message) {
      toast(flash.message, {
        type: flash.type || 'success', // 'success', 'error', etc.
        position: 'top-right',
      });
    }
  },
  { deep: true }
);
</script>



<template>
    <div class="container-fluid" >
    <SideBar>
<ErrorToasts/>


      <slot/>

</SideBar>

    </div>
</template>

<style >

</style>
