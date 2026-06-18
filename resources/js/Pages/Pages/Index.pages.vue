<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { computed, ref, watch, shallowRef } from "vue";

const props = defineProps({
    allPages: Array,
    errors:   Object,
});

// ── Active page ──────────────────────────────────────────────────
const activePageId = ref(null);

watch(
    () => props.allPages,
    (pages) => {
        if (pages?.length && !activePageId.value) {
            activePageId.value = pages[0].id_page;
        }
    },
    { immediate: true }
);

const selectedPage = computed(() =>
    props.allPages?.find((p) => p.id_page === activePageId.value)
);

const totalCards = computed(() =>
    selectedPage.value?.sections?.reduce((n, s) => n + (s.cards?.length ?? 0), 0) ?? 0
);

// ── Active section (sub-menu) ────────────────────────────────────
const activeSectionId = ref(null);

watch(
    selectedPage,
    (page) => {
        activeSectionId.value = page?.sections?.[0]?.id_section ?? null;
    },
    { immediate: true }
);

const selectedSection = computed(() =>
    selectedPage.value?.sections?.find((s) => s.id_section === activeSectionId.value)
);

// ── Route publique par page ──────────────────────────────────────
const pageRoutes = {
    'Accueil':          '/',
    'Qui sommes-nous?': '/about-us',
    'Services':         '/services',
    'Réalisations':     '/realisations',
    'Équipe':           '/equipe',
    'Partenaires':      '/partenaires',
    'Contact':          '/nous-contacter',
};
const pagePublicUrl = (titre) => pageRoutes[titre] ?? null;

// ── Sources dédiées (contenu géré par un dashboard séparé) ───────
const dedicatedSources = {
    'Services': {
        'Introduction':   { label: 'Départements & Services', adminRoute: route('departements'), icon: 'mdi-briefcase-outline' },
        'Nos Services':   { label: 'Départements & Services', adminRoute: route('departements'), icon: 'mdi-briefcase-outline' },
    },
    'Accueil': {
        'Nos Services':    { label: 'Départements & Services', adminRoute: route('departements'), icon: 'mdi-briefcase-outline' },
        'Réalisations':    { label: 'Réalisations',            adminRoute: route('realisations'), icon: 'mdi-image-outline' },
        'Notre Équipe':    { label: 'Équipe',                  adminRoute: route('employes'),     icon: 'mdi-account-group-outline' },
        'Nos Partenaires': { label: 'Partenaires',             adminRoute: route('partenaires'),  icon: 'mdi-handshake-outline' },
    },
    'Réalisations': {
        'Nos Projets': { label: 'Réalisations', adminRoute: route('realisations'), icon: 'mdi-image-outline' },
    },
    'Équipe': {
        'Notre Équipe': { label: 'Équipe', adminRoute: route('employes'), icon: 'mdi-account-group-outline' },
    },
    'Partenaires': {
        'Nos Partenaires': { label: 'Partenaires', adminRoute: route('partenaires'), icon: 'mdi-handshake-outline' },
    },
};

const sectionDedicatedSource = computed(() => {
    if (!selectedPage.value || !selectedSection.value) return null;
    return dedicatedSources[selectedPage.value.titre_page]?.[selectedSection.value.nom_section] ?? null;
});

// ── Hints contextuels pour sections spéciales ─────────────────────
const sectionHints = {
    'Accueil': {
        'Chiffres clés': {
            icon: 'mdi-counter',
            color: '#1b449c',
            lines: [
                'Chaque carte représente un chiffre affiché dans la bande de statistiques du héro.',
                '• Titre de la carte → valeur ("50+", "100+", "24/7")',
                '• Description → libellé ("Clients satisfaits", "Projets livrés"…)',
            ],
        },
        'Appels à l\'action': {
            icon: 'mdi-cursor-default-click-outline',
            color: '#f15a2d',
            lines: [
                'Chaque carte = un bouton CTA dans le héro. La 1ʳᵉ carte = bouton principal (orange), les suivantes = bouton secondaire.',
                '• Titre de la carte → texte du bouton ("Découvrir nos services")',
                '• Libellé bouton → URL de destination ("/services", "/nous-contacter")',
            ],
        },
    },
};

const sectionHint = computed(() => {
    if (!selectedPage.value || !selectedSection.value) return null;
    return sectionHints[selectedPage.value.titre_page]?.[selectedSection.value.nom_section] ?? null;
});

// ── Page CRUD ────────────────────────────────────────────────────
const dialogPage    = shallowRef(false);
const isPageEditing = ref(false);

const bannerPreview = ref(null);
const fileInputRef  = ref(null);

const formPage = useForm({
    _method:          'post',
    id_page:          null,
    titre_page:       "",
    slogan_page:      "",
    banniere_page:    null,
    description_page: "",
});

const openAddPage = () => {
    formPage.reset();
    formPage._method = 'post';
    formPage.clearErrors();
    bannerPreview.value = null;
    isPageEditing.value = false;
    dialogPage.value = true;
};

const openEditPage = (page) => {
    formPage.id_page          = page.id_page;
    formPage._method          = 'put';
    formPage.titre_page       = page.titre_page;
    formPage.slogan_page      = page.slogan_page      ?? "";
    formPage.banniere_page    = null;
    formPage.description_page = page.description_page ?? "";
    formPage.clearErrors();
    bannerPreview.value = page.banniere_page ?? null;
    isPageEditing.value = true;
    dialogPage.value = true;
};

const handleBannerFile = (e) => {
    const file = e.target?.files?.[0] ?? e.dataTransfer?.files?.[0];
    if (!file) return;
    formPage.banniere_page = file;
    bannerPreview.value = URL.createObjectURL(file);
};

const clearBanner = () => {
    formPage.banniere_page = null;
    bannerPreview.value = null;
    if (fileInputRef.value) fileInputRef.value.value = '';
};

const savePage = () => {
    const url = isPageEditing.value
        ? route("pages.update", formPage.id_page)
        : route("pages.store");
    formPage.post(url, {
        onSuccess: () => {
            dialogPage.value = false;
            formPage.reset();
            bannerPreview.value = null;
        },
    });
};

// ── Page delete ──────────────────────────────────────────────────
const dialogDeletePage  = shallowRef(false);
const deletePageTarget  = ref(null);
const deletePageProc    = ref(false);

const openDeletePage = (page) => { deletePageTarget.value = page; dialogDeletePage.value = true; };
const confirmDeletePage = () => {
    deletePageProc.value = true;
    router.delete(route("pages.destroy", deletePageTarget.value.id_page), {
        onFinish: () => {
            deletePageProc.value = false;
            dialogDeletePage.value = false;
            if (activePageId.value === deletePageTarget.value.id_page) {
                activePageId.value = props.allPages?.find(p => p.id_page !== deletePageTarget.value.id_page)?.id_page ?? null;
            }
        },
    });
};

// ── Section CRUD ─────────────────────────────────────────────────
const dialogSection    = shallowRef(false);
const isSectionEditing = ref(false);

const formSection = useForm({
    id_section:          null,
    nom_section:         "",
    description_section: "",
    icon_section:        "mdi-layers-outline",
    is_link_section:     false,
    id_page:             null,
});

const openAddSection = (pageId) => {
    formSection.reset(); formSection.clearErrors();
    formSection.id_page      = pageId;
    formSection.icon_section = "mdi-layers-outline";
    isSectionEditing.value = false; dialogSection.value = true;
};

const openEditSection = (section) => {
    formSection.id_section          = section.id_section;
    formSection.nom_section         = section.nom_section;
    formSection.description_section = section.description_section ?? "";
    formSection.icon_section        = section.icon_section ?? "mdi-layers-outline";
    formSection.is_link_section     = section.is_link_section;
    formSection.clearErrors();
    isSectionEditing.value = true; dialogSection.value = true;
};

const saveSection = () => {
    if (isSectionEditing.value) {
        formSection.put(route("sections.update", formSection.id_section), {
            onSuccess: () => { dialogSection.value = false; formSection.reset(); },
        });
    } else {
        formSection.post(route("sections.store"), {
            onSuccess: () => { dialogSection.value = false; formSection.reset(); },
        });
    }
};

// ── Section delete ───────────────────────────────────────────────
const dialogDeleteSection  = shallowRef(false);
const deleteSectionTarget  = ref(null);
const deleteSectionProc    = ref(false);

const openDeleteSection = (section) => { deleteSectionTarget.value = section; dialogDeleteSection.value = true; };
const confirmDeleteSection = () => {
    deleteSectionProc.value = true;
    router.delete(route("sections.destroy", deleteSectionTarget.value.id_section), {
        onFinish: () => {
            deleteSectionProc.value = false;
            dialogDeleteSection.value = false;
            if (activeSectionId.value === deleteSectionTarget.value.id_section) {
                activeSectionId.value = selectedPage.value?.sections?.find(
                    s => s.id_section !== deleteSectionTarget.value.id_section
                )?.id_section ?? null;
            }
        },
    });
};

// ── Card CRUD ────────────────────────────────────────────────────
const dialogCard    = shallowRef(false);
const isCardEditing = ref(false);

const formCard = useForm({
    id_card:           null,
    titre_card:        "",
    description_card:  "",
    icon_card:         "mdi-card-text-outline",
    titre_bouton_card: "",
    id_section:        null,
});

const openAddCard = (sectionId) => {
    formCard.reset(); formCard.clearErrors();
    formCard.id_section = sectionId;
    formCard.icon_card  = "mdi-card-text-outline";
    isCardEditing.value = false; dialogCard.value = true;
};

const openEditCard = (card, sectionId) => {
    formCard.id_card           = card.id_card;
    formCard.titre_card        = card.titre_card;
    formCard.description_card  = card.description_card  ?? "";
    formCard.icon_card         = card.icon_card         ?? "mdi-card-text-outline";
    formCard.titre_bouton_card = card.titre_bouton_card ?? "";
    formCard.id_section        = sectionId;
    formCard.clearErrors();
    isCardEditing.value = true; dialogCard.value = true;
};

const saveCard = () => {
    if (isCardEditing.value) {
        formCard.put(route("cards.update", formCard.id_card), {
            onSuccess: () => { dialogCard.value = false; formCard.reset(); },
        });
    } else {
        formCard.post(route("cards.store"), {
            onSuccess: () => { dialogCard.value = false; formCard.reset(); },
        });
    }
};

// ── Card delete ──────────────────────────────────────────────────
const dialogDeleteCard  = shallowRef(false);
const deleteCardTarget  = ref(null);
const deleteCardProc    = ref(false);

const openDeleteCard = (card) => { deleteCardTarget.value = card; dialogDeleteCard.value = true; };
const confirmDeleteCard = () => {
    deleteCardProc.value = true;
    router.delete(route("cards.destroy", deleteCardTarget.value.id_card), {
        onFinish: () => { deleteCardProc.value = false; dialogDeleteCard.value = false; },
    });
};

// ── Icon presets ─────────────────────────────────────────────────
const sectionIcons = [
    "mdi-panorama-variant-outline", "mdi-cog-outline",            "mdi-briefcase-outline",
    "mdi-check-decagram-outline",   "mdi-account-group-outline",  "mdi-email-newsletter",
    "mdi-handshake-outline",        "mdi-layers-outline",          "mdi-home-outline",
    "mdi-information-outline",      "mdi-star-outline",            "mdi-image-outline",
    "mdi-text-box-outline",         "mdi-link-variant",            "mdi-chart-bar",
    "mdi-map-marker-outline",       "mdi-phone-outline",           "mdi-shield-lock-outline",
];

const cardIcons = [
    "mdi-cpu-64-bit",               "mdi-monitor-shimmer",          "mdi-cellphone",
    "mdi-school-outline",           "mdi-shield-lock-outline",      "mdi-server-outline",
    "mdi-graph-outline",            "mdi-cart-outline",             "mdi-magnify-scan",
    "mdi-wifi",                     "mdi-code-braces",              "mdi-cloud-outline",
    "mdi-card-text-outline",        "mdi-check-circle-outline",     "mdi-lightbulb-outline",
    "mdi-rocket-launch-outline",    "mdi-trophy-outline",           "mdi-email-outline",
    "mdi-web",                      "mdi-printer-outline",          "mdi-chart-pie",
];
</script>

<template>
    <Head title="Pages" />
    <AuthenticatedLayout>
        <div class="pages-manager">

            <!-- ── Page tabs bar ──────────────────────────────────── -->
            <div class="page-tabs-bar">
                <div class="page-tabs-scroll">
                    <button
                        v-for="p in allPages"
                        :key="p.id_page"
                        class="page-tab"
                        :class="{ 'page-tab--active': activePageId === p.id_page }"
                        @click="activePageId = p.id_page"
                    >
                        <v-icon icon="mdi-web" size="13" class="mr-1" />
                        {{ p.titre_page }}
                        <span class="tab-badge">{{ p.sections?.length ?? 0 }}</span>
                    </button>
                </div>
                <button class="add-page-btn" @click="openAddPage">
                    <v-icon icon="mdi-plus" size="15" class="mr-1" />
                    <span class="d-none d-sm-inline">Nouvelle page</span>
                </button>
            </div>

            <!-- ── Empty: no pages ───────────────────────────────── -->
            <div v-if="!allPages?.length" class="empty-global">
                <v-icon icon="mdi-web-off" size="56" style="opacity:.2" />
                <p>Aucune page configurée</p>
                <button class="add-btn mt-3" @click="openAddPage">
                    <v-icon icon="mdi-plus" size="15" class="mr-1" />Créer la première page
                </button>
            </div>

            <!-- ── Page workspace ────────────────────────────────── -->
            <template v-else-if="selectedPage">

                <!-- Page info bar -->
                <div class="page-info-bar">
                    <div class="page-info-left">
                        <div class="page-banner-thumb" v-if="selectedPage.banniere_page">
                            <img :src="selectedPage.banniere_page" alt="bannière" />
                        </div>
                        <div v-else class="page-info-icon-bg">
                            <v-icon icon="mdi-web" size="20" style="color:#1b449c" />
                        </div>
                        <div class="page-info-text">
                            <span class="page-info-title">{{ selectedPage.titre_page }}</span>
                            <span v-if="selectedPage.slogan_page" class="page-info-slogan">
                                {{ selectedPage.slogan_page }}
                            </span>
                        </div>
                    </div>
                    <div class="page-info-right">
                        <span class="page-info-stat">
                            <v-icon icon="mdi-layers-outline" size="13" class="mr-1" />
                            {{ selectedPage.sections?.length ?? 0 }} section{{ (selectedPage.sections?.length ?? 0) !== 1 ? 's' : '' }}
                        </span>
                        <span class="page-info-stat">
                            <v-icon icon="mdi-card-text-outline" size="13" class="mr-1" />
                            {{ totalCards }} carte{{ totalCards !== 1 ? 's' : '' }}
                        </span>
                        <div class="page-info-actions">
                            <a v-if="pagePublicUrl(selectedPage.titre_page)"
                               :href="pagePublicUrl(selectedPage.titre_page)"
                               target="_blank"
                               class="icon-btn icon-btn--view"
                               title="Voir la page publique">
                                <v-icon icon="mdi-open-in-new" size="14" />
                            </a>
                            <button class="icon-btn icon-btn--edit" title="Modifier la page" @click="openEditPage(selectedPage)">
                                <v-icon icon="mdi-pencil-outline" size="14" />
                            </button>
                            <button class="icon-btn icon-btn--delete" title="Supprimer la page" @click="openDeletePage(selectedPage)">
                                <v-icon icon="mdi-delete-outline" size="14" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Two-column workspace -->
                <div class="workspace">

                    <!-- ── Left: sections sub-menu ──────────────── -->
                    <aside class="sections-sidebar">
                        <div class="sidebar-header">
                            <span class="sidebar-label">SECTIONS <span class="sidebar-label-count">{{ selectedPage.sections?.length ?? 0 }}</span></span>
                            <button class="sidebar-add-btn" title="Ajouter une section" @click="openAddSection(selectedPage.id_page)">
                                <v-icon icon="mdi-plus" size="15" />
                            </button>
                        </div>

                        <!-- Empty sections -->
                        <div v-if="!selectedPage.sections?.length" class="sidebar-empty">
                            <v-icon icon="mdi-layers-off-outline" size="28" style="opacity:.25" />
                            <p>Aucune section</p>
                            <button class="sidebar-create-btn" @click="openAddSection(selectedPage.id_page)">
                                Créer une section
                            </button>
                        </div>

                        <!-- Section nav items -->
                        <nav v-else class="sections-nav">
                            <button
                                v-for="section in selectedPage.sections"
                                :key="section.id_section"
                                class="section-nav-item"
                                :class="{ 'section-nav-item--active': activeSectionId === section.id_section }"
                                @click="activeSectionId = section.id_section"
                            >
                                <div class="section-nav-icon">
                                    <v-icon
                                        :icon="section.icon_section || 'mdi-layers-outline'"
                                        size="15"
                                    />
                                </div>
                                <div class="section-nav-text">
                                    <span class="section-nav-name">{{ section.nom_section }}</span>
                                    <span v-if="section.description_section" class="section-nav-desc">{{ section.description_section }}</span>
                                </div>
                                <span class="section-nav-count" :class="{ 'section-nav-count--empty': !section.cards?.length }">
                                    {{ section.cards?.length ?? 0 }}
                                </span>
                            </button>
                        </nav>
                    </aside>

                    <!-- ── Right: section editor ─────────────────── -->
                    <div class="section-editor">

                        <!-- No section selected / none exist -->
                        <div v-if="!selectedSection" class="editor-empty">
                            <v-icon icon="mdi-cursor-default-click-outline" size="44" style="opacity:.2" />
                            <p>Sélectionnez une section dans le menu</p>
                        </div>

                        <template v-else>

                            <!-- Section editor header -->
                            <div class="editor-header">
                                <div class="editor-header-left">
                                    <div class="editor-section-icon">
                                        <v-icon
                                            :icon="selectedSection.icon_section || 'mdi-layers-outline'"
                                            size="22"
                                            style="color:#1b449c"
                                        />
                                    </div>
                                    <div>
                                        <div class="editor-section-title">{{ selectedSection.nom_section }}</div>
                                        <div v-if="selectedSection.description_section" class="editor-section-desc">
                                            {{ selectedSection.description_section }}
                                        </div>
                                    </div>
                                </div>
                                <div class="editor-header-right">
                                    <span v-if="selectedSection.is_link_section" class="link-badge">
                                        <v-icon icon="mdi-link-variant" size="11" class="mr-1" />Lien
                                    </span>
                                    <button class="outline-btn" @click="openEditSection(selectedSection)">
                                        <v-icon icon="mdi-pencil-outline" size="14" class="mr-1" />
                                        Modifier
                                    </button>
                                    <button class="icon-btn icon-btn--delete" @click="openDeleteSection(selectedSection)">
                                        <v-icon icon="mdi-delete-outline" size="14" />
                                    </button>
                                </div>
                            </div>

                            <!-- Cards toolbar -->
                            <div class="cards-toolbar">
                                <div class="cards-toolbar-left">
                                    <v-icon icon="mdi-card-multiple-outline" size="15" class="mr-1" style="color:#f15a2d" />
                                    <span class="cards-toolbar-title">Cartes</span>
                                    <span class="cards-count-badge">{{ selectedSection.cards?.length ?? 0 }}</span>
                                </div>
                                <button class="add-btn" @click="openAddCard(selectedSection.id_section)">
                                    <v-icon icon="mdi-plus" size="15" class="mr-1" />Ajouter une carte
                                </button>
                            </div>

                            <!-- Hint contextuel pour sections spéciales -->
                            <div v-if="sectionHint && !sectionDedicatedSource" class="section-hint">
                                <div class="section-hint__icon" :style="{ color: sectionHint.color }">
                                    <v-icon :icon="sectionHint.icon" size="18" />
                                </div>
                                <div class="section-hint__body">
                                    <p v-for="(line, i) in sectionHint.lines" :key="i" class="section-hint__line">
                                        {{ line }}
                                    </p>
                                </div>
                            </div>

                            <!-- Section gérée par un dashboard dédié -->
                            <div v-if="sectionDedicatedSource" class="dedicated-notice">
                                <div class="dedicated-notice__icon-wrap">
                                    <v-icon :icon="sectionDedicatedSource.icon" size="32" style="color:#1b449c" />
                                </div>
                                <p class="dedicated-notice__title">Contenu géré séparément</p>
                                <p class="dedicated-notice__desc">
                                    Le contenu affiché dans la section
                                    <strong>{{ selectedSection.nom_section }}</strong>
                                    sur la page publique est géré via le tableau de bord
                                    <strong>{{ sectionDedicatedSource.label }}</strong>.
                                </p>
                                <a :href="sectionDedicatedSource.adminRoute" class="dedicated-notice__btn">
                                    <v-icon :icon="sectionDedicatedSource.icon" size="15" class="mr-1" />
                                    Gérer {{ sectionDedicatedSource.label }}
                                </a>
                            </div>

                            <!-- Empty cards (section générique sans contenu) -->
                            <div v-else-if="!selectedSection.cards?.length" class="editor-cards-empty">
                                <v-icon icon="mdi-card-plus-outline" size="44" style="opacity:.18;color:#1b449c" />
                                <p class="editor-cards-empty-title">Cette section n'a pas encore de cartes</p>
                                <p class="editor-cards-empty-hint">
                                    Les cartes représentent les éléments de contenu affichés dans
                                    <strong>{{ selectedSection.nom_section }}</strong> sur la page publique :
                                    titre, description, icône et bouton d'action.
                                </p>
                                <button class="add-btn mt-3" @click="openAddCard(selectedSection.id_section)">
                                    <v-icon icon="mdi-plus" size="15" class="mr-1" />Créer la première carte
                                </button>
                            </div>

                            <!-- Cards grid -->
                            <div v-else class="cards-grid">
                                <div
                                    v-for="card in selectedSection.cards"
                                    :key="card.id_card"
                                    class="card-item"
                                >
                                    <div class="card-item__top">
                                        <div class="card-item__icon-wrap">
                                            <v-icon
                                                :icon="card.icon_card || 'mdi-card-text-outline'"
                                                size="26"
                                                style="color:#1b449c"
                                            />
                                        </div>
                                        <div class="card-item__actions">
                                            <button class="icon-btn icon-btn--edit" title="Modifier" @click="openEditCard(card, selectedSection.id_section)">
                                                <v-icon icon="mdi-pencil-outline" size="12" />
                                            </button>
                                            <button class="icon-btn icon-btn--delete" title="Supprimer" @click="openDeleteCard(card)">
                                                <v-icon icon="mdi-delete-outline" size="12" />
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-item__title">{{ card.titre_card }}</div>
                                    <div v-if="card.description_card" class="card-item__desc">{{ card.description_card }}</div>
                                    <div v-if="card.titre_bouton_card" class="card-item__btn-label">
                                        <v-icon icon="mdi-arrow-right-circle-outline" size="11" class="mr-1" />
                                        {{ card.titre_bouton_card }}
                                    </div>
                                </div>

                                <!-- Add card CTA -->
                                <button class="add-card-placeholder" @click="openAddCard(selectedSection.id_section)">
                                    <v-icon icon="mdi-plus-circle-outline" size="24" class="mb-1" style="color:#1b449c;opacity:.4" />
                                    <span>Ajouter</span>
                                </button>
                            </div>

                        </template>
                    </div>

                </div><!-- .workspace -->
            </template>

        </div><!-- .pages-manager -->

        <!-- ──────────────────────────────────────────────────── -->
        <!-- Dialog: Créer / Modifier page                        -->
        <!-- ──────────────────────────────────────────────────── -->
        <v-dialog v-model="dialogPage" max-width="540" :persistent="formPage.processing">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon :icon="isPageEditing ? 'mdi-web' : 'mdi-web-plus'" size="20" class="mr-2" style="color:#f15a2d" />
                    <h3>{{ isPageEditing ? "Modifier la page" : "Nouvelle page" }}</h3>
                    <button class="modal-close" @click="dialogPage = false"><v-icon icon="mdi-close" size="18" /></button>
                </div>
                <div class="modal-body">
                    <div class="field-group">
                        <label class="field-label">Titre <span class="required">*</span></label>
                        <input v-model="formPage.titre_page" type="text" class="field-input"
                            :class="{ 'field-input--error': formPage.errors.titre_page }"
                            placeholder="Ex : Accueil" />
                        <span v-if="formPage.errors.titre_page" class="field-error">{{ formPage.errors.titre_page }}</span>
                    </div>
                    <div class="field-group mt-3">
                        <label class="field-label">Slogan</label>
                        <input v-model="formPage.slogan_page" type="text" class="field-input"
                            placeholder="Ex : Développer votre entreprise avec le numérique" />
                    </div>
                    <div class="field-group mt-3">
                        <label class="field-label">Bannière</label>
                        <div
                            class="banner-upload-zone"
                            :class="{ 'banner-upload-zone--has-image': bannerPreview }"
                            @click="fileInputRef.click()"
                            @dragover.prevent
                            @drop.prevent="e => handleBannerFile(e)"
                        >
                            <template v-if="bannerPreview">
                                <img :src="bannerPreview" class="banner-preview-img" alt="Aperçu bannière" />
                                <div class="banner-overlay">
                                    <span class="banner-change-hint">
                                        <v-icon icon="mdi-image-edit-outline" size="16" />
                                        Changer l'image
                                    </span>
                                    <button type="button" class="banner-clear-btn" @click.stop="clearBanner">
                                        <v-icon icon="mdi-close-circle" size="18" />
                                    </button>
                                </div>
                            </template>
                            <template v-else>
                                <v-icon icon="mdi-image-plus-outline" size="36" style="color:#94a3b8" />
                                <p class="upload-hint">Cliquez ou glissez une image ici</p>
                                <p class="upload-hint-sub">PNG, JPG, WebP · max 5 Mo</p>
                            </template>
                        </div>
                        <input
                            ref="fileInputRef"
                            type="file"
                            accept="image/*"
                            style="display:none"
                            @change="handleBannerFile"
                        />
                        <span v-if="formPage.errors.banniere_page" class="field-error">{{ formPage.errors.banniere_page }}</span>
                    </div>
                    <div class="field-group mt-3">
                        <label class="field-label">Description</label>
                        <textarea v-model="formPage.description_page" class="field-textarea" rows="3"
                            placeholder="Description de la page..." />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogPage = false">Annuler</button>
                    <button class="btn-confirm" :disabled="formPage.processing" @click="savePage">
                        <v-progress-circular v-if="formPage.processing" size="14" width="2" indeterminate class="mr-1" />
                        {{ isPageEditing ? "Enregistrer" : "Créer" }}
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ──────────────────────────────────────────────────── -->
        <!-- Dialog: Supprimer page                               -->
        <!-- ──────────────────────────────────────────────────── -->
        <v-dialog v-model="dialogDeletePage" max-width="420">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon icon="mdi-alert-circle-outline" size="20" class="mr-2" style="color:#e74c3c" />
                    <h3>Supprimer la page</h3>
                    <button class="modal-close" @click="dialogDeletePage = false"><v-icon icon="mdi-close" size="18" /></button>
                </div>
                <div class="modal-body">
                    <p class="confirm-text">
                        Supprimer la page <strong>{{ deletePageTarget?.titre_page }}</strong> ?
                        Les sections liées ne seront pas supprimées.
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogDeletePage = false">Annuler</button>
                    <button class="btn-danger" :disabled="deletePageProc" @click="confirmDeletePage">
                        <v-progress-circular v-if="deletePageProc" size="14" width="2" indeterminate class="mr-1" />
                        Supprimer
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ──────────────────────────────────────────────────── -->
        <!-- Dialog: Créer / Modifier section                     -->
        <!-- ──────────────────────────────────────────────────── -->
        <v-dialog v-model="dialogSection" max-width="560" :persistent="formSection.processing">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon :icon="isSectionEditing ? 'mdi-layers-edit' : 'mdi-layers-plus'" size="20" class="mr-2" style="color:#f15a2d" />
                    <h3>{{ isSectionEditing ? "Modifier la section" : "Nouvelle section" }}</h3>
                    <button class="modal-close" @click="dialogSection = false"><v-icon icon="mdi-close" size="18" /></button>
                </div>
                <div class="modal-body">
                    <div class="field-group">
                        <label class="field-label">Nom <span class="required">*</span></label>
                        <input v-model="formSection.nom_section" type="text" class="field-input"
                            :class="{ 'field-input--error': formSection.errors.nom_section }"
                            placeholder="Ex : Nos services" />
                        <span v-if="formSection.errors.nom_section" class="field-error">{{ formSection.errors.nom_section }}</span>
                    </div>
                    <div class="field-group mt-3">
                        <label class="field-label">Description</label>
                        <textarea v-model="formSection.description_section" class="field-textarea" rows="2"
                            placeholder="Description courte de la section..." />
                    </div>
                    <div class="field-group mt-3">
                        <label class="field-label">Icône</label>
                        <div class="icon-input-row">
                            <div class="icon-preview-box">
                                <v-icon :icon="formSection.icon_section || 'mdi-layers-outline'" size="22" style="color:#1b449c" />
                            </div>
                            <input v-model="formSection.icon_section" type="text" class="field-input"
                                placeholder="Ex : mdi-cog-outline" />
                        </div>
                        <div class="icon-presets">
                            <button
                                v-for="ic in sectionIcons" :key="ic"
                                type="button" class="icon-preset-btn"
                                :class="{ 'icon-preset-btn--active': formSection.icon_section === ic }"
                                :title="ic" @click="formSection.icon_section = ic"
                            >
                                <v-icon :icon="ic" size="16" />
                            </button>
                        </div>
                    </div>
                    <div class="field-group mt-3">
                        <label class="toggle-row">
                            <span class="field-label" style="margin:0">Section de lien</span>
                            <div
                                class="toggle-switch"
                                :class="{ 'toggle-switch--on': formSection.is_link_section }"
                                @click="formSection.is_link_section = !formSection.is_link_section"
                            >
                                <div class="toggle-knob" />
                            </div>
                        </label>
                        <span class="form-hint">Cette section sert de lien de navigation vers une autre page ou ressource.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogSection = false">Annuler</button>
                    <button class="btn-confirm" :disabled="formSection.processing" @click="saveSection">
                        <v-progress-circular v-if="formSection.processing" size="14" width="2" indeterminate class="mr-1" />
                        {{ isSectionEditing ? "Enregistrer" : "Créer" }}
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ──────────────────────────────────────────────────── -->
        <!-- Dialog: Supprimer section                            -->
        <!-- ──────────────────────────────────────────────────── -->
        <v-dialog v-model="dialogDeleteSection" max-width="420">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon icon="mdi-alert-circle-outline" size="20" class="mr-2" style="color:#e74c3c" />
                    <h3>Supprimer la section</h3>
                    <button class="modal-close" @click="dialogDeleteSection = false"><v-icon icon="mdi-close" size="18" /></button>
                </div>
                <div class="modal-body">
                    <p class="confirm-text">
                        Supprimer la section <strong>{{ deleteSectionTarget?.nom_section }}</strong> et toutes ses cartes ?
                        Cette action est irréversible.
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogDeleteSection = false">Annuler</button>
                    <button class="btn-danger" :disabled="deleteSectionProc" @click="confirmDeleteSection">
                        <v-progress-circular v-if="deleteSectionProc" size="14" width="2" indeterminate class="mr-1" />
                        Supprimer
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ──────────────────────────────────────────────────── -->
        <!-- Dialog: Créer / Modifier carte                       -->
        <!-- ──────────────────────────────────────────────────── -->
        <v-dialog v-model="dialogCard" max-width="560" :persistent="formCard.processing">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon :icon="isCardEditing ? 'mdi-card-text' : 'mdi-card-plus-outline'" size="20" class="mr-2" style="color:#f15a2d" />
                    <h3>{{ isCardEditing ? "Modifier la carte" : "Nouvelle carte" }}</h3>
                    <button class="modal-close" @click="dialogCard = false"><v-icon icon="mdi-close" size="18" /></button>
                </div>
                <div class="modal-body">
                    <div class="field-group">
                        <label class="field-label">Titre <span class="required">*</span></label>
                        <input v-model="formCard.titre_card" type="text" class="field-input"
                            :class="{ 'field-input--error': formCard.errors.titre_card }"
                            placeholder="Ex : Développement Web/Mobile" />
                        <span v-if="formCard.errors.titre_card" class="field-error">{{ formCard.errors.titre_card }}</span>
                    </div>
                    <div class="field-group mt-3">
                        <label class="field-label">Description</label>
                        <textarea v-model="formCard.description_card" class="field-textarea" rows="3"
                            placeholder="Description de l'élément de contenu..." />
                    </div>
                    <div class="field-group mt-3">
                        <label class="field-label">Icône <span class="form-hint-inline">(nom MDI)</span></label>
                        <div class="icon-input-row">
                            <div class="icon-preview-box">
                                <v-icon :icon="formCard.icon_card || 'mdi-card-text-outline'" size="22" style="color:#1b449c" />
                            </div>
                            <input v-model="formCard.icon_card" type="text" class="field-input"
                                placeholder="Ex : mdi-wifi" />
                        </div>
                        <div class="icon-presets">
                            <button
                                v-for="ic in cardIcons" :key="ic"
                                type="button" class="icon-preset-btn"
                                :class="{ 'icon-preset-btn--active': formCard.icon_card === ic }"
                                :title="ic" @click="formCard.icon_card = ic"
                            >
                                <v-icon :icon="ic" size="16" />
                            </button>
                        </div>
                    </div>
                    <div class="field-group mt-3">
                        <label class="field-label">Libellé du bouton <span class="form-hint-inline">(optionnel)</span></label>
                        <input v-model="formCard.titre_bouton_card" type="text" class="field-input"
                            placeholder="Ex : Lire plus, En savoir plus..." />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogCard = false">Annuler</button>
                    <button class="btn-confirm" :disabled="formCard.processing" @click="saveCard">
                        <v-progress-circular v-if="formCard.processing" size="14" width="2" indeterminate class="mr-1" />
                        {{ isCardEditing ? "Enregistrer" : "Créer" }}
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ──────────────────────────────────────────────────── -->
        <!-- Dialog: Supprimer carte                              -->
        <!-- ──────────────────────────────────────────────────── -->
        <v-dialog v-model="dialogDeleteCard" max-width="400">
            <div class="modal-card">
                <div class="modal-header">
                    <v-icon icon="mdi-alert-circle-outline" size="20" class="mr-2" style="color:#e74c3c" />
                    <h3>Supprimer la carte</h3>
                    <button class="modal-close" @click="dialogDeleteCard = false"><v-icon icon="mdi-close" size="18" /></button>
                </div>
                <div class="modal-body">
                    <p class="confirm-text">
                        Supprimer la carte <strong>{{ deleteCardTarget?.titre_card }}</strong> ?
                        Cette action est irréversible.
                    </p>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="dialogDeleteCard = false">Annuler</button>
                    <button class="btn-danger" :disabled="deleteCardProc" @click="confirmDeleteCard">
                        <v-progress-circular v-if="deleteCardProc" size="14" width="2" indeterminate class="mr-1" />
                        Supprimer
                    </button>
                </div>
            </div>
        </v-dialog>

    </AuthenticatedLayout>
</template>

<style scoped>
.pages-manager { padding: 24px; display: flex; flex-direction: column; gap: 16px; }

/* ── Page tabs bar ──────────────────────────────────────────────── */
.page-tabs-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 7px 10px;
    flex-shrink: 0;
}

.page-tabs-scroll {
    display: flex;
    gap: 3px;
    overflow-x: auto;
    scrollbar-width: none;
    flex: 1;
    min-width: 0;
}
.page-tabs-scroll::-webkit-scrollbar { display: none; }

.page-tab {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 6px 14px;
    border-radius: 8px;
    border: none;
    background: none;
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.15s;
    flex-shrink: 0;
}
.page-tab:hover { background: var(--card-hover); color: var(--text-primary); }
.page-tab--active { background: #1b449c; color: white; font-weight: 600; }

.tab-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 17px;
    height: 15px;
    padding: 0 4px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 700;
    background: rgba(255,255,255,0.18);
}
.page-tab:not(.page-tab--active) .tab-badge {
    background: var(--border-color);
    color: var(--text-secondary);
}

.add-page-btn {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 6px 13px;
    border: 1.5px dashed var(--border-color);
    border-radius: 8px;
    background: none;
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.15s;
    flex-shrink: 0;
}
.add-page-btn:hover { border-color: #1b449c; color: #1b449c; }

/* ── Empty state ────────────────────────────────────────────────── */
.empty-global {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 72px 24px;
    color: var(--text-secondary);
    gap: 8px;
}

/* ── Page info bar ──────────────────────────────────────────────── */
.page-info-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 10px 16px;
    flex-wrap: wrap;
    flex-shrink: 0;
}
.page-info-left  { display: flex; align-items: center; gap: 10px; flex: 1; min-width: 0; }
.page-info-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

.page-banner-thumb {
    width: 48px;
    height: 34px;
    border-radius: 6px;
    overflow: hidden;
    flex-shrink: 0;
    border: 1px solid var(--border-color);
}
.page-banner-thumb img { width: 100%; height: 100%; object-fit: cover; }

.page-info-icon-bg {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: rgba(27,68,156,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.page-info-text { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
.page-info-title  { font-size: 14px; font-weight: 700; color: var(--text-primary); }
.page-info-slogan {
    font-size: 11px; color: var(--text-secondary); font-style: italic;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 400px;
}
.page-info-stat   {
    display: inline-flex;
    align-items: center;
    font-size: 12px;
    color: var(--text-secondary);
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 3px 10px;
}
.page-info-actions { display: flex; gap: 5px; }

/* ── Workspace (2-col) ──────────────────────────────────────────── */
.workspace {
    display: flex;
    gap: 16px;
    flex: 1;
    min-height: 0;
    align-items: flex-start;
}

/* ── Sections sidebar ───────────────────────────────────────────── */
.sections-sidebar {
    width: 240px;
    flex-shrink: 0;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.sidebar-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px 10px;
    border-bottom: 1px solid var(--border-color);
}
.sidebar-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.08em;
    color: var(--text-secondary);
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 6px;
}
.sidebar-label-count {
    background: var(--border-color);
    color: var(--text-secondary);
    font-size: 10px;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 8px;
}
.sidebar-add-btn {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    border: 1px solid var(--border-color);
    background: none;
    color: var(--text-secondary);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
}
.sidebar-add-btn:hover { border-color: #1b449c; color: #1b449c; background: rgba(27,68,156,0.08); }

.sidebar-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 28px 14px;
    gap: 6px;
    color: var(--text-secondary);
    text-align: center;
    font-size: 12px;
}
.sidebar-create-btn {
    margin-top: 4px;
    padding: 5px 12px;
    border: 1px dashed var(--border-color);
    border-radius: 6px;
    background: none;
    color: var(--text-secondary);
    font-size: 11px;
    cursor: pointer;
    transition: all 0.15s;
}
.sidebar-create-btn:hover { border-color: #1b449c; color: #1b449c; }

.sections-nav { display: flex; flex-direction: column; padding: 6px; gap: 2px; }

.section-nav-item {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    padding: 9px 10px;
    border-radius: 8px;
    border: none;
    background: none;
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    text-align: left;
    transition: all 0.15s;
    width: 100%;
}
.section-nav-item:hover { background: var(--card-hover); color: var(--text-primary); }
.section-nav-item--active {
    background: rgba(27,68,156,0.12);
    color: #1b449c;
    font-weight: 600;
}
.section-nav-item--active .section-nav-icon { color: #1b449c; }

.section-nav-icon { flex-shrink: 0; display: flex; padding-top: 1px; }
.section-nav-text  { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px; }
.section-nav-name  { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 13px; }
.section-nav-desc  {
    font-size: 11px;
    color: var(--text-secondary);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    font-weight: 400;
    opacity: .8;
}
.section-nav-item--active .section-nav-desc { color: #1b449c; opacity: .7; }

.section-nav-count {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 16px;
    padding: 0 4px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 700;
    background: var(--border-color);
    color: var(--text-secondary);
    margin-top: 2px;
}
.section-nav-count--empty {
    background: rgba(241,90,45,.1);
    color: #f15a2d;
}
.section-nav-item--active .section-nav-count {
    background: rgba(27,68,156,0.2);
    color: #1b449c;
}

/* ── Section editor ─────────────────────────────────────────────── */
.section-editor {
    flex: 1;
    min-width: 0;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.editor-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 64px 24px;
    color: var(--text-secondary);
    gap: 8px;
    font-size: 13px;
    flex: 1;
}

/* Section editor header */
.editor-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border-color);
    flex-wrap: wrap;
    gap: 10px;
    flex-shrink: 0;
}
.editor-header-left { display: flex; align-items: flex-start; gap: 12px; flex: 1; min-width: 0; }
.editor-section-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: rgba(27,68,156,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.editor-section-title { font-size: 16px; font-weight: 700; color: var(--text-primary); line-height: 1.2; }
.editor-section-desc  { font-size: 12px; color: var(--text-secondary); margin-top: 3px; line-height: 1.4; max-width: 460px; }

.editor-header-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

.link-badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 9px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 600;
    background: rgba(241,90,45,0.1);
    color: #f15a2d;
}

.outline-btn {
    display: flex;
    align-items: center;
    padding: 6px 12px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: none;
    color: var(--text-secondary);
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}
.outline-btn:hover { border-color: #1b449c; color: #1b449c; background: rgba(27,68,156,0.06); }

/* Cards toolbar */
.cards-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-bottom: 1px solid var(--border-color);
    flex-shrink: 0;
    flex-wrap: wrap;
    gap: 8px;
}
/* ── Section hint ───────────────────────────────────────────────── */
.section-hint {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin: 12px 20px;
    padding: 12px 14px;
    background: rgba(27,68,156,0.07);
    border: 1px solid rgba(27,68,156,0.2);
    border-left: 3px solid #1b449c;
    border-radius: 8px;
    flex-shrink: 0;
}
.section-hint__icon { flex-shrink: 0; padding-top: 1px; }
.section-hint__body { flex: 1; min-width: 0; }
.section-hint__line {
    font-size: 11.5px;
    color: var(--text-secondary);
    line-height: 1.5;
    margin: 0 0 2px;
}
.section-hint__line:first-child { color: var(--text-primary); font-weight: 500; margin-bottom: 5px; }
.section-hint__line:last-child  { margin-bottom: 0; }

.cards-toolbar-left { display: flex; align-items: center; gap: 6px; }
.cards-toolbar-title { font-size: 13px; font-weight: 600; color: var(--text-primary); }
.cards-count-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 18px;
    padding: 0 6px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 700;
    background: rgba(27,68,156,0.1);
    color: #1b449c;
}

/* Dedicated source notice */
.dedicated-notice {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 48px 40px;
    gap: 12px;
    text-align: center;
    flex: 1;
}
.dedicated-notice__icon-wrap {
    width: 64px; height: 64px;
    border-radius: 16px;
    background: rgba(27,68,156,0.1);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 4px;
}
.dedicated-notice__title {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: var(--text-primary);
}
.dedicated-notice__desc {
    margin: 0;
    font-size: 13px;
    color: var(--text-secondary);
    max-width: 380px;
    line-height: 1.6;
}
.dedicated-notice__desc strong { color: var(--text-primary); }
.dedicated-notice__btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 20px;
    background: #1b449c;
    color: white;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.15s, transform 0.13s;
    margin-top: 4px;
}
.dedicated-notice__btn:hover { background: #163a86; transform: translateY(-1px); }

/* Empty cards */
.editor-cards-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 48px 40px;
    gap: 8px;
    color: var(--text-secondary);
    text-align: center;
    flex: 1;
}
.editor-cards-empty-title { margin: 0; font-size: 14px; font-weight: 600; color: var(--text-primary); }
.editor-cards-empty-hint { font-size: 12px; color: var(--text-secondary); max-width: 380px; line-height: 1.5; margin: 0; }
.editor-cards-empty-hint strong { color: var(--text-primary); }

/* Cards grid */
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 12px;
    padding: 16px 20px 20px;
    overflow-y: auto;
}

.card-item {
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    padding: 14px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.card-item:hover { border-color: rgba(27,68,156,.35); box-shadow: 0 2px 10px rgba(27,68,156,.08); }

.card-item__top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 4px;
}
.card-item__icon-wrap {
    width: 38px; height: 38px;
    border-radius: 8px;
    background: rgba(27,68,156,0.08);
    display: flex; align-items: center; justify-content: center;
}
.card-item__actions {
    display: flex;
    gap: 3px;
    opacity: 0;
    transition: opacity 0.15s;
}
.card-item:hover .card-item__actions { opacity: 1; }

.card-item__title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
    line-height: 1.3;
}
.card-item__desc {
    font-size: 12px;
    color: var(--text-secondary);
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.card-item__btn-label {
    display: inline-flex;
    align-items: center;
    font-size: 11px;
    color: #f15a2d;
    font-weight: 600;
    margin-top: auto;
    padding-top: 4px;
}

.add-card-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: none;
    border: 1.5px dashed var(--border-color);
    border-radius: 10px;
    padding: 20px;
    cursor: pointer;
    color: var(--text-secondary);
    font-size: 12px;
    font-weight: 500;
    transition: all 0.15s;
    min-height: 90px;
    gap: 4px;
}
.add-card-placeholder:hover { border-color: #1b449c; color: #1b449c; }

/* ── Shared buttons ─────────────────────────────────────────────── */
.add-btn {
    display: inline-flex;
    align-items: center;
    background: #1b449c;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 7px 13px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s, transform 0.13s;
    white-space: nowrap;
}
.add-btn:hover { background: #163a86; transform: translateY(-1px); }
.mt-3 { margin-top: 12px; }

.icon-btn {
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    border: 1px solid var(--border-color);
    background: none;
    cursor: pointer;
    transition: all 0.13s;
    color: var(--text-secondary);
}
.icon-btn--view         { text-decoration: none; }
.icon-btn--view:hover   { background: rgba(5,150,105,0.12); border-color: #059669; color: #059669; }
.icon-btn--edit:hover   { background: rgba(27,68,156,0.12); border-color: #1b449c; color: #1b449c; }
.icon-btn--delete:hover { background: rgba(231,76,60,0.12); border-color: #e74c3c; color: #e74c3c; }

/* ── Icon picker ────────────────────────────────────────────────── */
.icon-input-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}
.icon-preview-box {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: rgba(27,68,156,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.icon-presets { display: flex; flex-wrap: wrap; gap: 4px; }
.icon-preset-btn {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: 1px solid var(--border-color);
    background: var(--dark-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all 0.13s;
}
.icon-preset-btn:hover { border-color: #1b449c; color: #1b449c; }
.icon-preset-btn--active { background: rgba(27,68,156,0.15); border-color: #1b449c; color: #1b449c; }

/* ── Toggle ─────────────────────────────────────────────────────── */
.toggle-row { display: flex; align-items: center; justify-content: space-between; cursor: pointer; }
.toggle-switch {
    width: 38px; height: 20px;
    border-radius: 10px;
    background: var(--border-color);
    position: relative;
    transition: background 0.2s;
    flex-shrink: 0;
}
.toggle-switch--on { background: #1b449c; }
.toggle-knob {
    position: absolute;
    top: 2px; left: 2px;
    width: 16px; height: 16px;
    border-radius: 50%;
    background: white;
    transition: transform 0.2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.25);
}
.toggle-switch--on .toggle-knob { transform: translateX(18px); }

/* ── Modals ─────────────────────────────────────────────────────── */
.modal-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden;
}
.modal-header {
    display: flex;
    align-items: center;
    padding: 15px 18px;
    border-bottom: 1px solid var(--border-color);
    gap: 4px;
}
.modal-header h3 { flex: 1; font-size: 15px; font-weight: 700; color: var(--text-primary); margin: 0; }
.modal-close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-secondary);
    display: flex;
    padding: 4px;
    border-radius: 6px;
    transition: background 0.13s;
}
.modal-close:hover { background: var(--card-hover); }
.modal-body { padding: 18px; max-height: 65vh; overflow-y: auto; }
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 13px 18px;
    border-top: 1px solid var(--border-color);
}
.confirm-text { font-size: 14px; color: var(--text-secondary); line-height: 1.5; margin: 0; }
.confirm-text strong { color: var(--text-primary); }

/* ── Form ───────────────────────────────────────────────────────── */
.field-group { display: flex; flex-direction: column; }
.field-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 6px;
}
.required { color: #e74c3c; }
.form-hint { font-size: 11px; color: var(--text-secondary); margin-top: 4px; }
.form-hint-inline { font-size: 11px; color: var(--text-secondary); font-weight: 400; text-transform: none; letter-spacing: 0; }

.field-input, .field-textarea {
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 13px;
    padding: 8px 11px;
    outline: none;
    transition: border-color 0.18s;
    width: 100%;
    box-sizing: border-box;
    font-family: inherit;
}
.field-input:focus, .field-textarea:focus { border-color: #1b449c; }
.field-input--error { border-color: #e74c3c !important; }
.field-textarea { resize: vertical; }
.field-error { font-size: 11px; color: #e74c3c; margin-top: 4px; }

/* ── Banner upload zone ─────────────────────────────────────────── */
.banner-upload-zone {
    position: relative;
    border: 2px dashed var(--border-color);
    border-radius: 10px;
    min-height: 110px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    transition: border-color 0.2s, background 0.2s;
    overflow: hidden;
    background: var(--dark-bg);
}
.banner-upload-zone:hover {
    border-color: #1b449c;
    background: rgba(27,68,156,0.04);
}
.banner-upload-zone--has-image {
    border-style: solid;
    min-height: 130px;
}
.banner-preview-img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    display: block;
}
.banner-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s;
}
.banner-upload-zone:hover .banner-overlay { opacity: 1; }
.banner-change-hint {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
}
.banner-clear-btn {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(0,0,0,0.55);
    border: none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    transition: background 0.15s;
}
.banner-clear-btn:hover { background: rgba(231,76,60,0.85); }
.upload-hint     { font-size: 13px; color: var(--text-secondary); margin: 0; }
.upload-hint-sub { font-size: 11px; color: var(--text-muted, #94a3b8); margin: 0; }

.btn-cancel {
    padding: 7px 16px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    background: none;
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.13s;
}
.btn-cancel:hover { background: var(--card-hover); color: var(--text-primary); }

.btn-confirm {
    display: flex;
    align-items: center;
    padding: 7px 18px;
    border-radius: 8px;
    border: none;
    background: #1b449c;
    color: white;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.13s;
}
.btn-confirm:hover:not(:disabled) { background: #163a86; }
.btn-confirm:disabled { opacity: .6; cursor: not-allowed; }

.btn-danger {
    display: flex;
    align-items: center;
    padding: 7px 18px;
    border-radius: 8px;
    border: none;
    background: #e74c3c;
    color: white;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.13s;
}
.btn-danger:hover:not(:disabled) { background: #c0392b; }
.btn-danger:disabled { opacity: .6; cursor: not-allowed; }
</style>
