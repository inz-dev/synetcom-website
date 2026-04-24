<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { router, usePage } from '@inertiajs/vue3';


const props = defineProps({
    allPages: Array,
    errors:   Object,
});

const page     = usePage();
const scrolled = ref(false);
const menuOpen = ref(false);
const activeSection = ref('');

const isHome         = computed(() => page.url === '/' || page.url === '');
const isContact      = computed(() => page.url.startsWith('/nous-contacter'));
const isAbout        = computed(() => page.url.startsWith('/about-us'));
const isServices     = computed(() => page.url.startsWith('/services'));
const isRealisations = computed(() => page.url.startsWith('/realisations'));
const isEquipe       = computed(() => page.url.startsWith('/equipe'));
const isPartenaires  = computed(() => page.url.startsWith('/partenaires'));

const onScroll = () => { scrolled.value = window.scrollY > 60; };

onMounted(() => {
    window.addEventListener('scroll', onScroll, { passive: true });
    //console.log('allPages:',page.props.allPages)
});
onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
});

const nav = (routeName) => {
    menuOpen.value = false;
    router.visit(route(routeName));
};
</script>

<template>
    <header class="site-header" :class="{ 'scrolled': scrolled }">
        <div class="h-inner">

            <!-- Brand -->
            <a href="/" class="h-brand">
                <img src="/images/logo.png" alt="Synetcom" />
            </a>

            <!-- Desktop navigation -->
            <nav class="h-nav">
                <a href="/" class="h-link" :class="{ 'h-link--active': isHome }">Accueil</a>

                <button class="h-link" :class="{ 'h-link--active': isServices }"
                        @click="nav('services')">Services</button>

                <button class="h-link" :class="{ 'h-link--active': isRealisations }"
                        @click="nav('realisations')">Réalisations</button>

                <button class="h-link" :class="{ 'h-link--active': isEquipe }"
                        @click="nav('equipe')">Équipe</button>

                <button class="h-link" :class="{ 'h-link--active': isPartenaires }"
                        @click="nav('partenaires')">Partenaires</button>

                <button class="h-link" :class="{ 'h-link--active': isContact }"
                        @click="nav('nous-contacter')">Contact</button>
            </nav>

            <!-- CTA buttons -->
            <div class="h-actions">
                <button class="btn-login" @click="nav('login')">Connexion</button>
                <button class="btn-devis">Obtenir un devis</button>
            </div>

            <!-- Mobile hamburger -->
            <button class="h-burger" :class="{ open: menuOpen }" @click="menuOpen = !menuOpen" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>

        <!-- Mobile drawer -->
        <div class="h-mobile" :class="{ open: menuOpen }">
            <a href="/" class="m-link" :class="{ active: isHome }" @click="menuOpen=false">Accueil</a>
            <button class="m-link" :class="{ active: isServices }"     @click="nav('services')">Services</button>
            <button class="m-link" :class="{ active: isRealisations }" @click="nav('realisations')">Réalisations</button>
            <button class="m-link" :class="{ active: isEquipe }"       @click="nav('equipe')">Équipe</button>
            <button class="m-link" :class="{ active: isPartenaires }"  @click="nav('partenaires')">Partenaires</button>
            <button class="m-link" :class="{ active: isContact }"      @click="nav('nous-contacter')">Contact</button>
            <div class="m-actions">
                <button class="btn-login w-full" @click="nav('login')">Connexion</button>
                <button class="btn-devis w-full">Obtenir un devis</button>
            </div>
        </div>
    </header>

    <slot />
</template>

<style scoped>
/* ── Base ─────────────────────────────────────────────────────── */
.site-header {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 1000;
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid #e8edf5;
    transition: box-shadow 0.3s, background 0.3s;
}
.site-header.scrolled {
    box-shadow: 0 4px 24px rgba(27,68,156,0.10);
    background: #fff;
}

.h-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
    height: 68px;
    display: flex;
    align-items: center;
    gap: 32px;
}

/* ── Brand ────────────────────────────────────────────────────── */
.h-brand { display: flex; align-items: center; text-decoration: none; flex-shrink: 0; }
.h-brand img { height: 44px; width: auto; object-fit: contain; }

/* ── Desktop nav ─────────────────────────────────────────────── */
.h-nav {
    display: flex;
    align-items: center;
    gap: 2px;
    flex: 1;
}

.h-link {
    position: relative;
    display: inline-flex;
    align-items: center;
    padding: 8px 14px;
    border: none;
    background: none;
    font-size: 14px;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    border-radius: 8px;
    text-decoration: none;
    transition: color 0.2s, background 0.2s;
    white-space: nowrap;
    font-family: inherit;
}
.h-link:hover { color: #1b449c; background: rgba(27,68,156,0.06); }

.h-link--active { color: #1b449c; font-weight: 600; }
.h-link--active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 14px;
    right: 14px;
    height: 2px;
    background: #f15a2d;
    border-radius: 2px;
}

/* ── CTA ──────────────────────────────────────────────────────── */
.h-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

.btn-login {
    padding: 8px 18px;
    border: 1.5px solid #1b449c;
    border-radius: 8px;
    background: none;
    color: #1b449c;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: inherit;
    white-space: nowrap;
}
.btn-login:hover { background: #1b449c; color: #fff; }

.btn-devis {
    padding: 8px 18px;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: inherit;
    white-space: nowrap;
    box-shadow: 0 2px 8px rgba(241,90,45,0.3);
}
.btn-devis:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(241,90,45,0.4); }

/* ── Hamburger ───────────────────────────────────────────────── */
.h-burger {
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    gap: 5px;
    border: none;
    background: none;
    cursor: pointer;
    padding: 0;
    border-radius: 8px;
    transition: background 0.2s;
    flex-shrink: 0;
}
.h-burger:hover { background: rgba(27,68,156,0.06); }
.h-burger span {
    display: block;
    width: 22px;
    height: 2px;
    background: #374151;
    border-radius: 2px;
    transition: all 0.3s;
    transform-origin: center;
}
.h-burger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.h-burger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.h-burger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* ── Mobile drawer ───────────────────────────────────────────── */
.h-mobile {
    display: none;
    flex-direction: column;
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.35s ease;
    border-top: 1px solid #e8edf5;
    background: #fff;
}
.h-mobile.open { max-height: 480px; }

.m-link {
    display: block;
    width: 100%;
    padding: 13px 24px;
    border: none;
    background: none;
    font-size: 15px;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    text-align: left;
    border-bottom: 1px solid #f1f5f9;
    transition: color 0.2s, background 0.2s;
    font-family: inherit;
    text-decoration: none;
}
.m-link:hover, .m-link.active { color: #1b449c; background: rgba(27,68,156,0.04); }
.m-link.active { font-weight: 700; border-left: 3px solid #f15a2d; }

.m-actions {
    display: flex;
    gap: 10px;
    padding: 16px 24px;
}
.w-full { width: 100%; justify-content: center; }

/* ── Responsive ──────────────────────────────────────────────── */
@media (max-width: 1024px) {
    .h-nav { gap: 0; }
    .h-link { padding: 8px 10px; font-size: 13px; }
}

@media (max-width: 768px) {
    .h-nav, .h-actions { display: none; }
    .h-burger { display: flex; }
    .h-mobile { display: flex; }
    .h-inner { gap: 0; justify-content: space-between; }
}
</style>
