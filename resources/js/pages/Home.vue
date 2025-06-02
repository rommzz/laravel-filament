<script setup>
const props = defineProps({
  title: {
    type: String,
    default: 'Inertia.js dengan Vue 3'
  },
    description: {
        type: String,
        default: 'Ini adalah halaman utama yang dibuat dengan Inertia.js dan Vue 3.'
    }
})
</script>
<template>
  <h1>Halo dari Inertia!</h1>
  <div>
    <p>
        {{ props.title }} <br>
        {{ props.description }}
    </p>
  </div>
</template>
