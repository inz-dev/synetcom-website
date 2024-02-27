<template>
  <v-btn v-bind="$props" id="btn-secon">
    <span id="label-style"> {{ label }}</span>
    <!-- <template #label>
        <span id="label-style">{{ label }}</span>
      </template> -->
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
  font-size: 12px;
  font-style: normal;
  font-weight: 500;
  line-height: normal;
  text-transform: none;
}
#btn-secon {
  border-radius: 99px;
  background: #f15a2d;
}
</style>
