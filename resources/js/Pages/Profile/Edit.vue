<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';


defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>
<template>
    <AuthenticatedLayout>

     <h1>Profile</h1>
    </AuthenticatedLayout>
</template>
