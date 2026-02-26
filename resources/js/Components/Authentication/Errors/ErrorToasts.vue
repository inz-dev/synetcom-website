
<template>
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div
      v-for="(message, field) in errors"
      :key="field"
      class="toast text-bg-danger border-0"
      role="alert"
    >
      <div class="d-flex">
        <div class="toast-body">
          <strong>{{ field }} :</strong> {{ message }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import { watch } from 'vue'

const { props } = usePage()
const errors = props.errors

watch(() => props.errors, (newErrors) => {
  if (Object.keys(newErrors).length) {
    const toastElList = document.querySelectorAll('.toast')
    toastElList.forEach(toastEl => {
      const toast = new bootstrap.Toast(toastEl)
      toast.show()
    })
  }
})
</script>
