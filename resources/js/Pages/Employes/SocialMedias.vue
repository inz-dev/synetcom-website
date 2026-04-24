<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { computed, ref, shallowRef } from "vue";

const props = defineProps({
    allSocialMedias: Array,
    allEmployes: Array,
    errors: Object,
});

// ── Plateformes disponibles ─────────────────────────────────────
const platforms = [
    { name: 'Mobile',      icon: 'bi-share-fill',   color: '#6b7280', needsPhone: true,  needsEmail: false,  needsLink: false  },
    { name: 'WhatsApp',    icon: 'bi-whatsapp',     color: '#25d366', needsPhone: true,  needsEmail: false, needsLink: false },
    { name: 'LinkedIn',    icon: 'bi-linkedin',     color: '#0077b5', needsPhone: false, needsEmail: false, needsLink: true  },
    { name: 'Gmail',       icon: 'bi-envelope-fill',color: '#ea4335', needsPhone: false, needsEmail: true,  needsLink: false },
    { name: 'Yahoo',       icon: 'bi-envelope-fill',color: '#6001d2', needsPhone: false, needsEmail: true,  needsLink: false },
    { name: 'Facebook',    icon: 'bi-facebook',     color: '#1877f2', needsPhone: false, needsEmail: false, needsLink: true  },
    { name: 'Twitter / X', icon: 'bi-twitter-x',   color: '#000000', needsPhone: false, needsEmail: false, needsLink: true  },
    { name: 'Instagram',   icon: 'bi-instagram',   color: '#e1306c', needsPhone: false, needsEmail: false, needsLink: true  },
    { name: 'Autre',       icon: 'bi-share-fill',   color: '#6b7280', needsPhone: true,  needsEmail: true,  needsLink: true  },
];

const platformMeta = (name) => platforms.find(p => p.name === name) ?? platforms[platforms.length - 1];

// ── Stats ────────────────────────────────────────────────────────
const socialMedias = computed(() => props.allSocialMedias ?? []);

const withPhone  = computed(() => socialMedias.value.filter(sm => sm.telephone).length);
const withEmail  = computed(() => socialMedias.value.filter(sm => sm.email).length);
const assigned   = computed(() => socialMedias.value.filter(sm => sm.employes?.length > 0).length);

// ── Recherche ────────────────────────────────────────────────────
const search = ref('');
const filtered = computed(() => {
    const q = search.value.toLowerCase();
    if (!q) return socialMedias.value;
    return socialMedias.value.filter(sm =>
        sm.nom_social_media?.toLowerCase().includes(q) ||
        sm.telephone?.telephone?.toLowerCase().includes(q) ||
        sm.email?.email?.toLowerCase().includes(q) ||
        sm.lien_social_media?.toLowerCase().includes(q) ||
        sm.employes?.some(e => e.nom_employe.toLowerCase().includes(q))
    );
});

// ── Formulaire CRUD ──────────────────────────────────────────────
const dialogSm    = shallowRef(false);
const isEditing   = ref(false);

const formSm = useForm({
    id_social_media:   null,
    nom_social_media:  'WhatsApp',
    lien_social_media: '',
    is_mobile:         true,
    code_telephone:    '+227',
    telephone:         '',
    email:             '',
});

const currentPlatform = computed(() => platformMeta(formSm.nom_social_media));

const onPlatformChange = () => {
    const meta = currentPlatform.value;
    formSm.is_mobile   = meta.needsPhone;
    formSm.telephone   = '';
    formSm.email       = '';
    formSm.lien_social_media = '';
};
onMounted(() => {
    console.log('socialMedias:', socialMedias)
})
const openAdd = () => {
    formSm.reset();
    formSm.nom_social_media = 'WhatsApp';
    formSm.is_mobile        = true;
    formSm.code_telephone   = '+227';
    formSm.clearErrors();
    isEditing.value   = false;
    dialogSm.value    = true;
};

const openEdit = (sm) => {
    formSm.id_social_media   = sm.id_social_media;
    formSm.nom_social_media  = sm.nom_social_media ?? 'Autre';
    formSm.lien_social_media = sm.lien_social_media ?? '';
    formSm.is_mobile         = !!sm.is_mobile;
    formSm.code_telephone    = sm.telephone?.code_telephone ?? '+227';
    formSm.telephone         = sm.telephone?.telephone ?? '';
    formSm.email             = sm.email?.email ?? '';
    formSm.clearErrors();
    isEditing.value  = true;
    dialogSm.value   = true;
    console.log('sm from openEdit:', sm)
};

const saveSm = () => {
    if (isEditing.value) {
        formSm.put(route('social-medias.update', formSm.id_social_media), {
            onSuccess: () => { dialogSm.value = false; formSm.reset(); },
        });
    } else {
        formSm.post(route('social-medias.store'), {
            onSuccess: () => { dialogSm.value = false; formSm.reset(); },
        });
    }
    console.log('formSm from saveSm',formSm)
};

// ── Suppression ──────────────────────────────────────────────────
const dialogDelete     = shallowRef(false);
const deleteTarget     = ref(null);
const deleteProcessing = ref(false);

const openDelete = (sm) => {
    deleteTarget.value  = sm;
    dialogDelete.value  = true;
};

const confirmDelete = () => {
    deleteProcessing.value = true;
    router.delete(route('social-medias.destroy', deleteTarget.value.id_social_media), {
        onFinish: () => {
            deleteProcessing.value = false;
            dialogDelete.value     = false;
        },
    });
};

// ── Attribution à un employé ─────────────────────────────────────
const dialogAssign    = shallowRef(false);
const assignTarget    = ref(null);
const assignEmployeId = ref('');

const openAssign = (sm) => {
    assignTarget.value    = sm;
    assignEmployeId.value = '';
    dialogAssign.value    = true;
};

const availableEmployes = computed(() => {
    if (!assignTarget.value) return props.allEmployes ?? [];
    const assignedIds = (assignTarget.value.employes ?? []).map(e => e.id_employe);
    return (props.allEmployes ?? []).filter(e => !assignedIds.includes(e.id_employe));
});

const formAssign = useForm({ id_employe: '', id_social_media: '' });

const confirmAssign = () => {
    if (!assignEmployeId.value) return;
    formAssign.id_employe      = assignEmployeId.value;
    formAssign.id_social_media = assignTarget.value.id_social_media;
    formAssign.post(route('social-medias.assign'), {
        onSuccess: () => { dialogAssign.value = false; },
    });
};

const formRemove = useForm({ id_employe: '', id_social_media: '' });

const removeAssignment = (sm, employeId) => {
    formRemove.id_employe      = employeId;
    formRemove.id_social_media = sm.id_social_media;
    formRemove.post(route('social-medias.remove'));
};

// ── Utilitaires ──────────────────────────────────────────────────
const initials = (nom) => {
    const parts = (nom ?? '').trim().split(/\s+/);
    return parts.length >= 2
        ? parts[0][0].toUpperCase() + parts[1][0].toUpperCase()
        : (parts[0]?.[0] ?? '?').toUpperCase();
};
</script>

<template>
    <Head title="Réseaux Sociaux" />
    <AuthenticatedLayout>
        <div class="sm-page">

            <!-- En-tête ─────────────────────────────────────────── -->
            <div class="page-header-row">
                <div>
                    <h2 class="page-title">
                        <i class="bi bi-share-fill me-2" style="color:#f15a2d"></i>
                        Réseaux Sociaux
                    </h2>
                    <p class="page-subtitle">Gérez les contacts et plateformes des employés</p>
                </div>
                <button class="add-btn" @click="openAdd">
                    <i class="bi bi-plus-lg me-1"></i>
                    Ajouter
                </button>
            </div>

            <!-- Stats ──────────────────────────────────────────── -->
            <div class="stats-row">
                <div class="stat-chip">
                    <i class="bi bi-share stat-icon"></i>
                    <div>
                        <div class="stat-value">{{ socialMedias.length }}</div>
                        <div class="stat-label">Total réseaux</div>
                    </div>
                </div>
                <div class="stat-chip">
                    <i class="bi bi-telephone-fill stat-icon stat-icon--green"></i>
                    <div>
                        <div class="stat-value">{{ withPhone }}</div>
                        <div class="stat-label">Avec téléphone</div>
                    </div>
                </div>
                <div class="stat-chip">
                    <i class="bi bi-envelope-fill stat-icon stat-icon--blue"></i>
                    <div>
                        <div class="stat-value">{{ withEmail }}</div>
                        <div class="stat-label">Avec email</div>
                    </div>
                </div>
                <div class="stat-chip">
                    <i class="bi bi-person-check-fill stat-icon stat-icon--orange"></i>
                    <div>
                        <div class="stat-value">{{ assigned }}</div>
                        <div class="stat-label">Attribués</div>
                    </div>
                </div>
            </div>

            <!-- Tableau ────────────────────────────────────────── -->
            <div class="table-card">
                <!-- Barre d'outils -->
                <div class="table-toolbar">
                    <div class="toolbar-left">
                        <i class="bi bi-share-fill me-2" style="color:#f15a2d"></i>
                        <span class="toolbar-title">Liste des réseaux sociaux</span>
                    </div>
                    <div class="toolbar-right">
                        <div class="search-wrapper">
                            <i class="bi bi-search search-icon"></i>
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Rechercher..."
                                class="search-input"
                            />
                            <button v-if="search" class="search-clear" @click="search = ''">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tableau responsive -->
                <div class="table-responsive">
                    <table class="sm-table">
                        <thead>
                            <tr>
                                <th>Plateforme</th>
                                <th>Type</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Lien</th>
                                <th>Employés associés</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="filtered.length === 0">
                                <td colspan="7" class="empty-row">
                                    <i class="bi bi-share" style="font-size:32px;opacity:.3"></i>
                                    <p>Aucun réseau social trouvé</p>
                                    <button class="add-btn mt-2" @click="openAdd">
                                        <i class="bi bi-plus-lg me-1"></i>Ajouter le premier
                                    </button>
                                </td>
                            </tr>
                            <tr v-for="sm in filtered" :key="sm.id_social_media">
                                <!-- Plateforme -->
                                <td>
                                    <div class="platform-cell">
                                        <span class="platform-icon" :style="{ background: platformMeta(sm.nom_social_media).color + '22', color: platformMeta(sm.nom_social_media).color }">
                                            <i :class="'bi ' + platformMeta(sm.nom_social_media).icon"></i>
                                        </span>
                                        <span class="platform-name">{{ sm.nom_social_media }}</span>
                                    </div>
                                </td>
                                <!-- Type -->
                                <td>
                                    <span class="type-badge" :class="sm.is_mobile ? 'badge-mobile' : 'badge-web'">
                                        <i :class="sm.is_mobile ? 'bi bi-phone-fill' : 'bi bi-globe2'" class="me-1"></i>
                                        {{ sm.is_mobile ? 'Mobile' : 'Web' }}
                                    </span>
                                </td>
                                <!-- Téléphone -->
                                <td>
                                    <span v-if="sm.telephone" class="contact-val">
                                        <i class="bi bi-telephone-fill me-1" style="color:#059669;font-size:11px"></i>
                                        {{ sm.telephone.code_telephone }} {{ sm.telephone.telephone }}
                                    </span>
                                    <span v-else class="text-muted">—</span>
                                </td>
                                <!-- Email -->
                                <td>
                                    <span v-if="sm.email" class="contact-val">
                                        <i class="bi bi-envelope-fill me-1" style="color:#1b449c;font-size:11px"></i>
                                        {{ sm.email.email }}
                                    </span>
                                    <span v-else class="text-muted">—</span>
                                </td>
                                <!-- Lien -->
                                <td>
                                    <a v-if="sm.lien_social_media" :href="sm.lien_social_media" target="_blank" class="link-val">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>
                                        {{ sm.lien_social_media.length > 30 ? sm.lien_social_media.slice(0,30)+'…' : sm.lien_social_media }}
                                    </a>
                                    <span v-else class="text-muted">—</span>
                                </td>
                                <!-- Employés -->
                                <td>
                                    <div class="employes-cell">
                                        <div v-for="e in (sm.employes ?? []).slice(0,3)" :key="e.id_employe" class="emp-tag">
                                            <span class="emp-tag-avatar">{{ initials(e.nom_employe) }}</span>
                                            <span class="emp-tag-name">{{ e.nom_employe }}</span>
                                            <button class="emp-tag-remove" @click="removeAssignment(sm, e.id_employe)" title="Retirer">
                                                <i class="bi bi-x"></i>
                                            </button>
                                        </div>
                                        <span v-if="(sm.employes ?? []).length > 3" class="emp-more">+{{ sm.employes.length - 3 }}</span>
                                        <button v-if="availableEmployes.length > 0 || (sm.employes?.length === 0)" class="btn-assign" @click="openAssign(sm)" title="Attribuer à un employé">
                                            <i class="bi bi-person-plus-fill"></i>
                                        </button>
                                    </div>
                                </td>
                                <!-- Actions -->
                                <td>
                                    <div class="action-btns">
                                        <button class="icon-btn icon-btn--edit" title="Modifier" @click="openEdit(sm)">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <button class="icon-btn icon-btn--delete" title="Supprimer" @click="openDelete(sm)">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ── Dialog : Créer / Modifier réseau social ───────────── -->
        <v-dialog v-model="dialogSm" max-width="520" :persistent="formSm.processing">
            <div class="modal-card">
                <div class="modal-header">
                    <i :class="isEditing ? 'bi bi-pencil-square' : 'bi bi-plus-circle-fill'" style="color:#f15a2d;font-size:18px"></i>
                    <h3>{{ isEditing ? 'Modifier le réseau social' : 'Nouveau réseau social' }}</h3>
                    <button class="modal-close" @click="dialogSm = false"><i class="bi bi-x-lg"></i></button>
                </div>

                <div class="modal-body">
                    <!-- Plateforme -->
                    <div class="field-group">
                        <label class="field-label">Plateforme <span class="required">*</span></label>
                        <div class="styled-select-wrapper">
                            <select v-model="formSm.nom_social_media" class="field-input field-select" @change="onPlatformChange">
                                <option v-for="p in platforms" :key="p.name" :value="p.name">{{ p.name }}</option>
                            </select>
                        </div>
                        <span v-if="formSm.errors.nom_social_media" class="field-error">{{ formSm.errors.nom_social_media }}</span>
                    </div>

                    <!-- Aperçu plateforme + toggle mobile -->
                    <div class="platform-preview mt-3">
                        <span class="platform-icon lg" :style="{ background: currentPlatform.color + '22', color: currentPlatform.color }">
                            <i :class="'bi ' + currentPlatform.icon"></i>
                        </span>
                        <label class="toggle-row flex-grow">
                            <input type="checkbox" v-model="formSm.is_mobile" class="toggle-input" />
                            <span class="toggle-label">Plateforme mobile (téléphone)</span>
                        </label>
                    </div>

                    <!-- Téléphone -->
                    <div v-if="currentPlatform.needsPhone || formSm.is_mobile" class="field-row mt-3">
                        <div class="field-group" style="max-width:100px">
                            <label class="field-label">Code</label>
                            <input v-model="formSm.code_telephone" type="text" class="field-input" placeholder="+227" />
                        </div>
                        <div class="field-group">
                            <label class="field-label">Numéro de téléphone</label>
                            <input v-model="formSm.telephone" type="text" class="field-input" placeholder="90 00 00 00" />
                            <span v-if="formSm.errors.telephone" class="field-error">{{ formSm.errors.telephone }}</span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div v-if="currentPlatform.needsEmail || (!currentPlatform.needsPhone && !currentPlatform.needsLink)" class="field-group mt-3">
                        <label class="field-label">Adresse email</label>
                        <input v-model="formSm.email" type="email" class="field-input" placeholder="exemple@gmail.com" />
                        <span v-if="formSm.errors.email" class="field-error">{{ formSm.errors.email }}</span>
                    </div>

                    <!-- Lien URL -->
                    <div v-if="currentPlatform.needsLink" class="field-group mt-3">
                        <label class="field-label">Lien / URL du profil</label>
                        <input v-model="formSm.lien_social_media" type="text" class="field-input" placeholder="https://..." />
                        <span v-if="formSm.errors.lien_social_media" class="field-error">{{ formSm.errors.lien_social_media }}</span>
                    </div>

                    <!-- Autre : tous les champs -->
                    <template v-if="formSm.nom_social_media === 'Autre'">
                        <div v-if="!formSm.is_mobile" class="field-group mt-3">
                            <label class="field-label">Email (optionnel)</label>
                            <input v-model="formSm.email" type="email" class="field-input" placeholder="exemple@domaine.com" />
                        </div>
                        <div class="field-group mt-3">
                            <label class="field-label">Lien (optionnel)</label>
                            <input v-model="formSm.lien_social_media" type="text" class="field-input" placeholder="https://..." />
                        </div>
                    </template>
                </div>

                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogSm = false">Annuler</button>
                    <button class="btn-confirm" :disabled="formSm.processing" @click="saveSm">
                        <v-progress-circular v-if="formSm.processing" size="14" width="2" indeterminate class="mr-1" />
                        {{ isEditing ? 'Enregistrer' : 'Créer' }}
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ── Dialog : Attribuer à un employé ───────────────────── -->
        <v-dialog v-model="dialogAssign" max-width="400">
            <div class="modal-card">
                <div class="modal-header">
                    <i class="bi bi-person-plus-fill" style="color:#1b449c;font-size:18px"></i>
                    <h3>Attribuer à un employé</h3>
                    <button class="modal-close" @click="dialogAssign = false"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="modal-body">
                    <p class="confirm-text mb-3">
                        Choisissez un employé pour associer
                        <strong>{{ assignTarget?.nom_social_media }}</strong>
                        ({{ assignTarget?.telephone?.telephone || assignTarget?.email?.email || assignTarget?.lien_social_media }})
                    </p>
                    <div class="field-group">
                        <label class="field-label">Employé</label>
                        <div class="styled-select-wrapper">
                            <select v-model="assignEmployeId" class="field-input field-select">
                                <option value="" disabled>Choisir un employé</option>
                                <option v-for="e in availableEmployes" :key="e.id_employe" :value="e.id_employe">
                                    {{ e.nom_employe }}
                                </option>
                            </select>
                        </div>
                        <p v-if="availableEmployes.length === 0" class="field-error mt-1">
                            Tous les employés ont déjà ce réseau social.
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogAssign = false">Annuler</button>
                    <button class="btn-confirm" :disabled="!assignEmployeId || formAssign.processing" @click="confirmAssign">
                        <v-progress-circular v-if="formAssign.processing" size="14" width="2" indeterminate class="mr-1" />
                        Attribuer
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ── Dialog : Confirmation suppression ─────────────────── -->
        <v-dialog v-model="dialogDelete" max-width="400">
            <div class="modal-card">
                <div class="modal-header">
                    <i class="bi bi-exclamation-triangle-fill" style="color:#e74c3c;font-size:18px"></i>
                    <h3>Confirmer la suppression</h3>
                    <button class="modal-close" @click="dialogDelete = false"><i class="bi bi-x-lg"></i></button>
                </div>
                <div class="modal-body">
                    <p class="confirm-text">
                        Voulez-vous supprimer le réseau social
                        <strong>{{ deleteTarget?.nom_social_media }}</strong> ?
                        Il sera retiré de tous les employés associés.
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
.sm-page { padding: 24px; }

/* En-tête */
.page-header-row {
    display: flex; align-items: flex-start; justify-content: space-between;
    flex-wrap: wrap; gap: 16px; margin-bottom: 24px;
}
.page-title { font-size: 22px; font-weight: 700; color: var(--text-primary); margin: 0; }
.page-subtitle { font-size: 13px; color: var(--text-secondary); margin: 4px 0 0; }

/* Stats */
.stats-row { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 24px; }
.stat-chip {
    display: flex; align-items: center; gap: 12px;
    background: var(--card-bg); border: 1px solid var(--border-color);
    border-radius: 12px; padding: 14px 20px; min-width: 150px;
}
.stat-icon { font-size: 20px; color: #1b449c; }
.stat-icon--green { color: #059669; }
.stat-icon--blue  { color: #1b449c; }
.stat-icon--orange{ color: #f15a2d; }
.stat-value { font-size: 22px; font-weight: 700; color: var(--text-primary); line-height: 1.1; }
.stat-label { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }

/* Table */
.table-card {
    background: var(--card-bg); border: 1px solid var(--border-color);
    border-radius: 14px; overflow: hidden;
}
.table-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px; border-bottom: 1px solid var(--border-color); flex-wrap: wrap; gap: 10px;
}
.toolbar-left  { display: flex; align-items: center; }
.toolbar-title { font-size: 15px; font-weight: 600; color: var(--text-primary); }
.toolbar-right { display: flex; align-items: center; gap: 10px; }

.search-wrapper { position: relative; display: flex; align-items: center; }
.search-icon { position: absolute; left: 10px; color: var(--text-secondary); font-size: 14px; }
.search-input {
    background: var(--dark-bg); border: 1px solid var(--border-color);
    border-radius: 8px; color: var(--text-primary); font-size: 13px;
    padding: 7px 32px 7px 32px; width: 220px; outline: none; transition: border-color .2s;
}
.search-input:focus { border-color: #1b449c; }
.search-clear { position: absolute; right: 8px; background: none; border: none; color: var(--text-secondary); cursor: pointer; padding: 0; display: flex; font-size: 16px; }

.sm-table { width: 100%; border-collapse: collapse; font-size: 13px; }
.sm-table thead th {
    background: var(--dark-bg); color: var(--text-secondary);
    font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em;
    padding: 10px 16px; border-bottom: 1px solid var(--border-color); white-space: nowrap;
}
.sm-table tbody tr { border-bottom: 1px solid var(--border-color); transition: background .15s; }
.sm-table tbody tr:hover { background: var(--card-hover); }
.sm-table tbody td { padding: 12px 16px; color: var(--text-primary); vertical-align: middle; }

.empty-row { text-align: center; padding: 48px 24px !important; color: var(--text-secondary); }
.empty-row p { margin: 8px 0 0; }

/* Plateforme */
.platform-cell { display: flex; align-items: center; gap: 10px; }
.platform-icon {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.platform-icon.lg { width: 40px; height: 40px; border-radius: 10px; font-size: 20px; }
.platform-name { font-weight: 600; }

/* Type badge */
.type-badge {
    display: inline-flex; align-items: center;
    padding: 3px 9px; border-radius: 20px;
    font-size: 11px; font-weight: 600;
}
.badge-mobile { background: rgba(37,211,102,.15); color: #25d366; }
.badge-web    { background: rgba(27,68,156,.15);  color: #1b449c; }

/* Contact */
.contact-val { font-size: 12px; color: var(--text-primary); }
.text-muted  { color: var(--text-secondary); font-size: 12px; }
.link-val    { font-size: 12px; color: #1b449c; text-decoration: none; }
.link-val:hover { text-decoration: underline; }

/* Employés associés */
.employes-cell { display: flex; flex-wrap: wrap; gap: 4px; align-items: center; }
.emp-tag {
    display: inline-flex; align-items: center; gap: 4px;
    background: rgba(27,68,156,.12); border: 1px solid rgba(27,68,156,.25);
    border-radius: 20px; padding: 2px 6px 2px 4px; font-size: 11px;
}
.emp-tag-avatar {
    width: 18px; height: 18px; border-radius: 50%;
    background: linear-gradient(135deg,#1b449c,#f15a2d);
    display: flex; align-items: center; justify-content: center;
    font-size: 8px; font-weight: 700; color: white; flex-shrink: 0;
}
.emp-tag-name  { color: var(--text-primary); white-space: nowrap; }
.emp-tag-remove {
    background: none; border: none; color: var(--text-secondary); cursor: pointer;
    padding: 0; display: flex; font-size: 12px; line-height: 1; transition: color .15s;
}
.emp-tag-remove:hover { color: #e74c3c; }
.emp-more { font-size: 11px; color: var(--text-secondary); padding: 0 4px; }
.btn-assign {
    background: rgba(27,68,156,.12); border: 1px dashed rgba(27,68,156,.4);
    border-radius: 50%; width: 22px; height: 22px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #1b449c; font-size: 12px; transition: all .15s;
}
.btn-assign:hover { background: rgba(27,68,156,.25); }

/* Actions */
.action-btns { display: flex; gap: 6px; justify-content: flex-end; }
.icon-btn {
    width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;
    border-radius: 6px; border: 1px solid var(--border-color); background: none;
    cursor: pointer; transition: all .15s; color: var(--text-secondary); font-size: 13px;
}
.icon-btn--edit:hover   { background: rgba(27,68,156,.15); border-color: #1b449c; color: #1b449c; }
.icon-btn--delete:hover { background: rgba(231,76,60,.15); border-color: #e74c3c; color: #e74c3c; }

/* Bouton ajouter */
.add-btn {
    display: inline-flex; align-items: center;
    background: #1b449c; color: white; border: none;
    border-radius: 8px; padding: 9px 16px;
    font-size: 13px; font-weight: 600; cursor: pointer;
    transition: background .2s, transform .15s; white-space: nowrap;
}
.add-btn:hover { background: #163a86; transform: translateY(-1px); }

/* Modal */
.modal-card {
    background: var(--card-bg); border: 1px solid var(--border-color);
    border-radius: 14px; overflow: hidden;
}
.modal-header {
    display: flex; align-items: center; gap: 10px;
    padding: 16px 18px; border-bottom: 1px solid var(--border-color);
}
.modal-header h3 { flex: 1; font-size: 15px; font-weight: 600; color: var(--text-primary); margin: 0; }
.modal-close {
    background: none; border: none; color: var(--text-secondary); cursor: pointer;
    padding: 4px; border-radius: 6px; display: flex; font-size: 16px;
    transition: all .15s; margin-left: auto;
}
.modal-close:hover { background: var(--card-hover); color: var(--text-primary); }
.modal-body { padding: 20px 18px; max-height: 65vh; overflow-y: auto; }
.modal-footer {
    display: flex; justify-content: flex-end; gap: 10px;
    padding: 14px 18px; border-top: 1px solid var(--border-color);
}

/* Formulaire */
.field-row  { display: grid; grid-template-columns: auto 1fr; gap: 12px; }
.field-group{ display: flex; flex-direction: column; gap: 6px; }
.field-label {
    font-size: 11px; font-weight: 600; color: var(--text-secondary);
    text-transform: uppercase; letter-spacing: .04em;
}
.required { color: #f15a2d; margin-left: 2px; }
.field-input {
    background: var(--dark-bg); border: 1px solid var(--border-color);
    border-radius: 8px; color: var(--text-primary); font-size: 13px;
    padding: 9px 12px; outline: none; transition: border-color .2s; width: 100%;
}
.field-input:focus { border-color: #1b449c; }
.field-error { font-size: 11px; color: #e74c3c; }
.styled-select-wrapper { position: relative; }
.field-select { appearance: none; cursor: pointer; padding-right: 28px; }
.styled-select-wrapper::after {
    content: "▾"; position: absolute; right: 10px; top: 50%;
    transform: translateY(-50%); color: var(--text-secondary); pointer-events: none; font-size: 12px;
}
.field-select option { background: var(--card-bg); color: var(--text-primary); }

/* Aperçu plateforme */
.platform-preview { display: flex; align-items: center; gap: 12px; }
.flex-grow { flex: 1; }

/* Toggle */
.toggle-row {
    display: flex; align-items: center; gap: 10px; cursor: pointer;
    padding: 10px 12px; background: var(--dark-bg);
    border: 1px solid var(--border-color); border-radius: 8px; transition: border-color .15s;
}
.toggle-row:hover { border-color: #1b449c; }
.toggle-input  { width: 16px; height: 16px; cursor: pointer; accent-color: #1b449c; flex-shrink: 0; }
.toggle-label  { font-size: 13px; color: var(--text-secondary); }

/* Boutons modal */
.btn-cancel {
    background: none; border: 1px solid var(--border-color); border-radius: 8px;
    color: var(--text-secondary); font-size: 13px; font-weight: 600;
    padding: 9px 18px; cursor: pointer; transition: all .15s;
}
.btn-cancel:hover { border-color: var(--text-secondary); color: var(--text-primary); }
.btn-confirm {
    display: flex; align-items: center;
    background: #1b449c; color: white; border: none;
    border-radius: 8px; font-size: 13px; font-weight: 600;
    padding: 9px 20px; cursor: pointer; transition: background .15s;
}
.btn-confirm:hover:not(:disabled) { background: #163a86; }
.btn-confirm:disabled { opacity: .6; cursor: not-allowed; }
.btn-danger {
    display: flex; align-items: center;
    background: rgba(231,76,60,.1); border: 1px solid rgba(231,76,60,.3);
    border-radius: 8px; color: #e74c3c; font-size: 13px; font-weight: 600;
    padding: 9px 18px; cursor: pointer; transition: all .15s;
}
.btn-danger:hover:not(:disabled) { background: rgba(231,76,60,.2); }
.btn-danger:disabled { opacity: .6; cursor: not-allowed; }

.confirm-text { color: var(--text-secondary); font-size: 13px; line-height: 1.6; }
.confirm-text strong { color: var(--text-primary); }

.mt-2 { margin-top: 8px; }
.mt-3 { margin-top: 12px; }
.mb-3 { margin-bottom: 12px; }
.me-1 { margin-right: 4px; }
.me-2 { margin-right: 8px; }
.text-end { text-align: right; }

@media (max-width: 768px) {
    .sm-page { padding: 16px; }
    .sm-table thead th:nth-child(4),
    .sm-table tbody td:nth-child(4),
    .sm-table thead th:nth-child(5),
    .sm-table tbody td:nth-child(5) { display: none; }
}
</style>
