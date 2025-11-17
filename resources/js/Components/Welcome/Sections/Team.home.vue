<script>
export default {
  data() {
    return {
      listMembers: [
        {
          id: 1,
          title: "Chaibou Abdou",
          role: "Ingénieur Réseau et CEO de Synetcom",
          socialMedia: {
            linkdin: "/images/member2.png",
            email: "mamane@gmail.com",
            whatsapp: "+227606060",
          },
          imagefile: "/images/member1.png",
        },
        {
          id: 2,
          title: "Mamane Laouali Ali Gambo",
          role: "Développeur d’applications web/Mobile",
          socialMedia: {
            linkdin: "/images/member2.png",
            email: "mamane@gmail.com",
            whatsapp: "+227606060",
          },
          imagefile: "/images/member2.png",
        },
        {
          id: 3,
          title: "Ismaeil Nouri",
          role: "Développeur d’applications web/Mobile",
          link: "https://www.enabel.be/fr/country/niger/",
          imagefile: "/images/member3.png",
        },

        {
          id: 4,
          title: "Zeinabou Issaka Nouhou",
          role: "Designer et Développeur d’applications web/Mobile",
          socialMedia: {
            linkdin: "/images/member2.png",
            email: "mamane@gmail.com",
            whatsapp: "+227606060",
          },
          imagefile: "/images/oriba-logo.jpeg",
        },
        {
          id: 5,
          title: "Abdoul-azize",
          role: "Développeur d’applications web/Mobile",
          socialMedia: {
            linkdin: "/images/member2.png",
            email: "mamane@gmail.com",
            whatsapp: "+227606060",
          },
          imagefile: "/images/member3.png",
        },
        {
          id: 6,
          title: "Zakariyaou",
          role: "Développeur d’applications web/Mobile",
          socialMedia: {
            linkdin: "/images/member2.png",
            email: "mamane@gmail.com",
            whatsapp: "+227606060",
          },
          imagefile: "/images/member2.png",
        },
      ],
    };
  },
};
</script>
<template>
  <section class="bg-light py-5 py-xl-8" id="team">
    <div class="container">
      <header>
        <div>
          <span class="spacer"></span>
          <h1>Notre Équipe</h1>
          <span class="spacer"></span>
        </div>
      </header>
      <p id="message">Équipe et professionnels</p>
      <div class="row blog">
        <!-- <h1 class="center mx-auto text-center py-4">Notre Equipe</h1> -->

        <div class="col-md-12">
          <div id="blogCarousel" class="carousel slide" data-ride="carousel">
            <ol class="invisible carousel-indicators">
              <li data-target="#blogCarousel" data-slide-to="0" class="active"></li>
              <li data-target="#blogCarousel" data-slide-to="1"></li>
            </ol>

            <!-- Carousel items -->
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="row">
                  <div
                    class="col-lg-3 col-md-6 col-sm-6"
                    v-for="item in listMembers"
                    :key="item.id"
                  >
                    <div class="our-team">
                      <div class="pic">
                        <img :src="item.imagefile" cover :alt="item.title" />
                      </div>
                      <div class="team-content">
                        <h3 class="title">{{ item.title }}</h3>
                        <span class="post">{{ item.role }}</span>
                      </div>
                      <ul class="social">
                        <li style="margin: 20px">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="blue"
                            class="bi bi-linkedin"
                            viewBox="0 0 16 16"
                          >
                            <path
                              d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"
                            />
                          </svg>
                        </li>
                        <li style="margin: 20px">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="orange"
                            class="bi bi-envelope"
                            viewBox="0 0 16 16"
                          >
                            <path
                              d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"
                            />
                          </svg>
                        </li>
                        <li style="margin: 20px">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            fill="green"
                            class="bi bi-whatsapp"
                            viewBox="0 0 16 16"
                          >
                            <path
                              d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"
                            />
                          </svg>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <!--.row-->
              </div>
              <!--.item-->

              <!--.item-->
            </div>
            <!--.carousel-inner-->
          </div>
          <!--.Carousel-->
        </div>
      </div>
    </div>
  </section>
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
/* h1 {
  margin-top: 0;
  font-size: 3rem;
  display: inline-block;
}
h1 div {
  position: relative;
  float: left;
}
h1 div:first-child {
  color: #1b449c;
  margin-right: 1rem;
} */
/* PROFIL */
.blog .carousel-indicators {
  left: 0;
  top: auto;
  bottom: -40px;
}

/* The colour of the indicators */
.blog .carousel-indicators li {
  background: #a3a3a3;
  border-radius: 50%;
  width: 8px;
  height: 8px;
  margin-bottom: 10px;
}

.blog .carousel-indicators .active {
  background: #707070;
  margin-bottom: 10px;
}

.our-team {
  padding: 0 0 40px;
  background: #f9f9f9;
  height: 240px;
  text-align: center;
  overflow: hidden;
  position: relative;
  border-bottom: 5px solid #1b449c;
  margin: 20px;
}
.our-team:hover {
  border-bottom: 5px solid #ff5252;
}

.our-team .pic {
  display: inline-block;
  width: 130px;
  height: 130px;
  margin-bottom: 50px;
  z-index: 1;
  position: relative;
}
.our-team .pic:before {
  content: "";
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: #1b449c;
  position: absolute;
  bottom: 135%;
  right: 0;
  left: 0;
  opacity: 1;
  transform: scale(3);
  transition: all 0.3s linear 0s;
}
.our-team:hover .pic:before {
  height: 100%;
  background: #ff5252;
}
.our-team .pic:after {
  content: "";
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: #ffffff00;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1;
  transition: all 0.3s linear 0s;
}
.our-team:hover .pic:after {
  background: #1b449c;
}
.our-team .pic img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  transform: scale(1);
  transition: all 0.9s ease 0s;
  box-shadow: 0 0 0 14px #f7f5ec;
  transform: scale(0.7);
  position: relative;
  z-index: 2;
}
.our-team:hover .pic img {
  box-shadow: 0 0 0 14px #f7f5ec;
  transform: scale(0.7);
}
.our-team .team-content {
  margin-bottom: 30px;
}
.our-team .title {
  font-size: 22px;
  font-weight: 700;
  color: #4e5052;
  letter-spacing: 1px;
  text-transform: capitalize;
  margin-bottom: 5px;
}
.our-team .post {
  display: block;
  font-size: 15px;
  color: #4e5052;
  text-transform: capitalize;
}
.our-team .social {
  width: 100%;
  height: 70px;
  padding-top: 10px;
  margin: 0;
  background: white;
  position: absolute;
  bottom: -100px;
  left: 0;
  transition: all 0.5s ease 0s;
}
.our-team:hover .social {
  bottom: 0;
}
.our-team .social li {
  display: inline-block;
}
.our-team .social li a {
  display: block;
  padding-top: 6px;
  font-size: 15px;
  color: #fff;
  transition: all 0.3s ease 0s;
}
.our-team .social li a:hover {
  color: #1b449c;
  background: #f7f5ec;
}
@media only screen and (max-width: 990px) {
  .our-team {
    margin-bottom: 10px;
  }
}
</style>
