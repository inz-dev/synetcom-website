<script setup>

import { Head } from '@inertiajs/vue3';
import BanierePage from '../../Components/MyComponents/BanierePage.vue';
import NousContacterSection from '../../Components/MyComponents/NousContacter/NousContacter.section.vue';


</script>
<template>
          <Head title="Nous contacter"/>

<Header>
<BanierePage title="Nous Contacter"  :backgroundImage="'/images/background1.png'"/>
</Header>

<NousContacterSection />



</template>
<style scoped>


</style>

