<script setup>
import Footer from "@/Components/Welcome/Footer.vue";
import Header from "@/Components/Welcome/Header.vue";
import { Head, Link } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const categories = [
    { key: "all",      label: "Tous les projets" },
    { key: "apps",     label: "Applications" },
    { key: "print",    label: "Impressions & Gadgets" },
    { key: "panneau",  label: "Panneaux publicitaires" },
];

const projects = [
    {
        id: 1, category: "apps",
        image: "/images/portfolio/portfolio-2.jpg",
        title: "Pass-Sutura",
        desc: "Application mobile de gestion de pass et accès sécurisés pour événements et établissements.",
        tags: ["Mobile", "Sécurité"],
    },
    {
        id: 2, category: "apps",
        image: "/images/portfolio/portfolio-3.jpg",
        title: "Gestion Scolaire",
        desc: "Plateforme complète de gestion d'établissements scolaires : inscriptions, notes, emplois du temps.",
        tags: ["Web", "ERP"],
    },
    {
        id: 3, category: "apps",
        image: "/images/portfolio/portfolio-4.jpg",
        title: "Gestion de Locations",
        desc: "Application de gestion de parc immobilier locatif avec suivi des paiements et contrats.",
        tags: ["Web", "Immobilier"],
    },
    {
        id: 4, category: "apps",
        image: "/images/portfolio/portfolio-8.jpg",
        title: "Assurance Maladie",
        desc: "Système de gestion des dossiers assurance maladie avec tableau de bord analytique.",
        tags: ["Web", "Santé"],
    },
    {
        id: 5, category: "print",
        image: "/images/portfolio/portfolio-7.jpg",
        title: "Cadeaux d'Entreprise",
        desc: "Conception et impression de gadgets et cadeaux personnalisés aux couleurs de l'entreprise.",
        tags: ["Impression", "Branding"],
    },
    {
        id: 6, category: "print",
        image: "/images/portfolio/portfolio-9.jpg",
        title: "Bracelets Personnalisés",
        desc: "Fabrication de bracelets personnalisés pour événements, promotions et activations marketing.",
        tags: ["Impression", "Événementiel"],
    },
    {
        id: 7, category: "print",
        image: "/images/portfolio/portfolio-details-1.jpg",
        title: "Supports Beauté",
        desc: "Impression de packagings, étiquettes et supports visuels pour marques de produits de beauté.",
        tags: ["Impression", "Packaging"],
    },
    {
        id: 8, category: "print",
        image: "/images/portfolio/portfolio-details-3.jpg",
        title: "Produits Maquillage",
        desc: "Création visuelle et impression de catalogues, affiches et supports pour ligne cosmétique.",
        tags: ["Impression", "Cosmétique"],
    },
    {
        id: 9, category: "panneau",
        image: "/images/portfolio/portfolio-details-2.jpg",
        title: "Déco Grand Marché",
        desc: "Conception et pose d'éléments décoratifs et signalétiques pour le Grand Marché de Niamey.",
        tags: ["Signalétique", "Affichage"],
    },
    {
        id: 10, category: "panneau",
        image: "/images/portfolio/portfolio-5.jpg",
        title: "Panneau École INSP",
        desc: "Réalisation du panneau d'entrée et de la signalétique directionnelle de l'École INSP.",
        tags: ["Panneau", "Signalétique"],
    },
    {
        id: 11, category: "panneau",
        image: "/images/portfolio/portfolio-6.jpg",
        title: "Affichage Institutionnel",
        desc: "Fabrication et pose de panneaux grand format pour communication institutionnelle.",
        tags: ["Panneau", "Grand format"],
    },
    {
        id: 12, category: "panneau",
        image: "/images/portfolio/portfolio-1.jpg",
        title: "Banderoles Événement",
        desc: "Impression et installation de banderoles et oriflammes pour manifestations publiques.",
        tags: ["Panneau", "Événementiel"],
    },
];

const activeCategory = ref("all");

const filtered = computed(() =>
    activeCategory.value === "all"
        ? projects
        : projects.filter((p) => p.category === activeCategory.value)
);

const stats = [
    { value: "100+", label: "Projets livrés" },
    { value: "50+",  label: "Clients satisfaits" },
    { value: "9+",   label: "Ans d'expérience" },
    { value: "3",    label: "Catégories" },
];

const categoryColors = {
    apps:    { bg: "rgba(27,68,156,0.12)",  color: "#1b449c" },
    print:   { bg: "rgba(241,90,45,0.12)",  color: "#f15a2d" },
    panneau: { bg: "rgba(5,150,105,0.12)",  color: "#059669" },
};
</script>

<template>
    <Head title="Nos Réalisations" />

    <Header>
        <section class="page-hero">
            <div class="hero-bg"></div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <nav class="breadcrumb">
                    <Link href="/" class="breadcrumb-link">Accueil</Link>
                    <span class="breadcrumb-sep">/</span>
                    <span class="breadcrumb-current">Réalisations</span>
                </nav>
                <h1 class="hero-title">Nos Réalisations<span class="accent">.</span></h1>
                <p class="hero-sub">
                    Découvrez une sélection de projets réalisés pour nos clients — applications, impressions et supports visuels.
                </p>
            </div>
            <div class="hero-stats">
                <div v-for="(s, i) in stats" :key="i" class="stat-item">
                    <span class="stat-value">{{ s.value }}</span>
                    <span class="stat-label">{{ s.label }}</span>
                </div>
            </div>
        </section>
    </Header>

    <main class="r-main">
        <div class="r-container">

            <!-- Filters -->
            <div class="filters">
                <button
                    v-for="cat in categories" :key="cat.key"
                    class="filter-btn"
                    :class="{ 'filter-btn--active': activeCategory === cat.key }"
                    @click="activeCategory = cat.key"
                >
                    {{ cat.label }}
                    <span class="filter-count" v-if="cat.key !== 'all'">
                        {{ projects.filter(p => p.category === cat.key).length }}
                    </span>
                </button>
            </div>

            <!-- Grid -->
            <div class="projects-grid">
                <article
                    v-for="project in filtered" :key="project.id"
                    class="project-card"
                >
                    <div class="card-img-wrap">
                        <img :src="project.image" :alt="project.title" class="card-img" loading="lazy" />
                        <div class="card-overlay">
                            <div class="overlay-tags">
                                <span v-for="tag in project.tags" :key="tag" class="overlay-tag">{{ tag }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-cat"
                             :style="{ background: categoryColors[project.category]?.bg, color: categoryColors[project.category]?.color }">
                            {{ categories.find(c => c.key === project.category)?.label }}
                        </div>
                        <h3 class="card-title">{{ project.title }}</h3>
                        <p class="card-desc">{{ project.desc }}</p>
                    </div>
                </article>
            </div>

        </div>
    </main>

    <!-- CTA -->
    <section class="cta-section">
        <div class="r-container">
            <div class="cta-inner">
                <div class="cta-text">
                    <h2 class="cta-title">Votre projet sera le prochain.</h2>
                    <p class="cta-desc">Confiez-nous votre vision, nous la transformons en réalité numérique ou visuelle.</p>
                </div>
                <div class="cta-actions">
                    <Link href="/nous-contacter" class="btn-primary">Démarrer un projet</Link>
                    <Link :href="route('services')" class="btn-ghost">Voir nos services</Link>
                </div>
            </div>
        </div>
    </section>

    <Footer />
</template>

<style scoped>
/* ── Hero ─────────────────────────────────────────────────────── */
.page-hero {
    position: relative; min-height: 52vh;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    padding-top: 68px; overflow: hidden;
}
.hero-bg {
    position: absolute; inset: 0;
    background-image: url('/images/background1.png');
    background-size: cover; background-position: center;
}
.hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(11,22,56,.93) 0%, rgba(27,68,156,.82) 60%, rgba(11,22,56,.90) 100%);
}
.hero-content {
    position: relative; z-index: 2;
    text-align: center; padding: 52px 24px 32px;
    max-width: 720px; width: 100%;
}
.breadcrumb {
    display: flex; align-items: center; justify-content: center;
    gap: 8px; margin-bottom: 20px; font-size: 13px;
}
.breadcrumb-link { color: rgba(255,255,255,.55); text-decoration: none; transition: color .2s; }
.breadcrumb-link:hover { color: #f15a2d; }
.breadcrumb-sep { color: rgba(255,255,255,.25); }
.breadcrumb-current { color: rgba(255,255,255,.90); font-weight: 600; }
.hero-title {
    font-size: clamp(2.2rem, 5vw, 3.4rem); font-weight: 800;
    color: #fff; letter-spacing: -.02em; line-height: 1.12; margin: 0 0 16px;
}
.accent { color: #f15a2d; }
.hero-sub {
    font-size: 1.05rem; color: rgba(255,255,255,.72);
    line-height: 1.7; margin: 0 auto; max-width: 560px;
}
.hero-stats {
    position: relative; z-index: 2;
    display: flex; align-items: center; justify-content: center;
    flex-wrap: wrap; padding: 24px 24px 36px; width: 100%;
}
.stat-item {
    display: flex; flex-direction: column; align-items: center;
    padding: 12px 36px; border-right: 1px solid rgba(255,255,255,.12);
}
.stat-item:last-child { border-right: none; }
.stat-value { font-size: 2.1rem; font-weight: 800; color: #fff; line-height: 1; letter-spacing: -.02em; }
.stat-label { font-size: 11px; font-weight: 500; color: rgba(255,255,255,.55); text-transform: uppercase; letter-spacing: .08em; margin-top: 5px; white-space: nowrap; }

/* ── Main ─────────────────────────────────────────────────────── */
.r-main { padding: 72px 0 96px; background: #f8fafc; }
.r-container { max-width: 1280px; margin: 0 auto; padding: 0 24px; }

/* ── Filters ──────────────────────────────────────────────────── */
.filters {
    display: flex; align-items: center; justify-content: center;
    gap: 10px; flex-wrap: wrap; margin-bottom: 48px;
}
.filter-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 22px;
    border: 1.5px solid #e2e8f0;
    border-radius: 50px;
    background: #fff;
    color: #64748b;
    font-size: 13.5px; font-weight: 600;
    cursor: pointer; transition: all .22s;
    font-family: inherit;
}
.filter-btn:hover { border-color: #1b449c; color: #1b449c; background: rgba(27,68,156,.05); }
.filter-btn--active { background: #1b449c; border-color: #1b449c; color: #fff; box-shadow: 0 4px 14px rgba(27,68,156,.25); }
.filter-count {
    display: inline-flex; align-items: center; justify-content: center;
    width: 20px; height: 20px; border-radius: 50%;
    background: rgba(255,255,255,.25); font-size: 11px; font-weight: 700;
}
.filter-btn:not(.filter-btn--active) .filter-count { background: #f1f5f9; color: #94a3b8; }

/* ── Grid ─────────────────────────────────────────────────────── */
.projects-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

/* ── Card ─────────────────────────────────────────────────────── */
.project-card {
    background: #fff; border: 1px solid #e8edf5;
    border-radius: 18px; overflow: hidden;
    display: flex; flex-direction: column;
    transition: all .28s;
}
.project-card:hover { transform: translateY(-7px); box-shadow: 0 24px 48px rgba(27,68,156,.11); border-color: transparent; }

.card-img-wrap { position: relative; overflow: hidden; height: 200px; }
.card-img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
.project-card:hover .card-img { transform: scale(1.06); }

.card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(13,27,62,.75) 0%, transparent 55%);
    display: flex; align-items: flex-end; padding: 14px;
    opacity: 0; transition: opacity .28s;
}
.project-card:hover .card-overlay { opacity: 1; }
.overlay-tags { display: flex; gap: 6px; flex-wrap: wrap; }
.overlay-tag {
    padding: 3px 10px; border-radius: 100px;
    background: rgba(255,255,255,.20); backdrop-filter: blur(4px);
    color: #fff; font-size: 11px; font-weight: 700; border: 1px solid rgba(255,255,255,.25);
}

.card-body { padding: 20px 22px 24px; flex: 1; display: flex; flex-direction: column; gap: 8px; }
.card-cat {
    display: inline-block; padding: 3px 10px;
    border-radius: 100px; font-size: 11px; font-weight: 700; letter-spacing: .05em;
    text-transform: uppercase; align-self: flex-start;
}
.card-title { font-size: 16px; font-weight: 800; color: #0d1b3e; margin: 0; line-height: 1.3; }
.card-desc { font-size: 13.5px; color: #64748b; line-height: 1.65; margin: 0; flex: 1; }

/* ── CTA ──────────────────────────────────────────────────────── */
.cta-section { padding: 80px 0; background: linear-gradient(135deg, #0d1b3e 0%, #1b449c 100%); }
.cta-inner { display: flex; align-items: center; justify-content: space-between; gap: 40px; flex-wrap: wrap; }
.cta-text { flex: 1; min-width: 260px; }
.cta-title { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 800; color: #fff; margin: 0 0 10px; }
.cta-desc { font-size: 1rem; color: rgba(255,255,255,.70); line-height: 1.65; margin: 0; }
.cta-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; flex-shrink: 0; }
.btn-primary {
    display: inline-flex; align-items: center; padding: 13px 28px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff; border-radius: 50px; font-size: 14px; font-weight: 700;
    text-decoration: none; transition: all .25s; box-shadow: 0 4px 16px rgba(241,90,45,.35);
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(241,90,45,.50); color: #fff; }
.btn-ghost {
    display: inline-flex; align-items: center; padding: 12px 22px;
    border: 1.5px solid rgba(255,255,255,.28); color: rgba(255,255,255,.82);
    border-radius: 50px; font-size: 14px; font-weight: 600;
    text-decoration: none; transition: all .25s;
}
.btn-ghost:hover { background: rgba(255,255,255,.10); border-color: rgba(255,255,255,.55); color: #fff; }

/* ── Responsive ───────────────────────────────────────────────── */
@media (max-width: 1024px) { .projects-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) { .cta-inner { flex-direction: column; text-align: center; } .cta-actions { justify-content: center; } }
@media (max-width: 600px) {
    .projects-grid { grid-template-columns: 1fr; gap: 16px; }
    .stat-item { border-right: none; border-bottom: 1px solid rgba(255,255,255,.10); width: 100%; padding: 10px 0; }
    .stat-item:last-child { border-bottom: none; }
}
</style>
