<script>
export default {
  data: () => ({
    tab: null,
    list: [
      {
        id: 1,
        type: "apps",
        data: [
          {
            imageFile: "/images/portfolio/portfolio-2.jpg",
            title: "App1",
            text: "Pass-sutura",
          },
          {
            imageFile: "/images/portfolio/portfolio-3.jpg",
            title: "App2",
            text: "Gestion scolaire",
          },
          {
            imageFile: "/images/portfolio/portfolio-4.jpg",
            title: "App3",
            text: "Gestion de locations",
          },
          {
            imageFile: "/images/portfolio/portfolio-8.jpg",
            title: "App3",
            text: "Assurance Maladie ",
          },
        ],
      },
      {
        id: 3,
        type: "panneaux publicitaires",
        data: [
          {
            imageFile: "/images/portfolio/portfolio-details-2.jpg",
            title: "Panneau1",
            text: "Déco Grand marché",
          },
          {
            imageFile: "/images/portfolio/portfolio-5.jpg",
            title: "Panneau2",
            text: "Ecole INSP",
          },
          {
            imageFile: "/images/portfolio/portfolio-4.jpg",
            title: "Panneau3",
            text: "Gestion de locations",
          },
          {
            imageFile: "/images/portfolio/portfolio-8.jpg",
            title: "Panneau4",
            text: "Assurance Maladie ",
          },
        ],
      },

      {
        id: 2,
        type: "impressions g&s",
        data: [
          {
            imageFile: "/images/portfolio/portfolio-7.jpg",
            title: "Impression1",
            text: "Cadeaux",
          },
          {
            imageFile: "/images/portfolio/portfolio-9.jpg",
            title: "Impression2",
            text: "Bracelets",
          },
          {
            imageFile: "/images/portfolio/portfolio-details-1.jpg",
            title: "Impression3",
            text: "Produits de beauté",
          },
          {
            imageFile: "/images/portfolio/portfolio-details-3.jpg",
            title: "Impression4",
            text: "Produits de maquillages",
          },
        ],
      },
    ],
  }),
};
</script>

<template>
  <section id="nous-contacter" class="nous-contacter" style="margin-top: 50px">
    <div class="container" data-aos="fade-up">
      <header>
        <div>
          <span class="spacer"></span>
          <h1>Nous contacter</h1>
          <span class="spacer"></span>
        </div>
      </header>

<div class="row bg-blue-700">
<div class="col">
<div>
    <img src="/images/sections/icon_section_nouscontacter.png" alt="" srcset="" style="background-size:cover; width:300px">
</div>
</div>
<div class="col">
<form action="" method="post" class="border rounded-top rounded-4 min-h-20 border-black">
<h1>Informations</h1>
</form>
</div>

</div>
    </div>
  </section>
  <!-- End Nous contacter Section -->
  <Footer/>
</template>

<style scoped>
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





</style>
