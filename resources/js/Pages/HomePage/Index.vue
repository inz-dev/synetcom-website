<script setup>
import BanierePage from "@/Components/MyComponents/BanierePage.vue";
import Footer from "@/Components/Welcome/Footer.vue";
import Header from "@/Components/Welcome/Header.vue";
import NewsletterHome from "@/Components/Welcome/Sections/Newsletter.home.vue";
import PartenersHome from "@/Components/Welcome/Sections/Parteners.home.vue";
import Portfolio from "@/Components/Welcome/Sections/Portfolio.vue";
import ServicesHome from "@/Components/Welcome/Sections/Services.home.vue";
import TeamHome from "@/Components/Welcome/Sections/Team.home.vue";
import WhyChooseUsHome from "@/Components/Welcome/Sections/WhyChooseUs.home.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Accueil" />

    <Header>
        <BanierePage title="Synetcom" backgroundImage="/images/background1.png">
            <p class="hero-sub">
                Développez votre entreprise chaque jour avec la transformation numérique.<br />
                Nous vous permettons de générer de la croissance grâce aux outils digitaux.
            </p>

            <div class="hero-cta-row">
                <a href="#services" class="cta-primary" @click.prevent="document.getElementById('services')?.scrollIntoView({behavior:'smooth'})">
                    Découvrir nos services
                    <svg viewBox="0 0 20 20" fill="currentColor" class="cta-arrow"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                </a>
                <a href="/nous-contacter" class="cta-ghost">Nous contacter</a>
            </div>

            <!-- Stats strip -->
            <div class="hero-stats">
                <div class="hero-stat">
                    <span class="stat-num">50+</span>
                    <span class="stat-lbl">Clients satisfaits</span>
                </div>
                <div class="stat-sep"></div>
                <div class="hero-stat">
                    <span class="stat-num">100+</span>
                    <span class="stat-lbl">Projets livrés</span>
                </div>
                <div class="stat-sep"></div>
                <div class="hero-stat">
                    <span class="stat-num">9+</span>
                    <span class="stat-lbl">Ans d'expérience</span>
                </div>
                <div class="stat-sep"></div>
                <div class="hero-stat">
                    <span class="stat-num">24/7</span>
                    <span class="stat-lbl">Support disponible</span>
                </div>
            </div>
        </BanierePage>
    </Header>

    <ServicesHome />
    <Portfolio />
    <WhyChooseUsHome />
    <TeamHome />
    <NewsletterHome />
    <PartenersHome />
    <Footer />
</template>

<style scoped>
.hero-sub {
    font-size: clamp(1rem, 2vw, 1.15rem);
    color: rgba(255,255,255,0.80);
    line-height: 1.7;
    margin: 0 auto 36px;
    max-width: 640px;
    font-weight: 400;
}

.hero-cta-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-bottom: 56px;
}

.cta-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 28px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff;
    border-radius: 50px;
    font-size: 15px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.25s;
    box-shadow: 0 4px 20px rgba(241,90,45,0.35);
    letter-spacing: 0.01em;
}
.cta-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(241,90,45,0.50);
    color: #fff;
}
.cta-arrow { width: 16px; height: 16px; transition: transform 0.2s; }
.cta-primary:hover .cta-arrow { transform: translateX(3px); }

.cta-ghost {
    display: inline-flex;
    align-items: center;
    padding: 13px 28px;
    border: 1.5px solid rgba(255,255,255,0.45);
    color: #fff;
    border-radius: 50px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.25s;
    backdrop-filter: blur(4px);
}
.cta-ghost:hover {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.7);
    color: #fff;
    transform: translateY(-1px);
}

/* Stats */
.hero-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    background: rgba(255,255,255,0.07);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 16px;
    padding: 20px 32px;
    flex-wrap: wrap;
    gap: 8px;
}

.hero-stat {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0 28px;
    gap: 4px;
}
.stat-sep {
    width: 1px;
    height: 36px;
    background: rgba(255,255,255,0.2);
    flex-shrink: 0;
}
.stat-num {
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.stat-lbl {
    font-size: 11px;
    font-weight: 500;
    color: rgba(255,255,255,0.6);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    white-space: nowrap;
}

@media (max-width: 640px) {
    .hero-stats { gap: 16px; padding: 16px; }
    .hero-stat { padding: 0 12px; }
    .stat-sep { display: none; }
    .stat-num { font-size: 1.5rem; }
}
</style>
