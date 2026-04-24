<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { computed, ref, shallowRef } from "vue";
import { useDisplay } from "vuetify";

const props = defineProps({
    allUsers:       Array,
    allRoles:       Array,
    allPermissions: Array,
    errors:         Object,
});
const { smAndDown } = useDisplay();

// ── Active tab ───────────────────────────────────────────────────
const activeTab = ref("users");

// ── Users tab ────────────────────────────────────────────────────
const users = computed(() =>
    (props.allUsers ?? []).map((u, i) => ({ ...u, index: i + 1 }))
);

const totalSuperAdmins = computed(() =>
    users.value.filter((u) => u.roles.some((r) => r.name === "Super-administrateur")).length
);

const search = ref("");
const showPassword = ref(false);

const headers = computed(() => [
    { title: "N°", key: "index", width: 56, sortable: false },
    { title: "Nom complet", key: "fullname", sortable: true },
    { title: "Email / Login", key: "email", sortable: true },
    { title: "Rôle(s)", key: "roles", sortable: false },
    ...(!smAndDown.value
        ? [
              { title: "Sexe", key: "sex", width: 80, align: "center", sortable: false },
/*               { title: "Téléphone", key: "telephone", width: 140, sortable: false },
 */
              { title: "Créé le", key: "created_at", width: 110, sortable: false },
          ]
        : []),
    { title: "Actions", key: "actions", width: 96, align: "end", sortable: false },
]);

const normalize = (s) =>
    s.toLowerCase()
        .replace(/[àâä]/g, "a").replace(/[éèêë]/g, "e")
        .replace(/[îï]/g, "i").replace(/[ôö]/g, "o")
        .replace(/[ùûü]/g, "u").replace(/ç/g, "c")
        .replace(/[^a-z0-9]/g, "");

const dialogUser = shallowRef(false);
const isEditing  = ref(false);

const formUser = useForm({
    id: null, lastname: "", firstname: "", sex: "M",
    roles: [], password: "",
});

const emailPreview = computed(() => {
    const fn = normalize(formUser.firstname || "");
    const ln = normalize(formUser.lastname  || "");
    return fn || ln ? `${fn}.${ln}@synetcom-niger.com` : "";
});

const openAdd = () => {
    formUser.reset(); formUser.clearErrors();
    showPassword.value = false; isEditing.value = false;
    dialogUser.value = true;
};

const openEdit = (user) => {
    formUser.id        = user.id_user;
    formUser.lastname  = user.lastname;
    formUser.firstname = user.firstname;
    formUser.sex       = user.sex ?? "M";
    formUser.roles     = user.roles.map((r) => r.name);
    formUser.password  = "";
    formUser.clearErrors();
    showPassword.value = false; isEditing.value = true;
    dialogUser.value = true;
};

const saveUser = () => {
    if (isEditing.value) {
        formUser.put(route("users.update", formUser.id), {
            onSuccess: () => { dialogUser.value = false; formUser.reset(); },
        });
    } else {
        formUser.post(route("users.store"), {
            onSuccess: () => { dialogUser.value = false; formUser.reset(); },
        });
    }
};

const dialogDeleteUser  = shallowRef(false);
const deleteUserTarget  = ref(null);
const deleteUserProc    = ref(false);

const openDeleteUser = (u) => { deleteUserTarget.value = u; dialogDeleteUser.value = true; };
const confirmDeleteUser = () => {
    deleteUserProc.value = true;
    router.delete(route("users.destroy", deleteUserTarget.value.id_user), {
        onFinish: () => { deleteUserProc.value = false; dialogDeleteUser.value = false; },
    });
};

const roleColor = (name) => ({
    "Super-administrateur": "#f15a2d",
    "Administrateur":       "#1b449c",
}[name] ?? "#6b7280");

// ── Roles & Permissions tab ──────────────────────────────────────

// Permission grouping
const permGroups = computed(() => {
    const groups = {};
    (props.allPermissions ?? []).forEach((p) => {
        const parts = p.name.split(".");
        const key = parts.length === 2 ? parts[0]
            : p.name.startsWith("manage_") ? "_system" : "_other";
        if (!groups[key]) groups[key] = [];
        groups[key].push(p);
    });
    return groups;
});

const groupMeta = {
    user:       { label: "Utilisateurs",  icon: "mdi-account-group-outline",    color: "#1b449c" },
    role:       { label: "Rôles",          icon: "mdi-shield-account-outline",   color: "#7c3aed" },
    permission: { label: "Permissions",    icon: "mdi-key-outline",              color: "#d97706" },
    management: { label: "Gestion",        icon: "mdi-cog-outline",              color: "#059669" },
    _system:    { label: "Système",        icon: "mdi-server-security",          color: "#dc2626" },
    _other:     { label: "Autres",         icon: "mdi-circle-outline",           color: "#6b7280" },
};

const getGroupMeta = (key) => groupMeta[key] ?? { label: key, icon: "mdi-circle-outline", color: "#6b7280" };

// Role dialog
const dialogRole   = shallowRef(false);
const isRoleEditing = ref(false);

const formRole = useForm({ id: null, name: "", permissions: [] });

const openAddRole = () => {
    formRole.reset(); formRole.clearErrors();
    isRoleEditing.value = false; dialogRole.value = true;
};

const openEditRole = (role) => {
    formRole.id          = role.id;
    formRole.name        = role.name;
    formRole.permissions = [...(role.permissions ?? [])];
    formRole.clearErrors();
    isRoleEditing.value = true; dialogRole.value = true;
};

const saveRole = () => {
    if (isRoleEditing.value) {
        formRole.put(route("roles.update", formRole.id), {
            onSuccess: () => { dialogRole.value = false; formRole.reset(); },
        });
    } else {
        formRole.post(route("roles.store"), {
            onSuccess: () => { dialogRole.value = false; formRole.reset(); },
        });
    }
};

// Toggle all permissions in a group
const toggleGroup = (groupPerms) => {
    const names = groupPerms.map((p) => p.name);
    const allOn = names.every((n) => formRole.permissions.includes(n));
    formRole.permissions = allOn
        ? formRole.permissions.filter((n) => !names.includes(n))
        : [...new Set([...formRole.permissions, ...names])];
};

const groupAllChecked = (groupPerms) =>
    groupPerms.every((p) => formRole.permissions.includes(p.name));

const groupSomeChecked = (groupPerms) =>
    groupPerms.some((p) => formRole.permissions.includes(p.name));

// Role delete
const dialogDeleteRole  = shallowRef(false);
const deleteRoleTarget  = ref(null);
const deleteRoleProc    = ref(false);

const openDeleteRole = (role) => { deleteRoleTarget.value = role; dialogDeleteRole.value = true; };
const confirmDeleteRole = () => {
    deleteRoleProc.value = true;
    router.delete(route("roles.destroy", deleteRoleTarget.value.id), {
        onFinish: () => { deleteRoleProc.value = false; dialogDeleteRole.value = false; },
    });
};
</script>

<template>
    <Head title="Utilisateurs" />
    <AuthenticatedLayout>
        <div class="users-page">

            <!-- Tab Navigation ─────────────────────────────────── -->
            <div class="tab-nav">
                <button
                    class="tab-btn"
                    :class="{ 'tab-btn--active': activeTab === 'users' }"
                    @click="activeTab = 'users'"
                >
                    <v-icon icon="mdi-account-group-outline" size="16" class="mr-1" />
                    Utilisateurs
                    <span class="tab-count">{{ users.length }}</span>
                </button>
                <button
                    class="tab-btn"
                    :class="{ 'tab-btn--active': activeTab === 'roles' }"
                    @click="activeTab = 'roles'"
                >
                    <v-icon icon="mdi-shield-key-outline" size="16" class="mr-1" />
                    Rôles &amp; Permissions
                    <span class="tab-count">{{ allRoles?.length ?? 0 }}</span>
                </button>
            </div>

            <!-- ══ TAB : Utilisateurs ═══════════════════════════ -->
            <div v-show="activeTab === 'users'">

                <!-- Stats -->
                <div class="stats-row">
                    <div class="stat-chip">
                        <v-icon icon="mdi-account-group-outline" size="22" class="stat-icon" />
                        <div>
                            <div class="stat-value">{{ users.length }}</div>
                            <div class="stat-label">Utilisateurs</div>
                        </div>
                    </div>
                    <div class="stat-chip">
                        <v-icon icon="mdi-shield-crown-outline" size="22" class="stat-icon stat-icon--orange" />
                        <div>
                            <div class="stat-value">{{ totalSuperAdmins }}</div>
                            <div class="stat-label">Super-admins</div>
                        </div>
                    </div>
                    <div class="stat-chip">
                        <v-icon icon="mdi-shield-account-outline" size="22" class="stat-icon stat-icon--blue" />
                        <div>
                            <div class="stat-value">{{ allRoles?.length ?? 0 }}</div>
                            <div class="stat-label">Rôles</div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-card">
                    <v-data-table
                        :headers="headers"
                        :items="users"
                        :search="search"
                        item-value="id"
                        fixed-header
                        height="520"
                        :items-per-page="10"
                        class="users-table"
                    >
                        <template #top>
                            <div class="table-toolbar">
                                <div class="toolbar-left">
                                    <v-icon icon="mdi-account-group-outline" size="20" class="mr-2" style="color:#f15a2d" />
                                    <span class="toolbar-title">Gestion des Utilisateurs</span>
                                </div>
                                <div class="toolbar-right">
                                    <div class="search-wrapper">
                                        <v-icon icon="mdi-magnify" size="18" class="search-icon" />
                                        <input v-model="search" type="text" placeholder="Rechercher..." class="search-input" />
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

                        <template #item.fullname="{ item }">
                            <div class="user-cell">
                                <div class="user-avatar-sm">
                                    {{ item.firstname?.[0]?.toUpperCase() }}{{ item.lastname?.[0]?.toUpperCase() }}
                                </div>
                                <div class="user-name">{{ item.lastname }} {{ item.firstname }}</div>
                            </div>
                        </template>

                        <template #item.email="{ item }">
                            <span class="email-text">{{ item.email }}</span>
                        </template>

                        <template #item.roles="{ item }">
                            <div class="roles-cell">
                                <span
                                    v-for="role in item.roles" :key="role.id"
                                    class="role-badge"
                                    :style="{ background: roleColor(role.name)+'22', color: roleColor(role.name), borderColor: roleColor(role.name)+'55' }"
                                >{{ role.name }}</span>
                                <span v-if="!item.roles.length" class="no-role">—</span>
                            </div>
                        </template>

                        <template #item.sex="{ item }">
                            <v-icon
                                :icon="item.sex === 'F' ? 'mdi-gender-female' : 'mdi-gender-male'"
                                :style="{ color: item.sex === 'F' ? '#e91e8c' : '#1b449c' }"
                                size="18"
                            />
                        </template>

                        <template #item.actions="{ item }">
                            <div class="action-btns">
                                <button class="icon-btn icon-btn--edit" title="Modifier" @click="openEdit(item)">
                                    <v-icon icon="mdi-pencil-outline" size="16" />
                                </button>
                                <button class="icon-btn icon-btn--delete" title="Supprimer" @click="openDeleteUser(item)">
                                    <v-icon icon="mdi-delete-outline" size="16" />
                                </button>
                            </div>
                        </template>

                        <template #no-data>
                            <div class="no-data">
                                <v-icon icon="mdi-account-off-outline" size="40" class="mb-2" style="opacity:.3" />
                                <p>Aucun utilisateur trouvé</p>
                                <button class="add-btn mt-3" @click="openAdd">
                                    <v-icon icon="mdi-plus" size="16" class="mr-1" />Créer le premier utilisateur
                                </button>
                            </div>
                        </template>
                    </v-data-table>
                </div>
            </div>

            <!-- ══ TAB : Rôles & Permissions ════════════════════ -->
            <div v-show="activeTab === 'roles'">

                <!-- Toolbar roles -->
                <div class="roles-toolbar">
                    <div class="toolbar-left">
                        <v-icon icon="mdi-shield-key-outline" size="20" class="mr-2" style="color:#f15a2d" />
                        <span class="toolbar-title">Gestion des Rôles &amp; Permissions</span>
                    </div>
                    <button class="add-btn" @click="openAddRole">
                        <v-icon icon="mdi-plus" size="18" class="mr-1" />
                        <span class="d-none d-sm-inline">Créer un rôle</span>
                    </button>
                </div>

                <!-- Role cards -->
                <div class="roles-grid">
                    <div
                        v-for="role in allRoles"
                        :key="role.id"
                        class="role-card"
                    >
                        <div class="role-card__header">
                            <div class="role-card__icon">
                                <v-icon icon="mdi-shield-account" size="22" style="color:#1b449c" />
                            </div>
                            <div class="role-card__name">{{ role.name }}</div>
                        </div>

                        <div class="role-card__stats">
                            <div class="role-stat">
                                <v-icon icon="mdi-account-multiple-outline" size="14" class="mr-1" />
                                <span>{{ role.users_count }} utilisateur{{ role.users_count !== 1 ? 's' : '' }}</span>
                            </div>
                            <div class="role-stat">
                                <v-icon icon="mdi-key-outline" size="14" class="mr-1" />
                                <span>{{ role.permissions?.length ?? 0 }} permission{{ (role.permissions?.length ?? 0) !== 1 ? 's' : '' }}</span>
                            </div>
                        </div>

                        <!-- Permission preview (first 4) -->
                        <div class="role-card__perms">
                            <span
                                v-for="p in (role.permissions ?? []).slice(0, 5)"
                                :key="p"
                                class="perm-chip"
                            >{{ p }}</span>
                            <span v-if="(role.permissions?.length ?? 0) > 5" class="perm-chip perm-chip--more">
                                +{{ role.permissions.length - 5 }}
                            </span>
                            <span v-if="!(role.permissions?.length)" class="perm-empty">Aucune permission</span>
                        </div>

                        <div class="role-card__actions">
                            <button class="role-action-btn role-action-btn--edit" @click="openEditRole(role)">
                                <v-icon icon="mdi-pencil-outline" size="14" class="mr-1" />
                                Modifier
                            </button>
                            <button
                                class="role-action-btn role-action-btn--delete"
                                :disabled="role.name === 'Super-administrateur'"
                                @click="openDeleteRole(role)"
                            >
                                <v-icon icon="mdi-delete-outline" size="14" class="mr-1" />
                                Supprimer
                            </button>
                        </div>
                    </div>

                    <!-- Empty state -->
                    <div v-if="!allRoles?.length" class="roles-empty">
                        <v-icon icon="mdi-shield-off-outline" size="40" class="mb-2" style="opacity:.3" />
                        <p>Aucun rôle créé</p>
                    </div>
                </div>

                <!-- All permissions reference -->
                <div class="perms-reference">
                    <div class="perms-reference__title">
                        <v-icon icon="mdi-key-variant" size="16" class="mr-1" style="color:#d97706" />
                        Référence des permissions disponibles
                    </div>
                    <div class="perms-groups">
                        <div v-for="(perms, groupKey) in permGroups" :key="groupKey" class="perm-group">
                            <div class="perm-group__header">
                                <v-icon :icon="getGroupMeta(groupKey).icon" size="14" class="mr-1" :style="{ color: getGroupMeta(groupKey).color }" />
                                {{ getGroupMeta(groupKey).label }}
                            </div>
                            <div class="perm-group__perms">
                                <span v-for="p in perms" :key="p.id" class="perm-ref-chip">{{ p.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ── Dialog : Créer / Modifier utilisateur ─────────────── -->
        <v-dialog v-model="dialogUser" max-width="520" :persistent="formUser.processing">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon
                        :icon="isEditing ? 'mdi-account-edit-outline' : 'mdi-account-plus-outline'"
                        size="20" class="mr-2" style="color:#f15a2d"
                    />
                    <h3>{{ isEditing ? "Modifier l'utilisateur" : "Nouvel utilisateur" }}</h3>
                    <button class="modal-close" @click="dialogUser = false">
                        <v-icon icon="mdi-close" size="18" />
                    </button>
                </div>
                <div class="modal-body">
                    <div class="field-row">
                        <div class="field-group">
                            <label class="field-label">Nom <span class="required">*</span></label>
                            <input v-model="formUser.lastname" type="text" class="field-input"
                                :class="{ 'field-input--error': formUser.errors.lastname }"
                                placeholder="Ex : Mahamane" />
                            <span v-if="formUser.errors.lastname" class="field-error">{{ formUser.errors.lastname }}</span>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Prénom <span class="required">*</span></label>
                            <input v-model="formUser.firstname" type="text" class="field-input"
                                :class="{ 'field-input--error': formUser.errors.firstname }"
                                placeholder="Ex : Ibrahim" />
                            <span v-if="formUser.errors.firstname" class="field-error">{{ formUser.errors.firstname }}</span>
                        </div>
                    </div>

                    <div class="field-group mt-3">
                        <label class="field-label">Login généré automatiquement</label>
                        <div class="email-preview" :class="{ 'email-preview--empty': !emailPreview }">
                            <v-icon icon="mdi-email-outline" size="15" class="mr-1" style="opacity:.6" />
                            {{ emailPreview || "Renseignez le nom et prénom" }}
                        </div>
                        <span class="form-hint">Ce login sera l'identifiant de connexion.</span>
                    </div>

                    <div class="field-row mt-3">
                        <div class="field-group">
                            <label class="field-label">Sexe <span class="required">*</span></label>
                            <div class="sex-toggle">
                                <button type="button" class="sex-btn" :class="{ 'sex-btn--active': formUser.sex === 'M' }" @click="formUser.sex = 'M'">
                                    <v-icon icon="mdi-gender-male" size="16" class="mr-1" /> M
                                </button>
                                <button type="button" class="sex-btn" :class="{ 'sex-btn--active sex-btn--female': formUser.sex === 'F' }" @click="formUser.sex = 'F'">
                                    <v-icon icon="mdi-gender-female" size="16" class="mr-1" /> F
                                </button>
                            </div>
                            <span v-if="formUser.errors.sex" class="field-error">{{ formUser.errors.sex }}</span>
                        </div>
                    </div>

                    <div class="field-group mt-3">
                        <label class="field-label">Rôle(s)</label>
                        <div class="roles-picker">
                            <label v-for="role in allRoles" :key="role.id" class="role-check"
                                :class="{ 'role-check--active': formUser.roles.includes(role.name) }">
                                <input type="checkbox" :value="role.name" v-model="formUser.roles" class="role-check-input" />
                                <v-icon icon="mdi-shield-account-outline" size="14" class="mr-1" />
                                {{ role.name }}
                            </label>
                        </div>
                    </div>

                    <div class="field-group mt-3">
                        <label class="field-label">
                            {{ isEditing ? "Nouveau mot de passe" : "Mot de passe" }}
                            <span v-if="!isEditing" class="required">*</span>
                            <span v-if="isEditing" class="form-hint-inline">(laisser vide pour ne pas changer)</span>
                        </label>
                        <div class="password-wrapper">
                            <input v-model="formUser.password"
                                :type="showPassword ? 'text' : 'password'"
                                class="field-input"
                                :class="{ 'field-input--error': formUser.errors.password }"
                                :placeholder="isEditing ? '••••••••' : 'Min. 8 caractères'" />
                            <button type="button" class="pw-toggle" @click="showPassword = !showPassword">
                                <v-icon :icon="showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'" size="16" />
                            </button>
                        </div>
                        <span v-if="!isEditing" class="form-hint">Mot de passe provisoire par défaut : <strong>password</strong>.</span>
                        <span v-if="formUser.errors.password" class="field-error">{{ formUser.errors.password }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogUser = false">Annuler</button>
                    <button class="btn-confirm" :disabled="formUser.processing" @click="saveUser">
                        <v-progress-circular v-if="formUser.processing" size="14" width="2" indeterminate class="mr-1" />
                        {{ isEditing ? "Enregistrer" : "Créer" }}
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ── Dialog : Supprimer utilisateur ────────────────────── -->
        <v-dialog v-model="dialogDeleteUser" max-width="400">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon icon="mdi-alert-circle-outline" size="20" class="mr-2" style="color:#e74c3c" />
                    <h3>Confirmer la suppression</h3>
                    <button class="modal-close" @click="dialogDeleteUser = false"><v-icon icon="mdi-close" size="18" /></button>
                </div>
                <div class="modal-body">
                    <p class="confirm-text">
                        Voulez-vous vraiment supprimer l'utilisateur
                        <strong>{{ deleteUserTarget?.lastname }} {{ deleteUserTarget?.firstname }}</strong> ?
                        Cette action est irréversible.
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogDeleteUser = false">Annuler</button>
                    <button class="btn-danger" :disabled="deleteUserProc" @click="confirmDeleteUser">
                        <v-progress-circular v-if="deleteUserProc" size="14" width="2" indeterminate class="mr-1" />
                        Supprimer
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ── Dialog : Créer / Modifier rôle ────────────────────── -->
        <v-dialog v-model="dialogRole" max-width="600" :persistent="formRole.processing">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon
                        :icon="isRoleEditing ? 'mdi-shield-edit-outline' : 'mdi-shield-plus-outline'"
                        size="20" class="mr-2" style="color:#f15a2d"
                    />
                    <h3>{{ isRoleEditing ? "Modifier le rôle" : "Nouveau rôle" }}</h3>
                    <button class="modal-close" @click="dialogRole = false"><v-icon icon="mdi-close" size="18" /></button>
                </div>

                <div class="modal-body modal-body--scroll">

                    <!-- Nom du rôle -->
                    <div class="field-group">
                        <label class="field-label">Nom du rôle <span class="required">*</span></label>
                        <input v-model="formRole.name" type="text" class="field-input"
                            :class="{ 'field-input--error': formRole.errors.name }"
                            placeholder="Ex : Responsable RH"
                            @keyup.enter="saveRole" />
                        <span v-if="formRole.errors.name" class="field-error">{{ formRole.errors.name }}</span>
                    </div>

                    <!-- Permissions groupées -->
                    <div class="field-group mt-4">
                        <div class="perm-section-header">
                            <label class="field-label" style="margin:0">
                                Permissions
                                <span class="perm-count-badge">{{ formRole.permissions.length }} sélectionnée{{ formRole.permissions.length !== 1 ? 's' : '' }}</span>
                            </label>
                            <button type="button" class="btn-clear-all" @click="formRole.permissions = []">
                                Tout effacer
                            </button>
                        </div>

                        <div class="perm-groups-list">
                            <div
                                v-for="(perms, groupKey) in permGroups"
                                :key="groupKey"
                                class="perm-group-block"
                            >
                                <!-- Group header with select-all -->
                                <div class="perm-group-block__header" @click="toggleGroup(perms)">
                                    <div class="perm-group-block__label">
                                        <v-icon
                                            :icon="getGroupMeta(groupKey).icon"
                                            size="14" class="mr-1"
                                            :style="{ color: getGroupMeta(groupKey).color }"
                                        />
                                        {{ getGroupMeta(groupKey).label }}
                                    </div>
                                    <div class="perm-group-block__toggle">
                                        <span class="group-check-indicator"
                                            :class="{
                                                'group-check-indicator--all': groupAllChecked(perms),
                                                'group-check-indicator--some': !groupAllChecked(perms) && groupSomeChecked(perms),
                                            }"
                                        >
                                            <v-icon
                                                :icon="groupAllChecked(perms) ? 'mdi-checkbox-marked' : groupSomeChecked(perms) ? 'mdi-minus-box' : 'mdi-checkbox-blank-outline'"
                                                size="16"
                                            />
                                        </span>
                                        <span class="group-toggle-label">Tout</span>
                                    </div>
                                </div>

                                <!-- Individual permissions -->
                                <div class="perm-checks">
                                    <label
                                        v-for="p in perms"
                                        :key="p.id"
                                        class="perm-check"
                                        :class="{ 'perm-check--active': formRole.permissions.includes(p.name) }"
                                    >
                                        <input
                                            type="checkbox"
                                            :value="p.name"
                                            v-model="formRole.permissions"
                                            class="perm-check-input"
                                        />
                                        <span class="perm-check-name">{{ p.name }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogRole = false">Annuler</button>
                    <button class="btn-confirm" :disabled="formRole.processing" @click="saveRole">
                        <v-progress-circular v-if="formRole.processing" size="14" width="2" indeterminate class="mr-1" />
                        {{ isRoleEditing ? "Enregistrer" : "Créer le rôle" }}
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ── Dialog : Supprimer rôle ────────────────────────────── -->
        <v-dialog v-model="dialogDeleteRole" max-width="420">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon icon="mdi-alert-circle-outline" size="20" class="mr-2" style="color:#e74c3c" />
                    <h3>Supprimer le rôle</h3>
                    <button class="modal-close" @click="dialogDeleteRole = false"><v-icon icon="mdi-close" size="18" /></button>
                </div>
                <div class="modal-body">
                    <p class="confirm-text">
                        Voulez-vous vraiment supprimer le rôle
                        <strong>{{ deleteRoleTarget?.name }}</strong> ?
                        Les utilisateurs ayant ce rôle le perdront automatiquement.
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogDeleteRole = false">Annuler</button>
                    <button class="btn-danger" :disabled="deleteRoleProc" @click="confirmDeleteRole">
                        <v-progress-circular v-if="deleteRoleProc" size="14" width="2" indeterminate class="mr-1" />
                        Supprimer
                    </button>
                </div>
            </div>
        </v-dialog>

    </AuthenticatedLayout>
</template>

<style scoped>
.users-page { padding: 24px; }

/* ── Tab Navigation ─────────────────────────────────────────────── */
.tab-nav {
    display: flex;
    gap: 4px;
    margin-bottom: 24px;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 6px;
    width: fit-content;
}

.tab-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    border-radius: 8px;
    border: none;
    background: none;
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}

.tab-btn:hover { background: var(--card-hover); color: var(--text-primary); }

.tab-btn--active {
    background: #1b449c;
    color: white;
    font-weight: 600;
}

.tab-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 18px;
    padding: 0 5px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 700;
    background: rgba(255,255,255,0.15);
}

.tab-btn--active .tab-count { background: rgba(255,255,255,0.25); }
.tab-btn:not(.tab-btn--active) .tab-count { background: var(--border-color); color: var(--text-secondary); }

/* ── Stats ──────────────────────────────────────────────────────── */
.stats-row { display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 24px; }

.stat-chip {
    display: flex; align-items: center; gap: 12px;
    background: var(--card-bg); border: 1px solid var(--border-color);
    border-radius: 12px; padding: 14px 20px; min-width: 150px;
}

.stat-icon { color: #1b449c; }
.stat-icon--orange { color: #f15a2d; }
.stat-icon--blue { color: #3498db; }
.stat-value { font-size: 22px; font-weight: 700; color: var(--text-primary); line-height: 1.1; }
.stat-label { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }

/* ── Table ──────────────────────────────────────────────────────── */
.table-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 14px; overflow: hidden; }

:deep(.users-table), :deep(.users-table .v-table), :deep(.users-table .v-table__wrapper), :deep(.users-table table) {
    background: transparent !important; color: var(--text-primary) !important;
}
:deep(.users-table thead), :deep(.users-table thead tr), :deep(.users-table .v-data-table__thead tr) { background: var(--dark-bg) !important; }
:deep(.users-table thead th), :deep(.users-table .v-data-table-headers__th) {
    background: var(--dark-bg) !important; color: var(--text-secondary) !important;
    font-size: 11px !important; font-weight: 600 !important;
    text-transform: uppercase !important; letter-spacing: 0.05em !important;
    border-bottom: 1px solid var(--border-color) !important;
}
:deep(.users-table tbody tr) { border-bottom: 1px solid var(--border-color) !important; transition: background 0.15s; }
:deep(.users-table tbody tr:hover) { background: var(--card-hover) !important; }
:deep(.users-table tbody td) { color: var(--text-primary) !important; font-size: 13px !important; padding: 10px 16px !important; }
:deep(.users-table .v-data-table-footer) {
    background: var(--dark-bg) !important; color: var(--text-secondary) !important;
    border-top: 1px solid var(--border-color) !important;
}

/* ── Table toolbar ──────────────────────────────────────────────── */
.table-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 18px; border-bottom: 1px solid var(--border-color);
    flex-wrap: wrap; gap: 10px;
}
.toolbar-left { display: flex; align-items: center; }
.toolbar-title { font-size: 15px; font-weight: 600; color: var(--text-primary); }
.toolbar-right { display: flex; align-items: center; gap: 10px; }

.search-wrapper { position: relative; display: flex; align-items: center; }
.search-icon { position: absolute; left: 10px; color: var(--text-secondary); }
.search-input {
    background: var(--dark-bg); border: 1px solid var(--border-color);
    border-radius: 8px; color: var(--text-primary); font-size: 13px;
    padding: 7px 32px 7px 32px; width: 200px; outline: none; transition: border-color 0.2s;
}
.search-input:focus { border-color: #1b449c; }
.search-clear { position: absolute; right: 8px; background: none; border: none; color: var(--text-secondary); cursor: pointer; padding: 0; display: flex; }

.add-btn {
    display: flex; align-items: center;
    background: #1b449c; color: white;
    border: none; border-radius: 8px;
    padding: 8px 14px; font-size: 13px; font-weight: 600;
    cursor: pointer; transition: background 0.2s, transform 0.15s; white-space: nowrap;
}
.add-btn:hover { background: #163a86; transform: translateY(-1px); }

/* ── User cells ─────────────────────────────────────────────────── */
.user-cell { display: flex; align-items: center; gap: 10px; }
.user-avatar-sm {
    width: 32px; height: 32px; border-radius: 50%;
    background: linear-gradient(135deg, #1b449c, #f15a2d);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700; color: white; flex-shrink: 0;
}
.user-name { font-size: 13px; font-weight: 500; color: var(--text-primary); }
.email-text { font-size: 12px; color: var(--text-secondary); font-family: monospace; }
.phone-text { font-size: 12px; color: var(--text-secondary); }

.roles-cell { display: flex; flex-wrap: wrap; gap: 4px; }
.role-badge {
    display: inline-block; padding: 2px 8px; border-radius: 12px;
    font-size: 11px; font-weight: 600; border: 1px solid; white-space: nowrap;
}
.no-role { color: var(--text-secondary); font-size: 13px; }

.action-btns { display: flex; gap: 6px; justify-content: flex-end; }
.icon-btn {
    width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;
    border-radius: 6px; border: 1px solid var(--border-color); background: none;
    cursor: pointer; transition: all 0.15s; color: var(--text-secondary);
}
.icon-btn--edit:hover { background: rgba(27,68,156,0.15); border-color: #1b449c; color: #1b449c; }
.icon-btn--delete:hover { background: rgba(231,76,60,0.15); border-color: #e74c3c; color: #e74c3c; }

.no-data { display: flex; flex-direction: column; align-items: center; padding: 48px 24px; color: var(--text-secondary); }

/* ── Roles tab ──────────────────────────────────────────────────── */
.roles-toolbar {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; flex-wrap: wrap; gap: 10px;
}

.roles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
}

.role-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 14px;
    transition: border-color 0.2s, transform 0.15s;
}
.role-card:hover { border-color: #1b449c55; transform: translateY(-2px); }

.role-card__header { display: flex; align-items: center; gap: 10px; }
.role-card__icon {
    width: 40px; height: 40px; border-radius: 10px;
    background: rgba(27,68,156,0.12);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.role-card__name { font-size: 15px; font-weight: 700; color: var(--text-primary); }

.role-card__stats { display: flex; gap: 16px; }
.role-stat { display: flex; align-items: center; font-size: 12px; color: var(--text-secondary); }

.role-card__perms { display: flex; flex-wrap: wrap; gap: 5px; min-height: 26px; }
.perm-chip {
    display: inline-block; padding: 2px 8px; border-radius: 6px;
    font-size: 10px; font-weight: 600; font-family: monospace;
    background: rgba(27,68,156,0.1); color: #1b449c; border: 1px solid rgba(27,68,156,0.2);
}
.perm-chip--more { background: var(--dark-bg); color: var(--text-secondary); border-color: var(--border-color); font-family: inherit; font-weight: 500; }
.perm-empty { font-size: 12px; color: var(--text-secondary); font-style: italic; }

.role-card__actions { display: flex; gap: 8px; margin-top: auto; }
.role-action-btn {
    flex: 1; display: flex; align-items: center; justify-content: center;
    padding: 7px 10px; border-radius: 8px; font-size: 12px; font-weight: 600;
    cursor: pointer; transition: all 0.15s; border: 1px solid var(--border-color);
    background: none; color: var(--text-secondary);
}
.role-action-btn--edit:hover { background: rgba(27,68,156,0.12); border-color: #1b449c; color: #1b449c; }
.role-action-btn--delete:hover:not(:disabled) { background: rgba(231,76,60,0.1); border-color: #e74c3c; color: #e74c3c; }
.role-action-btn:disabled { opacity: 0.3; cursor: not-allowed; }

.roles-empty { display: flex; flex-direction: column; align-items: center; padding: 48px; color: var(--text-secondary); }

/* ── Permissions reference ──────────────────────────────────────── */
.perms-reference {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    padding: 20px;
}
.perms-reference__title {
    display: flex; align-items: center;
    font-size: 13px; font-weight: 600; color: var(--text-secondary);
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border-color);
}
.perms-groups { display: flex; flex-direction: column; gap: 14px; }
.perm-group {}
.perm-group__header {
    display: flex; align-items: center;
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.05em; color: var(--text-secondary);
    margin-bottom: 7px;
}
.perm-group__perms { display: flex; flex-wrap: wrap; gap: 6px; }
.perm-ref-chip {
    display: inline-block; padding: 3px 10px; border-radius: 6px;
    font-size: 11px; font-family: monospace;
    background: var(--dark-bg); color: var(--text-secondary); border: 1px solid var(--border-color);
}

/* ── Permission dialog ──────────────────────────────────────────── */
.perm-section-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 12px;
}
.perm-count-badge {
    display: inline-block; margin-left: 8px; padding: 2px 8px;
    border-radius: 10px; font-size: 10px; font-weight: 600;
    background: rgba(27,68,156,0.15); color: #1b449c;
    text-transform: none; letter-spacing: 0;
}
.btn-clear-all {
    background: none; border: none; color: var(--text-secondary);
    font-size: 11px; cursor: pointer; padding: 0; text-decoration: underline;
    transition: color 0.15s;
}
.btn-clear-all:hover { color: #e74c3c; }

.perm-groups-list { display: flex; flex-direction: column; gap: 8px; }

.perm-group-block {
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    overflow: hidden;
}

.perm-group-block__header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 14px;
    cursor: pointer;
    transition: background 0.15s;
}
.perm-group-block__header:hover { background: var(--card-hover); }

.perm-group-block__label {
    display: flex; align-items: center;
    font-size: 12px; font-weight: 600; color: var(--text-secondary);
}

.perm-group-block__toggle {
    display: flex; align-items: center; gap: 4px;
    font-size: 11px; color: var(--text-secondary);
}

.group-check-indicator { display: flex; color: var(--text-secondary); }
.group-check-indicator--all { color: #1b449c; }
.group-check-indicator--some { color: #d97706; }
.group-toggle-label { font-size: 11px; }

.perm-checks {
    display: flex; flex-wrap: wrap; gap: 6px;
    padding: 8px 14px 12px;
    border-top: 1px solid var(--border-color);
}

.perm-check {
    display: flex; align-items: center; gap: 5px;
    padding: 4px 10px; border-radius: 6px;
    border: 1px solid var(--border-color);
    background: var(--card-bg);
    cursor: pointer; transition: all 0.15s;
    user-select: none;
}
.perm-check:hover { border-color: #1b449c; }
.perm-check--active {
    background: rgba(27,68,156,0.15);
    border-color: #1b449c;
}
.perm-check-input { display: none; }
.perm-check-name {
    font-size: 11px; font-family: monospace; font-weight: 600;
    color: var(--text-secondary);
}
.perm-check--active .perm-check-name { color: #1b449c; }

/* ── Modal ──────────────────────────────────────────────────────── */
.modal-card { background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 14px; overflow: hidden; }
.modal-header { display: flex; align-items: center; padding: 16px 18px; border-bottom: 1px solid var(--border-color); gap: 2px; }
.modal-header h3 { flex: 1; font-size: 15px; font-weight: 600; color: var(--text-primary); margin: 0; }
.modal-close { background: none; border: none; color: var(--text-secondary); cursor: pointer; padding: 4px; border-radius: 6px; display: flex; transition: all 0.15s; margin-left: auto; }
.modal-close:hover { background: var(--card-hover); color: var(--text-primary); }
.modal-body { padding: 20px 18px; }
.modal-body--scroll { max-height: 65vh; overflow-y: auto; }
.modal-footer { display: flex; justify-content: flex-end; gap: 10px; padding: 14px 18px; border-top: 1px solid var(--border-color); }

/* ── Form ───────────────────────────────────────────────────────── */
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.field-group { display: flex; flex-direction: column; gap: 6px; }
.field-label { font-size: 12px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.04em; }
.required { color: #f15a2d; margin-left: 2px; }
.field-input { background: var(--dark-bg); border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-primary); font-size: 13px; padding: 9px 12px; outline: none; transition: border-color 0.2s; width: 100%; }
.field-input:focus { border-color: #1b449c; }
.field-input--error { border-color: #e74c3c !important; }
.field-error { font-size: 11px; color: #e74c3c; }
.form-hint { font-size: 11px; color: var(--text-secondary); }
.form-hint-inline { font-size: 11px; color: var(--text-secondary); font-weight: 400; text-transform: none; letter-spacing: 0; margin-left: 4px; }

.email-preview { background: var(--dark-bg); border: 1px dashed var(--border-color); border-radius: 8px; padding: 9px 12px; font-size: 12px; font-family: monospace; color: #2ecc71; display: flex; align-items: center; }
.email-preview--empty { color: var(--text-secondary); font-family: inherit; }

.sex-toggle { display: flex; gap: 8px; }
.sex-btn { flex: 1; display: flex; align-items: center; justify-content: center; padding: 8px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--dark-bg); color: var(--text-secondary); font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.15s; }
.sex-btn--active { background: rgba(27,68,156,0.2); border-color: #1b449c; color: #1b449c; }
.sex-btn--female.sex-btn--active { background: rgba(233,30,140,0.15); border-color: #e91e8c; color: #e91e8c; }

.roles-picker { display: flex; flex-wrap: wrap; gap: 8px; }
.role-check { display: flex; align-items: center; padding: 6px 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--dark-bg); color: var(--text-secondary); font-size: 12px; font-weight: 500; cursor: pointer; transition: all 0.15s; gap: 4px; user-select: none; }
.role-check:hover { border-color: #1b449c; color: #1b449c; }
.role-check--active { background: rgba(27,68,156,0.2); border-color: #1b449c; color: #1b449c; }
.role-check-input { display: none; }

.password-wrapper { position: relative; display: flex; align-items: center; }
.password-wrapper .field-input { padding-right: 38px; }
.pw-toggle { position: absolute; right: 10px; background: none; border: none; color: var(--text-secondary); cursor: pointer; display: flex; padding: 0; }
.pw-toggle:hover { color: var(--text-primary); }

.btn-cancel { background: none; border: 1px solid var(--border-color); border-radius: 8px; color: var(--text-secondary); font-size: 13px; font-weight: 600; padding: 9px 18px; cursor: pointer; transition: all 0.15s; }
.btn-cancel:hover { border-color: var(--text-secondary); color: var(--text-primary); }
.btn-confirm { display: flex; align-items: center; background: #1b449c; color: white; border: none; border-radius: 8px; font-size: 13px; font-weight: 600; padding: 9px 20px; cursor: pointer; transition: background 0.15s; }
.btn-confirm:hover:not(:disabled) { background: #163a86; }
.btn-confirm:disabled { opacity: 0.6; cursor: not-allowed; }
.btn-danger { display: flex; align-items: center; background: rgba(231,76,60,0.1); border: 1px solid rgba(231,76,60,0.3); border-radius: 8px; color: #e74c3c; font-size: 13px; font-weight: 600; padding: 9px 18px; cursor: pointer; transition: all 0.15s; }
.btn-danger:hover:not(:disabled) { background: rgba(231,76,60,0.2); }
.btn-danger:disabled { opacity: 0.6; cursor: not-allowed; }

.confirm-text { color: var(--text-secondary); font-size: 13px; line-height: 1.6; }
.confirm-text strong { color: var(--text-primary); }

.mt-3 { margin-top: 12px; }
.mt-4 { margin-top: 20px; }
.mb-2 { margin-bottom: 8px; }
.mr-1 { margin-right: 4px; }
.mr-2 { margin-right: 8px; }

@media (max-width: 600px) {
    .users-page { padding: 16px; }
    .field-row { grid-template-columns: 1fr; }
    .search-input { width: 140px; }
    .roles-grid { grid-template-columns: 1fr; }
    .tab-nav { width: 100%; }
    .tab-btn { flex: 1; justify-content: center; }
}
</style>
