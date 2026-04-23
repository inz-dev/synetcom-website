<template>
    <section id="why-us" class="why-section">
        <div class="w-container">

            <div class="why-grid">
                <!-- Left: image -->
                <div class="why-visual">
                    <div class="visual-frame">
                        <img src="/images/why-choose-use1.png" alt="Pourquoi Synetcom" class="visual-img" />
                        <!-- Floating badge -->
                        <div class="visual-badge">
                            <span class="badge-num">9+</span>
                            <span class="badge-txt">Années<br/>d'expérience</span>
                        </div>
                    </div>
                </div>

                <!-- Right: content -->
                <div class="why-content">
                    <span class="section-eyebrow">Notre avantage compétitif</span>
                    <h2 class="section-title">Pourquoi choisir Synetcom ?</h2>
                    <p class="why-intro">
                        Notre équipe d'experts vous accompagne avec un service personnalisé,
                        disponible 24h/24 et 7j/7. Nous nous engageons à fournir des solutions
                        numériques supérieures et professionnelles adaptées à votre contexte.
                    </p>

                    <div class="features-list">
                        <div v-for="f in features" :key="f.id" class="feature-item">
                            <div class="feature-icon" :style="{ background: f.color + '18', color: f.color }">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                     width="20" height="20">
                                    <path v-for="(d,i) in f.paths" :key="i" :d="d" />
                                </svg>
                            </div>
                            <div>
                                <div class="feature-title">{{ f.title }}</div>
                                <div class="feature-desc">{{ f.desc }}</div>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="btn-why">
                        En savoir plus
                        <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </section>
</template>

<script setup>
const features = [
    {
        id: 1,
        title: "Expertise multidisciplinaire",
        desc: "Une équipe polyvalente couvrant développement, réseaux, design et marketing digital.",
        color: "#1b449c",
        paths: ["M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"]
    },
    {
        id: 2,
        title: "Support 24h/24 — 7j/7",
        desc: "Un accompagnement continu pour garantir la disponibilité et la performance de vos systèmes.",
        color: "#059669",
        paths: ["M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"]
    },
    {
        id: 3,
        title: "Solutions sur mesure",
        desc: "Chaque projet est conçu spécifiquement selon vos besoins et votre secteur d'activité.",
        color: "#f15a2d",
        paths: ["M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"]
    },
    {
        id: 4,
        title: "Innovation permanente",
        desc: "Nous intégrons les dernières technologies pour que vos solutions restent compétitives et évolutives.",
        color: "#7c3aed",
        paths: ["M13 10V3L4 14h7v7l9-11h-7z"]
    },
];
</script>

<style scoped>
.why-section {
    padding: 96px 0;
    background: #f8fafc;
}
.w-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

.why-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 72px;
    align-items: center;
}

/* Visual */
.why-visual { position: relative; }
.visual-frame {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(27,68,156,0.15);
}
.visual-img {
    width: 100%;
    height: 460px;
    object-fit: cover;
    display: block;
}
.visual-badge {
    position: absolute;
    bottom: 28px;
    right: 28px;
    background: #fff;
    border-radius: 14px;
    padding: 14px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}
.badge-num {
    font-size: 2rem;
    font-weight: 800;
    color: #1b449c;
    line-height: 1;
}
.badge-txt {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    line-height: 1.3;
}

/* Content */
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
    font-size: clamp(1.7rem, 3.5vw, 2.4rem);
    font-weight: 800;
    color: #0d1b3e;
    margin: 0 0 16px;
    letter-spacing: -0.02em;
    line-height: 1.15;
}
.why-intro {
    font-size: 1rem;
    color: #64748b;
    line-height: 1.75;
    margin-bottom: 32px;
}

/* Features */
.features-list { display: flex; flex-direction: column; gap: 20px; margin-bottom: 36px; }
.feature-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.feature-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.feature-title { font-size: 14px; font-weight: 700; color: #0d1b3e; margin-bottom: 3px; }
.feature-desc  { font-size: 13px; color: #64748b; line-height: 1.5; }

.btn-why {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 13px 28px;
    background: #1b449c;
    color: #fff;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s;
    box-shadow: 0 4px 16px rgba(27,68,156,0.25);
}
.btn-why:hover {
    background: #163a86;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(27,68,156,0.35);
    color: #fff;
}

@media (max-width: 900px) {
    .why-grid { grid-template-columns: 1fr; gap: 40px; }
    .visual-img { height: 300px; }
    .why-section { padding: 64px 0; }
}
</style>
