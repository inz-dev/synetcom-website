<script setup>
import FooterComponent from "@/Components/MyComponents/Footer.component.vue";
</script>
<template>
  <!-- <div class="d-flex flex-column min-vh-100" style="background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);"> -->
   <div class="d-flex flex-column min-vh-100" style="background:black;">
    <main class="flex-grow-1 d-flex">
      <div class="container">

                <slot />

          </div>


    </main>

    <!-- Footer -->
<FooterComponent />


  </div>
</template>



<style scoped>
.card {
  border-radius: 0.75rem;
}
</style>
