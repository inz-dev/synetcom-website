<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { ref } from "vue";

const showingNavigationDropdown = ref(false);
</script>

<template>


 <div class="container">

                <slot />

          </div>
</template>
