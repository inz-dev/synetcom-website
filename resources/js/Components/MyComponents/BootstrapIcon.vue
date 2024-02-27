<template>
  <svg
    xmlns="http://www.w3.org/2000/svg"
    width="56"
    height="56"
    fill="#1B449C"
    viewBox="0 0 16 16"
    :class="classIcon"
  >
    <path fill-rule="evenodd" :d="path1" />
    <path v-if="path2" fill-rule="evenodd" :d="path2" />
    <path v-if="path3" fill-rule="evenodd" :d="path3" />
  </svg>
</template>
<script>
export default {
  name: "BooststrapIcon",
  props: {
    width: {
      type: Number,
      default: 56,
    },
    height: {
      type: Number,
      default: 56,
    },
    path1: String,
    path2: {
      type: String,
      default: null,
    },
    path3: {
      type: String,
      default: null,
    },
    classIcon: {
      type: String,
      default: "icon",
    },
  },
};
</script>
