<script setup>
import Footer from '@/Components/Welcome/Footer.vue';
import Header from '@/Components/Welcome/Header.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    opportunites: { type: Array, default: () => [] },
});

const contractColors = {
    CDI:        { bg: '#e8f5e9', color: '#2e7d32' },
    CDD:        { bg: '#e3f2fd', color: '#1565c0' },
    Stage:      { bg: '#fff8e1', color: '#f57f17' },
    Alternance: { bg: '#f3e5f5', color: '#6a1b9a' },
    Freelance:  { bg: '#fce4ec', color: '#880e4f' },
};

const formatDate = (d) => {
    if (!d) return null;
    return new Date(d).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });
};

const isExpiring = (d) => {
    if (!d) return false;
    const diff = (new Date(d) - new Date()) / (1000 * 60 * 60 * 24);
    return diff >= 0 && diff <= 7;
};
</script>

<template>
    <Head title="Opportunités" />

    <Header>
        <section class="page-hero">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <nav class="breadcrumb">
                    <Link href="/" class="breadcrumb-link">Accueil</Link>
                    <span class="breadcrumb-sep">/</span>
                    <span class="breadcrumb-current">Opportunités</span>
                </nav>
                <h1 class="hero-title">Rejoignez notre équipe<span class="accent">.</span></h1>
                <p class="hero-sub">Découvrez nos offres d'emploi et donnez un nouvel élan à votre carrière avec Synetcom.</p>
            </div>
        </section>
    </Header>

    <section class="offers-section">
        <div class="offers-container">
            <div v-if="opportunites.length === 0" class="empty-state">
                <i class="bi bi-briefcase" style="font-size:3rem; color:#cbd5e1;"></i>
                <h3>Aucune offre disponible</h3>
                <p>Revenez bientôt, de nouvelles opportunités arrivent régulièrement.</p>
            </div>

            <div v-else class="offers-grid">
                <Link
                    v-for="offre in opportunites"
                    :key="offre.id_opportunite"
                    :href="route('opportunites.show', offre.id_opportunite)"
                    class="offer-card"
                >
                    <div class="offer-header">
                        <span class="contract-badge"
                              :style="{ background: contractColors[offre.type_contrat]?.bg, color: contractColors[offre.type_contrat]?.color }">
                            {{ offre.type_contrat }}
                        </span>
                        <span v-if="offre.date_limite && isExpiring(offre.date_limite)" class="expiring-badge">
                            Expire bientôt
                        </span>
                    </div>

                    <h3 class="offer-title">{{ offre.titre_opportunite }}</h3>

                    <p class="offer-desc">{{ offre.description_opportunite?.slice(0, 140) }}{{ offre.description_opportunite?.length > 140 ? '…' : '' }}</p>

                    <div class="offer-meta">
                        <span v-if="offre.lieu_opportunite" class="meta-item">
                            <i class="bi bi-geo-alt-fill"></i> {{ offre.lieu_opportunite }}
                        </span>
                        <span v-if="offre.date_limite" class="meta-item">
                            <i class="bi bi-calendar3"></i> Limite : {{ formatDate(offre.date_limite) }}
                        </span>
                    </div>

                    <div class="offer-cta">
                        Voir l'offre
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </Link>
            </div>
        </div>
    </section>

    <Footer />
</template>

<style scoped>
/* Hero */
.page-hero {
    position: relative;
    min-height: 44vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 68px;
    overflow: hidden;
    background: url('/images/background1.png') center/cover no-repeat;
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(11,22,56,.92) 0%, rgba(27,68,156,.80) 60%, rgba(11,22,56,.88) 100%);
}
.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 52px 24px 44px;
    max-width: 680px;
}
.breadcrumb { display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 20px; font-size: 13px; }
.breadcrumb-link { color: rgba(255,255,255,.55); text-decoration: none; transition: color .2s; }
.breadcrumb-link:hover { color: #f15a2d; }
.breadcrumb-sep { color: rgba(255,255,255,.25); }
.breadcrumb-current { color: rgba(255,255,255,.90); font-weight: 600; }
.hero-title { font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 800; color: #fff; margin: 0 0 14px; letter-spacing: -.02em; line-height: 1.12; }
.accent { color: #f15a2d; }
.hero-sub { font-size: 1.05rem; color: rgba(255,255,255,.72); line-height: 1.7; margin: 0; }

/* Offers */
.offers-section { padding: 72px 24px; background: #f8fafc; min-height: 50vh; }
.offers-container { max-width: 1100px; margin: 0 auto; }

.empty-state {
    text-align: center;
    padding: 80px 24px;
    color: #94a3b8;
}
.empty-state h3 { margin: 16px 0 8px; font-size: 1.4rem; color: #64748b; }

.offers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 24px;
}

.offer-card {
    background: #fff;
    border-radius: 16px;
    padding: 28px;
    border: 1px solid #e8edf5;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    gap: 14px;
    box-shadow: 0 2px 12px rgba(27,68,156,.06);
    transition: transform .2s, box-shadow .2s, border-color .2s;
}
.offer-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(27,68,156,.13);
    border-color: #1b449c;
}

.offer-header { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

.contract-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .04em;
}
.expiring-badge {
    font-size: 11px;
    font-weight: 700;
    color: #b45309;
    background: #fef3c7;
    border: 1px solid #fbbf24;
    padding: 3px 10px;
    border-radius: 100px;
}

.offer-title { font-size: 1.15rem; font-weight: 700; color: #1e293b; margin: 0; line-height: 1.3; }

.offer-desc { font-size: 14px; color: #64748b; line-height: 1.7; margin: 0; flex: 1; }

.offer-meta { display: flex; flex-wrap: wrap; gap: 12px; }
.meta-item { font-size: 13px; color: #94a3b8; display: flex; align-items: center; gap: 5px; }
.meta-item i { color: #1b449c; }

.offer-cta {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    font-weight: 600;
    color: #1b449c;
    margin-top: 4px;
    transition: gap .2s;
}
.offer-card:hover .offer-cta { gap: 10px; }

@media (max-width: 600px) {
    .offers-grid { grid-template-columns: 1fr; }
}
</style>
