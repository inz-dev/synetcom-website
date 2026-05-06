<script setup>
import Footer from '@/Components/Welcome/Footer.vue';
import Header from '@/Components/Welcome/Header.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    opportunite: { type: Object, required: true },
});

const submitted = ref(false);

const form = useForm({
    nom_candidat: '',
    prenom_candidat: '',
    email_candidat: '',
    telephone_candidat: '',
    message_candidature: '',
    cv: null,
});

const onFileChange = (e) => {
    form.cv = e.target.files[0] ?? null;
};

const submit = () => {
    form.post(route('opportunites.postuler', props.opportunite.id_opportunite), {
        forceFormData: true,
        onSuccess: () => { submitted.value = true; form.reset(); },
    });
};

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
</script>

<template>
    <Head :title="opportunite.titre_opportunite" />

    <Header>
        <section class="page-hero">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <nav class="breadcrumb">
                    <Link href="/" class="breadcrumb-link">Accueil</Link>
                    <span class="breadcrumb-sep">/</span>
                    <Link :href="route('opportunites')" class="breadcrumb-link">Opportunités</Link>
                    <span class="breadcrumb-sep">/</span>
                    <span class="breadcrumb-current">{{ opportunite.titre_opportunite }}</span>
                </nav>
                <span class="hero-badge"
                      :style="{ background: contractColors[opportunite.type_contrat]?.bg, color: contractColors[opportunite.type_contrat]?.color }">
                    {{ opportunite.type_contrat }}
                </span>
                <h1 class="hero-title">{{ opportunite.titre_opportunite }}<span class="accent">.</span></h1>
                <div class="hero-meta">
                    <span v-if="opportunite.lieu_opportunite">
                        <i class="bi bi-geo-alt-fill"></i> {{ opportunite.lieu_opportunite }}
                    </span>
                    <span v-if="opportunite.date_limite">
                        <i class="bi bi-calendar3"></i> Candidatez avant le {{ formatDate(opportunite.date_limite) }}
                    </span>
                </div>
            </div>
        </section>
    </Header>

    <section class="detail-section">
        <div class="detail-container">

            <!-- Description -->
            <div class="detail-card">
                <h2 class="section-title">Description du poste</h2>
                <div class="offer-body" v-html="opportunite.description_opportunite.replace(/\n/g, '<br>')"></div>
            </div>

            <!-- Formulaire de candidature -->
            <div class="apply-card" id="postuler">
                <h2 class="section-title">
                    <i class="bi bi-send-fill" style="color:#f15a2d;"></i>
                    Postuler à cette offre
                </h2>

                <!-- Succès -->
                <div v-if="submitted" class="success-box">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>
                        <strong>Candidature envoyée !</strong>
                        <p>Nous avons bien reçu votre candidature. Notre équipe RH vous contactera dans les prochains jours.</p>
                    </div>
                    <Link :href="route('opportunites')" class="btn-back">Voir d'autres offres</Link>
                </div>

                <form v-else @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Prénom <span class="req">*</span></label>
                            <input v-model="form.prenom_candidat" type="text" placeholder="Votre prénom" required />
                            <span v-if="form.errors.prenom_candidat" class="field-error">{{ form.errors.prenom_candidat }}</span>
                        </div>
                        <div class="form-group">
                            <label>Nom <span class="req">*</span></label>
                            <input v-model="form.nom_candidat" type="text" placeholder="Votre nom" required />
                            <span v-if="form.errors.nom_candidat" class="field-error">{{ form.errors.nom_candidat }}</span>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email <span class="req">*</span></label>
                            <input v-model="form.email_candidat" type="email" placeholder="vous@example.com" required />
                            <span v-if="form.errors.email_candidat" class="field-error">{{ form.errors.email_candidat }}</span>
                        </div>
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input v-model="form.telephone_candidat" type="tel" placeholder="+222 XX XX XX XX" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Lettre de motivation <span class="req">*</span></label>
                        <textarea
                            v-model="form.message_candidature"
                            rows="6"
                            placeholder="Présentez-vous et expliquez pourquoi vous êtes le candidat idéal…"
                            required
                        ></textarea>
                        <span class="char-count">{{ form.message_candidature.length }} / 3000</span>
                        <span v-if="form.errors.message_candidature" class="field-error">{{ form.errors.message_candidature }}</span>
                    </div>

                    <div class="form-group">
                        <label>CV (PDF, Word — max 5 Mo)</label>
                        <div class="file-input-wrapper">
                            <input type="file" accept=".pdf,.doc,.docx" @change="onFileChange" />
                            <div class="file-label">
                                <i class="bi bi-paperclip"></i>
                                {{ form.cv ? form.cv.name : 'Choisir un fichier…' }}
                            </div>
                        </div>
                        <span v-if="form.errors.cv" class="field-error">{{ form.errors.cv }}</span>
                    </div>

                    <button type="submit" class="btn-submit" :disabled="form.processing">
                        <span v-if="form.processing">Envoi en cours…</span>
                        <span v-else><i class="bi bi-send-fill"></i> Envoyer ma candidature</span>
                    </button>
                </form>
            </div>

        </div>
    </section>

    <Footer />
</template>

<style scoped>
/* Hero */
.page-hero {
    position: relative;
    min-height: 46vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-top: 68px;
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
    max-width: 720px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 14px;
}
.breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; }
.breadcrumb-link { color: rgba(255,255,255,.55); text-decoration: none; transition: color .2s; }
.breadcrumb-link:hover { color: #f15a2d; }
.breadcrumb-sep { color: rgba(255,255,255,.25); }
.breadcrumb-current { color: rgba(255,255,255,.90); font-weight: 600; }
.hero-badge { padding: 5px 14px; border-radius: 100px; font-size: 13px; font-weight: 700; }
.hero-title { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800; color: #fff; margin: 0; line-height: 1.15; letter-spacing: -.02em; }
.accent { color: #f15a2d; }
.hero-meta { display: flex; align-items: center; gap: 20px; flex-wrap: wrap; justify-content: center; font-size: 14px; color: rgba(255,255,255,.72); }
.hero-meta i { color: #f15a2d; margin-right: 4px; }

/* Layout */
.detail-section { padding: 64px 24px; background: #f8fafc; }
.detail-container { max-width: 900px; margin: 0 auto; display: flex; flex-direction: column; gap: 32px; }

/* Cards */
.detail-card, .apply-card {
    background: #fff;
    border-radius: 16px;
    padding: 36px;
    border: 1px solid #e8edf5;
    box-shadow: 0 2px 12px rgba(27,68,156,.06);
}

.section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0 0 24px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.offer-body {
    font-size: 15px;
    line-height: 1.8;
    color: #475569;
}

/* Form */
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 20px; }
.form-group label { font-size: 13px; font-weight: 600; color: #374151; }
.req { color: #f15a2d; }
.form-group input, .form-group textarea {
    padding: 11px 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    color: #1e293b;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
    resize: vertical;
}
.form-group input:focus, .form-group textarea:focus {
    border-color: #1b449c;
    box-shadow: 0 0 0 3px rgba(27,68,156,.1);
}
.char-count { font-size: 11px; color: #94a3b8; text-align: right; }
.field-error { font-size: 12px; color: #e74c3c; }

/* File input */
.file-input-wrapper { position: relative; }
.file-input-wrapper input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; z-index: 2; }
.file-label {
    padding: 11px 14px;
    border: 1.5px dashed #cbd5e1;
    border-radius: 10px;
    font-size: 14px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: border-color .2s;
}
.file-input-wrapper:hover .file-label { border-color: #1b449c; color: #1b449c; }

/* Submit */
.btn-submit {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    box-shadow: 0 4px 16px rgba(241,90,45,.35);
}
.btn-submit:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(241,90,45,.45); }
.btn-submit:disabled { opacity: .65; cursor: not-allowed; }

/* Success */
.success-box {
    background: #f0fdf4;
    border: 1.5px solid #86efac;
    border-radius: 12px;
    padding: 28px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
    text-align: center;
}
.success-box i { font-size: 2.5rem; color: #22c55e; }
.success-box strong { font-size: 1.1rem; color: #15803d; display: block; margin-bottom: 6px; }
.success-box p { color: #166534; font-size: 14px; margin: 0; }
.btn-back {
    display: inline-flex;
    align-items: center;
    padding: 10px 22px;
    background: #1b449c;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: background .2s;
}
.btn-back:hover { background: #2d5cc8; color: #fff; }

@media (max-width: 640px) {
    .form-row { grid-template-columns: 1fr; }
    .detail-card, .apply-card { padding: 24px; }
}
</style>
