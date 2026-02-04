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

      <div class="container my-3 py-4">
        <p
          class="mt-5 text-center text-white fs-1 fw-semibold font-family-Montserrat text-capitalize"
        >
          Synetcom
        </p>
        <p class="text-center text-white fs-5 fw-medium font-family-Montserrat">
          Développer votre entreprise chaque jour avec la transformation numérique.
          <br />
          Nous vous permettons de générer de la croissance grâce aux outils de la
          transformation numérique.
        </p>
        <p class="text-center">
          <a
            class="btn btn-default btn-lg text-white"
            style="border-radius: 10px 100px / 120px; background-color: #1b449c"
            role="button"
            >Obtenir un devis</a
          >
          <!-- &nbsp;&nbsp; -->
          <a
            class="btn btn-action text-white btn-lg mx-3 mt-2"
            style="border-radius: 10px 100px / 120px; background-color: #f15a2d"
            role="button"
            >Nous contacter</a
          >
        </p>

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
