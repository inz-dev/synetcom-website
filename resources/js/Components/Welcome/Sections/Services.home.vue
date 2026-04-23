<template>
    <section id="services" class="services-section">
        <div class="s-container">

            <!-- Header -->
            <div class="section-head">
                <span class="section-eyebrow">Ce que nous faisons</span>
                <h2 class="section-title">Nos Services</h2>
                <p class="section-sub">
                    Des solutions numériques complètes pour accompagner votre croissance à chaque étape.
                </p>
            </div>

            <!-- Grid -->
            <div class="services-grid">
                <div v-for="item in services" :key="item.id" class="service-card">
                    <div class="card-icon" :style="{ background: item.color + '18', color: item.color }">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round" width="26" height="26">
                            <component :is="'path'" v-for="(d,i) in item.paths" :key="i" :d="d" />
                        </svg>
                    </div>
                    <h3 class="card-title">{{ item.title }}</h3>
                    <p class="card-desc">{{ item.desc }}</p>
                    <Link :href="route('services')" class="card-link">
                        Lire plus
                        <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </Link>
                </div>
            </div>

            <div class="section-footer">
                <Link :href="route('services')" class="btn-all-services">Voir tous nos services</Link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const services = [
    {
        id: 1,
        title: "Développement & Intégration Digitale",
        desc: "Conception et déploiement de solutions logicielles sur mesure pour digitaliser vos processus métier.",
        color: "#1b449c",
        paths: ["M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v10m0 0H5a2 2 0 00-2 2v4h6m-6 0h14m0-14v10m0 0h-4a2 2 0 00-2 2v4m0 0h6"]
    },
    {
        id: 2,
        title: "Impression & Supports de Visibilité",
        desc: "Impression de gadgets, brochures, banderoles et supports publicitaires pour renforcer votre image.",
        color: "#f15a2d",
        paths: ["M17 17H17.01M17 3H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2z", "M17 3v6l-2-1-2 1V3"]
    },
    {
        id: 3,
        title: "Développement Web & Mobile",
        desc: "Création d'applications web et mobiles performantes, intuitives et adaptées à vos utilisateurs.",
        color: "#7c3aed",
        paths: ["M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"]
    },
    {
        id: 4,
        title: "Formation & Renforcement de Capacités",
        desc: "Formations professionnelles en informatique et technologies pour développer les compétences de vos équipes.",
        color: "#059669",
        paths: ["M12 14l9-5-9-5-9 5 9 5z", "M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"]
    },
    {
        id: 5,
        title: "Administration & Sécurité Réseau",
        desc: "Gestion, monitoring et sécurisation de vos infrastructures réseaux pour assurer continuité et protection.",
        color: "#dc2626",
        paths: ["M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"]
    },
    {
        id: 6,
        title: "Hébergement & Référencement SEO",
        desc: "Hébergement sécurisé de vos plateformes et optimisation SEO pour améliorer votre visibilité en ligne.",
        color: "#0284c7",
        paths: ["M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"]
    },
    {
        id: 7,
        title: "Collecte & Analyse des Données",
        desc: "Collecte, traitement et visualisation de vos données pour une prise de décision éclairée basée sur les faits.",
        color: "#d97706",
        paths: ["M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"]
    },
    {
        id: 8,
        title: "Vente de Matériels Informatiques",
        desc: "Fourniture de matériels et consommables informatiques de qualité pour équiper vos espaces de travail.",
        color: "#7c3aed",
        paths: ["M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"]
    },
    {
        id: 9,
        title: "Audit & Analyse des Systèmes d'Information",
        desc: "Évaluation complète de vos systèmes d'information pour identifier les risques et optimiser les performances.",
        color: "#1b449c",
        paths: ["M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"]
    },
];
</script>

<style scoped>
.services-section {
    padding: 96px 0;
    background: #fff;
}
.s-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Section header */
.section-head { text-align: center; margin-bottom: 56px; }
.section-eyebrow {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #f15a2d;
    margin-bottom: 12px;
}
.section-title {
    font-size: clamp(1.8rem, 4vw, 2.6rem);
    font-weight: 800;
    color: #0d1b3e;
    margin: 0 0 14px;
    letter-spacing: -0.02em;
    line-height: 1.15;
}
.section-sub {
    font-size: 1.05rem;
    color: #64748b;
    max-width: 560px;
    margin: 0 auto;
    line-height: 1.7;
}

/* Grid */
.services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

/* Card */
.service-card {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 16px;
    padding: 28px 24px 24px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: all 0.25s;
    position: relative;
    overflow: hidden;
}
.service-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #1b449c, #f15a2d);
    transform: scaleX(0);
    transition: transform 0.3s;
    transform-origin: left;
}
.service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(27,68,156,0.10);
    border-color: transparent;
}
.service-card:hover::before { transform: scaleX(1); }

.card-icon {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.card-title {
    font-size: 15px;
    font-weight: 700;
    color: #0d1b3e;
    line-height: 1.3;
    margin: 0;
}
.card-desc {
    font-size: 13.5px;
    color: #64748b;
    line-height: 1.6;
    margin: 0;
    flex: 1;
}
.card-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    font-weight: 700;
    color: #1b449c;
    text-decoration: none;
    margin-top: auto;
    transition: gap 0.2s;
}
.card-link:hover { gap: 8px; color: #f15a2d; }

/* Footer CTA */
.section-footer { text-align: center; margin-top: 48px; }
.btn-all-services {
    display: inline-flex;
    align-items: center;
    padding: 13px 32px;
    border: 2px solid #1b449c;
    border-radius: 50px;
    color: #1b449c;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s;
}
.btn-all-services:hover {
    background: #1b449c;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(27,68,156,0.25);
}

@media (max-width: 1024px) {
    .services-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 640px) {
    .services-section { padding: 64px 0; }
    .services-grid { grid-template-columns: 1fr; gap: 16px; }
}
</style>
