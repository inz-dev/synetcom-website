<template>
  <!-- <div class="d-flex flex-column min-vh-100" style="background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);"> -->
   <div class="d-flex flex-column min-vh-100" style="background:black;">
    <!-- Header -->
    <!-- <header class="bg-light text-bold py-1 mb-2">
      <div class="container">
        <h1 class="h4 text-wrap fw-bold mb-0">Synetcom</h1>
      </div>
    </header> -->

    <!-- Contenu principal -->
    <main class="flex-grow-1 d-flex">
      <div class="container">

                <slot />

          </div>


    </main>

    <!-- Footer -->
    <footer class="bg-light text-center py-1 mt-auto">

      <small>&copy;{{ new Date().getFullYear() }}&nbsp; Copyright:
                                                    <a
                                                        class="text-bold"
                                                        href="http://127.0.0.1:8000/"
                                                        >Synetcom-niger</a
                                                    > - Tous droits réservés</small>
    </footer>
  </div>
</template>

<script setup>
// Pas de logique complexe ici, c’est un layout statique
</script>

<style scoped>
.card {
  border-radius: 0.75rem;
}
</style>
