<script setup></script>

<template>
  <header>
    <!-- Navbar -->
    <nav
      class="navbar fixed-top navbar-expand-lg navbar-light bg-light"
      style="height: 75px"
    >
      <a class="navbar-brand" href="#">
        <img
          src="/images/logo.png"
          width="150"
          height="70"
          class="d-inline-block align-top"
        />
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Accueil</a>
          </li>

          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              Services
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Équipe & Partenaires</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Nous contacter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Recrutement</a>
          </li>
        </ul>
        <div style="display: flex; justify-content: flex-end">
          <div><PrimaryButton label="Obtenir un dévis" /></div>
        </div>
      </div>
    </nav>
    <!-- Navbar -->

    <!-- Background image -->

    <div class="bg-image">
      <!-- <div id="component"  class="container my-5"> -->
      <div class="container my-5 py-5">
        <p
          class="mt-5 text-center text-white fs-1 fw-semibold font-family-Montserrat text-capitalize"
        >
          Synetcom
        </p>
        <p class="text-center text-white fs-5 fw-medium font-family-Montserrat">
          Développer votre entreprise chaque jour avec la transformation numérique.
          <br />
          Nous vous permettons de générer de la croissance grâce aux outils de la
          transformation numérique.
        </p>
        <v-row class="text-center"
          ><v-col> <SecondaryButton label="Obtenir un devis" /></v-col>
          <v-col> <SecondaryButton label="Obtenir un devis" /></v-col>
        </v-row>
      </div>
    </div>
    <!-- Background image -->
  </header>
</template>

<style>
.navbar-default .navbar-nav > .active > a,
.navbar-default .navbar-nav > .active > a:hover,
.navbar-default .navbar-nav > .active > a:focus {
  color: #333333;
  /* <----- change your color here*/
  background-color: transparent;
}
#component {
  margin-top: 100px;
  width: 1108px;
  height: 300px;
}
.bg-image {
  /* Workaround for some mobile browsers */
  background: url("/images/background1.png") no-repeat center center;
  background-size: cover;
  min-height: 80vh;
  padding-top: 20px;
  padding-bottom: 20px;
}
</style>
