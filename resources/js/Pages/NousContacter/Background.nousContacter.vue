<script setup>
import Footer from "@/Components/Welcome/Footer.vue";
import Header from "@/Components/Welcome/Header.vue";
import NewsletterHome from "@/Components/Welcome/Sections/Newsletter.home.vue";
import PartenersHome from "@/Components/Welcome/Sections/Parteners.home.vue";
import Portfolio from "@/Components/Welcome/Sections/Portfolio.vue";
import ServicesHome from "@/Components/Welcome/Sections/Services.home.vue";
import TeamHome from "@/Components/Welcome/Sections/Team.home.vue";
import WhyChooseUsHome from "@/Components/Welcome/Sections/WhyChooseUs.home.vue";
</script>

<template>

   <div class="bg-image">

      <div class="container my-3 py-4 mt-10">

        <h1 class="mt-10 text-center text-white fw-medium font-family-Montserrat">
         Nous Contacter
        </h1>


      </div>
    </div>

</template>

<style>
.bg-image {
  /* Workaround for some mobile browsers */
  background: url("/images/background1.png") no-repeat center center;
  background-size: cover;
  min-height: 80vh;
  padding-top: 20px;
  padding-bottom: 20px;
}
</style>
