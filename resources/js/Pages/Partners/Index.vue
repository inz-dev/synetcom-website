<script setup>
import Footer from "@/Components/Welcome/Footer.vue";
import Header from "@/Components/Welcome/Header.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({ page: { type: Object, default: null } });

const partners = [
    {
        id: 1,
        title: "Nita Transfert",
        sector: "Services Financiers",
        sectorColor: "#059669",
        desc: "Nita Transfert est une société de transfert d'argent opérant au Niger. Synetcom accompagne Nita dans la digitalisation de ses opérations et le développement de ses outils numériques pour améliorer l'expérience client.",
        link: "https://nitatransfert.com/",
        imagefile: "/images/logo-nita.jpeg",
    },
    {
        id: 2,
        title: "Amana Transfert",
        sector: "Services Financiers",
        sectorColor: "#059669",
        desc: "Amana Transfert est un acteur majeur du transfert de fonds au Niger. En partenariat avec Synetcom, Amana bénéficie de solutions technologiques adaptées pour sécuriser et fluidifier ses transactions.",
        link: "https://amana-transfert.com/",
        imagefile: "/images/amana-logo.jpeg",
    },
    {
        id: 3,
        title: "Enabel Niger",
        sector: "Coopération au développement",
        sectorColor: "#1b449c",
        desc: "Enabel est l'Agence belge de développement. Au Niger, elle met en œuvre des programmes de coopération internationale. Synetcom soutient Enabel dans ses besoins en solutions numériques et en renforcement des capacités.",
        link: "https://www.enabel.be/fr/country/niger/",
        imagefile: "/images/logo-enabel.jpeg",
    },
    {
        id: 4,
        title: "ORIBA",
        sector: "Agroalimentaire",
        sectorColor: "#d97706",
        desc: "ORIBA est une entreprise spécialisée dans la production et la commercialisation du riz au Niger. Synetcom accompagne ORIBA dans sa transformation digitale pour optimiser sa gestion et renforcer sa visibilité en ligne.",
        link: "https://oribarice.business.site/",
        imagefile: "/images/oriba-logo.jpeg",
    },
    {
        id: 5,
        title: "UNICEF Niger",
        sector: "Organisation internationale",
        sectorColor: "#0284c7",
        desc: "L'UNICEF œuvre pour les droits et le bien-être des enfants dans le monde entier. Au Niger, Synetcom contribue aux initiatives de l'UNICEF en fournissant des outils numériques et des services informatiques adaptés à leurs missions.",
        link: "https://www.unicef.org/niger/",
        imagefile: "/images/unicef-logo.jpeg",
    },
];

const stats = [
    { value: "5+", label: "Partenaires actifs" },
    { value: "9+", label: "Ans de collaboration" },
    { value: "4", label: "Secteurs couverts" },
    { value: "100%", label: "Satisfaction client" },
];
</script>

<template>
    <Head title="Nos Partenaires" />

    <Header>
        <!-- Hero -->
        <section class="page-hero">
            <div class="hero-bg"></div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <nav class="breadcrumb">
                    <Link href="/" class="breadcrumb-link">Accueil</Link>
                    <span class="breadcrumb-sep">/</span>
                    <span class="breadcrumb-current">Partenaires</span>
                </nav>
                <h1 class="hero-title">Nos Partenaires<span class="accent">.</span></h1>
                <p class="hero-sub">
                    {{ props.page?.slogan_page ?? 'Des organisations et entreprises qui nous font confiance pour accompagner leur transformation numérique.' }}
                </p>
            </div>

            <!-- Stats strip -->
            <div class="hero-stats">
                <div v-for="(stat, i) in stats" :key="i" class="stat-item">
                    <span class="stat-value">{{ stat.value }}</span>
                    <span class="stat-label">{{ stat.label }}</span>
                </div>
            </div>
        </section>
    </Header>

    <!-- Partners section -->
    <main class="partners-main">
        <div class="p-container">

            <!-- Intro -->
            <div class="section-intro">
                <span class="eyebrow">Ils nous font confiance</span>
                <h2 class="intro-title">Une collaboration fondée sur la confiance</h2>
                <p class="intro-desc">
                    Depuis plus de 9 ans, Synetcom construit des partenariats durables avec des organisations
                    de secteurs variés — finances, développement, agroalimentaire et international.
                </p>
            </div>

            <!-- Partners grid -->
            <div class="partners-grid">
                <article v-for="partner in partners" :key="partner.id" class="partner-card">

                    <!-- Logo -->
                    <div class="card-logo-wrap">
                        <img :src="partner.imagefile" :alt="partner.title" class="card-logo" />
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <div class="card-meta">
                            <span class="sector-badge" :style="{ background: partner.sectorColor + '18', color: partner.sectorColor }">
                                {{ partner.sector }}
                            </span>
                        </div>
                        <h3 class="card-title">{{ partner.title }}</h3>
                        <p class="card-desc">{{ partner.desc }}</p>
                    </div>

                    <!-- Footer -->
                    <div class="card-footer">
                        <a :href="partner.link" target="_blank" rel="noopener noreferrer" class="card-link">
                            Visiter le site
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2"
                                 stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
                                <path d="M11 3H17M17 3V9M17 3L9 11M7 5H5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                            </svg>
                        </a>
                    </div>

                </article>
            </div>

        </div>
    </main>

    <!-- Become partner CTA -->
    <section class="cta-section">
        <div class="p-container">
            <div class="cta-inner">
                <div class="cta-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round" width="40" height="40">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                </div>
                <div class="cta-text">
                    <h2 class="cta-title">Devenez partenaire de Synetcom</h2>
                    <p class="cta-desc">
                        Vous souhaitez collaborer avec nous ? Contactez notre équipe pour discuter
                        d'un partenariat adapté à vos besoins et à votre secteur d'activité.
                    </p>
                </div>
                <div class="cta-actions">
                    <Link href="/nous-contacter" class="btn-primary">Nous contacter</Link>
                    <Link href="/" class="btn-ghost">
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
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-top: 68px;
    overflow: hidden;
    min-height: 52vh;
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
    background: linear-gradient(135deg, rgba(11,22,56,0.93) 0%, rgba(27,68,156,0.82) 60%, rgba(11,22,56,0.90) 100%);
}
.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 52px 24px 32px;
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
.breadcrumb-link { color: rgba(255,255,255,0.55); text-decoration: none; transition: color .2s; }
.breadcrumb-link:hover { color: #f15a2d; }
.breadcrumb-sep { color: rgba(255,255,255,0.25); }
.breadcrumb-current { color: rgba(255,255,255,0.90); font-weight: 600; }

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
    color: rgba(255,255,255,0.72);
    line-height: 1.7;
    margin: 0;
    max-width: 560px;
    margin-inline: auto;
}

/* Stats strip */
.hero-stats {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    flex-wrap: wrap;
    padding: 24px 24px 36px;
    width: 100%;
}
.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 12px 36px;
    border-right: 1px solid rgba(255,255,255,0.12);
}
.stat-item:last-child { border-right: none; }
.stat-value {
    font-size: 2.1rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    letter-spacing: -0.02em;
}
.stat-label {
    font-size: 11px;
    font-weight: 500;
    color: rgba(255,255,255,0.55);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-top: 5px;
    white-space: nowrap;
}

/* ── Main ────────────────────────────────────────────────────── */
.partners-main {
    padding: 80px 0 96px;
    background: #f8fafc;
}
.p-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Intro */
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
    font-size: clamp(1.7rem, 3.5vw, 2.3rem);
    font-weight: 800;
    color: #0d1b3e;
    margin: 0 0 14px;
    letter-spacing: -0.02em;
    line-height: 1.2;
}
.intro-desc {
    font-size: 1.05rem;
    color: #64748b;
    max-width: 580px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ── Grid ────────────────────────────────────────────────────── */
.partners-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

/* ── Card ────────────────────────────────────────────────────── */
.partner-card {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: all 0.28s;
}
.partner-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 48px rgba(27,68,156,0.11);
    border-color: transparent;
}

/* Logo area */
.card-logo-wrap {
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 28px 32px;
    background: #fff;
    border-bottom: 1px solid #f1f5f9;
}
.card-logo {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s;
}
.partner-card:hover .card-logo { transform: scale(1.06); }

/* Body */
.card-body {
    padding: 22px 24px 14px;
    flex: 1;
}
.card-meta { margin-bottom: 10px; }
.sector-badge {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 4px 10px;
    border-radius: 100px;
}
.card-title {
    font-size: 17px;
    font-weight: 800;
    color: #0d1b3e;
    margin: 0 0 10px;
    line-height: 1.3;
}
.card-desc {
    font-size: 13.5px;
    color: #64748b;
    line-height: 1.7;
    margin: 0;
}

/* Footer */
.card-footer {
    padding: 16px 24px 22px;
}
.card-link {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 13px;
    font-weight: 700;
    color: #1b449c;
    text-decoration: none;
    padding: 9px 18px;
    border-radius: 8px;
    background: rgba(27,68,156,0.07);
    transition: all 0.22s;
}
.card-link:hover {
    background: #1b449c;
    color: #fff;
    gap: 10px;
}

/* ── CTA Section ─────────────────────────────────────────────── */
.cta-section {
    padding: 80px 0;
    background: linear-gradient(135deg, #0d1b3e 0%, #1b449c 100%);
}
.cta-inner {
    display: flex;
    align-items: center;
    gap: 32px;
    flex-wrap: wrap;
}
.cta-icon {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: rgba(255,255,255,0.10);
    border: 1px solid rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f15a2d;
}
.cta-text { flex: 1; min-width: 260px; }
.cta-title {
    font-size: clamp(1.4rem, 2.8vw, 1.9rem);
    font-weight: 800;
    color: #fff;
    margin: 0 0 10px;
    line-height: 1.25;
}
.cta-desc {
    font-size: 1rem;
    color: rgba(255,255,255,0.70);
    line-height: 1.65;
    margin: 0;
}
.cta-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    flex-shrink: 0;
}
.btn-primary {
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
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(241,90,45,0.50);
    color: #fff;
}
.btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 12px 22px;
    border: 1.5px solid rgba(255,255,255,0.28);
    color: rgba(255,255,255,0.82);
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s;
}
.btn-ghost:hover {
    background: rgba(255,255,255,0.10);
    border-color: rgba(255,255,255,0.55);
    color: #fff;
}

/* ── Responsive ──────────────────────────────────────────────── */
@media (max-width: 1024px) {
    .partners-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .stat-item { padding: 10px 20px; }
    .cta-inner { flex-direction: column; text-align: center; }
    .cta-icon { margin: 0 auto; }
    .cta-actions { justify-content: center; }
}
@media (max-width: 600px) {
    .partners-grid { grid-template-columns: 1fr; gap: 18px; }
    .hero-stats { padding-bottom: 28px; }
    .stat-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.10); width: 100%; padding: 10px 0; }
    .stat-item:last-child { border-bottom: none; }
}
</style>
