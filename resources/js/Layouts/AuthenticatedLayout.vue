<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { ref } from "vue";
import FooterComponent from "@/Components/MyComponents/Footer.component.vue";
const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="container">
            <slot />
        </div>
<FooterComponent />
    </div>
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
