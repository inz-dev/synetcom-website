<script setup>
import { computed, onUnmounted, ref } from 'vue';

/* ── Form state ─────────────────────────────────────────────── */
const form = ref({ nom: '', email: '', telephone: '', sujet: '', message: '' });
const formStatus = ref('idle'); // idle | sending | success | error

const submitForm = () => {
    if (!form.value.nom || !form.value.email || !form.value.message) return;
    formStatus.value = 'sending';
    setTimeout(() => {
        formStatus.value = 'success';
        form.value = { nom: '', email: '', telephone: '', sujet: '', message: '' };
    }, 1200);
};

const resetForm = () => { formStatus.value = 'idle'; };

/* ── GPS live ───────────────────────────────────────────────── */
const SYNETCOM = { lat: 13.5137, lng: 2.1098 };

const gpsActive  = ref(false);
const gpsStatus  = ref('idle');   // idle | loading | live | error
const gpsError   = ref('');
const position   = ref(null);
const watchId    = ref(null);

const haversine = (lat1, lon1, lat2, lon2) => {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) ** 2
            + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180)
            * Math.sin(dLon / 2) ** 2;
    return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
};

const distance = computed(() => {
    if (!position.value) return null;
    const d = haversine(position.value.lat, position.value.lng, SYNETCOM.lat, SYNETCOM.lng);
    return d < 1 ? `${Math.round(d * 1000)} m` : `${d.toFixed(1)} km`;
});

const directionsUrl = computed(() => {
    if (!position.value) return '#';
    return `https://www.google.com/maps/dir/?api=1&origin=${position.value.lat},${position.value.lng}&destination=${SYNETCOM.lat},${SYNETCOM.lng}`;
});

const toggleGPS = () => {
    if (gpsActive.value) {
        if (watchId.value !== null) { navigator.geolocation.clearWatch(watchId.value); watchId.value = null; }
        gpsActive.value = false;
        gpsStatus.value = 'idle';
        position.value = null;
        return;
    }

    if (!navigator.geolocation) {
        gpsStatus.value = 'error';
        gpsError.value = 'Géolocalisation non supportée par votre navigateur.';
        return;
    }

    gpsActive.value = true;
    gpsStatus.value = 'loading';

    watchId.value = navigator.geolocation.watchPosition(
        (pos) => {
            position.value = {
                lat: pos.coords.latitude,
                lng: pos.coords.longitude,
                accuracy: Math.round(pos.coords.accuracy),
            };
            gpsStatus.value = 'live';
        },
        (err) => {
            gpsActive.value = false;
            gpsStatus.value = 'error';
            gpsError.value = {
                1: 'Permission de localisation refusée.',
                2: 'Position indisponible.',
                3: 'Délai d\'attente expiré.',
            }[err.code] ?? 'Erreur de géolocalisation.';
        },
        { enableHighAccuracy: true, timeout: 15000, maximumAge: 3000 }
    );
};

onUnmounted(() => {
    if (watchId.value !== null) navigator.geolocation.clearWatch(watchId.value);
});
</script>

<template>
    <section class="contact-section">
        <div class="c-container">
            <div class="contact-grid">

                <!-- ── Left panel ─────────────────────────────────── -->
                <aside class="left-panel">

                    <!-- Info block -->
                    <div class="info-block">
                        <h2 class="info-title">Entrez en contact</h2>
                        <p class="info-sub">
                            Remplissez le formulaire ou utilisez nos coordonnées directement.
                            Nous vous répondons sous 24 heures.
                        </p>

                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="18" height="18">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                                    </svg>
                                </span>
                                <div>
                                    <span class="info-label">Adresse</span>
                                    <span class="info-value">Face Pharmacie Maisons économiques,<br>13743 Niamey, NIGER</span>
                                </div>
                            </li>
                            <li class="info-item">
                                <span class="info-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="18" height="18">
                                        <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81a19.79 19.79 0 01-3.07-8.68A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z"/>
                                    </svg>
                                </span>
                                <div>
                                    <span class="info-label">Téléphone</span>
                                    <a href="tel:+22790717476" class="info-value info-link">+227 90 71 74 76 / 88 88 88 11</a>
                                </div>
                            </li>
                            <li class="info-item">
                                <span class="info-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="18" height="18">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                </span>
                                <div>
                                    <span class="info-label">Email</span>
                                    <a href="mailto:chaibou.abdou@synetcom.dev" class="info-value info-link">chaibou.abdou@synetcom.dev</a>
                                </div>
                            </li>
                            <li class="info-item">
                                <span class="info-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="18" height="18">
                                        <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                </span>
                                <div>
                                    <span class="info-label">Horaires</span>
                                    <span class="info-value">Lun – Ven : 8h00 – 18h00<br>Sam : 9h00 – 13h00</span>
                                </div>
                            </li>
                        </ul>

                        <!-- Socials -->
                        <div class="socials">
                            <a href="#" class="social-btn" aria-label="Facebook" target="_blank" rel="noopener">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="social-btn" aria-label="LinkedIn" target="_blank" rel="noopener">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                            <a href="#" class="social-btn" aria-label="WhatsApp" target="_blank" rel="noopener">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="17" height="17">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- GPS block -->
                    <div class="gps-block">
                        <div class="gps-header">
                            <span class="gps-icon-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="20" height="20">
                                    <circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/>
                                    <path d="M12 2a10 10 0 100 20A10 10 0 0012 2z" stroke-dasharray="2 4"/>
                                </svg>
                            </span>
                            <div>
                                <h3 class="gps-title">Ma position en direct</h3>
                                <p class="gps-sub">Localisez-vous et calculez la distance jusqu'à nous</p>
                            </div>
                        </div>

                        <!-- Toggle button -->
                        <button class="gps-toggle"
                                :class="{ 'gps-toggle--active': gpsActive, 'gps-toggle--loading': gpsStatus === 'loading' }"
                                @click="toggleGPS">
                            <span class="gps-dot" :class="{ 'gps-dot--pulse': gpsStatus === 'live' }"></span>
                            <span v-if="gpsStatus === 'idle'">Activer la géolocalisation</span>
                            <span v-else-if="gpsStatus === 'loading'">Localisation en cours…</span>
                            <span v-else-if="gpsStatus === 'live'">En direct — Désactiver</span>
                            <span v-else-if="gpsStatus === 'error'">Réessayer</span>
                        </button>

                        <!-- Error -->
                        <div v-if="gpsStatus === 'error'" class="gps-error">
                            <svg viewBox="0 0 20 20" fill="currentColor" width="15" height="15"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ gpsError }}
                        </div>

                        <!-- Live data -->
                        <div v-if="position" class="gps-data">
                            <div class="gps-row">
                                <span class="gps-row-label">Latitude</span>
                                <span class="gps-row-val">{{ position.lat.toFixed(6) }}°</span>
                            </div>
                            <div class="gps-row">
                                <span class="gps-row-label">Longitude</span>
                                <span class="gps-row-val">{{ position.lng.toFixed(6) }}°</span>
                            </div>
                            <div class="gps-row">
                                <span class="gps-row-label">Précision</span>
                                <span class="gps-row-val">± {{ position.accuracy }} m</span>
                            </div>
                            <div class="gps-row gps-row--dist">
                                <span class="gps-row-label">Distance Synetcom</span>
                                <span class="gps-row-val gps-dist">{{ distance }}</span>
                            </div>
                            <a :href="directionsUrl" target="_blank" rel="noopener noreferrer" class="gps-directions">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
                                    <polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                                Voir l'itinéraire depuis ma position
                            </a>
                        </div>
                    </div>
                </aside>

                <!-- ── Right panel ─────────────────────────────────── -->
                <div class="right-panel">

                    <!-- Form -->
                    <div class="form-card">
                        <!-- Success state -->
                        <div v-if="formStatus === 'success'" class="form-success">
                            <div class="success-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="36" height="36">
                                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                            </div>
                            <h3>Message envoyé !</h3>
                            <p>Merci de nous avoir contactés. Nous vous répondrons dans les plus brefs délais.</p>
                            <button class="btn-reset" @click="resetForm">Envoyer un autre message</button>
                        </div>

                        <!-- Form fields -->
                        <template v-else>
                            <h2 class="form-title">Envoyez-nous un message</h2>
                            <form @submit.prevent="submitForm" class="contact-form" novalidate>
                                <div class="field-row">
                                    <div class="field">
                                        <label class="field-label">
                                            Nom complet <span class="required">*</span>
                                        </label>
                                        <input v-model="form.nom" type="text" class="field-input"
                                               placeholder="Ex : Ibrahim Moussa" required />
                                    </div>
                                    <div class="field">
                                        <label class="field-label">Téléphone</label>
                                        <input v-model="form.telephone" type="tel" class="field-input"
                                               placeholder="+227 90 00 00 00" />
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="field-label">
                                        Adresse e-mail <span class="required">*</span>
                                    </label>
                                    <input v-model="form.email" type="email" class="field-input"
                                           placeholder="votre@email.com" required />
                                </div>

                                <div class="field">
                                    <label class="field-label">Sujet</label>
                                    <div class="select-wrap">
                                        <select v-model="form.sujet" class="field-input">
                                            <option value="">— Sélectionnez un sujet —</option>
                                            <option>Demande de devis</option>
                                            <option>Développement Web & Mobile</option>
                                            <option>Administration & Sécurité Réseau</option>
                                            <option>Formation</option>
                                            <option>Hébergement & SEO</option>
                                            <option>Audit Informatique</option>
                                            <option>Autre</option>
                                        </select>
                                        <svg class="select-arrow" viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>

                                <div class="field">
                                    <label class="field-label">
                                        Message <span class="required">*</span>
                                    </label>
                                    <textarea v-model="form.message" class="field-input field-textarea"
                                              placeholder="Décrivez votre projet ou votre demande…"
                                              rows="5" required></textarea>
                                </div>

                                <button type="submit" class="btn-submit"
                                        :class="{ 'btn-submit--loading': formStatus === 'sending' }"
                                        :disabled="formStatus === 'sending'">
                                    <svg v-if="formStatus !== 'sending'" viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
                                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                    </svg>
                                    <span class="spinner" v-else></span>
                                    {{ formStatus === 'sending' ? 'Envoi en cours…' : 'Envoyer le message' }}
                                </button>
                            </form>
                        </template>
                    </div>

                    <!-- Map -->
                    <div class="map-card">
                        <div class="map-label">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            Synetcom — Niamey, Niger
                        </div>
                        <iframe
                            src="https://www.openstreetmap.org/export/embed.html?bbox=2.0748%2C13.4937%2C2.1448%2C13.5337&layer=mapnik&marker=13.5137%2C2.1098"
                            class="map-iframe"
                            allowfullscreen
                            loading="lazy"
                            title="Localisation Synetcom Niamey"
                        ></iframe>
                        <a class="map-open"
                           href="https://www.openstreetmap.org/?mlat=13.5137&mlon=2.1098#map=15/13.5137/2.1098"
                           target="_blank" rel="noopener noreferrer">
                            Ouvrir dans OpenStreetMap
                            <svg viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="13" height="13">
                                <path d="M11 3H17M17 3V9M17 3L9 11M7 5H5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* ── Section ─────────────────────────────────────────────────── */
.contact-section {
    padding: 80px 0 96px;
    background: #f8fafc;
}
.c-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}
.contact-grid {
    display: grid;
    grid-template-columns: 420px 1fr;
    gap: 32px;
    align-items: start;
}

/* ── Left panel ──────────────────────────────────────────────── */
.left-panel { display: flex; flex-direction: column; gap: 24px; }

/* Info block */
.info-block {
    background: linear-gradient(145deg, #1b449c 0%, #0d1b3e 100%);
    border-radius: 20px;
    padding: 36px 32px;
    color: #fff;
}
.info-title {
    font-size: 1.4rem;
    font-weight: 800;
    margin: 0 0 10px;
    color: #fff;
}
.info-sub {
    font-size: 13.5px;
    color: rgba(255,255,255,0.68);
    line-height: 1.65;
    margin: 0 0 28px;
}
.info-list { list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 18px; }
.info-item { display: flex; align-items: flex-start; gap: 14px; }
.info-icon {
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(255,255,255,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #f15a2d;
    margin-top: 2px;
}
.info-label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: rgba(255,255,255,0.50);
    margin-bottom: 3px;
}
.info-value { display: block; font-size: 13.5px; color: rgba(255,255,255,0.85); line-height: 1.55; }
.info-link { text-decoration: none; transition: color .2s; }
.info-link:hover { color: #f15a2d; }

.socials { display: flex; gap: 10px; }
.social-btn {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: rgba(255,255,255,0.10);
    border: 1px solid rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.70);
    display: flex; align-items: center; justify-content: center;
    text-decoration: none;
    transition: all .22s;
}
.social-btn:hover { background: #f15a2d; color: #fff; border-color: transparent; transform: translateY(-2px); }

/* GPS block */
.gps-block {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 20px;
    padding: 28px 28px 24px;
}
.gps-header { display: flex; align-items: flex-start; gap: 14px; margin-bottom: 20px; }
.gps-icon-wrap {
    flex-shrink: 0;
    width: 44px; height: 44px;
    border-radius: 12px;
    background: rgba(27,68,156,0.08);
    color: #1b449c;
    display: flex; align-items: center; justify-content: center;
}
.gps-title { font-size: 15px; font-weight: 700; color: #0d1b3e; margin: 0 0 4px; }
.gps-sub { font-size: 12.5px; color: #64748b; margin: 0; line-height: 1.5; }

.gps-toggle {
    width: 100%;
    display: flex; align-items: center; gap: 10px;
    padding: 11px 18px;
    border: 1.5px solid #1b449c;
    border-radius: 10px;
    background: none;
    color: #1b449c;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all .22s;
    font-family: inherit;
}
.gps-toggle--active { background: #1b449c; color: #fff; border-color: #1b449c; }
.gps-toggle--loading { opacity: .7; cursor: wait; }
.gps-toggle:hover:not(.gps-toggle--loading) { background: #1b449c; color: #fff; }

.gps-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: currentColor;
    opacity: .5;
    flex-shrink: 0;
}
.gps-dot--pulse {
    opacity: 1;
    background: #22c55e;
    animation: gps-pulse 1.4s ease-in-out infinite;
}
@keyframes gps-pulse {
    0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(34,197,94,.6); }
    50% { transform: scale(1.2); box-shadow: 0 0 0 5px rgba(34,197,94,0); }
}

.gps-error {
    display: flex; align-items: center; gap: 7px;
    margin-top: 12px;
    padding: 10px 14px;
    border-radius: 8px;
    background: #fef2f2;
    color: #dc2626;
    font-size: 13px;
    font-weight: 500;
}

.gps-data {
    margin-top: 16px;
    border: 1px solid #e8edf5;
    border-radius: 12px;
    overflow: hidden;
}
.gps-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 9px 14px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
}
.gps-row:last-child { border-bottom: none; }
.gps-row--dist { background: rgba(27,68,156,0.04); }
.gps-row-label { color: #64748b; font-weight: 500; }
.gps-row-val { color: #0d1b3e; font-weight: 700; font-variant-numeric: tabular-nums; }
.gps-dist { color: #1b449c; font-size: 14px; }

.gps-directions {
    display: flex; align-items: center; gap: 8px;
    margin-top: 14px;
    padding: 10px 16px;
    border-radius: 10px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    width: 100%;
    justify-content: center;
    transition: all .22s;
    box-shadow: 0 4px 12px rgba(241,90,45,.30);
}
.gps-directions:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(241,90,45,.42); color: #fff; }

/* ── Right panel ─────────────────────────────────────────────── */
.right-panel { display: flex; flex-direction: column; gap: 24px; }

/* Form card */
.form-card {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 20px;
    padding: 36px 32px;
}
.form-title { font-size: 1.4rem; font-weight: 800; color: #0d1b3e; margin: 0 0 28px; }

.contact-form { display: flex; flex-direction: column; gap: 18px; }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.field { display: flex; flex-direction: column; gap: 7px; }
.field-label { font-size: 13px; font-weight: 600; color: #374151; }
.required { color: #f15a2d; }

.field-input {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    color: #0d1b3e;
    background: #fafafa;
    outline: none;
    transition: border-color .2s, box-shadow .2s, background .2s;
    font-family: inherit;
    box-sizing: border-box;
    appearance: none;
}
.field-input:focus {
    border-color: #1b449c;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(27,68,156,0.10);
}
.field-input::placeholder { color: #94a3b8; }
.field-textarea { resize: vertical; min-height: 120px; }

.select-wrap { position: relative; }
.select-wrap .field-input { padding-right: 36px; cursor: pointer; }
.select-arrow {
    position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
    pointer-events: none; color: #94a3b8;
}

.btn-submit {
    display: inline-flex; align-items: center; gap: 10px; justify-content: center;
    padding: 13px 28px;
    background: linear-gradient(135deg, #1b449c, #142f75);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all .25s;
    font-family: inherit;
    box-shadow: 0 4px 16px rgba(27,68,156,0.25);
    align-self: flex-start;
}
.btn-submit:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(27,68,156,0.35); }
.btn-submit--loading { opacity: .8; cursor: wait; }
.btn-submit:disabled { cursor: not-allowed; }

.spinner {
    width: 16px; height: 16px;
    border: 2px solid rgba(255,255,255,0.35);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin .7s linear infinite;
    flex-shrink: 0;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* Success */
.form-success {
    display: flex; flex-direction: column; align-items: center;
    gap: 12px; text-align: center; padding: 32px 16px;
}
.success-icon {
    width: 72px; height: 72px;
    border-radius: 50%;
    background: rgba(34,197,94,0.10);
    color: #22c55e;
    display: flex; align-items: center; justify-content: center;
}
.form-success h3 { font-size: 1.3rem; font-weight: 800; color: #0d1b3e; margin: 0; }
.form-success p { color: #64748b; font-size: 14px; line-height: 1.65; margin: 0; }
.btn-reset {
    margin-top: 8px;
    padding: 10px 22px;
    border: 1.5px solid #1b449c;
    border-radius: 8px;
    background: none;
    color: #1b449c;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    font-family: inherit;
}
.btn-reset:hover { background: #1b449c; color: #fff; }

/* Map */
.map-card {
    background: #fff;
    border: 1px solid #e8edf5;
    border-radius: 20px;
    overflow: hidden;
}
.map-label {
    display: flex; align-items: center; gap: 8px;
    padding: 14px 20px;
    font-size: 13px; font-weight: 700; color: #0d1b3e;
    border-bottom: 1px solid #f1f5f9;
}
.map-label svg { color: #f15a2d; }
.map-iframe {
    width: 100%;
    height: 260px;
    border: none;
    display: block;
}
.map-open {
    display: flex; align-items: center; gap: 6px; justify-content: center;
    padding: 12px;
    font-size: 12.5px; font-weight: 600;
    color: #64748b;
    text-decoration: none;
    border-top: 1px solid #f1f5f9;
    transition: color .2s, background .2s;
}
.map-open:hover { color: #1b449c; background: rgba(27,68,156,0.04); }

/* ── Responsive ──────────────────────────────────────────────── */
@media (max-width: 1024px) {
    .contact-grid { grid-template-columns: 1fr; }
    .left-panel { display: grid; grid-template-columns: 1fr 1fr; }
}
@media (max-width: 700px) {
    .left-panel { grid-template-columns: 1fr; }
    .field-row { grid-template-columns: 1fr; }
    .form-card, .info-block, .gps-block { padding: 24px 20px; }
    .btn-submit { width: 100%; }
}
</style>
