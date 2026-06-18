<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, router, Head } from "@inertiajs/vue3";
import { computed, ref, shallowRef } from "vue";
import { useDisplay } from "vuetify";

const props = defineProps({ allDepartments: Array, errors: Object });
const { smAndDown } = useDisplay();

const departements = computed(() =>
    (props.allDepartments ?? []).map((d, i) => ({ ...d, index: i + 1 }))
);

const totalServices = computed(() =>
    departements.value.reduce((n, d) => n + (d.services?.length ?? 0), 0)
);

const search = ref("");
const showPreview = ref(false);

const allServices = computed(() =>
    departements.value.flatMap(d => (d.services ?? []).map(s => ({ ...s, departement: d.nom_departement })))
);

const headers = computed(() => [
    { title: "N°", key: "index", width: 60, sortable: true },
    { title: "Département", key: "nom_departement", sortable: true },
    { title: "Services", key: "services_count", width: 110, align: "center", sortable: false },
    ...(!smAndDown.value
        ? [{ title: "Description", key: "description_departement", sortable: false }]
        : []),
    { title: "", key: "data-table-expand", width: 52 },
    { title: "Actions", key: "actions", width: 96, align: "end", sortable: false },
]);

// ── Department dialog ────────────────────────────────────────────
const dialogDept = shallowRef(false);
const isDeptEditing = ref(false);

const formDept = useForm({
    id_departement: null,
    nom_departement: "",
    description_departement: "",
});

const openAddDept = () => {
    formDept.reset();
    formDept.clearErrors();
    isDeptEditing.value = false;
    dialogDept.value = true;
};

const openEditDept = (dept) => {
    formDept.id_departement = dept.id_departement;
    formDept.nom_departement = dept.nom_departement;
    formDept.description_departement = dept.description_departement ?? "";
    formDept.clearErrors();
    isDeptEditing.value = true;
    dialogDept.value = true;
};

const saveDept = () => {
    if (isDeptEditing.value) {
        formDept.put(route("departements.update", formDept.id_departement), {
            onSuccess: () => { dialogDept.value = false; formDept.reset(); },
        });
    } else {
        formDept.post(route("departements.store"), {
            onSuccess: () => { dialogDept.value = false; formDept.reset(); },
        });
    }
};

// ── Service dialog ───────────────────────────────────────────────
const dialogService = shallowRef(false);
const isServiceEditing = ref(false);
const currentDeptName = ref("");

const formService = useForm({
    id_service: null,
    nom_service: "",
    description_service: "",
    icon_service: "mdi-cog-outline",
    color: "#1b449c",
    paths: "",
    departement_id: null,
});

const serviceIcons = [
    "mdi-briefcase-outline", "mdi-account-group-outline", "mdi-laptop",
    "mdi-hammer-wrench", "mdi-chart-bar", "mdi-shield-check-outline",
    "mdi-phone-outline", "mdi-school-outline", "mdi-currency-eur",
    "mdi-heart-pulse", "mdi-truck-outline", "mdi-bullhorn-outline",
    "mdi-palette-outline", "mdi-code-braces", "mdi-database-outline",
    "mdi-cloud-outline", "mdi-cog-outline", "mdi-headset",
];

const openAddService = (dept) => {
    formService.reset();
    formService.clearErrors();
    formService.icon_service = "mdi-cog-outline";
    formService.color = "#1b449c";
    formService.paths = "";
    formService.departement_id = dept.id_departement;
    currentDeptName.value = dept.nom_departement;
    isServiceEditing.value = false;
    dialogService.value = true;
};

const openEditService = (service, deptName) => {
    formService.id_service = service.id_service;
    formService.nom_service = service.nom_service;
    formService.description_service = service.description_service ?? "";
    formService.icon_service = service.icon_service ?? "bi bi-credit-card-fill";
    formService.color = service.color ?? "#1b449c";
    formService.paths = Array.isArray(service.paths)
        ? service.paths.join("\n")
        : (service.paths ?? "");
    formService.departement_id = service.departement_id;
    formService.clearErrors();
    currentDeptName.value = deptName;
    isServiceEditing.value = true;
    dialogService.value = true;
};

const saveService = () => {
    // convert textarea lines to array before sending
    const pathsArray = formService.paths
        .split("\n")
        .map(p => p.trim())
        .filter(p => p.length > 0);

    const payload = {
        nom_service:         formService.nom_service,
        description_service: formService.description_service,
        icon_service:        formService.icon_service,
        color:               formService.color,
        paths:               pathsArray,
        departement_id:      formService.departement_id,
    };

    if (isServiceEditing.value) {
        formService.transform(() => payload).put(route("services.update", formService.id_service), {
            onSuccess: () => { dialogService.value = false; formService.reset(); },
        });
    } else {
        formService.transform(() => payload).post(route("services.store"), {
            onSuccess: () => { dialogService.value = false; formService.reset(); },
        });
    }
};

// ── Delete confirm ───────────────────────────────────────────────
const dialogConfirm = shallowRef(false);
const deleteTarget = ref(null);
const deleteProcessing = ref(false);

const openDeleteDept = (dept) => {
    deleteTarget.value = { type: "dept", item: dept };
    dialogConfirm.value = true;
};

const openDeleteService = (service) => {
    deleteTarget.value = { type: "service", item: service };
    dialogConfirm.value = true;
};

const confirmDelete = () => {
    const { type, item } = deleteTarget.value;
    deleteProcessing.value = true;
    const url = type === "dept"
        ? route("departements.destroy", item.id_departement)
        : route("services.destroy", item.id_service);

    router.delete(url, {
        onFinish: () => {
            deleteProcessing.value = false;
            dialogConfirm.value = false;
        },
    });
};
</script>

<template>
    <Head title="Départements" />
    <AuthenticatedLayout>
        <div class="dept-page">

            <!-- Stats ─────────────────────────────────────────── -->
            <div class="stats-row">
                <div class="stat-chip">
                    <v-icon icon="mdi-domain" size="22" class="stat-icon" />
                    <div>
                        <div class="stat-value">{{ departements.length }}</div>
                        <div class="stat-label">Départements</div>
                    </div>
                </div>
                <div class="stat-chip">
                    <v-icon icon="mdi-cog-outline" size="22" class="stat-icon stat-icon--orange" />
                    <div>
                        <div class="stat-value">{{ totalServices }}</div>
                        <div class="stat-label">Services</div>
                    </div>
                </div>
            </div>

            <!-- Table ──────────────────────────────────────────── -->
            <div class="table-card">
                <v-data-table
                    :headers="headers"
                    :items="departements"
                    :search="search"
                    item-value="id_departement"
                    show-expand
                    :expand-on-click="false"
                    fixed-header
                    height="520"
                    :items-per-page="10"
                    class="dept-table"
                >
                    <!-- Toolbar -->
                    <template #top>
                        <div class="table-toolbar">
                            <div class="toolbar-left">
                                <v-icon icon="mdi-domain" size="20" class="mr-2" style="color:#f15a2d" />
                                <span class="toolbar-title">Gestion des Départements</span>
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
                                <button class="preview-btn" :class="{ 'preview-btn--active': showPreview }" @click="showPreview = !showPreview">
                                    <v-icon :icon="showPreview ? 'mdi-eye-off-outline' : 'mdi-eye-outline'" size="18" class="mr-1" />
                                    <span class="d-none d-sm-inline">{{ showPreview ? 'Masquer aperçu' : 'Aperçu public' }}</span>
                                </button>
                                <button class="add-btn" @click="openAddDept">
                                    <v-icon icon="mdi-plus" size="18" class="mr-1" />
                                    <span class="d-none d-sm-inline">Ajouter</span>
                                </button>
                            </div>
                        </div>
                    </template>

                    <!-- Badge services count -->
                    <template #item.services_count="{ item }">
                        <span class="services-badge">
                            {{ item.services?.length ?? 0 }}
                        </span>
                    </template>

                    <!-- Description tronquée -->
                    <template #item.description_departement="{ item }">
                        <span class="desc-text">
                            {{ item.description_departement || "—" }}
                        </span>
                    </template>

                    <!-- Expand button -->
                    <template #item.data-table-expand="{ internalItem, isExpanded, toggleExpand }">
                        <button
                            class="expand-btn"
                            :class="{ 'expand-btn--open': isExpanded(internalItem) }"
                            @click="toggleExpand(internalItem)"
                            :title="isExpanded(internalItem) ? 'Masquer services' : 'Voir services'"
                        >
                            <v-icon
                                :icon="isExpanded(internalItem) ? 'mdi-chevron-up' : 'mdi-chevron-down'"
                                size="18"
                            />
                        </button>
                    </template>

                    <!-- Actions -->
                    <template #item.actions="{ item }">
                        <div class="action-btns">
                            <button class="icon-btn icon-btn--edit" title="Modifier" @click="openEditDept(item)">
                                <v-icon icon="mdi-pencil-outline" size="16" />
                            </button>
                            <button class="icon-btn icon-btn--delete" title="Supprimer" @click="openDeleteDept(item)">
                                <v-icon icon="mdi-delete-outline" size="16" />
                            </button>
                        </div>
                    </template>

                    <!-- Expanded row : Services ──────────────────── -->
                    <template #expanded-row="{ columns, item }">
                        <tr class="expanded-row">
                            <td :colspan="columns.length" class="pa-0">
                                <div class="services-panel">
                                    <div class="services-panel__header">
                                        <div class="services-panel__title">
                                            <v-icon icon="mdi-cog-outline" size="16" class="mr-1" style="color:#f15a2d" />
                                            Services — {{ item.nom_departement }}
                                            <span class="services-count-inline">{{ item.services?.length ?? 0 }}</span>
                                        </div>
                                        <button class="add-service-btn" @click="openAddService(item)">
                                            <v-icon icon="mdi-plus" size="15" class="mr-1" />
                                            Ajouter un service
                                        </button>
                                    </div>

                                    <!-- Empty state -->
                                    <div v-if="!item.services?.length" class="services-empty">
                                        <v-icon icon="mdi-inbox-outline" size="32" class="mb-2" style="opacity:.35" />
                                        <p>Aucun service pour ce département</p>
                                    </div>

                                    <!-- Services table -->
                                    <table v-else class="services-table">
                                        <thead>
                                            <tr>
                                                <th style="width:48px">N°</th>
                                                <th style="width:36px"></th>
                                                <th>Service</th>
                                                <th class="d-none d-md-table-cell">Description</th>
                                                <th style="width:80px; text-align:right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(service, i) in item.services" :key="service.id_service">
                                                <td class="cell-num">{{ i + 1 }}</td>
                                                <td class="cell-icon">
                                                    <v-icon
                                                        :icon="service.icon_service || 'mdi-cog-outline'"
                                                        size="16"
                                                        style="color:#1b449c"
                                                    />
                                                </td>
                                                <td class="cell-name">{{ service.nom_service }}</td>
                                                <td class="cell-desc d-none d-md-table-cell">
                                                    {{ service.description_service || "—" }}
                                                </td>
                                                <td class="cell-actions">
                                                    <div class="action-btns">
                                                        <button
                                                            class="icon-btn icon-btn--edit"
                                                            title="Modifier"
                                                            @click="openEditService(service, item.nom_departement)"
                                                        >
                                                            <v-icon icon="mdi-pencil-outline" size="14" />
                                                        </button>
                                                        <button
                                                            class="icon-btn icon-btn--delete"
                                                            title="Supprimer"
                                                            @click="openDeleteService(service)"
                                                        >
                                                            <v-icon icon="mdi-delete-outline" size="14" />
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <!-- No data -->
                    <template #no-data>
                        <div class="no-data">
                            <v-icon icon="mdi-domain-off" size="40" class="mb-2" style="opacity:.3" />
                            <p>Aucun département trouvé</p>
                            <button class="add-btn mt-3" @click="openAddDept">
                                <v-icon icon="mdi-plus" size="16" class="mr-1" />
                                Créer le premier département
                            </button>
                        </div>
                    </template>
                </v-data-table>
            </div>

            <!-- ── Aperçu page Services publique ────────────────────── -->
            <transition name="preview-fade">
                <div v-if="showPreview" class="preview-panel">
                    <div class="preview-header">
                        <v-icon icon="mdi-eye-outline" size="18" style="color:#f15a2d" />
                        <span class="preview-title">Aperçu — Page Services publique</span>
                        <span class="preview-count">{{ allServices.length }} service(s)</span>
                        <button class="preview-close" @click="showPreview = false">
                            <v-icon icon="mdi-close" size="16" />
                        </button>
                    </div>

                    <div v-if="!allServices.length" class="preview-empty">
                        <v-icon icon="mdi-inbox-outline" size="40" style="opacity:.3" />
                        <p>Aucun service à afficher</p>
                    </div>

                    <div v-else class="preview-grid">
                        <div
                            v-for="(service, index) in allServices"
                            :key="service.id_service"
                            class="preview-card"
                        >
                            <div class="preview-card-top">
                                <div
                                    class="preview-card-icon"
                                    :style="{ background: (service.color || '#1b449c') + '22', color: service.color || '#1b449c' }"
                                >
                                    <svg
                                        v-if="Array.isArray(service.paths) && service.paths.length"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                                        width="26" height="26"
                                    >
                                        <path v-for="(d, i) in service.paths" :key="i" :d="d" />
                                    </svg>
                                    <v-icon v-else :icon="service.icon_service || 'mdi-cog-outline'" size="26" />
                                </div>
                                <span class="preview-card-num" :style="{ color: (service.color || '#1b449c') + '50' }">
                                    {{ String(index + 1).padStart(2, '0') }}
                                </span>
                            </div>
                            <div class="preview-card-accent" :style="{ background: service.color || '#1b449c' }"></div>
                            <h3 class="preview-card-title">{{ service.nom_service }}</h3>
                            <p class="preview-card-desc">{{ service.description_service || '—' }}</p>
                            <span class="preview-card-dept">
                                <v-icon icon="mdi-domain" size="11" class="mr-1" />
                                {{ service.departement }}
                            </span>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <!-- ── Dialog : Département ──────────────────────────────── -->
        <v-dialog v-model="dialogDept" max-width="600" :persistent="formDept.processing" scrollable>
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon
                        :icon="isDeptEditing ? 'mdi-pencil-outline' : 'mdi-domain'"
                        size="20"
                        class="mr-2"
                        style="color:#f15a2d"
                    />
                    <h3>{{ isDeptEditing ? "Modifier le département" : "Nouveau département" }}</h3>
                    <button class="modal-close" @click="dialogDept = false">
                        <v-icon icon="mdi-close" size="18" />
                    </button>
                </div>

                <div class="modal-body">
                    <div class="field-group">
                        <label class="field-label">Nom du département <span class="required">*</span></label>
                        <input
                            v-model="formDept.nom_departement"
                            type="text"
                            class="field-input"
                            :class="{ 'field-input--error': formDept.errors.nom_departement }"
                            placeholder="Ex : Ressources Humaines"
                            @keyup.enter="saveDept"
                        />
                        <span v-if="formDept.errors.nom_departement" class="field-error">
                            {{ formDept.errors.nom_departement }}
                        </span>
                    </div>

                    <div class="field-group mt-4">
                        <label class="field-label">Description</label>
                        <textarea
                            v-model="formDept.description_departement"
                            class="field-input field-textarea"
                            placeholder="Description du département…"
                            rows="3"
                        ></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogDept = false">Annuler</button>
                    <button
                        class="btn-confirm"
                        :class="{ 'btn-loading': formDept.processing }"
                        :disabled="formDept.processing"
                        @click="saveDept"
                    >
                        <v-progress-circular v-if="formDept.processing" size="14" width="2" indeterminate class="mr-1" />
                        {{ isDeptEditing ? "Enregistrer" : "Créer" }}
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ── Dialog : Service ──────────────────────────────────── -->
        <v-dialog v-model="dialogService" max-width="600" :persistent="formService.processing" scrollable>
            <div class="modal-card" style="height:900px;">
                <div class="modal-header">
                    <v-icon
                        :icon="isServiceEditing ? 'mdi-pencil-outline' : 'mdi-cog-outline'"
                        size="20"
                        class="mr-2"
                        style="color:#f15a2d"
                    />
                    <div>
                        <h3>{{ isServiceEditing ? "Modifier le service" : "Nouveau service" }}</h3>
                        <p class="modal-subtitle">{{ currentDeptName }}</p>
                    </div>
                    <button class="modal-close" @click="dialogService = false">
                        <v-icon icon="mdi-close" size="18" />
                    </button>
                </div>

                <div class="modal-body">
                    <div class="field-group">
                        <label class="field-label">Nom du service <span class="required">*</span></label>
                        <input
                            v-model="formService.nom_service"
                            type="text"
                            class="field-input"
                            :class="{ 'field-input--error': formService.errors.nom_service }"
                            placeholder="Ex : Recrutement"
                            @keyup.enter="saveService"
                        />
                        <span v-if="formService.errors.nom_service" class="field-error">
                            {{ formService.errors.nom_service }}
                        </span>
                    </div>

                    <div class="field-group mt-4">
                        <label class="field-label">Description</label>
                        <textarea
                            v-model="formService.description_service"
                            class="field-input field-textarea"
                            placeholder="Description du service…"
                            rows="3"
                        ></textarea>
                    </div>

                    <div class="field-group mt-4">
                        <label class="field-label">Icône</label>
                        <div class="icon-picker">
                            <button
                                v-for="ico in serviceIcons"
                                :key="ico"
                                type="button"
                                class="icon-option"
                                :class="{ 'icon-option--selected': formService.icon_service === ico }"
                                :title="ico"
                                @click="formService.icon_service = ico"
                            >
                                <v-icon :icon="ico" size="18" />
                            </button>
                        </div>
                    </div>

                    <div class="field-group mt-4">
                        <label class="field-label">Couleur</label>
                        <div class="color-row">
                            <input
                                v-model="formService.color"
                                type="color"
                                class="color-swatch"
                                title="Choisir la couleur"
                            />
                            <input
                                v-model="formService.color"
                                type="text"
                                class="field-input color-hex"
                                placeholder="#1b449c"
                                maxlength="20"
                            />
                        </div>
                    </div>

                    <div class="field-group mt-4">
                        <label class="field-label">
                            Chemins SVG
                            <span class="field-hint">(un chemin par ligne)</span>
                        </label>
                        <textarea
                            v-model="formService.paths"
                            class="field-input field-textarea"
                            placeholder="M9 3H5a2 2 0 00-2 2v4…&#10;M12 14l9-5-9-5-9 5 9 5z"
                            rows="4"
                        ></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogService = false">Annuler</button>
                    <button
                        class="btn-confirm"
                        :class="{ 'btn-loading': formService.processing }"
                        :disabled="formService.processing"
                        @click="saveService"
                    >
                        <v-progress-circular v-if="formService.processing" size="14" width="2" indeterminate class="mr-1" />
                        {{ isServiceEditing ? "Enregistrer" : "Créer" }}
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ── Dialog : Confirmation suppression ─────────────────── -->
        <v-dialog v-model="dialogConfirm" max-width="400">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon icon="mdi-alert-outline" size="20" class="mr-2" style="color:#e74c3c" />
                    <h3>Confirmer la suppression</h3>
                </div>

                <div class="modal-body">
                    <p class="confirm-msg" v-if="deleteTarget?.type === 'dept'">
                        Supprimer le département
                        <strong>{{ deleteTarget.item.nom_departement }}</strong> ?
                        <span class="confirm-warn" v-if="deleteTarget.item.services?.length">
                            Les {{ deleteTarget.item.services.length }} services associés seront également supprimés.
                        </span>
                    </p>
                    <p class="confirm-msg" v-else-if="deleteTarget?.type === 'service'">
                        Supprimer le service
                        <strong>{{ deleteTarget.item.nom_service }}</strong> ?
                    </p>
                </div>

                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogConfirm = false">Annuler</button>
                    <button
                        class="btn-delete"
                        :disabled="deleteProcessing"
                        @click="confirmDelete"
                    >
                        <v-progress-circular v-if="deleteProcessing" size="14" width="2" indeterminate class="mr-1" />
                        Supprimer
                    </button>
                </div>
            </div>
        </v-dialog>

    </AuthenticatedLayout>
</template>

<style scoped>
/* ── Page ──────────────────────────────────────────────────────── */
.dept-page {
    padding: 24px 20px;
    min-height: 100%;
}

/* ── Stats ─────────────────────────────────────────────────────── */
.stats-row {
    display: flex;
    gap: 14px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.stat-chip {
    display: flex;
    align-items: center;
    gap: 12px;
    background: var(--card-bg, #242837);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 12px;
    padding: 14px 20px;
    min-width: 160px;
}

.stat-icon { color: #1b449c; }
.stat-icon--orange { color: #f15a2d !important; }

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #fff;
    line-height: 1;
}

.stat-label {
    font-size: 0.75rem;
    color: var(--text-secondary, #a0a4b8);
    margin-top: 2px;
}

/* ── Table card ─────────────────────────────────────────────────── */
.table-card {
    background: var(--card-bg, #242837);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 14px;
    overflow: hidden;
}

/* ── Vuetify table : dark override complet ──────────────────────── */

/* Racine + toutes les couches wrapper internes */
:deep(.dept-table),
:deep(.dept-table .v-table),
:deep(.dept-table .v-table__wrapper),
:deep(.dept-table table) {
    background: transparent !important;
    color: var(--text-primary, #fff) !important;
}

/* Header : toutes les variantes de sélecteurs Vuetify 3 */
:deep(.dept-table thead),
:deep(.dept-table thead tr),
:deep(.dept-table .v-data-table__thead),
:deep(.dept-table .v-data-table__thead tr) {
    background: #1a1d29 !important;
}

:deep(.dept-table thead th),
:deep(.dept-table .v-data-table__thead th),
:deep(.dept-table .v-data-table-headers__th) {
    background: #1a1d29 !important;
    color: var(--text-secondary, #a0a4b8) !important;
    font-size: 0.72rem !important;
    font-weight: 600 !important;
    letter-spacing: 0.5px !important;
    text-transform: uppercase;
    border-bottom: 1px solid var(--border-color, #3a3d52) !important;
    white-space: nowrap;
}

/* Icônes de tri dans le header */
:deep(.dept-table .v-data-table-headers__th .v-data-table-header__sort-icon) {
    color: var(--text-secondary, #a0a4b8) !important;
}

/* Lignes du body */
:deep(.dept-table tbody tr),
:deep(.dept-table .v-data-table__tr) {
    background: transparent !important;
}

:deep(.dept-table tbody td),
:deep(.dept-table .v-data-table__tr td) {
    background: transparent !important;
    border-bottom: 1px solid rgba(58, 61, 82, 0.45) !important;
    color: var(--text-primary, #fff) !important;
    font-size: 0.875rem;
}

:deep(.dept-table tbody tr:hover td),
:deep(.dept-table .v-data-table__tr:hover td) {
    background: var(--card-hover, #2d3142) !important;
}

/* Footer */
:deep(.dept-table .v-data-table-footer),
:deep(.dept-table .v-data-table__tfoot) {
    background: #1a1d29 !important;
    color: var(--text-secondary, #a0a4b8) !important;
    border-top: 1px solid var(--border-color, #3a3d52) !important;
}

:deep(.dept-table .v-data-table-footer .v-select),
:deep(.dept-table .v-data-table-footer .v-select__selection),
:deep(.dept-table .v-data-table-footer span) {
    color: var(--text-secondary, #a0a4b8) !important;
}

/* Scrollbar sombre */
:deep(.dept-table .v-table__wrapper)::-webkit-scrollbar {
    height: 6px;
    width: 6px;
}
:deep(.dept-table .v-table__wrapper)::-webkit-scrollbar-track {
    background: transparent;
}
:deep(.dept-table .v-table__wrapper)::-webkit-scrollbar-thumb {
    background: var(--border-color, #3a3d52);
    border-radius: 3px;
}

/* ── Toolbar ────────────────────────────────────────────────────── */
.table-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color, #3a3d52);
    flex-wrap: wrap;
}

.toolbar-left {
    display: flex;
    align-items: center;
}

.toolbar-title {
    font-size: 1rem;
    font-weight: 600;
    color: #fff;
}

.toolbar-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 10px;
    color: var(--text-secondary, #a0a4b8);
    pointer-events: none;
}

.search-input {
    height: 36px;
    padding: 0 32px 0 34px;
    background: var(--dark-bg, #1a1d29);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 8px;
    color: #fff;
    font-size: 0.875rem;
    width: 200px;
    transition: border-color 0.2s;
    outline: none;
}

.search-input:focus { border-color: #1b449c; }
.search-input::placeholder { color: var(--text-secondary, #a0a4b8); }

.search-clear {
    position: absolute;
    right: 8px;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-secondary, #a0a4b8);
    display: flex;
    align-items: center;
    padding: 0;
}

.add-btn {
    display: flex;
    align-items: center;
    height: 36px;
    padding: 0 14px;
    background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.15s;
    white-space: nowrap;
}

.add-btn:hover { opacity: 0.88; transform: translateY(-1px); }

/* ── Badges & cells ─────────────────────────────────────────────── */
.services-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 26px;
    height: 22px;
    padding: 0 7px;
    background: rgba(27, 68, 156, 0.25);
    border: 1px solid rgba(27, 68, 156, 0.5);
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    color: #93b4ff;
}

.desc-text {
    color: var(--text-secondary, #a0a4b8);
    font-size: 0.8rem;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ── Expand button ──────────────────────────────────────────────── */
.expand-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 30px;
    height: 30px;
    background: var(--dark-bg, #1a1d29);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 6px;
    color: var(--text-secondary, #a0a4b8);
    cursor: pointer;
    transition: all 0.2s;
}

.expand-btn:hover,
.expand-btn--open {
    background: rgba(241, 90, 45, 0.12);
    border-color: #f15a2d;
    color: #f15a2d;
}

/* ── Action buttons ─────────────────────────────────────────────── */
.action-btns {
    display: flex;
    align-items: center;
    gap: 6px;
    justify-content: flex-end;
}

.icon-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border: 1px solid transparent;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
    background: none;
}

.icon-btn--edit { color: #f39c12; border-color: rgba(243,156,18,.25); background: rgba(243,156,18,.08); }
.icon-btn--edit:hover { background: rgba(243,156,18,.2); }

.icon-btn--delete { color: #e74c3c; border-color: rgba(231,76,60,.25); background: rgba(231,76,60,.08); }
.icon-btn--delete:hover { background: rgba(231,76,60,.2); }

/* ── Expanded row (services panel) ─────────────────────────────── */
.expanded-row td { padding: 0 !important; }

.services-panel {
    background: #1a1d29;
    border-top: 1px solid var(--border-color, #3a3d52);
    border-bottom: 1px solid var(--border-color, #3a3d52);
    padding: 0 0 12px;
}

.services-panel__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 24px;
    border-bottom: 1px solid rgba(58, 61, 82, 0.5);
    margin-bottom: 4px;
}

.services-panel__title {
    display: flex;
    align-items: center;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-secondary, #a0a4b8);
}

.services-count-inline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 18px;
    padding: 0 5px;
    background: rgba(241, 90, 45, 0.2);
    border-radius: 10px;
    font-size: 0.7rem;
    font-weight: 700;
    color: #f15a2d;
    margin-left: 8px;
}

.add-service-btn {
    display: flex;
    align-items: center;
    height: 30px;
    padding: 0 12px;
    background: rgba(27, 68, 156, 0.15);
    border: 1px solid rgba(27, 68, 156, 0.4);
    border-radius: 6px;
    color: #93b4ff;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.add-service-btn:hover {
    background: rgba(27, 68, 156, 0.3);
    border-color: #1b449c;
    color: #fff;
}

/* Services table */
.services-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.835rem;
}

.services-table thead tr {
    background: rgba(255, 255, 255, 0.03);
}

.services-table th {
    padding: 8px 16px;
    text-align: left;
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--text-secondary, #a0a4b8);
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 1px solid rgba(58, 61, 82, 0.4);
}

.services-table td {
    padding: 10px 16px;
    color: var(--text-primary, #fff);
    border-bottom: 1px solid rgba(58, 61, 82, 0.25);
}

.services-table tbody tr:last-child td { border-bottom: none; }
.services-table tbody tr:hover td { background: rgba(255, 255, 255, 0.03); }

.cell-num { color: var(--text-secondary, #a0a4b8); width: 48px; }
.cell-icon { width: 36px; }
.cell-name { font-weight: 500; }
.cell-desc { color: var(--text-secondary, #a0a4b8); font-size: 0.8rem; }
.cell-actions { text-align: right; }

/* ── Empty & no-data ────────────────────────────────────────────── */
.services-empty {
    padding: 24px;
    text-align: center;
    color: var(--text-secondary, #a0a4b8);
    font-size: 0.85rem;
}

.services-empty p { margin: 0; }

.no-data {
    padding: 40px;
    text-align: center;
    color: var(--text-secondary, #a0a4b8);
    font-size: 0.9rem;
}

/* ── Modals ─────────────────────────────────────────────────────── */
.modal-card {
    background: var(--card-bg, #242837);
    border: 1px solid var(--border-color, #3a3d52);

    border-radius: 14px;
    overflow: hidden;
}

.modal-header {
    display: flex;
    align-items: center;
    padding: 18px 20px;
    border-bottom: 1px solid var(--border-color, #3a3d52);
    gap: 4px;
}

.modal-header h3 {
    flex: 1;
    font-size: 1rem;
    font-weight: 600;
    color: #fff;
    margin: 0;
}

.modal-subtitle {
    font-size: 0.75rem;
    color: var(--text-secondary, #a0a4b8);
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-secondary, #a0a4b8);
    display: flex;
    align-items: center;
    padding: 4px;
    border-radius: 6px;
    transition: all 0.2s;
    margin-left: auto;
}

.modal-close:hover { background: rgba(255,255,255,.08); color: #fff; }

.modal-body {
    padding: 20px;
}

.modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding: 14px 20px;
    border-top: 1px solid var(--border-color, #3a3d52);
}

/* ── Form fields ────────────────────────────────────────────────── */
.field-group { display: flex; flex-direction: column; }

.field-label {
    font-size: 0.8rem;
    font-weight: 500;
    color: var(--text-secondary, #a0a4b8);
    margin-bottom: 6px;
}

.required { color: #e74c3c; }

.field-input {
    background: var(--dark-bg, #1a1d29);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 8px;
    color: #fff;
    font-size: 0.9rem;
    padding: 0 12px;
    height: 42px;
    outline: none;
    transition: border-color 0.2s;
    width: 100%;
    font-family: inherit;
}

.field-input:focus { border-color: #1b449c; }
.field-input::placeholder { color: rgba(255,255,255,.2); }
.field-input--error { border-color: #e74c3c !important; }

.field-textarea {
    height: auto;
    padding: 10px 12px;
    resize: vertical;
    line-height: 1.5;
}

.field-error {
    font-size: 0.75rem;
    color: #e74c3c;
    margin-top: 4px;
}

/* ── Color picker ───────────────────────────────────────────────── */
.color-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

.color-swatch {
    width: 42px;
    height: 42px;
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 8px;
    padding: 2px;
    background: var(--dark-bg, #1a1d29);
    cursor: pointer;
    flex-shrink: 0;
}

.color-hex {
    flex: 1;
    font-family: monospace;
}

.field-hint {
    font-size: 0.72rem;
    color: var(--text-secondary, #a0a4b8);
    margin-left: 6px;
    font-weight: 400;
}

/* ── Icon picker ────────────────────────────────────────────────── */
.icon-picker {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.icon-option {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    background: var(--dark-bg, #1a1d29);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 8px;
    cursor: pointer;
    color: var(--text-secondary, #a0a4b8);
    transition: all 0.15s;
}

.icon-option:hover { border-color: #1b449c; color: #fff; }

.icon-option--selected {
    background: rgba(27, 68, 156, 0.3);
    border-color: #1b449c;
    color: #fff;
    box-shadow: 0 0 0 2px rgba(27, 68, 156, 0.3);
}

/* ── Buttons ────────────────────────────────────────────────────── */
.btn-cancel {
    height: 36px;
    padding: 0 16px;
    background: none;
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 8px;
    color: var(--text-secondary, #a0a4b8);
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-cancel:hover { border-color: #fff; color: #fff; }

.btn-confirm {
    height: 36px;
    padding: 0 20px;
    background: linear-gradient(135deg, #1b449c 0%, #f15a2d 100%);
    border: none;
    border-radius: 8px;
    color: #fff;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: opacity 0.2s;
}

.btn-confirm:hover:not(:disabled) { opacity: 0.88; }
.btn-confirm:disabled { opacity: 0.55; cursor: not-allowed; }

.btn-delete {
    height: 36px;
    padding: 0 20px;
    background: rgba(231, 76, 60, 0.15);
    border: 1px solid rgba(231, 76, 60, 0.4);
    border-radius: 8px;
    color: #e74c3c;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    transition: all 0.2s;
}

.btn-delete:hover:not(:disabled) { background: rgba(231, 76, 60, 0.3); }
.btn-delete:disabled { opacity: 0.55; cursor: not-allowed; }

/* ── Confirm dialog ─────────────────────────────────────────────── */
.confirm-msg {
    font-size: 0.9rem;
    color: var(--text-primary, #fff);
    line-height: 1.6;
    margin: 0;
}

.confirm-warn {
    display: block;
    margin-top: 8px;
    font-size: 0.8rem;
    color: #f39c12;
}

/* ── Preview btn ────────────────────────────────────────────────── */
.preview-btn {
    display: flex;
    align-items: center;
    height: 36px;
    padding: 0 14px;
    background: rgba(241, 90, 45, 0.08);
    border: 1px solid rgba(241, 90, 45, 0.35);
    border-radius: 8px;
    color: #f15a2d;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}
.preview-btn:hover { background: rgba(241, 90, 45, 0.18); border-color: #f15a2d; }
.preview-btn--active {
    background: rgba(241, 90, 45, 0.2);
    border-color: #f15a2d;
}

/* ── Preview panel ──────────────────────────────────────────────── */
.preview-panel {
    margin-top: 24px;
    background: var(--card-bg, #242837);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 14px;
    overflow: hidden;
}

.preview-header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-color, #3a3d52);
    background: #1a1d29;
}

.preview-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #fff;
    flex: 1;
}

.preview-count {
    font-size: 0.75rem;
    color: var(--text-secondary, #a0a4b8);
    background: rgba(255,255,255,0.06);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 20px;
    padding: 2px 10px;
}

.preview-close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-secondary, #a0a4b8);
    display: flex;
    align-items: center;
    padding: 4px;
    border-radius: 6px;
    transition: all 0.2s;
}
.preview-close:hover { color: #fff; background: rgba(255,255,255,.08); }

.preview-empty {
    padding: 48px;
    text-align: center;
    color: var(--text-secondary, #a0a4b8);
    font-size: 0.875rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}
.preview-empty p { margin: 0; }

/* ── Preview grid ───────────────────────────────────────────────── */
.preview-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    padding: 24px;
}

/* ── Preview card ───────────────────────────────────────────────── */
.preview-card {
    background: #1a1d29;
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 14px;
    padding: 22px 20px 18px;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    transition: all 0.25s;
}
.preview-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 32px rgba(0,0,0,0.3);
    border-color: rgba(241,90,45,0.3);
}

.preview-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 14px;
}

.preview-card-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.preview-card-num {
    font-size: 1.8rem;
    font-weight: 800;
    line-height: 1;
    font-variant-numeric: tabular-nums;
}

.preview-card-accent {
    height: 3px;
    border-radius: 2px;
    width: 36px;
    margin-bottom: 14px;
    transition: width 0.3s;
}
.preview-card:hover .preview-card-accent { width: 56px; }

.preview-card-title {
    font-size: 14px;
    font-weight: 700;
    color: #fff;
    line-height: 1.35;
    margin: 0 0 8px;
}

.preview-card-desc {
    font-size: 13px;
    color: var(--text-secondary, #a0a4b8);
    line-height: 1.6;
    margin: 0 0 14px;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.preview-card-dept {
    display: inline-flex;
    align-items: center;
    font-size: 11px;
    color: var(--text-secondary, #a0a4b8);
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 3px 10px;
    margin-top: auto;
    align-self: flex-start;
}

/* ── Transition ─────────────────────────────────────────────────── */
.preview-fade-enter-active,
.preview-fade-leave-active {
    transition: opacity 0.25s, transform 0.25s;
}
.preview-fade-enter-from,
.preview-fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

/* ── Responsive ─────────────────────────────────────────────────── */
@media (max-width: 1024px) {
    .preview-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 600px) {
    .dept-page { padding: 16px 12px; }
    .table-toolbar { flex-direction: column; align-items: stretch; }
    .toolbar-right { width: 100%; }
    .search-input { width: 100%; }
    .search-wrapper { flex: 1; }
    .add-btn { justify-content: center; }
    .preview-btn { justify-content: center; }
    .stat-chip { flex: 1; min-width: 120px; }
    .preview-grid { grid-template-columns: 1fr; gap: 12px; padding: 16px; }
}
</style>
