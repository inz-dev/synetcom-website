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
  <Header />
  <ServicesHome />
  <Portfolio />
  <WhyChooseUsHome />
  <!-- <ProjectsHomeVue /> -->
  <TeamHome />
  <NewsletterHome />
  <PartenersHome />
  <Footer />
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
