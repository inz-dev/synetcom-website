<script setup>
import { onMounted } from "vue";




onMounted(() => {
  console.log("Mounted and DOM ready");

  const menuToggle = document.getElementById("menuToggle");
  const menuToggleMobile = document.getElementById("MenuToggleMobile");
  const sidebar = document.getElementById("sidebar");
  const preview = document.getElementById("preview"); // Assure-toi que cet élément existe

  // Desktop Menu
  if (menuToggle && sidebar) {
    menuToggle.addEventListener("click", (e) => {
      console.log("Click from MenuToggle:", e);
      e.stopPropagation();
      sidebar.classList.toggle("collapsed");
    });
  }

  // Mobile Menu
  if (menuToggleMobile && sidebar) {
    menuToggleMobile.addEventListener("click", (e) => {
      e.stopPropagation();
      sidebar.classList.toggle("mobile-open");
    });

    // Hide sidebar on outside click
    document.addEventListener("click", (e) => {
      if (
        sidebar.classList.contains("mobile-open") &&
        !sidebar.contains(e.target) &&
        !menuToggleMobile.contains(e.target)
      ) {
        console.log('mobile open')
        sidebar.classList.remove("mobile-open");
      }
      console.log('no mobile open')
    });
  }


});
</script>

<template>

      <v-app-bar
        color="teal-darken-4"
        image="https://picsum.photos/1920/1080?random"
      >
        <template v-slot:image>
          <v-img
            gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"
          ></v-img>
        </template>

        <template v-slot:prepend>
          <v-app-bar-nav-icon class="menu-toggle bg-white" id="menuToggle"></v-app-bar-nav-icon>
        </template>

        <v-app-bar-title>Title</v-app-bar-title>

        <v-btn icon>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-btn icon>
          <v-icon>mdi-heart</v-icon>
        </v-btn>

        <v-btn icon>
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>
      </v-app-bar>

      <v-navigation-drawer permanent  class="sidebar" id="sidebar">
  <v-list-item title="My Application" subtitle="Vuetify"></v-list-item>
  <v-divider></v-divider>
  <v-list-item link title="List Item 1"></v-list-item>
  <v-list-item link title="List Item 2"></v-list-item>
  <v-list-item link title="List Item 3"></v-list-item>
</v-navigation-drawer>


</template>

