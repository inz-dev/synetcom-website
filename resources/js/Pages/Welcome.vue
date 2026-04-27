<script setup>
import Index from "./HomePage/Index.vue";
defineProps({ page: Object, canLogin: Boolean, canRegister: Boolean });
</script>

<template>
  <Index :page="page" />
</template>
