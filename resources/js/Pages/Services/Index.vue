<script setup>
import Footer from "@/Components/Welcome/Footer.vue";
import Header from "@/Components/Welcome/Header.vue";
import { Head, Link } from "@inertiajs/vue3";

const services = [
    {
        id: 1,
        title: "Développement & Intégration Digitale",
        desc: "Conception et déploiement de solutions logicielles sur mesure pour digitaliser vos processus métier. Nous intégrons les meilleurs outils numériques pour transformer votre organisation et améliorer votre efficacité opérationnelle.",
        color: "#1b449c",
        paths: ["M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v10m0 0H5a2 2 0 00-2 2v4h6m-6 0h14m0-14v10m0 0h-4a2 2 0 00-2 2v4m0 0h6"]
    },
    {
        id: 2,
        title: "Impression & Supports de Visibilité",
        desc: "Impression de gadgets, brochures, banderoles et supports publicitaires pour renforcer votre image de marque et votre présence sur le terrain auprès de vos clients et partenaires.",
        color: "#f15a2d",
        paths: ["M17 17H17.01M17 3H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2z", "M17 3v6l-2-1-2 1V3"]
    },
    {
        id: 3,
        title: "Développement Web & Mobile",
        desc: "Création d'applications web et mobiles performantes, intuitives et adaptées à vos utilisateurs. Nous développons des solutions sur mesure qui répondent précisément à vos besoins métier.",
        color: "#7c3aed",
        paths: ["M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"]
    },
    {
        id: 4,
        title: "Formation & Renforcement de Capacités",
        desc: "Formations professionnelles en informatique et technologies pour développer les compétences de vos équipes. Nous proposons des programmes adaptés à tous les niveaux pour assurer votre montée en puissance.",
        color: "#059669",
        paths: ["M12 14l9-5-9-5-9 5 9 5z", "M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"]
    },
    {
        id: 5,
        title: "Administration & Sécurité Réseau",
        desc: "Gestion, monitoring et sécurisation de vos infrastructures réseaux pour assurer continuité et protection de vos données critiques contre les menaces internes et externes.",
        color: "#dc2626",
        paths: ["M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"]
    },
    {
        id: 6,
        title: "Hébergement & Référencement SEO",
        desc: "Hébergement sécurisé de vos plateformes numériques et optimisation SEO pour améliorer votre visibilité en ligne, attirer plus de visiteurs et convertir en clients fidèles.",
        color: "#0284c7",
        paths: ["M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"]
    },
    {
        id: 7,
        title: "Collecte & Analyse des Données",
        desc: "Collecte, traitement et visualisation de vos données pour une prise de décision éclairée basée sur les faits et les tendances réelles du marché. Nous transformons vos données en insights actionnables.",
        color: "#d97706",
        paths: ["M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"]
    },
    {
        id: 8,
        title: "Vente de Matériels Informatiques",
        desc: "Fourniture de matériels et consommables informatiques de qualité pour équiper vos espaces de travail. Nous sélectionnons des équipements fiables et performants adaptés à votre budget.",
        color: "#7c3aed",
        paths: ["M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"]
    },
    {
        id: 9,
        title: "Audit & Analyse des Systèmes d'Information",
        desc: "Évaluation complète de vos systèmes d'information pour identifier les risques, optimiser les performances et garantir la pérennité et la sécurité de votre infrastructure numérique.",
        color: "#1b449c",
        paths: ["M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"]
    },
];
</script>

<template>
    <Head title="Nos Services" />

    <Header>
        <!-- Hero compact -->
        <section class="page-hero">
            <div class="hero-bg"></div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <nav class="breadcrumb">
                    <Link href="/" class="breadcrumb-link">Accueil</Link>
                    <span class="breadcrumb-sep">/</span>
                    <span class="breadcrumb-current">Services</span>
                </nav>
                <h1 class="hero-title">Nos Services<span class="accent">.</span></h1>
                <p class="hero-sub">
                    Des solutions numériques complètes pour accompagner votre croissance à chaque étape.
                </p>
                <Link href="/nous-contacter" class="hero-cta">
                    Obtenir un devis
                    <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </Link>
            </div>
        </section>
    </Header>

    <!-- Services -->
    <main class="services-main">
        <div class="s-container">

            <!-- Intro -->
            <div class="section-intro">
                <span class="eyebrow">Ce que nous proposons</span>
                <h2 class="intro-title">L'expertise Synetcom à votre service</h2>
                <p class="intro-desc">
                    Depuis plus de 9 ans, nous accompagnons les entreprises et organisations du Niger
                    dans leur transformation digitale avec des solutions adaptées à chaque besoin.
                </p>
            </div>

            <!-- Grid -->
            <div class="services-grid">
                <div v-for="service in services" :key="service.id" class="service-card">
                    <div class="card-top">
                        <div class="card-icon" :style="{ background: service.color + '15', color: service.color }">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                 width="28" height="28">
                                <path v-for="(d, i) in service.paths" :key="i" :d="d" />
                            </svg>
                        </div>
                        <span class="card-num" :style="{ color: service.color + '30' }">
                            {{ String(service.id).padStart(2, '0') }}
                        </span>
                    </div>
                    <div class="card-accent" :style="{ background: service.color }"></div>
                    <h3 class="card-title">{{ service.title }}</h3>
                    <p class="card-desc">{{ service.desc }}</p>
                    <Link href="/nous-contacter" class="card-cta" :style="{ '--cta-color': service.color }">
                        Demander ce service
                        <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </Link>
                </div>
            </div>
        </div>
    </main>

    <!-- CTA Banner -->
    <section class="cta-banner">
        <div class="s-container">
            <div class="cta-box">
                <div class="cta-text">
                    <h2 class="cta-title">Vous avez un projet en tête ?</h2>
                    <p class="cta-desc">Contactez-nous dès aujourd'hui pour discuter de vos besoins et obtenir une solution personnalisée.</p>
                </div>
                <div class="cta-actions">
                    <Link href="/nous-contacter" class="btn-contact">Nous contacter</Link>
                    <Link href="/" class="btn-back">
                        <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                        Retour à l'accueil
                    </Link>
                </div>
            </div>
        </div>
    </section>

    <Footer />
</template>

<style scoped>
/* ── Hero ─────────────────────────────────────────────────────── */
.page-hero {
    position: relative;
    min-height: 42vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 68px;
    overflow: hidden;
}
.hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('/images/background1.png');
    background-size: cover;
    background-position: center;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(11,22,56,0.92) 0%, rgba(27,68,156,0.80) 60%, rgba(11,22,56,0.88) 100%);
}
.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 56px 24px;
    max-width: 700px;
    width: 100%;
}

.breadcrumb {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: 20px;
    font-size: 13px;
}
.breadcrumb-link {
    color: rgba(255,255,255,0.6);
    text-decoration: none;
    transition: color 0.2s;
}
.breadcrumb-link:hover { color: #f15a2d; }
.breadcrumb-sep { color: rgba(255,255,255,0.3); }
.breadcrumb-current { color: rgba(255,255,255,0.9); font-weight: 600; }

.hero-title {
    font-size: clamp(2.2rem, 5vw, 3.4rem);
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.02em;
    line-height: 1.12;
    margin: 0 0 16px;
}
.accent { color: #f15a2d; }

.hero-sub {
    font-size: 1.05rem;
    color: rgba(255,255,255,0.75);
    line-height: 1.7;
    margin: 0 0 32px;
}

.hero-cta {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 28px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s;
    box-shadow: 0 4px 16px rgba(241,90,45,0.35);
}
.hero-cta:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(241,90,45,0.50);
    color: #fff;
}

/* ── Main layout ─────────────────────────────────────────────── */
.services-main {
    padding: 80px 0 96px;
    background: #f8fafc;
}
.s-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* ── Intro ───────────────────────────────────────────────────── */
.section-intro {
    text-align: center;
    margin-bottom: 60px;
}
.eyebrow {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #f15a2d;
    margin-bottom: 14px;
}
.intro-title {
    font-size: clamp(1.7rem, 3.5vw, 2.4rem);
    font-weight: 800;
    color: #0d1b3e;
    margin: 0 0 14px;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.intro-desc {
    font-size: 1.05rem;
    color: #64748b;
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ── Grid ────────────────────────────────────────────────────── */
.services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

/* ── Card ────────────────────────────────────────────────────── */
.service-card {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 16px;
    padding: 28px 24px 24px;
    display: flex;
    flex-direction: column;
    gap: 0;
    position: relative;
    overflow: hidden;
    transition: all 0.25s;
}
.service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(27,68,156,0.10);
    border-color: transparent;
}

.card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 16px;
}
.card-icon {
    width: 54px;
    height: 54px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.card-num {
    font-size: 2rem;
    font-weight: 800;
    line-height: 1;
    font-variant-numeric: tabular-nums;
}

.card-accent {
    height: 3px;
    border-radius: 2px;
    margin-bottom: 16px;
    width: 40px;
    transition: width 0.3s;
}
.service-card:hover .card-accent { width: 64px; }

.card-title {
    font-size: 15px;
    font-weight: 700;
    color: #0d1b3e;
    line-height: 1.35;
    margin: 0 0 10px;
}
.card-desc {
    font-size: 13.5px;
    color: #64748b;
    line-height: 1.65;
    margin: 0 0 20px;
    flex: 1;
}

.card-cta {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 700;
    color: var(--cta-color, #1b449c);
    text-decoration: none;
    margin-top: auto;
    transition: gap 0.2s, opacity 0.2s;
    padding: 8px 14px;
    border-radius: 8px;
    background: var(--cta-color, #1b449c);
    background: color-mix(in srgb, var(--cta-color, #1b449c) 10%, transparent);
    align-self: flex-start;
}
.card-cta:hover {
    gap: 10px;
    background: color-mix(in srgb, var(--cta-color, #1b449c) 18%, transparent);
}

/* ── CTA Banner ──────────────────────────────────────────────── */
.cta-banner {
    padding: 80px 0;
    background: linear-gradient(135deg, #0d1b3e 0%, #1b449c 100%);
}
.cta-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    flex-wrap: wrap;
}
.cta-text { flex: 1; min-width: 280px; }
.cta-title {
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 800;
    color: #fff;
    margin: 0 0 10px;
    line-height: 1.25;
}
.cta-desc {
    font-size: 1rem;
    color: rgba(255,255,255,0.72);
    line-height: 1.6;
    margin: 0;
}
.cta-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    flex-shrink: 0;
}
.btn-contact {
    display: inline-flex;
    align-items: center;
    padding: 13px 28px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s;
    box-shadow: 0 4px 16px rgba(241,90,45,0.35);
}
.btn-contact:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(241,90,45,0.50);
    color: #fff;
}
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 12px 22px;
    border: 1.5px solid rgba(255,255,255,0.30);
    color: rgba(255,255,255,0.85);
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s;
}
.btn-back:hover {
    background: rgba(255,255,255,0.10);
    border-color: rgba(255,255,255,0.55);
    color: #fff;
}

/* ── Responsive ──────────────────────────────────────────────── */
@media (max-width: 1024px) {
    .services-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .cta-box { flex-direction: column; text-align: center; }
    .cta-actions { justify-content: center; }
}
@media (max-width: 640px) {
    .page-hero { min-height: 50vh; }
    .services-main { padding: 60px 0 72px; }
    .services-grid { grid-template-columns: 1fr; gap: 16px; }
}
</style>
