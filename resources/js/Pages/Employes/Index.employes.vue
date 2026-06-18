<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { computed, ref, shallowRef, reactive,onMounted } from "vue";
import { useDisplay } from "vuetify";

const props = defineProps({
    allEmployes: Array,
    allDepartements: Array,
    allRoles: Array,
    errors: Object,
});
onMounted(() => {
    //console.log('allEmployees!:', props.allEmployes)
})
const { smAndDown } = useDisplay();

const employes = computed(() =>
    (props.allEmployes ?? []).map((e, i) => ({ ...e, index: i + 1 }))
);

const withAccount = computed(() => employes.value.filter((e) => e.user).length);
const byProfil    = computed(() => {
    const counts = {};
    employes.value.forEach((e) => {
        if (e.profil_employe) counts[e.profil_employe] = (counts[e.profil_employe] ?? 0) + 1;
    });
    return counts;
});

const search = ref("");

const headers = computed(() => [
    { title: "N°", key: "index", width: 56, sortable: false },
    { title: "Employé", key: "nom_employe", sortable: true },
    { title: "Profil", key: "profil_employe", sortable: true },
    { title: "Poste", key: "poste", sortable: false },
    ...(!smAndDown.value
        ? [
              { title: "Département", key: "departement", sortable: false },
              { title: "Contrat", key: "type_contrat", width: 100, sortable: false },
              { title: "Embauche", key: "date_embauche_employe", width: 110, sortable: true },
          ]
        : []),
    { title: "Accès", key: "user", width: 72, align: "center", sortable: false },
    { title: "Actions", key: "actions", width: 100, align: "end", sortable: false },
]);

const profils = [
    "Ingénieur Réseau",
    "Administrateur Réseau",
    "Développeur Web",
    "Développeur Mobile",
    "Développeur Web/Mobile",
    "Designer",
    "Admin BD",
    "Manager",
];

const contrats = ["CDI", "CDD", "Stage", "Freelance", "Autre"];

const profilColors = {
    "Ingénieur Réseau":       { bg: "#1b449c22", text: "#1b449c", border: "#1b449c55" },
    "Administrateur Réseau":  { bg: "#0891b222", text: "#0891b2", border: "#0891b255" },
    "Développeur Web":        { bg: "#05966922", text: "#059669", border: "#05966955" },
    "Développeur Mobile":     { bg: "#7c3aed22", text: "#7c3aed", border: "#7c3aed55" },
    "Développeur Web/Mobile": { bg: "#9d174d22", text: "#e11d48", border: "#e11d4855" },
    "Designer":               { bg: "#f15a2d22", text: "#f15a2d", border: "#f15a2d55" },
    "Admin BD":               { bg: "#dc262622", text: "#dc2626", border: "#dc262655" },
    "Manager":                { bg: "#b4530922", text: "#b45309", border: "#b4530955" },
};

const contratColors = {
    CDI:       { bg: "#05966922", text: "#059669" },
    CDD:       { bg: "#d9770622", text: "#d97706" },
    Stage:     { bg: "#6366f122", text: "#6366f1" },
    Freelance: { bg: "#06b6d422", text: "#06b6d4" },
    Autre:     { bg: "#6b728022", text: "#9ca3af" },
};

const profilStyle = (p) => {
    const c = profilColors[p];
    return c
        ? { background: c.bg, color: c.text, border: `1px solid ${c.border}` }
        : { background: "#3a3d5222", color: "#a0a4b8", border: "1px solid #3a3d5255" };
};

const contratStyle = (c) => {
    const s = contratColors[c] ?? contratColors.Autre;
    return { background: s.bg, color: s.text };
};

// ── Email preview (from nom_employe split) ───────────────────────
const normalize = (s) =>
    s.toLowerCase()
        .replace(/[àâä]/g, "a").replace(/[éèêë]/g, "e")
        .replace(/[îï]/g, "i").replace(/[ôö]/g, "o")
        .replace(/[ùûü]/g, "u").replace(/ç/g, "c")
        .replace(/[^a-z0-9]/g, "");

const emailPreview = computed(() => {
    const nom = formEmploye.nom_employe.trim();
    if (!nom) return "";
    const parts = nom.split(/\s+/);
    const fn = normalize(parts[0] ?? "");
    const ln = normalize(parts.slice(1).join("") ?? "");
    return `${fn}.${ln}@synetcom-niger.com`;
});

// ── Employe form ─────────────────────────────────────────────────
const dialogEmploye = shallowRef(false);
const isEditing     = ref(false);
const showPoste     = ref(false);
const creerCompte   = ref(false);
const resetPwd      = ref(false);

const formEmploye = useForm({
    id_employe:            null,
    nom_employe:           "",
    profil_employe:        "",
    adresse_employe:       "",
    date_embauche_employe: "",
    type_contrat:          "CDI",
    nom_poste:             "",
    id_departement:        null,
    creer_compte:          false,
    reset_password:        false,
    role_employe:          'Employé',
    social_medias:         [],
    social_medias_remove:  [],
});

// ── Réseaux sociaux du formulaire ──────────────────────────────
const smPlatforms = [
    { name: 'WhatsApp',    icon: 'bi-whatsapp',     color: '#25d366', needsPhone: true,  needsEmail: false, needsLink: false },
    { name: 'LinkedIn',    icon: 'bi-linkedin',     color: '#0077b5', needsPhone: false, needsEmail: false, needsLink: true  },
    { name: 'Gmail',       icon: 'bi-envelope-fill',color: '#ea4335', needsPhone: false, needsEmail: true,  needsLink: false },
    { name: 'Yahoo',       icon: 'bi-envelope-fill',color: '#6001d2', needsPhone: false, needsEmail: true,  needsLink: false },
    { name: 'Facebook',    icon: 'bi-facebook',     color: '#1877f2', needsPhone: false, needsEmail: false, needsLink: true  },
    { name: 'Twitter / X', icon: 'bi-twitter-x',   color: '#000000', needsPhone: false, needsEmail: false, needsLink: true  },
    { name: 'Instagram',   icon: 'bi-instagram',   color: '#e1306c', needsPhone: false, needsEmail: false, needsLink: true  },
    { name: 'Mobile',      icon: 'bi-phone-fill',   color: '#64748b', needsPhone: true,  needsEmail: false, needsLink: false },
    { name: 'Autre',       icon: 'bi-share-fill',   color: '#6b7280', needsPhone: true,  needsEmail: true,  needsLink: true  },
];

const countryCodes = [
    { code: '+227', country: 'Niger' },
    { code: '+221', country: 'Sénégal' },
    { code: '+225', country: "Côte d'Ivoire" },
    { code: '+226', country: 'Burkina Faso' },
    { code: '+228', country: 'Togo' },
    { code: '+229', country: 'Bénin' },
    { code: '+223', country: 'Mali' },
    { code: '+224', country: 'Guinée' },
    { code: '+222', country: 'Mauritanie' },
    { code: '+220', country: 'Gambie' },
    { code: '+245', country: 'Guinée-Bissau' },
    { code: '+232', country: 'Sierra Leone' },
    { code: '+231', country: 'Liberia' },
    { code: '+238', country: 'Cap-Vert' },
    { code: '+237', country: 'Cameroun' },
    { code: '+235', country: 'Tchad' },
    { code: '+236', country: 'Centrafrique' },
    { code: '+242', country: 'Congo' },
    { code: '+243', country: 'RD Congo' },
    { code: '+241', country: 'Gabon' },
    { code: '+240', country: 'Guinée Équatoriale' },
    { code: '+239', country: 'São Tomé' },
    { code: '+234', country: 'Nigeria' },
    { code: '+233', country: 'Ghana' },
    { code: '+216', country: 'Tunisie' },
    { code: '+213', country: 'Algérie' },
    { code: '+212', country: 'Maroc' },
    { code: '+218', country: 'Libye' },
    { code: '+20',  country: 'Égypte' },
    { code: '+249', country: 'Soudan' },
    { code: '+251', country: 'Éthiopie' },
    { code: '+252', country: 'Somalie' },
    { code: '+253', country: 'Djibouti' },
    { code: '+254', country: 'Kenya' },
    { code: '+255', country: 'Tanzanie' },
    { code: '+256', country: 'Ouganda' },
    { code: '+250', country: 'Rwanda' },
    { code: '+257', country: 'Burundi' },
    { code: '+258', country: 'Mozambique' },
    { code: '+260', country: 'Zambie' },
    { code: '+263', country: 'Zimbabwe' },
    { code: '+27',  country: 'Afrique du Sud' },
    { code: '+261', country: 'Madagascar' },
    { code: '+230', country: 'Maurice' },
    { code: '+269', country: 'Comores' },
    { code: '+33',  country: 'France' },
    { code: '+32',  country: 'Belgique' },
    { code: '+41',  country: 'Suisse' },
    { code: '+352', country: 'Luxembourg' },
    { code: '+44',  country: 'Royaume-Uni' },
    { code: '+49',  country: 'Allemagne' },
    { code: '+34',  country: 'Espagne' },
    { code: '+39',  country: 'Italie' },
    { code: '+351', country: 'Portugal' },
    { code: '+31',  country: 'Pays-Bas' },
    { code: '+1',   country: 'USA / Canada' },
    { code: '+55',  country: 'Brésil' },
    { code: '+52',  country: 'Mexique' },
    { code: '+54',  country: 'Argentine' },
    { code: '+7',   country: 'Russie' },
    { code: '+86',  country: 'Chine' },
    { code: '+81',  country: 'Japon' },
    { code: '+91',  country: 'Inde' },
    { code: '+971', country: 'Émirats Arabes Unis' },
    { code: '+966', country: 'Arabie Saoudite' },
    { code: '+212', country: 'Maroc' },
];

const smPhoneError = ref('');

const smMeta     = (name) => smPlatforms.find(p => p.name === name) ?? smPlatforms[smPlatforms.length - 1];
const smColor    = (name) => smMeta(name).color;
const smIcon     = (name) => 'bi ' + smMeta(name).icon;

const showSocialMedia    = ref(false);
const showSmAddForm      = ref(false);
const employeSocialMedias = ref([]);

const newSm = reactive({
    nom_social_media:  'WhatsApp',
    is_mobile:         true,
    code_telephone:    '+227',
    telephone:         '',
    email:             '',
    lien_social_media: '',
});

const currentNewSmMeta = computed(() => smMeta(newSm.nom_social_media));

const onNewSmPlatformChange = () => {
    const meta     = currentNewSmMeta.value;
    newSm.is_mobile         = meta.needsPhone;
    newSm.telephone         = '';
    newSm.email             = '';
    newSm.lien_social_media = '';
};

const addSm = () => {
    smPhoneError.value = '';
    const meta = currentNewSmMeta.value;
    if (meta.needsPhone && newSm.telephone) {
        const digits = newSm.telephone.replace(/\s/g, '');
        if (!/^\d{8}$/.test(digits)) {
            smPhoneError.value = 'Le numéro doit comporter exactement 8 chiffres.';
            return;
        }
    }
    formEmploye.social_medias.push({ ...newSm });
    newSm.nom_social_media  = 'WhatsApp';
    newSm.is_mobile         = true;
    newSm.code_telephone    = '+227';
    newSm.telephone         = '';
    newSm.email             = '';
    newSm.lien_social_media = '';
    showSmAddForm.value = false;
};

const removePendingSm = (idx) => {
    formEmploye.social_medias.splice(idx, 1);
};

const removeExistingSm = (smId) => {
    formEmploye.social_medias_remove.push(smId);
    employeSocialMedias.value = employeSocialMedias.value.filter(sm => sm.id_social_media !== smId);
};

const smContactLabel = (sm) => {
    if (sm.telephone?.telephone) return `${sm.telephone.code_telephone ?? ''} ${sm.telephone.telephone}`.trim();
    if (sm.email?.email)         return sm.email.email;
    if (sm.lien_social_media)    return sm.lien_social_media;
    return '—';
};

// ── Validation client-side ──────────────────────────────────────
const touched = reactive({
    nom_employe:            false,
    profil_employe:         false,
    date_embauche_employe:  false,
    nom_poste:              false,
});
const submitAttempted = ref(false);

const clientErrors = computed(() => {
    const e = {};

    const nom = (formEmploye.nom_employe ?? '').trim();
    if (!nom)
        e.nom_employe = 'Le nom complet est obligatoire.';
    else if (nom.length < 2)
        e.nom_employe = 'Le nom doit comporter au moins 2 caractères.';

    if (!formEmploye.profil_employe)
        e.profil_employe = 'Veuillez choisir un profil.';

    if (!formEmploye.date_embauche_employe)
        e.date_embauche_employe = "La date d'embauche est obligatoire.";
    else if (isNaN(new Date(formEmploye.date_embauche_employe).getTime()))
        e.date_embauche_employe = 'Date invalide.';

    if (showPoste.value && (formEmploye.nom_poste ?? '').trim().length > 0 && formEmploye.nom_poste.trim().length < 2)
        e.nom_poste = 'Le nom du poste doit comporter au moins 2 caractères.';

    return e;
});

const isFormValid         = computed(() => Object.keys(clientErrors.value).length === 0);
const saveButtonTooltip   = computed(() => isFormValid.value ? '' : Object.values(clientErrors.value).join(' · '));
const touch               = (field) => { touched[field] = true; };
const resetTouched   = () => Object.keys(touched).forEach(k => { touched[k] = false; });

// Retourne l'erreur à afficher pour un champ (client ou serveur)
const fieldError = (field) => {
    const show = touched[field] || submitAttempted.value;
    if (show) return clientErrors.value[field] ?? formEmploye.errors[field] ?? null;
    return formEmploye.errors[field] ?? null;
};

const openAdd = () => {
    formEmploye.reset();
    formEmploye.clearErrors();
    resetTouched();
    submitAttempted.value     = false;
    showPoste.value           = false;
    creerCompte.value         = false;
    resetPwd.value            = false;
    showSocialMedia.value     = false;
    showSmAddForm.value       = false;
    employeSocialMedias.value = [];
    isEditing.value           = false;
    dialogEmploye.value       = true;
};

const openEdit = (e) => {
    formEmploye.id_employe            = e.id_employe;
    formEmploye.nom_employe           = e.nom_employe;
    formEmploye.profil_employe        = e.profil_employe ?? "";
    formEmploye.adresse_employe       = e.adresse_employe ?? "";
    formEmploye.date_embauche_employe = e.date_embauche_employe ?? "";
    formEmploye.type_contrat          = e.type_contrat ?? "CDI";
    formEmploye.nom_poste             = e.poste?.nom_poste ?? "";
    formEmploye.id_departement        = e.poste?.id_departement ?? null;
    formEmploye.creer_compte          = false;
    formEmploye.reset_password        = false;
    formEmploye.role_employe          = e.user?.roles?.[0] ?? 'Employé';
    formEmploye.social_medias         = [];
    formEmploye.social_medias_remove  = [];
    formEmploye.clearErrors();
    resetTouched();
    submitAttempted.value     = false;
    showPoste.value           = !!e.poste;
    creerCompte.value         = false;
    resetPwd.value            = false;
    showSocialMedia.value     = false;
    showSmAddForm.value       = false;
    employeSocialMedias.value = e.social_medias ?? [];
    isEditing.value           = true;
    dialogEmploye.value       = true;
};

const saveEmploye = () => {
    submitAttempted.value = true;
    Object.keys(touched).forEach(k => { touched[k] = true; });
    if (!isFormValid.value) return;

    formEmploye.creer_compte   = creerCompte.value;
    formEmploye.reset_password = resetPwd.value;
    if (isEditing.value) {
        formEmploye.put(route("employes.update", formEmploye.id_employe), {
            onSuccess: () => { dialogEmploye.value = false; formEmploye.reset(); },
        });

    } else {
        formEmploye.post(route("employes.store"), {
            onSuccess: () => { dialogEmploye.value = false; formEmploye.reset(); },
        });
    }
};

// ── View ─────────────────────────────────────────────────────────
const dialogView  = shallowRef(false);
const viewEmploye = ref(null);

const openView = (e) => {
    console.log('employees from openView:', employes)
    viewEmploye.value = e;
    dialogView.value  = true;
    console.log('viewEmploye:', viewEmploye)
};

// ── Delete ───────────────────────────────────────────────────────
const dialogDelete    = shallowRef(false);
const deleteTarget    = ref(null);
const deleteProcessing = ref(false);

const openDelete = (e) => {
    deleteTarget.value = e;
    dialogDelete.value = true;
};

const confirmDelete = () => {
    deleteProcessing.value = true;
    router.delete(route("employes.destroy", deleteTarget.value.id_employe), {
        onFinish: () => {
            deleteProcessing.value = false;
            dialogDelete.value     = false;
        },
    });
};

const initials = (nom) => {
    const parts = (nom ?? "").trim().split(/\s+/);
    return parts.length >= 2
        ? parts[0][0].toUpperCase() + parts[1][0].toUpperCase()
        : (parts[0]?.[0] ?? "?").toUpperCase();
};
</script>

<template>
    <Head title="Employés" />
    <AuthenticatedLayout>
        <div class="emp-page">

            <!-- Stats ──────────────────────────────────────────── -->
            <div class="stats-row">
                <div class="stat-chip">
                    <v-icon icon="mdi-account-hard-hat-outline" size="22" class="stat-icon" />
                    <div>
                        <div class="stat-value">{{ employes.length }}</div>
                        <div class="stat-label">Employés</div>
                    </div>
                </div>
                <div class="stat-chip">
                    <v-icon icon="mdi-monitor-account" size="22" class="stat-icon stat-icon--green" />
                    <div>
                        <div class="stat-value">{{ withAccount }}</div>
                        <div class="stat-label">Avec accès plateforme</div>
                    </div>
                </div>
                <div class="stat-chip">
                    <v-icon icon="mdi-briefcase-outline" size="22" class="stat-icon stat-icon--orange" />
                    <div>
                        <div class="stat-value">{{ Object.keys(byProfil).length }}</div>
                        <div class="stat-label">Profils distincts</div>
                    </div>
                </div>
            </div>

            <!-- Table ──────────────────────────────────────────── -->
            <div class="table-card">
                <v-data-table
                    :headers="headers"
                    :items="employes"
                    :search="search"
                    item-value="id_employe"
                    fixed-header
                    height="540"
                    :items-per-page="10"
                    class="emp-table"
                >
                    <!-- Toolbar -->
                    <template #top>
                        <div class="table-toolbar">
                            <div class="toolbar-left">
                                <v-icon icon="mdi-account-group-outline" size="20" class="mr-2" style="color:#f15a2d" />
                                <span class="toolbar-title">Gestion des Employés</span>
                            </div>
                            <div class="toolbar-right">
                                <div class="search-wrapper">
                                    <v-icon icon="mdi-magnify" size="18" class="search-icon" />
                                    <input
                                        v-model="search"
                                        type="text"
                                        placeholder="Rechercher..."
                                        class="search-input"
                                    />
                                    <button v-if="search" class="search-clear" @click="search = ''">
                                        <v-icon icon="mdi-close" size="14" />
                                    </button>
                                </div>
                                <button class="add-btn" @click="openAdd">
                                    <v-icon icon="mdi-account-plus-outline" size="18" class="mr-1" />
                                    <span class="d-none d-sm-inline">Ajouter</span>
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Employé (nom + avatar initiales) -->
                    <template #item.nom_employe="{ item }">
                        <div class="emp-cell">
                            <div class="emp-avatar">{{ initials(item.nom_employe) }}</div>
                            <div>
                                <div class="emp-name">{{ item.nom_employe }}</div>
                                <div v-if="item.adresse_employe" class="emp-address">{{ item.adresse_employe }}</div>
                            </div>
                        </div>
                    </template>

                    <!-- Profil badge -->
                    <template #item.profil_employe="{ item }">
                        <span v-if="item.profil_employe" class="profil-badge" :style="profilStyle(item.profil_employe)">
                            {{ item.profil_employe }}
                        </span>
                        <span v-else class="text-secondary">—</span>
                    </template>

                    <!-- Poste -->
                    <template #item.poste="{ item }">
                        <span class="poste-text">{{ item.poste?.nom_poste || "—" }}</span>
                    </template>

                    <!-- Département -->
                    <template #item.departement="{ item }">
                        <span class="dept-text">{{ item.poste?.departement || "—" }}</span>
                    </template>

                    <!-- Type contrat -->
                    <template #item.type_contrat="{ item }">
                        <span v-if="item.type_contrat" class="contrat-badge" :style="contratStyle(item.type_contrat)">
                            {{ item.type_contrat }}
                        </span>
                        <span v-else class="text-secondary">—</span>
                    </template>

                    <!-- Accès plateforme -->
                    <template #item.user="{ item }">
                        <v-tooltip location="top">
                            <template #activator="{ props: tp }">
                                <div v-bind="tp" class="access-cell">
                                    <span class="access-icon" :class="item.user ? 'access-icon--yes' : 'access-icon--no'">
                                        <v-icon :icon="item.user ? 'mdi-check-circle' : 'mdi-circle-off-outline'" size="16" />
                                    </span>
                                    <span v-if="item.user?.roles?.[0]" class="role-badge">{{ item.user.roles[0] }}</span>
                                </div>
                            </template>
                            <span>{{ item.user ? item.user.email + (item.user.roles?.[0] ? ' · ' + item.user.roles[0] : '') : 'Pas de compte' }}</span>
                        </v-tooltip>
                    </template>

                    <!-- Actions -->
                    <template #item.actions="{ item }">
                        <div class="action-btns">
                            <button class="icon-btn icon-btn--view" title="Voir la fiche" @click="openView(item)">
                                <v-icon icon="mdi-eye-outline" size="16" />
                            </button>
                            <button class="icon-btn icon-btn--edit" title="Modifier" @click="openEdit(item)">
                                <v-icon icon="mdi-pencil-outline" size="16" />
                            </button>
                            <button class="icon-btn icon-btn--delete" title="Supprimer" @click="openDelete(item)">
                                <v-icon icon="mdi-delete-outline" size="16" />
                            </button>
                        </div>
                    </template>

                    <!-- No data -->
                    <template #no-data>
                        <div class="no-data">
                            <v-icon icon="mdi-account-off-outline" size="40" class="mb-2" style="opacity:.3" />
                            <p>Aucun employé trouvé</p>
                            <button class="add-btn mt-3" @click="openAdd">
                                <v-icon icon="mdi-plus" size="16" class="mr-1" />
                                Ajouter le premier employé
                            </button>
                        </div>
                    </template>
                </v-data-table>
            </div>
        </div>

        <!-- ── Dialog : Créer / Modifier employé ─────────────────── -->
        <v-dialog v-model="dialogEmploye" max-width="580" :persistent="formEmploye.processing">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon
                        :icon="isEditing ? 'mdi-account-edit-outline' : 'mdi-account-plus-outline'"
                        size="20" class="mr-2" style="color:#f15a2d"
                    />
                    <h3>{{ isEditing ? "Modifier l'employé" : "Nouvel employé" }}</h3>
                    <button class="modal-close" @click="dialogEmploye = false">
                        <v-icon icon="mdi-close" size="18" />
                    </button>
                </div>

                <div class="modal-body">

                    <!-- ── Section 1 : Informations ─────────────── -->
                    <div class="section-title">
                        <v-icon icon="mdi-card-account-details-outline" size="14" class="mr-1" />
                        Informations
                    </div>

                    <div class="field-group">
                        <label class="field-label">Nom complet <span class="required">*</span></label>
                        <input
                            v-model="formEmploye.nom_employe"
                            type="text"
                            class="field-input"
                            :class="{ 'field-input--error': fieldError('nom_employe') }"
                            placeholder="Ex : Mamane Ibrahim"
                            @blur="touch('nom_employe')"
                        />
                        <span v-if="fieldError('nom_employe')" class="field-error">{{ fieldError('nom_employe') }}</span>
                    </div>

                    <div class="field-row mt-3">
                        <div class="field-group">
                            <label class="field-label">Profil <span class="required">*</span></label>
                            <div class="styled-select-wrapper">
                                <select
                                    v-model="formEmploye.profil_employe"
                                    class="field-input field-select"
                                    :class="{ 'field-input--error': fieldError('profil_employe') }"
                                    @change="touch('profil_employe')"
                                >
                                    <option value="" disabled>Choisir un profil</option>
                                    <option v-for="p in profils" :key="p" :value="p">{{ p }}</option>
                                </select>
                            </div>
                            <span v-if="fieldError('profil_employe')" class="field-error">{{ fieldError('profil_employe') }}</span>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Type de contrat <span class="required">*</span></label>
                            <div class="styled-select-wrapper">
                                <select
                                    v-model="formEmploye.type_contrat"
                                    class="field-input field-select"
                                    :class="{ 'field-input--error': formEmploye.errors.type_contrat }"
                                >
                                    <option v-for="c in contrats" :key="c" :value="c">{{ c }}</option>
                                </select>
                            </div>
                            <span v-if="formEmploye.errors.type_contrat" class="field-error">{{ formEmploye.errors.type_contrat }}</span>
                        </div>
                    </div>

                    <div class="field-row mt-3">
                        <div class="field-group">
                            <label class="field-label">Date d'embauche <span class="required">*</span></label>
                            <input
                                v-model="formEmploye.date_embauche_employe"
                                type="date"
                                class="field-input"
                                :class="{ 'field-input--error': fieldError('date_embauche_employe') }"
                                @blur="touch('date_embauche_employe')"
                            />
                            <span v-if="fieldError('date_embauche_employe')" class="field-error">{{ fieldError('date_embauche_employe') }}</span>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Adresse</label>
                            <input
                                v-model="formEmploye.adresse_employe"
                                type="text"
                                class="field-input"
                                placeholder="Ex : Niamey, Niger"
                            />
                        </div>
                    </div>

                    <!-- ── Section 2 : Poste ────────────────────── -->
                    <div class="section-toggle mt-4" @click="showPoste = !showPoste">
                        <div class="section-title" style="margin:0; cursor:pointer;">
                            <v-icon icon="mdi-briefcase-outline" size="14" class="mr-1" />
                            Affectation (poste &amp; département)
                        </div>
                        <v-icon
                            :icon="showPoste ? 'mdi-chevron-up' : 'mdi-chevron-down'"
                            size="18" style="color:var(--text-secondary)"
                        />
                    </div>

                    <div v-if="showPoste" class="field-row mt-2">
                        <div class="field-group">
                            <label class="field-label">Intitulé du poste</label>
                            <input
                                v-model="formEmploye.nom_poste"
                                type="text"
                                class="field-input"
                                :class="{ 'field-input--error': fieldError('nom_poste') }"
                                placeholder="Ex : Développeur senior"
                                @blur="touch('nom_poste')"
                            />
                            <span v-if="fieldError('nom_poste')" class="field-error">{{ fieldError('nom_poste') }}</span>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Département</label>
                            <div class="styled-select-wrapper">
                                <select v-model="formEmploye.id_departement" class="field-input field-select">
                                    <option :value="null">Aucun</option>
                                    <option
                                        v-for="d in allDepartements"
                                        :key="d.id_departement"
                                        :value="d.id_departement"
                                    >{{ d.nom_departement }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ── Section 3 : Accès plateforme ────────── -->
                    <div class="section-title mt-4">
                        <v-icon icon="mdi-monitor-account" size="14" class="mr-1" />
                        Accès à la plateforme
                    </div>

                    <!-- Déjà un compte (mode édition) -->
                    <template v-if="isEditing && formEmploye.id_employe">
                        <div v-if="allEmployes?.find(e => e.id_employe === formEmploye.id_employe)?.user" class="account-info">
                            <div class="account-info-row">
                                <v-icon icon="mdi-check-circle" size="16" style="color:#059669" class="mr-1" />
                                <span>
                                    Compte actif :
                                    <strong>{{ allEmployes.find(e => e.id_employe === formEmploye.id_employe)?.user?.email }}</strong>
                                </span>
                            </div>
                            <!-- Sélecteur de rôle pour compte existant -->
                            <div class="field-group mt-2">
                                <label class="field-label">
                                    <v-icon icon="mdi-shield-account-outline" size="12" class="mr-1" />
                                    Rôle
                                </label>
                                <div class="styled-select-wrapper">
                                    <select v-model="formEmploye.role_employe" class="field-input field-select">
                                        <option v-for="r in (allRoles ?? [])" :key="r.id" :value="r.name">{{ r.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <label class="toggle-row mt-2">
                                <input type="checkbox" v-model="resetPwd" class="toggle-input" />
                                <span class="toggle-label">Réinitialiser le mot de passe (→ <code>password</code>)</span>
                            </label>
                        </div>
                        <label v-else class="toggle-row">
                            <input type="checkbox" v-model="creerCompte" class="toggle-input" />
                            <span class="toggle-label">Créer un compte plateforme pour cet employé</span>
                        </label>
                    </template>

                    <!-- Nouveau (mode création) -->
                    <template v-else>
                        <label class="toggle-row">
                            <input type="checkbox" v-model="creerCompte" class="toggle-input" />
                            <span class="toggle-label">Créer un compte plateforme pour cet employé</span>
                        </label>
                    </template>

                    <!-- Aperçu email + sélecteur de rôle si toggle actif (création) -->
                    <template v-if="creerCompte">
                        <div class="email-preview mt-2" :class="{ 'email-preview--empty': !emailPreview }">
                            <v-icon icon="mdi-email-outline" size="14" class="mr-1" style="opacity:.6" />
                            {{ emailPreview || "Renseignez d'abord le nom complet" }}
                            <span v-if="emailPreview" class="email-hint">— mot de passe provisoire : <strong>password</strong></span>
                        </div>
                        <div class="field-group mt-2">
                            <label class="field-label">
                                <v-icon icon="mdi-shield-account-outline" size="12" class="mr-1" />
                                Rôle attribué
                            </label>
                            <div class="styled-select-wrapper">
                                <select v-model="formEmploye.role_employe" class="field-input field-select">
                                    <option v-for="r in (allRoles ?? [])" :key="r.id" :value="r.name">{{ r.name }}</option>
                                </select>
                            </div>
                            <span class="role-hint">
                                <v-icon icon="mdi-information-outline" size="11" class="mr-1" />
                                Le rôle détermine les accès de l'employé sur la plateforme.
                            </span>
                        </div>
                    </template>

                    <!-- ── Section 4 : Réseaux Sociaux ───────────── -->
                    <div class="section-toggle mt-4" @click="showSocialMedia = !showSocialMedia">
                        <div class="section-title" style="margin:0; cursor:pointer;">
                            <v-icon icon="mdi-share-variant-outline" size="14" class="mr-1" />
                            Réseaux Sociaux &amp; Contacts
                        </div>
                        <v-icon
                            :icon="showSocialMedia ? 'mdi-chevron-up' : 'mdi-chevron-down'"
                            size="18" style="color:var(--text-secondary)"
                        />
                    </div>

                    <div v-if="showSocialMedia" class="sm-form-section mt-2">

                        <!-- Réseaux existants (mode édition) -->
                        <div v-if="isEditing && employeSocialMedias.length > 0" class="sm-existing-list">
                            <div v-for="sm in employeSocialMedias" :key="sm.id_social_media" class="sm-existing-tag">
                                <i :class="smIcon(sm.nom_social_media)" class="sm-tag-icon-lg" :style="{ color: smColor(sm.nom_social_media) }"></i>
                                <div class="sm-tag-body">
                                    <span class="sm-tag-platform">{{ sm.nom_social_media }}</span>
                                    <div class="sm-tag-contacts">
                                        <span v-if="sm.telephone?.telephone" class="sm-contact-chip">
                                            <i class="bi bi-telephone-fill"></i> {{ sm.telephone.code_telephone }} {{ sm.telephone.telephone }}
                                        </span>
                                        <span v-if="sm.email?.email" class="sm-contact-chip">
                                            <i class="bi bi-envelope-fill"></i> {{ sm.email.email }}
                                        </span>
                                        <span v-if="sm.lien_social_media" class="sm-contact-chip">
                                            <i class="bi bi-link-45deg"></i> {{ sm.lien_social_media }}
                                        </span>
                                        <span v-if="!sm.telephone?.telephone && !sm.email?.email && !sm.lien_social_media" class="sm-contact-chip sm-contact-chip--empty">Aucun contact</span>
                                    </div>
                                </div>
                                <button class="sm-tag-remove-btn" @click="removeExistingSm(sm.id_social_media)" title="Retirer">
                                    <v-icon icon="mdi-close" size="12" />
                                </button>
                            </div>
                        </div>

                        <!-- Réseaux à ajouter (en attente) -->
                        <div v-if="formEmploye.social_medias.length > 0" class="sm-pending-list">
                            <div v-for="(sm, idx) in formEmploye.social_medias" :key="idx" class="sm-pending-tag">
                                <i :class="smIcon(sm.nom_social_media)" class="sm-tag-icon-lg" :style="{ color: smColor(sm.nom_social_media) }"></i>
                                <div class="sm-tag-body">
                                    <span class="sm-tag-platform">{{ sm.nom_social_media }}</span>
                                    <div class="sm-tag-contacts">
                                        <span v-if="sm.telephone" class="sm-contact-chip">
                                            <i class="bi bi-telephone-fill"></i> {{ sm.code_telephone }} {{ sm.telephone }}
                                        </span>
                                        <span v-if="sm.email" class="sm-contact-chip">
                                            <i class="bi bi-envelope-fill"></i> {{ sm.email }}
                                        </span>
                                        <span v-if="sm.lien_social_media" class="sm-contact-chip">
                                            <i class="bi bi-link-45deg"></i> {{ sm.lien_social_media }}
                                        </span>
                                        <span v-if="!sm.telephone && !sm.email && !sm.lien_social_media" class="sm-contact-chip sm-contact-chip--empty">Aucun contact</span>
                                    </div>
                                </div>
                                <button class="sm-tag-remove-btn" @click="removePendingSm(idx)">
                                    <v-icon icon="mdi-close" size="12" />
                                </button>
                            </div>
                        </div>

                        <!-- Formulaire d'ajout inline -->
                        <div v-if="showSmAddForm" class="sm-add-form">
                            <div class="field-group">
                                <label class="field-label">Plateforme</label>
                                <div class="styled-select-wrapper">
                                    <select v-model="newSm.nom_social_media" class="field-input field-select" @change="onNewSmPlatformChange">
                                        <option v-for="p in smPlatforms" :key="p.name" :value="p.name">{{ p.name }}</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Téléphone -->
                            <div v-if="currentNewSmMeta.needsPhone || newSm.is_mobile" class="mt-2">
                                <div class="field-group">
                                    <label class="field-label">Pays</label>
                                    <div class="styled-select-wrapper">
                                        <select v-model="newSm.code_telephone" class="field-input field-select">
                                            <option v-for="c in countryCodes" :key="c.code + c.country" :value="c.code">
                                                {{ c.code }} — {{ c.country }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field-group mt-2">
                                    <label class="field-label">Numéro de téléphone <span class="required">*</span></label>
                                    <input
                                        v-model="newSm.telephone"
                                        type="text"
                                        class="field-input"
                                        :class="{ 'field-input--error': smPhoneError }"
                                        placeholder="Ex : 90000000"
                                        maxlength="8"
                                        @input="smPhoneError = ''"
                                    />
                                    <span v-if="smPhoneError" class="field-error">{{ smPhoneError }}</span>
                                </div>
                            </div>

                            <!-- Email -->
                            <div v-if="currentNewSmMeta.needsEmail" class="field-group mt-2">
                                <label class="field-label">Email</label>
                                <input v-model="newSm.email" type="email" class="field-input" placeholder="exemple@gmail.com" />
                            </div>

                            <!-- Lien -->
                            <div v-if="currentNewSmMeta.needsLink" class="field-group mt-2">
                                <label class="field-label">Lien / URL</label>
                                <input v-model="newSm.lien_social_media" type="text" class="field-input" placeholder="https://..." />
                            </div>

                            <div class="sm-add-actions mt-2">
                                <button type="button" class="btn-sm-cancel" @click="showSmAddForm = false">Annuler</button>
                                <button type="button" class="btn-sm-confirm" @click="addSm">
                                    <v-icon icon="mdi-plus" size="14" class="mr-1" />
                                    Ajouter
                                </button>
                            </div>
                        </div>

                        <!-- Bouton pour afficher le formulaire -->
                        <button v-if="!showSmAddForm" type="button" class="btn-sm-new mt-2" @click="showSmAddForm = true">
                            <v-icon icon="mdi-plus" size="14" class="mr-1" />
                            Ajouter un réseau social
                        </button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogEmploye = false">Annuler</button>
                    <v-tooltip :text="saveButtonTooltip" :disabled="isFormValid" location="top" max-width="300">
                        <template #activator="{ props: tp }">
                            <span v-bind="tp">
                                <button
                                    class="btn-confirm"
                                    :class="{ 'btn-loading': formEmploye.processing }"
                                    :disabled="formEmploye.processing || !isFormValid"
                                    @click="saveEmploye"
                                >
                                    <v-progress-circular v-if="formEmploye.processing" size="14" width="2" indeterminate class="mr-1" />
                                    {{ isEditing ? "Enregistrer" : "Créer" }}
                                </button>
                            </span>
                        </template>
                    </v-tooltip>
                </div>
            </div>
        </v-dialog>

        <!-- ── Dialog : Fiche employé ───────────────────────────────── -->
        <v-dialog v-model="dialogView" max-width="500">
            <div class="modal-card" v-if="viewEmploye">
                <div class="modal-header">
                    <v-icon icon="mdi-account-details-outline" size="20" class="mr-2" style="color:#1b449c" />
                    <h3>Fiche employé</h3>
                    <button class="modal-close" @click="dialogView = false">
                        <v-icon icon="mdi-close" size="18" />
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Identité -->
                    <div class="view-identity">
                        <div class="view-avatar-lg">{{ initials(viewEmploye.nom_employe) }}</div>
                        <div class="view-identity-info">
                            <div class="view-name">{{ viewEmploye.nom_employe }}</div>
                            <span v-if="viewEmploye.profil_employe" class="profil-badge" :style="profilStyle(viewEmploye.profil_employe)">
                                {{ viewEmploye.profil_employe }}
                            </span>
                        </div>
                    </div>

                    <!-- Détails -->
                    <div class="view-details mt-3">
                        <div class="view-detail-row">
                            <span class="view-detail-label">
                                <v-icon icon="mdi-calendar-outline" size="13" class="mr-1" />Embauche
                            </span>
                            <span class="view-detail-value">{{ viewEmploye.date_embauche_employe || '—' }}</span>
                        </div>
                        <div class="view-detail-row">
                            <span class="view-detail-label">
                                <v-icon icon="mdi-file-sign" size="13" class="mr-1" />Contrat
                            </span>
                            <span v-if="viewEmploye.type_contrat" class="contrat-badge" :style="contratStyle(viewEmploye.type_contrat)">
                                {{ viewEmploye.type_contrat }}
                            </span>
                            <span v-else class="view-detail-value">—</span>
                        </div>
                        <div v-if="viewEmploye.adresse_employe" class="view-detail-row">
                            <span class="view-detail-label">
                                <v-icon icon="mdi-map-marker-outline" size="13" class="mr-1" />Adresse
                            </span>
                            <span class="view-detail-value">{{ viewEmploye.adresse_employe }}</span>
                        </div>
                        <div v-if="viewEmploye.poste" class="view-detail-row">
                            <span class="view-detail-label">
                                <v-icon icon="mdi-briefcase-outline" size="13" class="mr-1" />Poste
                            </span>
                            <span class="view-detail-value">{{ viewEmploye.poste.nom_poste }}</span>
                        </div>
                        <div v-if="viewEmploye.poste?.departement" class="view-detail-row">
                            <span class="view-detail-label">
                                <v-icon icon="mdi-domain" size="13" class="mr-1" />Département
                            </span>
                            <span class="view-detail-value">{{ viewEmploye.poste.departement }}</span>
                        </div>
                        <div v-if="viewEmploye.user" class="view-detail-row">
                            <span class="view-detail-label">
                                <v-icon icon="mdi-account-circle-outline" size="13" class="mr-1" />Compte
                            </span>
                            <span class="view-detail-value view-detail-value--green">{{ viewEmploye.user.email }}</span>
                        </div>
                    </div>

                    <!-- Réseaux sociaux -->
                    <div v-if="viewEmploye.social_medias?.length" class="mt-4">
                        <div class="section-title">
                            <v-icon icon="mdi-share-variant-outline" size="14" class="mr-1" />
                            Réseaux &amp; Contacts
                        </div>
                        <div class="view-sm-list">
                            <div v-for="sm in viewEmploye.social_medias" :key="sm.id_social_media" class="view-sm-item">
                                <i :class="smIcon(sm.nom_social_media)" class="view-sm-icon" :style="{ color: smColor(sm.nom_social_media) }"></i>
                                <div class="view-sm-info">
                                    <span class="view-sm-platform">{{ sm.nom_social_media }}</span>
                                    <div class="sm-tag-contacts">
                                        <span v-if="sm.telephone?.telephone" class="sm-contact-chip">
                                            <i class="bi bi-telephone-fill"></i> {{ sm.telephone.code_telephone }} {{ sm.telephone.telephone }}
                                        </span>
                                        <span v-if="sm.email?.email" class="sm-contact-chip">
                                            <i class="bi bi-envelope-fill"></i> {{ sm.email.email }}
                                        </span>
                                        <span v-if="sm.lien_social_media" class="sm-contact-chip">
                                            <i class="bi bi-link-45deg"></i> {{ sm.lien_social_media }}
                                        </span>
                                        <span v-if="!sm.telephone?.telephone && !sm.email?.email && !sm.lien_social_media" class="sm-contact-chip sm-contact-chip--empty">—</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else-if="viewEmploye.social_medias !== undefined" class="view-empty-sm mt-3">
                        <v-icon icon="mdi-share-variant-outline" size="18" class="mr-2" style="opacity:.3" />
                        Aucun réseau social renseigné
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogView = false">Fermer</button>
                    <button class="btn-confirm" @click="dialogView = false; openEdit(viewEmploye)">
                        <v-icon icon="mdi-pencil-outline" size="14" class="mr-1" />
                        Modifier
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ── Dialog : Confirmation suppression ─────────────────── -->
        <v-dialog v-model="dialogDelete" max-width="400">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon icon="mdi-alert-circle-outline" size="20" class="mr-2" style="color:#e74c3c" />
                    <h3>Confirmer la suppression</h3>
                    <button class="modal-close" @click="dialogDelete = false">
                        <v-icon icon="mdi-close" size="18" />
                    </button>
                </div>
                <div class="modal-body">
                    <p class="confirm-text">
                        Voulez-vous vraiment supprimer l'employé
                        <strong>{{ deleteTarget?.nom_employe }}</strong> ?
                        Son poste sera également supprimé.
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogDelete = false">Annuler</button>
                    <button class="btn-danger" :disabled="deleteProcessing" @click="confirmDelete">
                        <v-progress-circular v-if="deleteProcessing" size="14" width="2" indeterminate class="mr-1" />
                        Supprimer
                    </button>
                </div>
            </div>
        </v-dialog>

    </AuthenticatedLayout>
</template>

<style scoped>
.emp-page { padding: 24px; }

/* Stats */
.stats-row {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.stat-chip {
    display: flex;
    align-items: center;
    gap: 12px;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 14px 20px;
    min-width: 160px;
}

.stat-icon { color: #1b449c; }
.stat-icon--green { color: #059669; }
.stat-icon--orange { color: #f15a2d; }
.stat-value { font-size: 22px; font-weight: 700; color: var(--text-primary); line-height: 1.1; }
.stat-label { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }

/* Table */
.table-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    overflow: hidden;
}

:deep(.emp-table),
:deep(.emp-table .v-table),
:deep(.emp-table .v-table__wrapper),
:deep(.emp-table table) {
    background: transparent !important;
    color: var(--text-primary) !important;
}

:deep(.emp-table thead),
:deep(.emp-table thead tr),
:deep(.emp-table .v-data-table__thead tr) { background: var(--dark-bg) !important; }

:deep(.emp-table thead th),
:deep(.emp-table .v-data-table-headers__th) {
    background: var(--dark-bg) !important;
    color: var(--text-secondary) !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.05em !important;
    border-bottom: 1px solid var(--border-color) !important;
}

:deep(.emp-table tbody tr) { border-bottom: 1px solid var(--border-color) !important; transition: background 0.15s; }
:deep(.emp-table tbody tr:hover) { background: var(--card-hover) !important; }
:deep(.emp-table tbody td) { color: var(--text-primary) !important; font-size: 13px !important; padding: 10px 16px !important; }

:deep(.emp-table .v-data-table-footer) {
    background: var(--dark-bg) !important;
    color: var(--text-secondary) !important;
    border-top: 1px solid var(--border-color) !important;
}

/* Toolbar */
.table-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-bottom: 1px solid var(--border-color);
    flex-wrap: wrap;
    gap: 10px;
}

.toolbar-left { display: flex; align-items: center; }
.toolbar-title { font-size: 15px; font-weight: 600; color: var(--text-primary); }
.toolbar-right { display: flex; align-items: center; gap: 10px; }

.search-wrapper { position: relative; display: flex; align-items: center; }
.search-icon { position: absolute; left: 10px; color: var(--text-secondary); }
.search-input {
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 13px;
    padding: 7px 32px 7px 32px;
    width: 200px;
    outline: none;
    transition: border-color 0.2s;
}
.search-input:focus { border-color: #1b449c; }
.search-clear { position: absolute; right: 8px; background: none; border: none; color: var(--text-secondary); cursor: pointer; padding: 0; display: flex; }

.add-btn {
    display: flex;
    align-items: center;
    background: #1b449c;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 14px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    white-space: nowrap;
}
.add-btn:hover { background: #163a86; transform: translateY(-1px); }

/* Employee cell */
.emp-cell { display: flex; align-items: center; gap: 10px; }
.emp-avatar {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1b449c, #f15a2d);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: white;
    flex-shrink: 0;
}
.emp-name { font-size: 13px; font-weight: 500; }
.emp-address { font-size: 11px; color: var(--text-secondary); margin-top: 1px; }

/* Badges */
.profil-badge {
    display: inline-block;
    padding: 3px 9px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.contrat-badge {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

.poste-text { font-size: 12px; color: var(--text-primary); }
.dept-text { font-size: 12px; color: var(--text-secondary); max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; display: block; }

/* Access icon */
.access-cell { display: flex; flex-direction: column; align-items: center; gap: 3px; }
.access-icon { display: flex; align-items: center; justify-content: center; }
.access-icon--yes { color: #059669; }
.access-icon--no { color: #3a3d52; }

.role-badge {
    display: inline-block;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 1px 5px;
    border-radius: 4px;
    background: rgba(27,68,156,.15);
    color: #1b449c;
    white-space: nowrap;
    max-width: 70px;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Action buttons */
.action-btns { display: flex; gap: 6px; justify-content: flex-end; }
.icon-btn {
    width: 30px; height: 30px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 6px;
    border: 1px solid var(--border-color);
    background: none;
    cursor: pointer;
    transition: all 0.15s;
    color: var(--text-secondary);
}
.icon-btn--view:hover   { background: rgba(5,150,105,0.15);  border-color: #059669; color: #059669; }
.icon-btn--edit:hover   { background: rgba(27,68,156,0.15);  border-color: #1b449c; color: #1b449c; }
.icon-btn--delete:hover { background: rgba(231,76,60,0.15);  border-color: #e74c3c; color: #e74c3c; }

/* No data */
.no-data { display: flex; flex-direction: column; align-items: center; padding: 48px 24px; color: var(--text-secondary); }

/* Modal */
.modal-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    overflow: hidden;
}

.modal-header {
    display: flex;
    align-items: center;
    padding: 16px 18px;
    border-bottom: 1px solid var(--border-color);
    gap: 2px;
}

.modal-header h3 { flex: 1; font-size: 15px; font-weight: 600; color: var(--text-primary); margin: 0; }

.modal-close {
    background: none; border: none;
    color: var(--text-secondary); cursor: pointer;
    padding: 4px; border-radius: 6px;
    display: flex; transition: all 0.15s;
    margin-left: auto;
}
.modal-close:hover { background: var(--card-hover); color: var(--text-primary); }

.modal-body { padding: 20px 18px; max-height: 68vh; overflow-y: auto; }
.modal-footer {
    display: flex; justify-content: flex-end;
    gap: 10px; padding: 14px 18px;
    border-top: 1px solid var(--border-color);
}

/* Section headers */
.section-title {
    display: flex;
    align-items: center;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--text-secondary);
    margin-bottom: 12px;
    padding-bottom: 6px;
    border-bottom: 1px solid var(--border-color);
}

.section-toggle {
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
    padding: 8px 0;
    border-top: 1px solid var(--border-color);
    transition: opacity 0.15s;
}
.section-toggle:hover { opacity: 0.8; }

/* Form fields */
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.field-group { display: flex; flex-direction: column; gap: 6px; }

.field-label {
    font-size: 11px;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.required { color: #f15a2d; margin-left: 2px; }

.field-input {
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 13px;
    padding: 9px 12px;
    outline: none;
    transition: border-color 0.2s;
    width: 100%;
}
.field-input:focus { border-color: #1b449c; }
.field-input--error { border-color: #e74c3c !important; }
.field-error { font-size: 11px; color: #e74c3c; }

.styled-select-wrapper { position: relative; }
.field-select {
    appearance: none;
    cursor: pointer;
    padding-right: 28px;
}
.styled-select-wrapper::after {
    content: "▾";
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-secondary);
    pointer-events: none;
    font-size: 12px;
}
.field-select option { background: var(--card-bg); color: var(--text-primary); }

/* Toggle row */
.toggle-row {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    padding: 10px 12px;
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    transition: border-color 0.15s;
}
.toggle-row:hover { border-color: #1b449c; }
.toggle-input { width: 16px; height: 16px; cursor: pointer; accent-color: #1b449c; flex-shrink: 0; }
.toggle-label { font-size: 13px; color: var(--text-secondary); }

/* Account info box */
.account-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 10px 12px;
    background: rgba(5, 150, 105, 0.08);
    border: 1px solid rgba(5, 150, 105, 0.25);
    border-radius: 8px;
    font-size: 13px;
    color: var(--text-secondary);
}
.account-info strong { color: #059669; }

/* Email preview */
.email-preview {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 4px;
    background: rgba(5, 150, 105, 0.07);
    border: 1px dashed rgba(5, 150, 105, 0.3);
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 12px;
    font-family: monospace;
    color: #059669;
}
.email-preview--empty { color: var(--text-secondary); font-family: inherit; border-color: var(--border-color); background: var(--dark-bg); }
.email-hint { font-family: inherit; color: var(--text-secondary); font-size: 11px; }
.email-hint strong { color: var(--text-primary); }

code { background: var(--dark-bg); padding: 1px 5px; border-radius: 4px; font-size: 11px; color: #f15a2d; }

.account-info-row { display: flex; align-items: center; font-size: 13px; color: var(--text-secondary); }
.account-info-row strong { color: #059669; }

.role-hint {
    display: flex;
    align-items: center;
    font-size: 10px;
    color: var(--text-secondary);
    opacity: .7;
    margin-top: 2px;
}

/* Buttons */
.btn-cancel {
    background: none; border: 1px solid var(--border-color);
    border-radius: 8px; color: var(--text-secondary);
    font-size: 13px; font-weight: 600; padding: 9px 18px;
    cursor: pointer; transition: all 0.15s;
}
.btn-cancel:hover { border-color: var(--text-secondary); color: var(--text-primary); }

.btn-confirm {
    display: flex; align-items: center;
    background: #1b449c; color: white;
    border: none; border-radius: 8px;
    font-size: 13px; font-weight: 600;
    padding: 9px 20px; cursor: pointer;
    transition: background 0.15s;
}
.btn-confirm:hover:not(:disabled) { background: #163a86; }
.btn-confirm:disabled { opacity: 0.6; cursor: not-allowed; }

.btn-danger {
    display: flex; align-items: center;
    background: rgba(231,76,60,0.1);
    border: 1px solid rgba(231,76,60,0.3);
    border-radius: 8px; color: #e74c3c;
    font-size: 13px; font-weight: 600;
    padding: 9px 18px; cursor: pointer;
    transition: all 0.15s;
}
.btn-danger:hover:not(:disabled) { background: rgba(231,76,60,0.2); }
.btn-danger:disabled { opacity: 0.6; cursor: not-allowed; }

.confirm-text { color: var(--text-secondary); font-size: 13px; line-height: 1.6; }
.confirm-text strong { color: var(--text-primary); }

.text-secondary { color: var(--text-secondary); }
.mt-2 { margin-top: 8px; }
.mt-3 { margin-top: 12px; }
.mt-4 { margin-top: 20px; }
.me-1 { margin-right: 4px; }

/* Section réseaux sociaux */
.sm-form-section {
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 12px;
    background: var(--dark-bg);
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.sm-existing-list,
.sm-pending-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.sm-existing-tag,
.sm-pending-tag {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 8px 10px;
    border-radius: 8px;
    font-size: 12px;
}

.sm-existing-tag {
    background: rgba(27,68,156,.08);
    border: 1px solid rgba(27,68,156,.2);
}

.sm-pending-tag {
    background: rgba(5,150,105,.08);
    border: 1px solid rgba(5,150,105,.2);
}

.sm-tag-icon-lg {
    font-size: 16px;
    flex-shrink: 0;
    margin-top: 1px;
}

.sm-tag-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
    min-width: 0;
}

.sm-tag-platform {
    font-weight: 600;
    font-size: 12px;
    color: var(--text-primary);
}

.sm-tag-contacts {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

.sm-contact-chip {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 10px;
    color: var(--text-secondary);
    background: rgba(255,255,255,.05);
    border: 1px solid var(--border-color);
    border-radius: 4px;
    padding: 2px 6px;
}

.sm-contact-chip i { font-size: 9px; }
.sm-contact-chip--empty { opacity: .4; font-style: italic; }

.sm-tag-remove-btn {
    background: none; border: none;
    color: var(--text-secondary); cursor: pointer;
    padding: 0; display: flex; margin-left: auto;
    transition: color .15s;
}
.sm-tag-remove-btn:hover { color: #e74c3c; }

.sm-add-form {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 12px;
}

.sm-add-actions {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
}

.btn-sm-cancel {
    background: none; border: 1px solid var(--border-color);
    border-radius: 6px; color: var(--text-secondary);
    font-size: 12px; font-weight: 600; padding: 6px 12px;
    cursor: pointer; transition: all .15s;
}
.btn-sm-cancel:hover { border-color: var(--text-secondary); color: var(--text-primary); }

.btn-sm-confirm {
    display: flex; align-items: center;
    background: #059669; color: white; border: none;
    border-radius: 6px; font-size: 12px; font-weight: 600;
    padding: 6px 12px; cursor: pointer; transition: background .15s;
}
.btn-sm-confirm:hover { background: #047857; }

.btn-sm-new {
    display: inline-flex; align-items: center;
    background: none;
    border: 1px dashed rgba(27,68,156,.5);
    border-radius: 6px; color: #1b449c;
    font-size: 12px; font-weight: 600; padding: 6px 12px;
    cursor: pointer; transition: all .15s; width: 100%;
    justify-content: center;
}
.btn-sm-new:hover { background: rgba(27,68,156,.08); border-color: #1b449c; }

/* ── Fiche employé (vue) ────────────────────────────────────── */
.view-identity {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 10px;
}

.view-avatar-lg {
    width: 54px; height: 54px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1b449c, #f15a2d);
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; font-weight: 700; color: white;
    flex-shrink: 0;
}

.view-identity-info { display: flex; flex-direction: column; gap: 6px; }
.view-name { font-size: 16px; font-weight: 700; color: var(--text-primary); }

.view-details {
    display: flex;
    flex-direction: column;
    gap: 1px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    overflow: hidden;
}

.view-detail-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 14px;
    background: var(--dark-bg);
    border-bottom: 1px solid var(--border-color);
    gap: 12px;
}
.view-detail-row:last-child { border-bottom: none; }

.view-detail-label {
    display: flex; align-items: center;
    font-size: 11px; font-weight: 600;
    text-transform: uppercase; letter-spacing: 0.04em;
    color: var(--text-secondary);
    white-space: nowrap;
}

.view-detail-value {
    font-size: 13px;
    color: var(--text-primary);
    text-align: right;
}
.view-detail-value--green { color: #059669; }

.view-sm-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.view-sm-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
}

.view-sm-icon { font-size: 16px; flex-shrink: 0; }

.view-sm-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 0;
}

.view-sm-platform {
    font-size: 12px; font-weight: 600;
    color: var(--text-primary);
}

.view-sm-contact {
    font-size: 11px;
    color: var(--text-secondary);
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}

.view-empty-sm {
    display: flex; align-items: center;
    font-size: 12px; color: var(--text-secondary);
    padding: 10px 0;
}

@media (max-width: 600px) {
    .emp-page { padding: 16px; }
    .field-row { grid-template-columns: 1fr; }
    .search-input { width: 140px; }
}
</style>
