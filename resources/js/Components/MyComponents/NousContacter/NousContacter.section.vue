<script setup>

</script>

<template>
  <section id="nous-contacter" class="nous-contacter" style="margin-top:5px">
    <div class="container" data-aos="fade-up">
      <header class="mb-3">
        <div>
          <span class="spacer"></span>
          <h1>Nous contacter</h1>
          <span class="spacer"></span>
        </div>
      </header>

  <div class="container py-2 bg-light">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="contact-wrapper">
          <div class="row g-0">
            <div class="col-md-4">
              <div class="contact-info h-100">
                <h3 class="mb-4">Entrez en contact</h3>
                <p class="card-subtitle mb-4 " style="font-size: small; font-weight: 450;">
              Nous serions ravis d'avoir de vos nouvelles. Veuillez remplir le formulaire ou nous contacter en utilisant les informations ci-dessous.
                </p>

                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="fas fa-map-marker-alt"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Adresse</h6>
                    <p class="mb-0">Face Pharmacie Maisons économiques<br>13743 Niamey-NIGER</p>
                  </div>
                </div>

                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="fas fa-phone"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Téléphone</h6>
                    <p class="mb-0">  +227 90717476/88888811</p>
                  </div>
                </div>

                <div class="contact-item">
                  <div class="contact-icon">
                    <i class="fas fa-envelope"></i>
                  </div>
                  <div>
                    <h6 class="mb-0">Email</h6>
                    <p class="mb-0">chaibou.abdou@synetcom.dev</p>
                  </div>
                </div>

                <div class="social-links">
                  <h6 class="mb-3">Suivez-nous sur</h6>
                  <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                  <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                  <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                  <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                </div>
              </div>
            </div>

            <div class="col-md-8">
              <div class="contact-form">
                <h3 class="mb-4">Envoyez-nous un message</h3>
                <form>
                  <div class="row">
                    <div class="col mb-3">
                      <label class="form-label">Nom complet</label>
                      <input type="text" class="form-control" placeholder="Nom complet">
                    </div>

                  </div>

                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="john@example.com">
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Sujet</label>
                    <input type="text" class="form-control" placeholder="Sujet">
                  </div>

                  <div class="mb-4">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" rows="5" placeholder="Votre message ICI..."></textarea>
                  </div>

                  <button type="submit" class="btn btn-submit text-white">Soumettre</button>
                </form>

                <div class="map-container mt-4">
                  <img src="/api/placeholder/800/200" alt="Map" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
              </div>
            </div>
          </div>
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
  @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css");


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


    .contact-wrapper {
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    }

    .contact-info {
      background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);
      padding: 40px;
      color: white;
    }

    .contact-item {
      display: flex;
      align-items: center;
      margin-bottom: 25px;
      transition: all 0.3s ease;
      font-size: 12px;
    }

    .contact-item:hover {
      transform: translateX(10px);
    }

    .contact-icon {
      width: 40px;
      height: 40px;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
    }

    .social-links {
      margin-top: 30px;
    }

    .social-icon {
      width: 35px;
      height: 35px;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-right: 10px;
      transition: all 0.3s ease;
    }

    .social-icon:hover {
      background: white;
      color: #1b449c;
      transform: translateY(-3px);
    }

    .contact-form {
      padding: 40px;
    }

    .form-control {
      border-radius: 10px;
      padding: 12px 15px;
      border: 2px solid #eee;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #1b449c;
      box-shadow: none;
    }

    .form-label {
      font-weight: 500;
      margin-bottom: 8px;
    }

    .btn-submit {
      background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);
      border: none;
      padding: 12px 30px;
      border-radius: 10px;
      transition: all 0.3s ease;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px #1b449c;
    }

    .map-container {
      height: 200px;
      border-radius: 10px;
      overflow: hidden;
      margin-top: 20px;
    }
  </style>
