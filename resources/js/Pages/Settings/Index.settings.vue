<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted } from 'vue';
onMounted(
    ()=>{ console.log('je suis là')}
)
</script>


<template>
<AuthenticatedLayout>
<main>
    <h2 style="margin-top:70px">Settings</h2>
<img src="/images/amana-logo.jpeg" alt="" srcset="">
</main>

</AuthenticatedLayout>
</template>
