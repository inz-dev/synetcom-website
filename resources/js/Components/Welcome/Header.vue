<script setup>
    import { router } from '@inertiajs/vue3';
import SecondaryButton from '../MyComponents/SecondaryButton.vue';
const propos=defineProps(
    {  currentRoute:Boolean}
)
    function goToSection(typePage){
       const section=document.getElementById(typePage)
       if(section){
        section.scrollIntoView({behavior:'smooth'})
       }
    }

const navigateTo=(routeName)=>{
    console.log('routeName:',routeName)
    router.visit(route(routeName))
    console.log('routeName2:',route(routeName))

}
const listServices=[
    {
        nameLink:'Equipe',
        action:goToSection('team')
    }
]

</script>

<template>
  <header>
    <!-- Navbar -->

    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img
            src="/images/logo.png"
            style="background-size: cover; height:50px"
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
          <ul class="navbar-nav" style="display:flex; gap:12px">
            <li class="nav-item">
              <a class="active nav-link "   :class="{ active: currentRoute === 'Accueil' }" href="/">Accueil</a>
            </li>
            <li class="nav-item">

              <a class="nav-link" @click.prevent="navigateTo('about-us')"
               :class="{ active: currentRoute === 'Qui sommes-nous?' }">Qui sommes-nous?</a>
            </li>

            <li class="nav-item dropdown"  @click.prevent="goToSection('services')">
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
            <li class="nav-item"  @click.prevent="goToSection('team')">
              <a class="nav-link">Équipe</a>
            </li>
            <li class="nav-item"  @click.prevent="goToSection('partners')">
              <a class="nav-link">Partenaires</a>
            </li>
            <li class="nav-item"  @click.prevent="navigateTo('nous-contacter')">
              <a class="nav-link">Nous contacter</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Recrutement</a>
            </li>
          </ul>
          <div style="display: flex; justify-content: flex-end;margin-left:auto; gap:8px">
            <PrimaryButton label="Obtenir un dévis" />
            <SecondaryButton  label="Connexion" @click.prevent.stop="navigateTo('login')"/>
          </div>
        </div>
      </div>
    </nav>

    <!-- Navbar -->

    <!-- Background image -->

   <slot/>
    <!-- Background image -->
  </header>
</template>

<style scope>
/*   .nav-link.active {
  background-color: #28a745;
  color: #fff;
} */

/* .navbar-nav > .active > a, .navbar-nav > .active > a:hover, .navbar-nav > .active > a:focus {
  background-color: #97e6eb;
  color: #000000;
} */
 .nav-link.active:hover{
  border: 1px solid  #f15a2d;
  border-radius: 10px;
  color:#1b449c;
  padding: 5px;
  box-shadow: 0 2px 4px rgba(167, 45, 45, 0.1); /* ombre douce */

}
.navbar-collapse ul li a:hover{
      border: 1px dotted  #f15a2d;
  border-radius: 10px;
  color:#1b449c;
  padding: 5px;
  box-shadow: 0 2px 4px rgba(167, 45, 45, 0.1); /* ombre douce */

}
#component {
  margin-top: 100px;
  width: 1108px;
  height: 300px;
}

</style>
