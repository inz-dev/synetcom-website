<script setup>
function goToTeam() {
      const section = document.getElementById("team");
      if (section) {
        section.scrollIntoView({behavior:'smooth'});
      }
}
function goToPartners() {
      const section = document.getElementById("partners");
      if (section) {
        section.scrollIntoView({behavior:'smooth'});
      }
}
function goToContact() {
      const section = document.getElementById("contact");
      if (section) {
        section.scrollIntoView({behavior:'smooth'});
      }
}
function goToServices() {
      const section = document.getElementById("services");
      if (section) {
        section.scrollIntoView({behavior:'smooth'});
      }
}
</script>

<template>
  <header>
    <!-- Navbar -->

    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
      <div class="container">
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
          data-target="#navbarResponsive"
          aria-controls="navbarResponsive"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive" >
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="active nav-link" href="#">Accueil</a>
            </li>

            <li class="nav-item dropdown"  @click.prevent="goToServices">
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
                <a class="dropdown-item" href="#">Solutions Entreprise</a>
                <a class="dropdown-item" href="#">Développement apps/sites</a>
                <a class="dropdown-item" href="#">Hébergement sites web</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Autres</a>
              </div>
            </li>
            <li class="nav-item"  @click.prevent="goToTeam">
              <a class="nav-link">Équipe</a>
            </li>
            <li class="nav-item"  @click.prevent="goToPartners">
              <a class="nav-link">Partenaires</a>
            </li>
            <li class="nav-item"  @click.prevent="goToContact">
              <a class="nav-link">Nous contacter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Recrutement</a>
            </li>
          </ul>
          <div style="display: flex; justify-content: flex-end; margin:0 20px 0">
            <div><PrimaryButton label="Obtenir un dévis" /></div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Navbar -->

    <!-- Background image -->

    <div class="bg-image">
      <!-- <div id="component"  class="container my-5"> -->
      <div class="container my-4 py-4">
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
        <p class="text-center">
          <a
            class="btn btn-default btn-lg text-white"
            style="border-radius: 10px 100px / 120px; background-color: #1b449c"
            role="button"
            >Obtenir un devis</a
          >
          <!-- &nbsp;&nbsp; -->
          <a
            class="btn btn-action text-white btn-lg mx-3 mt-2"
            style="border-radius: 10px 100px / 120px; background-color: #f15a2d"
            role="button"
            >Nous contacter</a
          >
        </p>
        <!-- <v-row class="text-center"
          ><v-col> <SecondaryButton label="Obtenir un devis" /></v-col>
          <v-col> <SecondaryButton label="Obtenir un devis" /></v-col>
        </v-row> -->
      </div>
    </div>
    <!-- Background image -->
  </header>
</template>

<style>
/* .navbar-default .navbar-nav > .active > a,
.navbar-default .navbar-nav > .active > a:hover,
.navbar-default .navbar-nav > .active > a:focus {
  color: #333333;

  background-color: red;
} */
 .nav-link.active:hover{
  border: 1px solid  #f15a2d;
  border-radius: 10px;
  color:#1b449c;
  padding: 10px;
  box-shadow: 0 2px 4px rgba(167, 45, 45, 0.1); /* ombre douce */

}
.navbar-collapse ul li a:hover{
      border: 1px solid  #f15a2d;
  border-radius: 10px;
  color:#1b449c;
  padding: 10px;
  box-shadow: 0 2px 4px rgba(167, 45, 45, 0.1); /* ombre douce */

}
#component {
  margin-top: 100px;
  width: 1108px;
  height: 300px;
}
.bg-image {
  /* Workaround for some mobile browsers */
  margin-top: 65px;
  background: url("/images/background1.png") no-repeat center center;
  background-size: cover;
  min-height: 80vh;
  padding-top: 20px;
  padding-bottom: 20px;
}
</style>
