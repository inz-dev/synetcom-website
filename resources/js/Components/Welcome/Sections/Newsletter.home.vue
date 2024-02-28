<template>
  <section class="py-3 py-md-5 py-xl-8">
    <div
      class="container"
      style="background-color: #e6e6e6; bottom: 1641.6px; padding: 25px"
    >
      <div class="row justify-content-md-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-7">
          <h3 class="fs-6 mb-2 text-center text-uppercase">
            Inscription à la Newsletter
          </h3>

          <p>
            Inscrivez à notre Newsletter pour obtenir nos dernières solutions mises au
            point.
          </p>
        </div>
      </div>

      <div class="container overflow-hidden">
        <div class="row gy-4 gy-xl-0 justify-content-md-center">
          <div class="col-12 col-md-10 col-lg-8 col-xl-7 text-center">
            <div class="input-group mb-3 mt-4">
              <input
                type="text"
                class="form-control"
                placeholder="Entrez votre adresse-mail"
                aria-label="Adresse-mail"
                aria-describedby="button-addon2"
              />
            </div>

            <div class="card-footer text-center">
              <PrimaryButton label="S'inscrire"></PrimaryButton>
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
.form-control {
  display: block;
  width: 100%;
  min-height: calc(1.5em + 0.75rem + 2px);
  padding: 0.575rem 0.75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  border-radius: 52px;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-control:focus {
  color: #495057;
  background-color: #fff;
  border-color: #f15a2d;
  outline: 0;
  box-shadow: none;
}

.border-rad {
  border-top-right-radius: 28px;
  border-bottom-right-radius: 28px;

  color: #fff;
  background-color: #f15a2d;
  border-color: #f15a2d;
}

.border-rad:hover {
  background-color: #f15a2d;
  border-color: #f15a2d;
}
</style>
