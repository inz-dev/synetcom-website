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
  <section id="portfolio" class="portfolio" style="margin-top: 50px">
    <div class="container" data-aos="fade-up">
      <header>
        <div>
          <span class="spacer"></span>
          <h1>Nos Réalisations</h1>
          <span class="spacer"></span>
        </div>
      </header>
      <p id="message">
        Nous avons de la passion et de l’amour pour ce que nous faisons et nous ne croyons
        pas qu’il faille rogner sur les raccourcis et fixer de mauvaises attentes. Nous
        visons à nous améliorer chaque jour et à montrer ce que nous sommes réellement,
        sans faire semblant en aucune circonstance. Il y a plusieurs raisons qui vous
        feront craquer pour nous pour bénéficier de services de développement Web de
        premier ordre. En voici quelques-uns
      </p>

      <v-card>
        <v-tabs v-model="tab" color="primary" align-tabs="center">
          <v-tab :value="1">Apps</v-tab>
          <v-tab :value="2">Impressions Gadgets &nbsp;&&nbsp;Supports</v-tab>
          <v-tab :value="3">Panneaux publicitaires</v-tab>
        </v-tabs>
        <v-window v-model="tab">
          <v-window-item v-for="n in list" :key="n.id" :value="n.id">
            <v-container fluid>
              <v-row>
                <v-col
                  v-for="i in n.data"
                  :key="i.title"
                  cols="12"
                  md="4"
                  class="portfolio-wrap"
                >
                  <aos-vue animation="fade-in" :delay="300">
                    <v-img
                      cover
                      height="250"
                      :src="i.imageFile"
                      :lazy-src="i.imageFile"
                      aspect-ratio="1"
                    ></v-img>
                  </aos-vue>
                  <div class="portfolio-info">
                    <h4>{{ i.title }}</h4>
                    <p>{{ i.text }}</p>
                  </div>
                </v-col>
              </v-row>
            </v-container>
          </v-window-item>
        </v-window>
      </v-card>
    </div>
  </section>
  <!-- End Portfolio Section -->
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
.portfolio .portfolio-item {
  margin-bottom: 30px;
}

.portfolio #portfolio-flters {
  padding: 0;
  margin: 0 auto 25px auto;
  list-style: none;
  text-align: center;
  border-radius: 50px;
  padding: 2px 15px;
}

.portfolio #portfolio-flters li {
  cursor: pointer;
  display: inline-block;
  padding: 10px 15px;
  font-size: 14px;
  font-weight: 600;
  line-height: 1;
  text-transform: uppercase;
  color: #444444;
  margin-bottom: 5px;
  transition: all 0.3s ease-in-out;
  border-radius: 5px;
  font-family: "Poppins", sans-serif;
}

.portfolio #portfolio-flters li:hover,
.portfolio #portfolio-flters li.filter-active {
  color: #fff;
  background: #f15a2d;
}

.portfolio #portfolio-flters li:last-child {
  margin-right: 0;
}

.portfolio .portfolio-wrap {
  transition: 0.3s;
  position: relative;
  overflow: hidden;
  z-index: 1;
}

.portfolio .portfolio-wrap::before {
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

.portfolio .portfolio-wrap .portfolio-info {
  opacity: 0;
  position: absolute;
  top: 10%;
  left: 0;
  right: 0;
  text-align: center;
  z-index: 3;
  transition: all ease-in-out 0.3s;
}

.portfolio .portfolio-wrap .portfolio-info h4 {
  font-size: 20px;
  color: #fff;
  font-weight: 600;
}

.portfolio .portfolio-wrap .portfolio-info p {
  color: #ffffff;
  font-size: 14px;
  text-transform: uppercase;
}

.portfolio .portfolio-wrap .portfolio-links {
  opacity: 0;
  left: 0;
  right: 0;
  bottom: 10%;
  text-align: center;
  z-index: 3;
  position: absolute;
  transition: all ease-in-out 0.3s;
}

.portfolio .portfolio-wrap .portfolio-links a {
  color: rgba(255, 255, 255, 0.6);
  margin: 0 2px;
  font-size: 28px;
  display: inline-block;
  transition: 0.3s;
}

.portfolio .portfolio-wrap .portfolio-links a:hover {
  color: #fff;
}

.portfolio .portfolio-wrap:hover::before {
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  opacity: 1;
}

.portfolio .portfolio-wrap:hover .portfolio-info {
  opacity: 1;
  top: calc(50% - 48px);
}

.portfolio .portfolio-wrap:hover .portfolio-links {
  opacity: 1;
  bottom: calc(50% - 50px);
}
</style>
