<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { onMounted } from "vue";
import { Head } from "@inertiajs/vue3";

onMounted(() => {
    /*  console.log('je suis là') */
});
</script>

<template>
          <Head title="Paramètres"/>

    <AuthenticatedLayout>
        <main>
            <h2 style="margin-top: 70px">Settings</h2>
            <img src="/images/amana-logo.jpeg" alt="" srcset="" />
        </main>
    </AuthenticatedLayout>
</template>
