<script setup>
import BootstrapIcon from "@/Components/MyComponents/BootstrapIcon.vue";
import 'vue3-carousel/carousel.css'
import { Carousel, Slide, Navigation } from 'vue3-carousel'
const      listPartners= [
        {
          id: 1,
          title: "Nita",
          link: "https://nitatransfert.com/",
          imagefile: "/images/logo-nita.jpeg",
        },
        {
          id: 2,
          title: "Amana",
          link: "https://amana-transfert.com/",
          imagefile: "/images/amana-logo.jpeg",
        },
        {
          id: 3,
          title: "Enabel",
          link: "https://www.enabel.be/fr/country/niger/",
          imagefile: "/images/logo-enabel.jpeg",
        },

        {
          id: 4,
          title: "ORIBA",
          link: "https://oribarice.business.site/",
          imagefile: "/images/oriba-logo.jpeg",
        },
        {
          id: 5,
          title: "UNICEF",
          link: "https://www.unicef.org/niger/",
          imagefile: "/images/unicef-logo.jpeg",
        },
      ];
      const config = {
  height: 200,
  itemsToShow: 5,

  gap:10,
  autoplay: 2000,
  wrapAround: true,
  pauseAutoplayOnHover: true,
}
function  openlink(item) {
      if (item) {
        if (item.link) return window.open(item.link);
        else {
          // this.selectedItem = item;
          // this.dialogModal = true;
        }
      }
    }
</script>
<template>
  <section  id="partner-section" class="bg-light py-5 py-xl-8">
    <div class="container" id="partners">
      <header>
        <div>
          <span class="spacer"></span>
          <h1>Nos partenaires</h1>
          <span class="spacer"></span>
        </div>
      </header>
      <p id="message">Ils nous font confiance</p>

    </div>

    <div class="container overflow-hidden mt-5">
    <div class="img-card">
     <Carousel v-bind="config">
    <Slide v-for="item in listPartners" :key="item.id">
      <img :src="item.imagefile"
              class="card-img-top"
              :alt="item.title"
              @click="openlink(item)"
             />
    </Slide>

    <template #addons>
      <Navigation />
    </template>
  </Carousel>
</div>

    </div>

    <div class="card-footer text-center" style="margin: 15px">
      <PrimaryButton label="Tous nos partenaires"></PrimaryButton>
    </div>
  </section>
</template>
<style scoped>

.card-img-top::before {
  content: "";
  background: #1b449c;
  position: absolute;
  left: 30px;
  right: 30px;
  top: 30px;
  bottom: 30px;
  transition: all ease-in-out 0.3s;
  z-index: 2;
  opacity: 0;
}
.card-img-top{
    cursor:pointer;
    background-size: cover;
    height: 200px;
}
.img-card:hover {
  background-image: #f15a2d;
}
header {
  display: table;
  width: 100%;
  max-width: 100%;
}
header div {
  display: table-row;
  line-height: 1.5em;
  font-size: 2em;
  white-space: nowrap;
}
header h1 {
  font-size: inherit; /* Change font-size in header */
  overflow: hidden;
  display: table-cell;
  vertical-align: middle;
  width: 1px;
  table-layout: fixed;
}
header span.spacer {
  display: table-cell;
}
header h1 {
  padding: 0 10px;
}
header span.spacer:after {
  display: inline-block;
  width: 100%;
  content: ".";
  font-size: 0;
  color: transparent;
  height: 2px;
  background: #000;
  vertical-align: middle;
  position: relative;
  top: -1px;
  background-color: #1b449c;
}
#message {
  color: #f15a2d;
  text-align: center;
  font-family: "Montserrat";
  font-size: 15px;
  font-style: normal;
  font-weight: 400;
  line-height: 38px; /* 158.333% */
  letter-spacing: 0.12px;
}
h3 {
  font-family: "Montserrat";
  margin: 100px auto;
  text-align: center;
  color: black;
  font-size: 40px;
  max-width: 100%;
  position: relative;
}
h3:before {
  content: "";
  display: block;
  width: 150px;
  height: 5px;
  background: #1b449c;
  left: 85px;
  top: 50%;
  position: absolute;
}
h3:after {
  content: "";
  display: block;
  width: 150px;
  height: 5px;
  background: #1b449c;
  right: 85px;
  top: 50%;
  position: absolute;
}
</style>
