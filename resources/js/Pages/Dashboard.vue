<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
</script>

<template>
  <AuthenticatedLayout>

      <h2 class="font-semibold text-xl text-gray-800">Dashboard</h2>


    <div class="py-12">
      <v-card>
        <v-card-title>You're logged in!</v-card-title>
      </v-card>
    </div>
  </AuthenticatedLayout>
</template>
