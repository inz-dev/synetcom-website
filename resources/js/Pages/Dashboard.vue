<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <v-card>
        <v-card-title>You're logged in!</v-card-title>
      </v-card>
    </div>
  </AuthenticatedLayout>
</template>
