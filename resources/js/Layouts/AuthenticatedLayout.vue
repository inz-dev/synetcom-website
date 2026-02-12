<script setup>
import SideBar from "@/Components/Authentication/SideBar.vue";

</script>

<template>
    <v-layout>
    <SideBar>

      <v-main style="margin:20px" >
      <slot/>
      </v-main>
</SideBar>

    </v-layout>
</template>

<style scoped>

</style>
