<script setup>
import ProjectsHomeVue from "@/Components/Welcome/Sections/Projects.home.vue";
import Footer from "../Components/Welcome/Footer.vue";
import Header from "../Components/Welcome/Header.vue";
import NewsletterHome from "../Components/Welcome/Sections/Newsletter.home.vue";
import PartenersHome from "../Components/Welcome/Sections/Parteners.home.vue";
import ServicesHome from "../Components/Welcome/Sections/Services.home.vue";
import TeamHome from "../Components/Welcome/Sections/Team.home.vue";
import WhyChooseUsHome from "../Components/Welcome/Sections/WhyChooseUs.home.vue";
defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  laravelVersion: {
    type: String,
    required: true,
  },
  phpVersion: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <Header />
  <ServicesHome />
  <WhyChooseUsHome />
  <ProjectsHomeVue />
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
