<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { ref } from "vue";
import FooterComponent from "@/Components/MyComponents/Footer.component.vue";
import SideBar from "@/Components/Authentication/SideBar.vue";
const showingNavigationDropdown = ref(false);
</script>

<template>
    <v-layout>
    <SideBar/>
     <v-main>
      <slot />
</v-main>
<FooterComponent />
    </v-layout>
</template>

<style scoped>
.footer {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background-color: lightgray;
    color: white;
    text-align: center;
}
</style>
