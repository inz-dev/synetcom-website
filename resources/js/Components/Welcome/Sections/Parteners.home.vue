<script setup>
import { Link } from '@inertiajs/vue3';
import 'vue3-carousel/carousel.css';
import { Carousel, Navigation, Slide } from 'vue3-carousel';

const listPartners = [
    { id: 1, title: "Nita Transfert",  link: "https://nitatransfert.com/",                  imagefile: "/images/logo-nita.jpeg"    },
    { id: 2, title: "Amana Transfert", link: "https://amana-transfert.com/",                 imagefile: "/images/amana-logo.jpeg"   },
    { id: 3, title: "Enabel Niger",    link: "https://www.enabel.be/fr/country/niger/",      imagefile: "/images/logo-enabel.jpeg"  },
    { id: 4, title: "ORIBA",           link: "https://oribarice.business.site/",             imagefile: "/images/oriba-logo.jpeg"   },
    { id: 5, title: "UNICEF Niger",    link: "https://www.unicef.org/niger/",                imagefile: "/images/unicef-logo.jpeg"  },
];

const carouselConfig = {
    itemsToShow: 4,
    gap: 32,
    autoplay: 2500,
    wrapAround: true,
    pauseAutoplayOnHover: true,
    breakpoints: {
        0:    { itemsToShow: 1 },
        480:  { itemsToShow: 2 },
        768:  { itemsToShow: 3 },
        1024: { itemsToShow: 4 },
    },
};

const openLink = (url) => {
    if (url) window.open(url, '_blank', 'noopener,noreferrer');
};
</script>

<template>
    <section id="partners" class="partners-section">
        <div class="p-container">

            <!-- Header -->
            <div class="section-head">
                <span class="section-eyebrow">Nos partenaires</span>
                <h2 class="section-title">Ils nous font confiance</h2>
                <p class="section-sub">
                    Des organisations et entreprises de renom qui s'appuient sur l'expertise de Synetcom.
                </p>
            </div>

            <!-- Carousel -->
            <div class="carousel-wrap">
                <Carousel v-bind="carouselConfig">
                    <Slide v-for="partner in listPartners" :key="partner.id">
                        <div class="partner-slide" @click="openLink(partner.link)" :title="partner.title">
                            <div class="partner-logo-box">
                                <img :src="partner.imagefile" :alt="partner.title" class="partner-logo" />
                            </div>
                            <span class="partner-name">{{ partner.title }}</span>
                        </div>
                    </Slide>
                    <template #addons>
                        <Navigation />
                    </template>
                </Carousel>
            </div>

            <!-- CTA -->
            <div class="section-footer">
                <Link :href="route('partenaires')" class="btn-all-partners">
                    Tous nos partenaires
                    <svg viewBox="0 0 20 20" fill="currentColor" width="15" height="15">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </Link>
            </div>

        </div>
    </section>
</template>

<style scoped>
.partners-section {
    padding: 88px 0;
    background: #f8fafc;
}
.p-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Header */
.section-head { text-align: center; margin-bottom: 52px; }
.section-eyebrow {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.10em;
    text-transform: uppercase;
    color: #f15a2d;
    margin-bottom: 12px;
}
.section-title {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    font-weight: 800;
    color: #0d1b3e;
    margin: 0 0 12px;
    letter-spacing: -0.02em;
    line-height: 1.15;
}
.section-sub {
    font-size: 1.05rem;
    color: #64748b;
    max-width: 500px;
    margin: 0 auto;
    line-height: 1.7;
}

/* Carousel */
.carousel-wrap {
    margin-bottom: 48px;
}

/* Override vue3-carousel nav buttons */
:deep(.carousel__prev),
:deep(.carousel__next) {
    background: #fff;
    border: 1.5px solid #e8edf5;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    color: #1b449c;
    box-shadow: 0 2px 8px rgba(27,68,156,0.10);
    transition: all 0.2s;
}
:deep(.carousel__prev:hover),
:deep(.carousel__next:hover) {
    background: #1b449c;
    color: #fff;
    border-color: #1b449c;
}

/* Slide */
.partner-slide {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    padding: 0 12px;
    width: 100%;
}
.partner-logo-box {
    width: 100%;
    max-width: 180px;
    height: 100px;
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 18px 20px;
    transition: all 0.25s;
    box-shadow: 0 2px 8px rgba(27,68,156,0.04);
}
.partner-slide:hover .partner-logo-box {
    border-color: #1b449c;
    box-shadow: 0 8px 24px rgba(27,68,156,0.12);
    transform: translateY(-4px);
}
.partner-logo {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    filter: grayscale(40%);
    transition: filter 0.25s;
}
.partner-slide:hover .partner-logo { filter: grayscale(0%); }

.partner-name {
    font-size: 12.5px;
    font-weight: 600;
    color: #64748b;
    text-align: center;
    transition: color 0.2s;
}
.partner-slide:hover .partner-name { color: #1b449c; }

/* CTA */
.section-footer { text-align: center; }
.btn-all-partners {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 32px;
    background: linear-gradient(135deg, #1b449c, #1535804a);
    background: #1b449c;
    color: #fff;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s;
    box-shadow: 0 4px 16px rgba(27,68,156,0.25);
}
.btn-all-partners:hover {
    background: #0d1b3e;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(27,68,156,0.35);
}
.btn-all-partners svg { transition: transform 0.2s; }
.btn-all-partners:hover svg { transform: translateX(3px); }

@media (max-width: 640px) {
    .partners-section { padding: 64px 0; }
}
</style>
