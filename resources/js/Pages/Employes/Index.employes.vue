<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { computed, ref, shallowRef } from "vue";
import { useDisplay } from "vuetify";

const props = defineProps({
    allEmployes: Array,
    allDepartements: Array,
    errors: Object,
});
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
});

const openAdd = () => {
    formEmploye.reset();
    formEmploye.clearErrors();
    showPoste.value   = false;
    creerCompte.value = false;
    resetPwd.value    = false;
    isEditing.value   = false;
    dialogEmploye.value = true;
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
    formEmploye.clearErrors();
    showPoste.value   = !!e.poste;
    creerCompte.value = false;
    resetPwd.value    = false;
    isEditing.value   = true;
    dialogEmploye.value = true;
};

const saveEmploye = () => {
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
                        <v-tooltip :text="item.user ? item.user.email : 'Pas de compte'" location="top">
                            <template #activator="{ props: tp }">
                                <span v-bind="tp" class="access-icon" :class="item.user ? 'access-icon--yes' : 'access-icon--no'">
                                    <v-icon :icon="item.user ? 'mdi-check-circle' : 'mdi-circle-off-outline'" size="18" />
                                </span>
                            </template>
                        </v-tooltip>
                    </template>

                    <!-- Actions -->
                    <template #item.actions="{ item }">
                        <div class="action-btns">
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
                            :class="{ 'field-input--error': formEmploye.errors.nom_employe }"
                            placeholder="Ex : Mamane Ibrahim"
                        />
                        <span v-if="formEmploye.errors.nom_employe" class="field-error">{{ formEmploye.errors.nom_employe }}</span>
                    </div>

                    <div class="field-row mt-3">
                        <div class="field-group">
                            <label class="field-label">Profil <span class="required">*</span></label>
                            <div class="styled-select-wrapper">
                                <select
                                    v-model="formEmploye.profil_employe"
                                    class="field-input field-select"
                                    :class="{ 'field-input--error': formEmploye.errors.profil_employe }"
                                >
                                    <option value="" disabled>Choisir un profil</option>
                                    <option v-for="p in profils" :key="p" :value="p">{{ p }}</option>
                                </select>
                            </div>
                            <span v-if="formEmploye.errors.profil_employe" class="field-error">{{ formEmploye.errors.profil_employe }}</span>
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
                                :class="{ 'field-input--error': formEmploye.errors.date_embauche_employe }"
                            />
                            <span v-if="formEmploye.errors.date_embauche_employe" class="field-error">{{ formEmploye.errors.date_embauche_employe }}</span>
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
                                :class="{ 'field-input--error': formEmploye.errors.nom_poste }"
                                placeholder="Ex : Développeur senior"
                            />
                            <span v-if="formEmploye.errors.nom_poste" class="field-error">{{ formEmploye.errors.nom_poste }}</span>
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
                            <v-icon icon="mdi-check-circle" size="16" style="color:#059669" class="mr-1" />
                            <span>
                                Compte actif :
                                <strong>{{ allEmployes.find(e => e.id_employe === formEmploye.id_employe)?.user?.email }}</strong>
                            </span>
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

                    <!-- Aperçu email si toggle actif -->
                    <div v-if="creerCompte" class="email-preview mt-2" :class="{ 'email-preview--empty': !emailPreview }">
                        <v-icon icon="mdi-email-outline" size="14" class="mr-1" style="opacity:.6" />
                        {{ emailPreview || "Renseignez d'abord le nom complet" }}
                        <span v-if="emailPreview" class="email-hint">— mot de passe provisoire : <strong>password</strong></span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogEmploye = false">Annuler</button>
                    <button
                        class="btn-confirm"
                        :class="{ 'btn-loading': formEmploye.processing }"
                        :disabled="formEmploye.processing"
                        @click="saveEmploye"
                    >
                        <v-progress-circular v-if="formEmploye.processing" size="14" width="2" indeterminate class="mr-1" />
                        {{ isEditing ? "Enregistrer" : "Créer" }}
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
.access-icon { display: flex; align-items: center; justify-content: center; }
.access-icon--yes { color: #059669; }
.access-icon--no { color: #3a3d52; }

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
.icon-btn--edit:hover { background: rgba(27,68,156,0.15); border-color: #1b449c; color: #1b449c; }
.icon-btn--delete:hover { background: rgba(231,76,60,0.15); border-color: #e74c3c; color: #e74c3c; }

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

@media (max-width: 600px) {
    .emp-page { padding: 16px; }
    .field-row { grid-template-columns: 1fr; }
    .search-input { width: 140px; }
}
</style>
