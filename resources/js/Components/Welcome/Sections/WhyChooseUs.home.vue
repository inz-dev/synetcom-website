<template>
  <!-- About 1 - Bootstrap Brain Component -->
  <section class="py-3 py-md-5 py-xl-8">
    <div
      class="container"
      style="border-radius: 64px; border: 10px solid var(--primaryColor, #1b449c)"
    >
      <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
        <div class="col-12 col-lg-6 col-xl-5">
          <img
            class="img-fluid rounded"
            loading="lazy"
            src="/images/why-choose-use1.png"
            alt=""
          />
        </div>
        <div class="col-12 col-lg-6 col-xl-7">
          <div class="row justify-content-xl-center">
            <div class="col-12 col-xl-11">
              <h2 class="h1 mb-3" id="header1">Pourquoi nous choisir??</h2>
              <p id="message">
                Notre équipe est là pour vous apporter un accompagnement personnalisé dans
                l'heure disponible 24h/24 et 7j/7. Conformément à notre engagement à
                fournir un service supérieur et professionnel. Rejoignez des webinaires
                quotidiens en direct, regardez nos tutoriels ou parcourez nos
                connaissances.
              </p>
              <div class="row gy-4 gy-md-0 gx-xxl-5X">
                <div class="col-12 col-md-6">
                  <div class="d-flex">
                    <div class="me-4 text-primary">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="32"
                        height="32"
                        fill="currentColor"
                        class="bi bi-gear-fill"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"
                        />
                      </svg>
                    </div>
                    <div>
                      <h4 class="mb-3">Marque polyvalente</h4>
                      <p class="text-secondary mb-0">
                        Nous élaborons une méthode numérique qui perdure sur tous les
                        supports.
                      </p>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="d-flex">
                    <div class="me-4 text-primary">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="32"
                        height="32"
                        fill="currentColor"
                        class="bi bi-fire"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z"
                        />
                      </svg>
                    </div>
                    <div>
                      <h4 class="mb-3">Agence Digitale</h4>
                      <p class="text-secondary mb-0">
                        Nous croyons en l'innovation en fusionnant les idées primaires
                        avec des idées élaborées.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-6 card-footer text-center">
              <PrimaryButton label="Lire plus"></PrimaryButton>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {};
</script>
<style scoped>
#message {
  color: #585858;
  text-align: justify;

  /* text-paragraphe */
  font-family: "Montserrat";
  font-size: 20px;
  font-style: normal;
  font-weight: 400;
  line-height: 38px; /* 158.333% */
  letter-spacing: 0.12px;
}
#header1 {
  color: #151718;
  font-family: "Montserrat";
  font-size: 40px;
  font-style: normal;
  font-weight: 700;
  line-height: 147.4%; /* 58.96px */
  letter-spacing: 0.8px;
}
</style>
