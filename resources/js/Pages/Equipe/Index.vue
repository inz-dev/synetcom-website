<script setup>
import Footer from "@/Components/Welcome/Footer.vue";
import Header from "@/Components/Welcome/Header.vue";
import { Head, Link } from "@inertiajs/vue3";

const members = [
    {
        id: 1,
        name: "Chaibou Abdou",
        role: "CEO & Ingénieur Réseau",
        bio: "Fondateur et dirigeant de Synetcom, ingénieur réseau avec plus de 9 ans d'expérience dans la transformation digitale des entreprises au Niger.",
        image: "/images/member1.png",
        badge: "Fondateur",
        badgeColor: "#f15a2d",
        socials: { linkedin: "#", email: "chaibou.abdou@synetcom.dev", whatsapp: "#" },
    },
    {
        id: 2,
        name: "Mamane Laouali Ali Gambo",
        role: "Développeur Web & Mobile",
        bio: "Expert en développement d'applications web et mobiles, passionné par la création de solutions intuitives et performantes.",
        image: "/images/member2.png",
        badge: "Tech Lead",
        badgeColor: "#1b449c",
        socials: { linkedin: "#", email: "mamane@synetcom.dev", whatsapp: "#" },
    },
    {
        id: 3,
        name: "Ismaeil Nouri",
        role: "Développeur Web & Mobile",
        bio: "Développeur full-stack spécialisé dans la conception et le déploiement d'applications métier sur mesure.",
        image: "/images/member3.png",
        badge: "Développeur",
        badgeColor: "#7c3aed",
        socials: { linkedin: "#", email: "ismaeil@synetcom.dev", whatsapp: "#" },
    },
    {
        id: 4,
        name: "Zeinabou Issaka Nouhou",
        role: "Designer & Développeuse Web",
        bio: "Designer UI/UX et développeuse, elle conçoit des interfaces visuellement attrayantes et des expériences utilisateur optimales.",
        image: "/images/member1.png",
        badge: "Design",
        badgeColor: "#059669",
        socials: { linkedin: "#", email: "zeinabou@synetcom.dev", whatsapp: "#" },
    },
    {
        id: 5,
        name: "Abdoul-Azize",
        role: "Développeur Web & Mobile",
        bio: "Développeur mobile iOS/Android, expert en React Native et Flutter pour des applications cross-platform de haute qualité.",
        image: "/images/member3.png",
        badge: "Mobile",
        badgeColor: "#0284c7",
        socials: { linkedin: "#", email: "abdoulazize@synetcom.dev", whatsapp: "#" },
    },
    {
        id: 6,
        name: "Zakariyaou",
        role: "Développeur Web & Mobile",
        bio: "Spécialiste backend et intégrations API, il assure la robustesse et la scalabilité des systèmes développés par Synetcom.",
        image: "/images/member2.png",
        badge: "Backend",
        badgeColor: "#dc2626",
        socials: { linkedin: "#", email: "zakariyaou@synetcom.dev", whatsapp: "#" },
    },
];

const values = [
    {
        icon: ["M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"],
        title: "Excellence",
        desc: "Nous visons la perfection dans chaque projet livré.",
    },
    {
        icon: ["M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"],
        title: "Collaboration",
        desc: "L'intelligence collective au service de vos projets.",
    },
    {
        icon: ["M13 10V3L4 14h7v7l9-11h-7z"],
        title: "Innovation",
        desc: "Des solutions modernes adaptées aux défis d'aujourd'hui.",
    },
];
</script>

<template>
    <Head title="Notre Équipe" />

    <Header>
        <section class="page-hero">
            <div class="hero-bg"></div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <nav class="breadcrumb">
                    <Link href="/" class="breadcrumb-link">Accueil</Link>
                    <span class="breadcrumb-sep">/</span>
                    <span class="breadcrumb-current">Équipe</span>
                </nav>
                <h1 class="hero-title">Notre Équipe<span class="accent">.</span></h1>
                <p class="hero-sub">
                    Des professionnels passionnés qui unissent leurs expertises pour faire de votre transformation digitale une réussite.
                </p>
            </div>
        </section>
    </Header>

    <!-- Values strip -->
    <div class="values-strip">
        <div class="e-container">
            <div class="values-grid">
                <div v-for="v in values" :key="v.title" class="value-item">
                    <span class="value-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round" width="22" height="22">
                            <path v-for="(d, i) in v.icon" :key="i" :d="d" />
                        </svg>
                    </span>
                    <div>
                        <h3 class="value-title">{{ v.title }}</h3>
                        <p class="value-desc">{{ v.desc }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team section -->
    <main class="e-main">
        <div class="e-container">

            <div class="section-intro">
                <span class="eyebrow">Les visages derrière Synetcom</span>
                <h2 class="intro-title">Une équipe soudée et expérimentée</h2>
                <p class="intro-desc">
                    Chaque membre apporte une expertise unique. Ensemble, nous couvrons tout le spectre
                    du digital — du design au déploiement en production.
                </p>
            </div>

            <div class="team-grid">
                <article v-for="member in members" :key="member.id" class="member-card">

                    <!-- Photo -->
                    <div class="member-photo-wrap">
                        <img :src="member.image" :alt="member.name" class="member-photo" loading="lazy" />
                        <span class="member-badge" :style="{ background: member.badgeColor }">
                            {{ member.badge }}
                        </span>
                    </div>

                    <!-- Info -->
                    <div class="member-body">
                        <h3 class="member-name">{{ member.name }}</h3>
                        <span class="member-role">{{ member.role }}</span>
                        <p class="member-bio">{{ member.bio }}</p>
                    </div>

                    <!-- Socials -->
                    <div class="member-footer">
                        <a :href="`mailto:${member.socials.email}`" class="member-social" aria-label="Email">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </a>
                        <a :href="member.socials.linkedin" class="member-social" aria-label="LinkedIn" target="_blank" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a :href="member.socials.whatsapp" class="member-social" aria-label="WhatsApp" target="_blank" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>

                </article>
            </div>
        </div>
    </main>

    <!-- Join CTA -->
    <section class="cta-section">
        <div class="e-container">
            <div class="cta-inner">
                <div class="cta-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round" width="36" height="36">
                        <path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                </div>
                <div class="cta-text">
                    <h2 class="cta-title">Rejoignez l'équipe Synetcom</h2>
                    <p class="cta-desc">
                        Vous êtes passionné par le digital et souhaitez intégrer une équipe dynamique ?
                        Nous sommes toujours à la recherche de nouveaux talents.
                    </p>
                </div>
                <div class="cta-actions">
                    <Link href="/nous-contacter" class="btn-primary">Candidater</Link>
                    <Link href="/nous-contacter" class="btn-ghost">Nous contacter</Link>
                </div>
            </div>
        </div>
    </section>

    <Footer />
</template>

<style scoped>
/* ── Hero ─────────────────────────────────────────────────────── */
.page-hero {
    position: relative; min-height: 42vh;
    display: flex; align-items: center; justify-content: center;
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
    text-align: center; padding: 52px 24px 44px;
    max-width: 680px; width: 100%;
}
.breadcrumb { display: flex; align-items: center; justify-content: center; gap: 8px; margin-bottom: 20px; font-size: 13px; }
.breadcrumb-link { color: rgba(255,255,255,.55); text-decoration: none; transition: color .2s; }
.breadcrumb-link:hover { color: #f15a2d; }
.breadcrumb-sep { color: rgba(255,255,255,.25); }
.breadcrumb-current { color: rgba(255,255,255,.90); font-weight: 600; }
.hero-title { font-size: clamp(2.2rem, 5vw, 3.4rem); font-weight: 800; color: #fff; letter-spacing: -.02em; line-height: 1.12; margin: 0 0 16px; }
.accent { color: #f15a2d; }
.hero-sub { font-size: 1.05rem; color: rgba(255,255,255,.72); line-height: 1.7; margin: 0 auto; max-width: 560px; }

/* ── Values strip ─────────────────────────────────────────────── */
.values-strip { background: #0d1b3e; padding: 32px 0; }
.e-container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
.values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.value-item { display: flex; align-items: flex-start; gap: 16px; }
.value-icon {
    flex-shrink: 0; width: 48px; height: 48px; border-radius: 12px;
    background: rgba(241,90,45,.15); color: #f15a2d;
    display: flex; align-items: center; justify-content: center;
}
.value-title { font-size: 15px; font-weight: 700; color: #fff; margin: 0 0 4px; }
.value-desc { font-size: 13px; color: rgba(255,255,255,.55); margin: 0; line-height: 1.5; }

/* ── Main ─────────────────────────────────────────────────────── */
.e-main { padding: 80px 0 96px; background: #f8fafc; }

.section-intro { text-align: center; margin-bottom: 56px; }
.eyebrow { display: inline-block; font-size: 11px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #f15a2d; margin-bottom: 14px; }
.intro-title { font-size: clamp(1.7rem, 3.5vw, 2.3rem); font-weight: 800; color: #0d1b3e; margin: 0 0 14px; letter-spacing: -.02em; line-height: 1.2; }
.intro-desc { font-size: 1.05rem; color: #64748b; max-width: 580px; margin: 0 auto; line-height: 1.7; }

/* ── Grid ─────────────────────────────────────────────────────── */
.team-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }

/* ── Card ─────────────────────────────────────────────────────── */
.member-card {
    background: #fff; border: 1px solid #e8edf5; border-radius: 20px;
    overflow: hidden; display: flex; flex-direction: column;
    transition: all .28s;
}
.member-card:hover { transform: translateY(-7px); box-shadow: 0 24px 48px rgba(27,68,156,.11); border-color: transparent; }

.member-photo-wrap {
    position: relative; height: 220px; overflow: hidden;
    background: linear-gradient(135deg, #e8edf5, #f1f5f9);
}
.member-photo { width: 100%; height: 100%; object-fit: cover; object-position: top; transition: transform .4s; }
.member-card:hover .member-photo { transform: scale(1.05); }
.member-badge {
    position: absolute; top: 14px; right: 14px;
    padding: 4px 12px; border-radius: 100px;
    color: #fff; font-size: 11px; font-weight: 800; letter-spacing: .05em;
    text-transform: uppercase;
}

.member-body { padding: 20px 22px 12px; flex: 1; }
.member-name { font-size: 16px; font-weight: 800; color: #0d1b3e; margin: 0 0 5px; }
.member-role { display: block; font-size: 12.5px; font-weight: 600; color: #f15a2d; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 10px; }
.member-bio { font-size: 13.5px; color: #64748b; line-height: 1.65; margin: 0; }

.member-footer {
    display: flex; gap: 10px; padding: 14px 22px 20px;
    border-top: 1px solid #f1f5f9; margin-top: auto;
}
.member-social {
    width: 36px; height: 36px; border-radius: 9px;
    background: #f8fafc; border: 1px solid #e8edf5;
    display: flex; align-items: center; justify-content: center;
    color: #64748b; text-decoration: none; transition: all .2s;
}
.member-social:hover { background: #1b449c; color: #fff; border-color: #1b449c; transform: translateY(-2px); }

/* ── CTA ──────────────────────────────────────────────────────── */
.cta-section { padding: 80px 0; background: linear-gradient(135deg, #0d1b3e 0%, #1b449c 100%); }
.cta-inner { display: flex; align-items: center; gap: 32px; flex-wrap: wrap; }
.cta-icon {
    flex-shrink: 0; width: 80px; height: 80px; border-radius: 20px;
    background: rgba(255,255,255,.10); border: 1px solid rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center; color: #f15a2d;
}
.cta-text { flex: 1; min-width: 260px; }
.cta-title { font-size: clamp(1.4rem, 2.8vw, 1.9rem); font-weight: 800; color: #fff; margin: 0 0 10px; line-height: 1.25; }
.cta-desc { font-size: 1rem; color: rgba(255,255,255,.70); line-height: 1.65; margin: 0; }
.cta-actions { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; flex-shrink: 0; }
.btn-primary {
    display: inline-flex; align-items: center; padding: 13px 28px;
    background: linear-gradient(135deg, #f15a2d, #e04518); color: #fff;
    border-radius: 50px; font-size: 14px; font-weight: 700;
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
@media (max-width: 1024px) { .team-grid { grid-template-columns: repeat(2, 1fr); } .values-grid { grid-template-columns: 1fr; } }
@media (max-width: 768px) { .cta-inner { flex-direction: column; text-align: center; } .cta-icon { margin: 0 auto; } .cta-actions { justify-content: center; } }
@media (max-width: 600px) { .team-grid { grid-template-columns: 1fr; gap: 16px; } }
</style>
