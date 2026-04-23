<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/MyComponents/PrimaryButton.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    canResetPassword: { type: Boolean },
    status: { type: String },
});

const showPassword = ref(false);

const features = [
    { icon: "mdi-shield-check-outline", label: "Accès sécurisé et chiffré" },
    { icon: "mdi-chart-line", label: "Tableaux de bord en temps réel" },
    { icon: "mdi-account-group-outline", label: "Gestion centralisée des équipes" },
];

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Connexion" />

    <GuestLayout>
        <div class="login-wrapper">
            <!-- Panneau gauche : branding -->
            <div class="brand-panel d-none d-md-flex">
                <div class="brand-content">
                    <div class="brand-logo mb-6">
                        <img src="/images/logo.png" alt="Logo" height="60" />
                    </div>
                    <h1 class="brand-title">Solutions digitales <br />pour demain</h1>
                    <p class="brand-subtitle">
                        Pilotez vos opérations, gérez vos équipes et suivez vos
                        performances depuis une plateforme unifiée.
                    </p>
                    <div class="brand-features mt-8">
                        <div v-for="feat in features" :key="feat.icon" class="feature-item">
                            <v-icon :icon="feat.icon" size="18" class="feature-icon" />
                            <span>{{ feat.label }}</span>
                        </div>
                    </div>
                    <!-- Décoration techno -->
                    <div class="grid-decoration" aria-hidden="true">
                        <div v-for="n in 25" :key="n" class="grid-dot" />
                    </div>
                </div>
            </div>

            <!-- Panneau droit : formulaire -->
            <div class="form-panel">
                <!-- Logo mobile uniquement -->
                <div class="d-flex d-md-none justify-center mb-6">
                    <img src="/images/logo.png" alt="Logo" height="50" />
                </div>

                <div class="form-card">
                    <div v-if="status" class="status-banner mb-4">
                        {{ status }}
                    </div>

                    <div class="form-header mb-6">
                        <h2 class="form-title">Bon retour</h2>
                        <p class="form-subtitle">Connectez-vous à votre espace</p>
                    </div>

                    <form @submit.prevent="submit" novalidate>
                        <div class="field-group">
                            <label class="field-label" for="email">Adresse e-mail</label>
                            <div class="field-wrapper" :class="{ 'field-error': form.errors.email }">
                                <v-icon icon="mdi-email-outline" size="18" class="field-icon" />
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="field-input"
                                    placeholder="vous@exemple.com"
                                    autocomplete="username"
                                    required
                                />
                            </div>
                            <span v-if="form.errors.email" class="error-text">{{ form.errors.email }}</span>
                        </div>

                        <div class="field-group mt-4">
                            <label class="field-label" for="password">Mot de passe</label>
                            <div class="field-wrapper" :class="{ 'field-error': form.errors.password }">
                                <v-icon icon="mdi-lock-outline" size="18" class="field-icon" />
                                <input
                                    id="password"
                                    v-model="form.password"
                                    :type="showPassword ? 'text' : 'password'"
                                    class="field-input"
                                    placeholder="••••••••"
                                    autocomplete="current-password"
                                    required
                                />
                                <button
                                    type="button"
                                    class="toggle-password"
                                    @click="showPassword = !showPassword"
                                    :aria-label="showPassword ? 'Masquer' : 'Afficher'"
                                >
                                    <v-icon :icon="showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'" size="18" />
                                </button>
                            </div>
                            <span v-if="form.errors.password" class="error-text">{{ form.errors.password }}</span>
                        </div>

                        <div class="d-flex align-center justify-space-between mt-3 mb-6">
                            <label class="remember-label">
                                <input v-model="form.remember" type="checkbox" class="remember-checkbox" />
                                <span>Se souvenir de moi</span>
                            </label>
                            <a v-if="canResetPassword" :href="route('password.request')" class="forgot-link">
                                Mot de passe oublié ?
                            </a>
                        </div>

                        <button
                            type="submit"
                            class="submit-btn"
                            :class="{ 'submit-loading': form.processing }"
                            :disabled="form.processing"
                        >
                            <v-progress-circular v-if="form.processing" size="18" width="2" indeterminate class="mr-2" />
                            <span>{{ form.processing ? "Connexion…" : "Se connecter" }}</span>
                        </button>
                    </form>
                </div>

                <p class="form-footer">
                    © {{ new Date().getFullYear() }} Synetcom · Tous droits réservés
                </p>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>
/* ─── Layout principal ──────────────────────────────────────────── */
.login-wrapper {
    display: flex;
    min-height: 100vh;
    width: 100%;
}

/* ─── Panneau gauche (branding) ─────────────────────────────────── */
.brand-panel {
    flex: 1;
    position: relative;
    background: linear-gradient(150deg, #0d1b3e 0%, #1b449c 60%, #2a1a6e 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    padding: 3rem;
}

.brand-panel::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 20% 80%, rgba(241, 90, 45, 0.25) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(27, 68, 156, 0.4) 0%, transparent 50%);
}

.brand-content {
    position: relative;
    z-index: 1;
    max-width: 420px;
}

.brand-title {
    font-family: "Montserrat", sans-serif;
    font-size: clamp(1.6rem, 2.5vw, 2.2rem);
    font-weight: 700;
    color: #fff;
    line-height: 1.3;
    margin-bottom: 1rem;
}

.brand-subtitle {
    font-family: "Poppins", sans-serif;
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.7);
    line-height: 1.7;
    margin-bottom: 0;
}

/* Features */
.brand-features {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-family: "Poppins", sans-serif;
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.85);
}

.feature-icon {
    color: #f15a2d !important;
    flex-shrink: 0;
}

/* Grille décorative */
.grid-decoration {
    position: absolute;
    bottom: 2rem;
    right: 2rem;
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
    opacity: 0.2;
}

.grid-dot {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #fff;
}

/* ─── Panneau droit (formulaire) ────────────────────────────────── */
.form-panel {
    flex: 0 0 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem 1.25rem;
    background: #0f0f0f;
    min-height: 100vh;
}

@media (min-width: 768px) {
    .form-panel {
        flex: 0 0 480px;
        max-width: 480px;
    }
}

@media (min-width: 1200px) {
    .form-panel {
        flex: 0 0 520px;
        max-width: 520px;
    }
}

.form-card {
    width: 100%;
    max-width: 400px;
    background: #1a1a1a;
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 16px;
    padding: 2.5rem 2rem;
}

/* En-tête formulaire */
.form-title {
    font-family: "Montserrat", sans-serif;
    font-size: 1.6rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 0.25rem;
}

.form-subtitle {
    font-family: "Poppins", sans-serif;
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.5);
    margin: 0;
}

/* Status */
.status-banner {
    background: rgba(34, 197, 94, 0.15);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: #4ade80;
    font-size: 0.875rem;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    font-family: "Poppins", sans-serif;
}

/* ─── Champs ─────────────────────────────────────────────────────── */
.field-group {
    display: flex;
    flex-direction: column;
}

.field-label {
    font-family: "Poppins", sans-serif;
    font-size: 0.8rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 0.5rem;
    letter-spacing: 0.4px;
}

.field-wrapper {
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 10px;
    padding: 0 0.875rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.field-wrapper:focus-within {
    border-color: #1b449c;
    box-shadow: 0 0 0 3px rgba(27, 68, 156, 0.2);
}

.field-wrapper.field-error {
    border-color: #f15a2d;
    box-shadow: 0 0 0 3px rgba(241, 90, 45, 0.15);
}

.field-icon {
    color: rgba(255, 255, 255, 0.35) !important;
    flex-shrink: 0;
    margin-right: 0.625rem;
}

.field-input {
    flex: 1;
    height: 46px;
    background: transparent;
    border: none;
    outline: none;
    color: #fff;
    font-family: "Poppins", sans-serif;
    font-size: 0.9rem;
    font-weight: 300;
}

.field-input::placeholder {
    color: rgba(255, 255, 255, 0.25);
}

.toggle-password {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    display: flex;
    align-items: center;
    color: rgba(255, 255, 255, 0.35);
    transition: color 0.2s;
    margin-left: 0.5rem;
}

.toggle-password:hover {
    color: rgba(255, 255, 255, 0.7);
}

.error-text {
    font-family: "Poppins", sans-serif;
    font-size: 0.75rem;
    color: #f15a2d;
    margin-top: 0.35rem;
}

/* ─── Remember / Forgot ─────────────────────────────────────────── */
.remember-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-family: "Poppins", sans-serif;
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.55);
    cursor: pointer;
    user-select: none;
}

.remember-checkbox {
    accent-color: #1b449c;
    width: 15px;
    height: 15px;
    cursor: pointer;
}

.forgot-link {
    font-family: "Poppins", sans-serif;
    font-size: 0.8rem;
    color: #f15a2d;
    text-decoration: none;
    transition: opacity 0.2s;
}

.forgot-link:hover {
    opacity: 0.8;
    text-decoration: underline;
}

/* ─── Bouton submit ─────────────────────────────────────────────── */
.submit-btn {
    width: 100%;
    height: 48px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);
    color: #fff;
    font-family: "Montserrat", sans-serif;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: opacity 0.2s, transform 0.15s;
    letter-spacing: 0.3px;
}

.submit-btn:hover:not(:disabled) {
    opacity: 0.9;
    transform: translateY(-1px);
}

.submit-btn:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}

/* ─── Pied de page ──────────────────────────────────────────────── */
.form-footer {
    margin-top: 2rem;
    font-family: "Poppins", sans-serif;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.25);
    text-align: center;
}
</style>
