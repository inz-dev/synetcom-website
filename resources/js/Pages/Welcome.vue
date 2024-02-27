<script setup>
import Footer from "../Components/Welcome/Footer.vue";
import Header from "../Components/Welcome/Header.vue";
import ServicesHome from "../Components/Welcome/Sections/Services.home.vue";
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
