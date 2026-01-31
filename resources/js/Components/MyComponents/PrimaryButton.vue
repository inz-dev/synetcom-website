<template>
  <v-btn v-bind="$props" id="btn">
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
#btn {
  border-radius: 99px;
  background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);
}
#btn.v-btn[data-v-076875a5]:hover {

    background-color: #1b449c;

}
</style>
