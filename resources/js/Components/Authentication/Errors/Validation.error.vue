<template>
  <transition name="fade">
    <div v-if="Object.keys(errors).length" class="fixed top-4 right-4 bg-red-600 text-white p-4 rounded shadow-lg">
      <h3 class="font-bold">Erreurs detectées</h3>
      <ul>
        <li v-for="(message, field) in errors" :key="field">
          {{ message }}
        </li>
      </ul>
    </div>
  </transition>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'

const { props } = usePage()
const errors = props.errors
</script>
