<script setup>



</script>
<template>
  <section  id="nous_contacter-section" class="bg-light">
      <header>
        <div>
          <span class="spacerT"></span>
          <h1>Nous contacter</h1>
          <span class="spacerT"></span>
        </div>
      </header>
      <p id="message">Ils nous font confiance</p>




    <div class="row">
    <div class="col px-9" >
    <img id="col-image" src="/images/sections/icon_section_nouscontacter.png" alt="icon nous contacter">
    </div>
    <div class="col mx-9 my-10">
    <form action="" method="post" style="width:549px; height:1068px;" class=" px-9 py-10 border border-white bg-white" >
    <div id="form-contact" >
<h1>Hello</h1>
    </div>
    </form>
    </div>
    </div>







    </section>
<Footer/>
</template>
<style scoped>
.row {
    background-color: blue;
  display: flex;
  flex-wrap: wrap;        /* permet de passer à la ligne si l’écran est trop petit */
  margin: 0 -10px;        /* petit "gutter" */
}

.col {
  flex: 1;                /* chaque colonne prend la même largeur */
  min-width: 250px;       /* largeur minimale avant de se casser en ligne */
  padding: 10px;
  box-sizing: border-box;

  text-align: center;
}
#col-image{
    top:0;
    left: 0;
    background-size: cover;
    width: 400px;
    background-position: center;
}
header span.spacerT {
  display: table-cell;
}
header h1 {
  padding: 0 10px;
}
header span.spacerTT:after {
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

