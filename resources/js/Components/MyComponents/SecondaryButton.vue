<template>
  <v-btn v-bind="$props" id="btn-secon">
    <span id="label-style"> {{ label }}</span>

  </v-btn>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    default: "Button",
  },
});
</script>
<style scoped>
#label-style {
  color: var(--4, #fff);
  text-align: center;
  font-family: Montserrat;
  font-size: 15px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
  text-transform: none;
}
#btn-secon {
  border-radius: 99px;
  background: #f15a2d;
}
</style>
