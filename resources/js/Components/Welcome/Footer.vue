<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const email = ref('');
const organisme = computed(() => usePage().props.organisme);

const formatPhone = (t) => `${t.code_telephone} ${String(t.telephone).match(/.{1,2}/g).join(' ')}`;
const phonesDisplay = computed(() => organisme.value?.telephones?.map(formatPhone).join(' / ') ?? '');
const firstPhone = computed(() => organisme.value?.telephones?.[0]);
const firstPhoneHref = computed(() => firstPhone.value ? `tel:${firstPhone.value.code_telephone}${firstPhone.value.telephone}` : '#');

const subscribe = () => {
    if (!email.value) return;
    email.value = '';
};
</script>

<template>
    <footer class="site-footer">

        <!-- Main grid -->
        <div class="f-container">
            <div class="f-grid">

                <!-- Brand -->
                <div class="f-col f-col--brand">
                    <Link href="/" class="f-logo">
                        <img src="/images/logo.png" alt="Synetcom" />
                    </Link>
                    <p class="f-about">
                        Développez votre entreprise avec la transformation numérique.
                        Depuis plus de 9 ans, nous accompagnons les organisations du Niger
                        dans leur croissance digitale.
                    </p>
                    <div class="f-socials">
                        <a href="#" class="social-btn" aria-label="Facebook" target="_blank" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-btn" aria-label="LinkedIn" target="_blank" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-btn" aria-label="WhatsApp" target="_blank" rel="noopener">
                            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick links -->
                <div class="f-col">
                    <h3 class="f-heading">Navigation</h3>
                    <ul class="f-links">
                        <li><Link href="/" class="f-link">Accueil</Link></li>
                        <li><Link :href="route('services')" class="f-link">Nos services</Link></li>
                        <li><Link :href="route('about-us')" class="f-link">À propos</Link></li>
                        <li><Link :href="route('nous-contacter')" class="f-link">Contact</Link></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="f-col">
                    <h3 class="f-heading">Nos services</h3>
                    <ul class="f-links">
                        <li><Link :href="route('services')" class="f-link">Développement Web & Mobile</Link></li>
                        <li><Link :href="route('services')" class="f-link">Sécurité Réseau</Link></li>
                        <li><Link :href="route('services')" class="f-link">Hébergement & SEO</Link></li>
                        <li><Link :href="route('services')" class="f-link">Formation</Link></li>
                        <li><Link :href="route('services')" class="f-link">Audit Informatique</Link></li>
                    </ul>
                </div>

                <!-- Contact + Newsletter -->
                <div class="f-col">
                    <h3 class="f-heading">Nos coordonnées</h3>
                    <ul class="f-contacts">
                        <li class="f-contact-item">
                            <span class="contact-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                                </svg>
                            </span>
                            <span>{{ organisme?.adresse_organisme }}</span>
                        </li>
                        <template v-for="em in organisme?.emails" :key="em.id_email">
                            <li class="f-contact-item">
                                <span class="contact-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                </span>
                                <a :href="`mailto:${em.email}`" class="f-contact-link">{{ em.email }}</a>
                            </li>
                        </template>
                        <li class="f-contact-item" v-if="phonesDisplay">
                            <span class="contact-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.68A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/>
                                </svg>
                            </span>
                            <a :href="firstPhoneHref" class="f-contact-link">{{ phonesDisplay }}</a>
                        </li>
                    </ul>

                    <div class="f-newsletter">
                        <p class="newsletter-label">Newsletter</p>
                        <form class="newsletter-form" @submit.prevent="subscribe">
                            <input
                                v-model="email"
                                type="email"
                                placeholder="Votre adresse e-mail"
                                class="newsletter-input"
                                required
                            />
                            <button type="submit" class="newsletter-btn">
                                <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bottom bar -->
        <div class="f-bottom">
            <div class="f-container f-bottom-inner">
                <p class="f-copy">
                    © {{ new Date().getFullYear() }} Synetcom Niger. Tous droits réservés.
                </p>
                <div class="f-bottom-links">
                    <a href="#" class="f-bottom-link">Mentions légales</a>
                    <span class="f-dot">·</span>
                    <a href="#" class="f-bottom-link">Politique de confidentialité</a>
                </div>
            </div>
        </div>

    </footer>
</template>

<style scoped>
.site-footer {
    background: #0d1b3e;
    color: rgba(255,255,255,0.75);
    font-size: 14px;
}

/* ── Container ───────────────────────────────────────────────── */
.f-container {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 24px;
}

/* ── Grid ────────────────────────────────────────────────────── */
.f-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr 1fr 1.5fr;
    gap: 48px;
    padding: 64px 0 48px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

/* ── Brand col ───────────────────────────────────────────────── */
.f-logo {
    display: inline-flex;
    margin-bottom: 18px;
}
.f-logo img {
    height: 42px;
    width: auto;
    object-fit: contain;
    filter: brightness(0) invert(1);
    opacity: 0.9;
}
.f-about {
    font-size: 13.5px;
    line-height: 1.75;
    color: rgba(255,255,255,0.60);
    margin: 0 0 22px;
}

/* Socials */
.f-socials {
    display: flex;
    gap: 10px;
}
.social-btn {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.65);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.22s;
    border: 1px solid rgba(255,255,255,0.10);
}
.social-btn:hover {
    background: #f15a2d;
    color: #fff;
    border-color: transparent;
    transform: translateY(-2px);
}

/* ── Columns ─────────────────────────────────────────────────── */
.f-col {
    display: flex;
    flex-direction: column;
}
.f-heading {
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.10em;
    text-transform: uppercase;
    color: #fff;
    margin: 0 0 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f15a2d;
    width: fit-content;
}

/* ── Links ───────────────────────────────────────────────────── */
.f-links {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.f-link {
    color: rgba(255,255,255,0.60);
    text-decoration: none;
    font-size: 13.5px;
    transition: color 0.2s, padding-left 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.f-link::before {
    content: '';
    display: inline-block;
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #f15a2d;
    opacity: 0;
    transition: opacity 0.2s;
    flex-shrink: 0;
}
.f-link:hover {
    color: #fff;
    padding-left: 6px;
}
.f-link:hover::before { opacity: 1; }

/* ── Contacts ────────────────────────────────────────────────── */
.f-contacts {
    list-style: none;
    margin: 0 0 24px;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.f-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 13px;
    color: rgba(255,255,255,0.60);
    line-height: 1.55;
}
.contact-icon {
    flex-shrink: 0;
    color: #f15a2d;
    margin-top: 1px;
}
.f-contact-link {
    color: rgba(255,255,255,0.60);
    text-decoration: none;
    transition: color 0.2s;
}
.f-contact-link:hover { color: #f15a2d; }

/* ── Newsletter ──────────────────────────────────────────────── */
.newsletter-label {
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.45);
    margin: 0 0 10px;
}
.newsletter-form {
    display: flex;
    gap: 0;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.12);
    background: rgba(255,255,255,0.05);
}
.newsletter-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    padding: 11px 14px;
    font-size: 13px;
    color: #fff;
    font-family: inherit;
    min-width: 0;
}
.newsletter-input::placeholder { color: rgba(255,255,255,0.35); }
.newsletter-btn {
    flex-shrink: 0;
    padding: 0 14px;
    background: #f15a2d;
    border: none;
    color: #fff;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}
.newsletter-btn:hover { background: #e04518; }

/* ── Bottom bar ──────────────────────────────────────────────── */
.f-bottom {
    border-top: 1px solid rgba(255,255,255,0.06);
    padding: 20px 0;
}
.f-bottom-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}
.f-copy {
    margin: 0;
    font-size: 13px;
    color: rgba(255,255,255,0.40);
}
.f-bottom-links {
    display: flex;
    align-items: center;
    gap: 10px;
}
.f-bottom-link {
    font-size: 13px;
    color: rgba(255,255,255,0.40);
    text-decoration: none;
    transition: color 0.2s;
}
.f-bottom-link:hover { color: rgba(255,255,255,0.75); }
.f-dot { color: rgba(255,255,255,0.20); }

/* ── Responsive ──────────────────────────────────────────────── */
@media (max-width: 1024px) {
    .f-grid { grid-template-columns: 1fr 1fr; gap: 36px; }
    .f-col--brand { grid-column: span 2; }
}
@media (max-width: 600px) {
    .f-grid { grid-template-columns: 1fr; gap: 32px; padding: 48px 0 36px; }
    .f-col--brand { grid-column: span 1; }
    .f-bottom-inner { flex-direction: column; text-align: center; }
}
</style>
