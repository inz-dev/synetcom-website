<script setup>

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
<div class="card" style="width: 30rem;">

  <div class="card-body">
    <h5 class="card-title" style="color:red">Espace de contact</h5>
    <p class="card-subtitle mb-2 text-muted">
    Utilisez le formulaire ci-dessous pour nous contacter. Veuillez être aussi détaillé et précis que possible.
</p>
  </div>
  <div class="card-body">
  <form action="" method="post" class="border rounded-top rounded-4 min-h-20 bg-slate-400 border-black">
  <label for="name">Nom</label>
  <input type="text" value="name" />
  <label for="name">Nom</label>
  <input type="text" value="name" />
  <label for="name">Nom</label>
  <input type="text" value="name" />
  <label for="name">Nom</label>
  <input type="" value="name" />
  <input type="button" value="submit">
 </form>
  </div>
</div>


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
