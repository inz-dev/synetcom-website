<script setup>
import SideBar from "@/Components/Authentication/SideBar.vue";
import ErrorToasts from "@/Components/Authentication/Errors/ErrorToasts.vue";
</script>

<template>
    <div class="container-fluid" >
    <SideBar>
<ErrorToasts/>


      <slot/>

</SideBar>

    </div>
</template>

<style >

</style>
