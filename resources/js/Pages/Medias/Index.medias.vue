<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps({
    medias:    { type: Array,  default: () => [] },
    totalSize: { type: Number, default: 0 },
});

// ── Filters ──────────────────────────────────────────────────────
const activeFolder = ref('all');
const search       = ref('');

const folders = computed(() => {
    const map = {};
    props.medias.forEach(m => {
        map[m.folder] = map[m.folder] ? map[m.folder] + 1 : 1;
    });
    return map;
});

const filtered = computed(() => {
    let list = props.medias;
    if (activeFolder.value !== 'all') {
        list = list.filter(m => m.folder === activeFolder.value);
    }
    if (search.value.trim()) {
        const q = search.value.trim().toLowerCase();
        list = list.filter(m => m.filename.toLowerCase().includes(q));
    }
    return list;
});

// ── Stats ────────────────────────────────────────────────────────
const formatSize = (bytes) => {
    if (bytes < 1024)       return bytes + ' o';
    if (bytes < 1048576)    return (bytes / 1024).toFixed(1) + ' Ko';
    return (bytes / 1048576).toFixed(1) + ' Mo';
};

const formatDate = (ts) => {
    const d = new Date(ts * 1000);
    return d.toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' });
};

// ── Upload ────────────────────────────────────────────────────────
const isDragging   = ref(false);
const fileInputRef = ref(null);
const uploadForm   = useForm({ files: [] });

const handleFiles = (rawFiles) => {
    uploadForm.files = Array.from(rawFiles);
    if (uploadForm.files.length) {
        uploadForm.post(route('medias.store'), {
            onSuccess: () => { uploadForm.reset(); },
        });
    }
};

const onDrop = (e) => {
    isDragging.value = false;
    handleFiles(e.dataTransfer.files);
};

// ── Copy URL ──────────────────────────────────────────────────────
const copiedUrl = ref(null);
const copyUrl = async (url) => {
    try {
        await navigator.clipboard.writeText(window.location.origin + url);
        copiedUrl.value = url;
        setTimeout(() => { copiedUrl.value = null; }, 1800);
    } catch {
        copiedUrl.value = null;
    }
};

// ── Delete ────────────────────────────────────────────────────────
const deleteTarget  = ref(null);
const deleteLoading = ref(false);

const confirmDelete = () => {
    if (!deleteTarget.value) return;
    deleteLoading.value = true;
    router.delete(route('medias.destroy', deleteTarget.value.filename), {
        onFinish: () => {
            deleteLoading.value = false;
            deleteTarget.value  = null;
        },
    });
};

// ── Lightbox ──────────────────────────────────────────────────────
const lightbox = ref(null);
</script>

<template>
    <Head title="Médiathèque" />
    <AuthenticatedLayout>
        <div class="media-page">

            <!-- Stats ───────────────────────────────────────────── -->
            <div class="stats-row">
                <div class="stat-chip">
                    <v-icon icon="mdi-image-multiple-outline" size="22" class="stat-icon" />
                    <div>
                        <div class="stat-value">{{ medias.length }}</div>
                        <div class="stat-label">Images</div>
                    </div>
                </div>
                <div class="stat-chip">
                    <v-icon icon="mdi-folder-multiple-outline" size="22" class="stat-icon stat-icon--orange" />
                    <div>
                        <div class="stat-value">{{ Object.keys(folders).length }}</div>
                        <div class="stat-label">Dossiers</div>
                    </div>
                </div>
                <div class="stat-chip">
                    <v-icon icon="mdi-harddisk" size="22" class="stat-icon stat-icon--green" />
                    <div>
                        <div class="stat-value">{{ formatSize(totalSize) }}</div>
                        <div class="stat-label">Espace utilisé</div>
                    </div>
                </div>
            </div>

            <!-- Upload zone ─────────────────────────────────────── -->
            <div
                class="upload-zone"
                :class="{ 'upload-zone--drag': isDragging, 'upload-zone--loading': uploadForm.processing }"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="onDrop"
                @click="fileInputRef.click()"
            >
                <v-icon
                    :icon="uploadForm.processing ? 'mdi-loading' : 'mdi-cloud-upload-outline'"
                    size="36"
                    :class="{ 'spin': uploadForm.processing }"
                    style="color:#1b449c;opacity:.6"
                />
                <p class="upload-hint">
                    <template v-if="uploadForm.processing">Envoi en cours…</template>
                    <template v-else>
                        <strong>Cliquez</strong> ou glissez vos images ici
                    </template>
                </p>
                <p class="upload-hint-sub">PNG, JPG, WebP, GIF · max 5 Mo par fichier</p>
                <input
                    ref="fileInputRef"
                    type="file"
                    accept="image/*"
                    multiple
                    style="display:none"
                    @change="e => handleFiles(e.target.files)"
                />
            </div>

            <!-- Toolbar ─────────────────────────────────────────── -->
            <div class="toolbar">
                <!-- Folder tabs -->
                <div class="folder-tabs">
                    <button
                        class="folder-tab"
                        :class="{ 'folder-tab--active': activeFolder === 'all' }"
                        @click="activeFolder = 'all'"
                    >
                        Tout <span class="tab-count">{{ medias.length }}</span>
                    </button>
                    <button
                        v-for="(count, folder) in folders"
                        :key="folder"
                        class="folder-tab"
                        :class="{ 'folder-tab--active': activeFolder === folder }"
                        @click="activeFolder = folder"
                    >
                        {{ folder }} <span class="tab-count">{{ count }}</span>
                    </button>
                </div>

                <!-- Search -->
                <div class="search-wrap">
                    <v-icon icon="mdi-magnify" size="16" class="search-icon" />
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Rechercher un fichier…"
                        class="search-input"
                    />
                    <button v-if="search" class="search-clear" @click="search = ''">
                        <v-icon icon="mdi-close" size="13" />
                    </button>
                </div>
            </div>

            <!-- Grid ────────────────────────────────────────────── -->
            <div v-if="!filtered.length" class="empty-state">
                <v-icon icon="mdi-image-off-outline" size="48" style="opacity:.2" />
                <p>Aucune image trouvée</p>
            </div>

            <div v-else class="media-grid">
                <div
                    v-for="media in filtered"
                    :key="media.url"
                    class="media-card"
                >
                    <!-- Thumbnail -->
                    <div class="media-thumb" @click="lightbox = media">
                        <img :src="media.url" :alt="media.filename" loading="lazy" />
                        <div class="media-thumb-overlay">
                            <v-icon icon="mdi-magnify-plus-outline" size="22" />
                        </div>
                    </div>

                    <!-- Meta -->
                    <div class="media-meta">
                        <span class="media-name" :title="media.filename">{{ media.filename }}</span>
                        <div class="media-sub">
                            <span class="folder-badge">{{ media.label }}</span>
                            <span class="media-size">{{ formatSize(media.size) }}</span>
                        </div>
                        <span class="media-date">{{ formatDate(media.timestamp) }}</span>
                    </div>

                    <!-- Actions -->
                    <div class="media-actions">
                        <button
                            class="action-btn action-btn--copy"
                            :class="{ 'action-btn--copied': copiedUrl === media.url }"
                            :title="copiedUrl === media.url ? 'URL copiée !' : 'Copier l\'URL'"
                            @click="copyUrl(media.url)"
                        >
                            <v-icon
                                :icon="copiedUrl === media.url ? 'mdi-check' : 'mdi-link-variant'"
                                size="14"
                            />
                            {{ copiedUrl === media.url ? 'Copié !' : 'Copier URL' }}
                        </button>
                        <button
                            v-if="media.deletable"
                            class="action-btn action-btn--delete"
                            title="Supprimer"
                            @click="deleteTarget = media"
                        >
                            <v-icon icon="mdi-delete-outline" size="14" />
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- ── Lightbox ──────────────────────────────────────────── -->
        <v-dialog v-model="lightbox" max-width="900">
            <div class="lightbox-card" v-if="lightbox">
                <div class="lightbox-header">
                    <span class="lightbox-filename">{{ lightbox.filename }}</span>
                    <button class="modal-close" @click="lightbox = null">
                        <v-icon icon="mdi-close" size="18" />
                    </button>
                </div>
                <img :src="lightbox.url" :alt="lightbox.filename" class="lightbox-img" />
                <div class="lightbox-footer">
                    <span class="folder-badge">{{ lightbox.label }}</span>
                    <span class="media-size">{{ formatSize(lightbox.size) }}</span>
                    <span class="media-date">{{ formatDate(lightbox.timestamp) }}</span>
                    <button
                        class="action-btn action-btn--copy ml-auto"
                        :class="{ 'action-btn--copied': copiedUrl === lightbox.url }"
                        @click="copyUrl(lightbox.url)"
                    >
                        <v-icon
                            :icon="copiedUrl === lightbox.url ? 'mdi-check' : 'mdi-link-variant'"
                            size="14"
                        />
                        {{ copiedUrl === lightbox.url ? 'Copié !' : 'Copier URL' }}
                    </button>
                </div>
            </div>
        </v-dialog>

        <!-- ── Confirm delete ─────────────────────────────────────── -->
        <v-dialog v-model="deleteTarget" max-width="420">
            <div class="modal-card" v-if="deleteTarget">
                <div class="modal-header">
                    <v-icon icon="mdi-alert-outline" size="20" class="mr-2" style="color:#e74c3c" />
                    <h3>Supprimer l'image</h3>
                    <button class="modal-close" @click="deleteTarget = null">
                        <v-icon icon="mdi-close" size="18" />
                    </button>
                </div>
                <div class="modal-body">
                    <div class="delete-preview">
                        <img :src="deleteTarget.url" :alt="deleteTarget.filename" class="delete-thumb" />
                        <div>
                            <p class="confirm-text">
                                Supprimer <strong>{{ deleteTarget.filename }}</strong> ?
                            </p>
                            <p class="confirm-warn">Cette action est irréversible.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-cancel" @click="deleteTarget = null">Annuler</button>
                    <button class="btn-danger" :disabled="deleteLoading" @click="confirmDelete">
                        <v-progress-circular v-if="deleteLoading" size="14" width="2" indeterminate class="mr-1" />
                        Supprimer
                    </button>
                </div>
            </div>
        </v-dialog>

    </AuthenticatedLayout>
</template>

<style scoped>
.media-page {
    padding: 24px 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

/* ── Stats ─────────────────────────────────────────────────────── */
.stats-row {
    display: flex;
    gap: 14px;
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
    min-width: 150px;
}

.stat-icon       { color: #1b449c; }
.stat-icon--orange { color: #f15a2d !important; }
.stat-icon--green  { color: #2ecc71 !important; }

.stat-value { font-size: 1.4rem; font-weight: 700; color: #fff; line-height: 1; }
.stat-label { font-size: 0.72rem; color: var(--text-secondary, #a0a4b8); margin-top: 2px; }

/* ── Upload zone ────────────────────────────────────────────────── */
.upload-zone {
    border: 2px dashed var(--border-color, #3a3d52);
    border-radius: 14px;
    padding: 32px 24px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--card-bg, #242837);
}

.upload-zone:hover,
.upload-zone--drag {
    border-color: #1b449c;
    background: rgba(27, 68, 156, 0.06);
}

.upload-zone--loading { pointer-events: none; opacity: .75; }

.upload-hint { font-size: 14px; color: var(--text-secondary, #a0a4b8); margin: 0; }
.upload-hint strong { color: #fff; }
.upload-hint-sub { font-size: 12px; color: var(--text-secondary, #a0a4b8); margin: 0; opacity: .7; }

@keyframes spin { to { transform: rotate(360deg); } }
.spin { animation: spin 0.8s linear infinite; }

/* ── Toolbar ────────────────────────────────────────────────────── */
.toolbar {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.folder-tabs {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    flex: 1;
}

.folder-tab {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid var(--border-color, #3a3d52);
    background: none;
    color: var(--text-secondary, #a0a4b8);
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}
.folder-tab:hover { border-color: #1b449c; color: #fff; }
.folder-tab--active { background: #1b449c; border-color: #1b449c; color: #fff; font-weight: 600; }

.tab-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 16px;
    height: 14px;
    padding: 0 4px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 700;
    background: rgba(255,255,255,.18);
}
.folder-tab:not(.folder-tab--active) .tab-count {
    background: var(--border-color, #3a3d52);
    color: var(--text-secondary, #a0a4b8);
}

.search-wrap {
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
    height: 34px;
    padding: 0 30px 0 32px;
    background: var(--card-bg, #242837);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 8px;
    color: #fff;
    font-size: 13px;
    width: 200px;
    outline: none;
    transition: border-color 0.2s;
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

/* ── Empty state ────────────────────────────────────────────────── */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    padding: 60px 24px;
    color: var(--text-secondary, #a0a4b8);
    font-size: 14px;
}
.empty-state p { margin: 0; }

/* ── Media grid ─────────────────────────────────────────────────── */
.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
}

/* ── Media card ─────────────────────────────────────────────────── */
.media-card {
    background: var(--card-bg, #242837);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: border-color 0.2s, transform 0.2s;
}
.media-card:hover {
    border-color: rgba(27, 68, 156, 0.5);
    transform: translateY(-2px);
}

.media-thumb {
    position: relative;
    aspect-ratio: 4 / 3;
    background: #1a1d29;
    overflow: hidden;
    cursor: zoom-in;
}

.media-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.25s;
}
.media-card:hover .media-thumb img { transform: scale(1.04); }

.media-thumb-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    opacity: 0;
    transition: opacity 0.2s;
}
.media-card:hover .media-thumb-overlay { opacity: 1; }

.media-meta {
    padding: 10px 12px 6px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1;
}

.media-name {
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.media-sub {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-wrap: wrap;
}

.folder-badge {
    display: inline-flex;
    align-items: center;
    padding: 1px 7px;
    border-radius: 10px;
    font-size: 10px;
    font-weight: 600;
    background: rgba(27, 68, 156, 0.2);
    color: #93b4ff;
    border: 1px solid rgba(27, 68, 156, 0.3);
}

.media-size { font-size: 11px; color: var(--text-secondary, #a0a4b8); }
.media-date { font-size: 11px; color: var(--text-secondary, #a0a4b8); opacity: .7; }

.media-actions {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 12px 10px;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    height: 28px;
    padding: 0 10px;
    border-radius: 6px;
    border: 1px solid transparent;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
}

.action-btn--copy {
    background: rgba(27,68,156,.1);
    border-color: rgba(27,68,156,.3);
    color: #93b4ff;
    flex: 1;
    justify-content: center;
}
.action-btn--copy:hover { background: rgba(27,68,156,.2); }
.action-btn--copied {
    background: rgba(46,204,113,.12);
    border-color: rgba(46,204,113,.3);
    color: #2ecc71;
}

.action-btn--delete {
    background: rgba(231,76,60,.08);
    border-color: rgba(231,76,60,.25);
    color: #e74c3c;
    padding: 0 8px;
}
.action-btn--delete:hover { background: rgba(231,76,60,.2); }

.ml-auto { margin-left: auto; }

/* ── Lightbox ────────────────────────────────────────────────────── */
.lightbox-card {
    background: var(--card-bg, #242837);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 16px;
    overflow: hidden;
}

.lightbox-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 18px;
    border-bottom: 1px solid var(--border-color, #3a3d52);
}

.lightbox-filename {
    font-size: 13px;
    font-weight: 600;
    color: #fff;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 600px;
}

.lightbox-img {
    width: 100%;
    max-height: 65vh;
    object-fit: contain;
    background: #1a1d29;
    display: block;
}

.lightbox-footer {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 18px;
    border-top: 1px solid var(--border-color, #3a3d52);
    flex-wrap: wrap;
}

/* ── Modal shared ────────────────────────────────────────────────── */
.modal-card {
    background: var(--card-bg, #242837);
    border: 1px solid var(--border-color, #3a3d52);
    border-radius: 14px;
    overflow: hidden;
}

.modal-header {
    display: flex;
    align-items: center;
    padding: 16px 18px;
    border-bottom: 1px solid var(--border-color, #3a3d52);
    gap: 4px;
}
.modal-header h3 { flex: 1; font-size: 15px; font-weight: 700; color: #fff; margin: 0; }

.modal-close {
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text-secondary, #a0a4b8);
    display: flex;
    padding: 4px;
    border-radius: 6px;
    transition: background 0.13s;
    margin-left: auto;
}
.modal-close:hover { background: rgba(255,255,255,.08); color: #fff; }

.modal-body { padding: 18px; }
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 13px 18px;
    border-top: 1px solid var(--border-color, #3a3d52);
}

.delete-preview {
    display: flex;
    align-items: center;
    gap: 14px;
}

.delete-thumb {
    width: 72px;
    height: 56px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid var(--border-color, #3a3d52);
    flex-shrink: 0;
}

.confirm-text { font-size: 13px; color: var(--text-secondary, #a0a4b8); margin: 0 0 4px; }
.confirm-text strong { color: #fff; }
.confirm-warn { font-size: 11px; color: #e74c3c; margin: 0; }

.btn-cancel {
    height: 34px;
    padding: 0 14px;
    border-radius: 8px;
    border: 1px solid var(--border-color, #3a3d52);
    background: none;
    color: var(--text-secondary, #a0a4b8);
    font-size: 13px;
    cursor: pointer;
    transition: all 0.13s;
}
.btn-cancel:hover { color: #fff; border-color: #fff; }

.btn-danger {
    display: flex;
    align-items: center;
    height: 34px;
    padding: 0 16px;
    border-radius: 8px;
    border: none;
    background: #e74c3c;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.13s;
}
.btn-danger:hover:not(:disabled) { background: #c0392b; }
.btn-danger:disabled { opacity: .6; cursor: not-allowed; }

/* ── Responsive ─────────────────────────────────────────────────── */
@media (max-width: 768px) {
    .media-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .toolbar { flex-direction: column; align-items: stretch; }
    .search-input { width: 100%; }
    .search-wrap { flex: 1; }
}

@media (max-width: 480px) {
    .media-grid { grid-template-columns: 1fr; }
}
</style>
