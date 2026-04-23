<script setup>
import Footer from "@/Components/Welcome/Footer.vue";
import Header from "@/Components/Welcome/Header.vue";
import NousContacterSection from "@/Components/MyComponents/NousContacter/NousContacter.section.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Nous contacter" />

    <Header>
        <section class="page-hero">
            <div class="hero-bg"></div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <nav class="breadcrumb">
                    <Link href="/" class="breadcrumb-link">Accueil</Link>
                    <span class="breadcrumb-sep">/</span>
                    <span class="breadcrumb-current">Contact</span>
                </nav>
                <h1 class="hero-title">Nous contacter<span class="accent">.</span></h1>
                <p class="hero-sub">
                    Une question, un projet, un devis ? Notre équipe vous répond dans les plus brefs délais.
                </p>
                <div class="hero-badges">
                    <span class="badge">
                        <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Réponse sous 24h
                    </span>
                    <span class="badge">
                        <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Devis gratuit
                    </span>
                    <span class="badge">
                        <svg viewBox="0 0 20 20" fill="currentColor" width="14" height="14"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Support 24/7
                    </span>
                </div>
            </div>
        </section>
    </Header>

    <NousContacterSection />

    <Footer />
</template>

<style scoped>
.page-hero {
    position: relative;
    min-height: 46vh;
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
    background: linear-gradient(135deg, rgba(11,22,56,0.93) 0%, rgba(27,68,156,0.82) 60%, rgba(11,22,56,0.90) 100%);
}
.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 52px 24px 44px;
    max-width: 680px;
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
    margin: 0 0 28px;
}

.hero-badges {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}
.badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 100px;
    background: rgba(255,255,255,0.10);
    border: 1px solid rgba(255,255,255,0.18);
    color: rgba(255,255,255,0.85);
    font-size: 12.5px;
    font-weight: 600;
    backdrop-filter: blur(8px);
}

@media (max-width: 480px) {
    .page-hero { min-height: 52vh; }
}
</style>
