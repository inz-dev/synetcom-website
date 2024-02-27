<template>
  <v-btn v-bind="$props" id="btn">
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
  font-size: 15px;
  font-style: normal;
  font-weight: 700;
  line-height: normal;
  text-transform: none;
}
#btn {
  border-radius: 99px;
  background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);
}
</style>
