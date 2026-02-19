<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { onMounted } from 'vue';
onMounted(
    ()=>{ console.log('Pages:je suis là')}
)
</script>


<template>
<AuthenticatedLayout>
<main>
    <h2 style="margin-top:70px">Départements</h2>
</main>

</AuthenticatedLayout>
</template>
