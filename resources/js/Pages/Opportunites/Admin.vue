<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
    opportunites: { type: Array, default: () => [] },
    candidatures: { type: Array, default: () => [] },
});

const activeTab = ref('offres');

// ── Gestion des offres ───────────────────────────────────────────────────────
const showModal = ref(false);
const editTarget = ref(null);

const form = useForm({
    titre_opportunite: '',
    description_opportunite: '',
    type_contrat: 'CDI',
    lieu_opportunite: '',
    date_limite: '',
    est_active: true,
});

const openCreate = () => {
    editTarget.value = null;
    form.reset();
    form.est_active = true;
    showModal.value = true;
};

const openEdit = (offre) => {
    editTarget.value = offre;
    form.titre_opportunite       = offre.titre_opportunite;
    form.description_opportunite = offre.description_opportunite;
    form.type_contrat            = offre.type_contrat;
    form.lieu_opportunite        = offre.lieu_opportunite ?? '';
    form.date_limite             = offre.date_limite ?? '';
    form.est_active              = offre.est_active;
    showModal.value = true;
};

const saveOffre = () => {
    if (editTarget.value) {
        form.put(route('opportunites.update', editTarget.value.id_opportunite), {
            onSuccess: () => { showModal.value = false; },
        });
    } else {
        form.post(route('opportunites.store'), {
            onSuccess: () => { showModal.value = false; form.reset(); },
        });
    }
};

const deleteOffre = (id) => {
    if (confirm('Supprimer cette offre ? Les candidatures associées seront aussi supprimées.')) {
        router.delete(route('opportunites.destroy', id));
    }
};

// ── Gestion des candidatures ─────────────────────────────────────────────────
const statutFilter = ref('all');
const offreFilter  = ref('all');

const filteredCandidatures = computed(() => {
    return props.candidatures.filter(c => {
        const matchStatut = statutFilter.value === 'all' || c.statut === statutFilter.value;
        const matchOffre  = offreFilter.value  === 'all' || c.id_opportunite === offreFilter.value;
        return matchStatut && matchOffre;
    });
});

const updateStatut = (candidature, statut) => {
    router.put(route('candidatures.update', candidature.id_candidature), { statut }, {
        preserveScroll: true,
    });
};

const statutLabel = { en_attente: 'En attente', vue: 'Vue', acceptee: 'Acceptée', refusee: 'Refusée' };
const statutClass = { en_attente: 'badge-waiting', vue: 'badge-seen', acceptee: 'badge-ok', refusee: 'badge-no' };

const contractColors = {
    CDI:        { bg: '#e8f5e9', color: '#2e7d32' },
    CDD:        { bg: '#e3f2fd', color: '#1565c0' },
    Stage:      { bg: '#fff8e1', color: '#f57f17' },
    Alternance: { bg: '#f3e5f5', color: '#6a1b9a' },
    Freelance:  { bg: '#fce4ec', color: '#880e4f' },
    Autre:  { bg: '#fce4ec', color: '#553e4f' },
};

const formatDate = (d) => d ? new Date(d).toLocaleDateString('fr-FR') : '—';
const formatDateTime = (d) => d ? new Date(d).toLocaleString('fr-FR') : '—';

// ── Modal détail candidature ─────────────────────────────────────────────────
const detailCandidat    = ref(null);
const showDetailModal   = ref(false);

const openDetail = (c) => {
    detailCandidat.value = c;
    showDetailModal.value = true;
};

const cvExt = computed(() => {
    if (!detailCandidat.value?.cv_path) return null;
    return detailCandidat.value.cv_path.split('.').pop().toLowerCase();
});

const isPdf = computed(() => cvExt.value === 'pdf');
</script>

<template>
    <Head title="Opportunités — Admin" />
    <AuthenticatedLayout>
        <div class="page-wrap">

            <!-- Header -->
            <div class="page-header">
                <div>
                    <h1>Opportunités</h1>
                    <p>Gérez les offres d'emploi et les candidatures reçues.</p>
                </div>
                <button v-if="activeTab === 'offres'" class="btn-create" @click="openCreate">
                    <i class="bi bi-plus-lg"></i> Nouvelle offre
                </button>
            </div>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab" :class="{ active: activeTab === 'offres' }" @click="activeTab = 'offres'">
                    <i class="bi bi-list-task"></i> Offres d'emploi
                    <span class="tab-count">{{ opportunites.length }}</span>
                </button>
                <button class="tab" :class="{ active: activeTab === 'candidatures' }" @click="activeTab = 'candidatures'">
                    <i class="bi bi-person-lines-fill"></i> Candidatures
                    <span class="tab-count">{{ candidatures.length }}</span>
                </button>
            </div>

            <!-- ── OFFRES ── -->
            <div v-if="activeTab === 'offres'">
                <div v-if="opportunites.length === 0" class="empty-state">
                    <i class="bi bi-briefcase" style="font-size:2.5rem; color:#4b5563;"></i>
                    <p>Aucune offre créée. Commencez par en ajouter une.</p>
                </div>

                <div v-else class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Titre</th>
                                <th>Contrat</th>
                                <th>Lieu</th>
                                <th>Limite</th>
                                <th>Candidatures</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="offre in opportunites" :key="offre.id_opportunite">
                                <td class="td-title">{{ offre.titre_opportunite }}</td>
                                <td>
                                    <span class="contract-badge"
                                          :style="{ background: contractColors[offre.type_contrat]?.bg, color: contractColors[offre.type_contrat]?.color }">
                                        {{ offre.type_contrat }}
                                    </span>
                                </td>
                                <td>{{ offre.lieu_opportunite || '—' }}</td>
                                <td>{{ formatDate(offre.date_limite) }}</td>
                                <td>
                                    <button class="count-btn" @click="activeTab = 'candidatures'; offreFilter = offre.id_opportunite">
                                        {{ offre.candidatures_count }}
                                        <i class="bi bi-person-fill"></i>
                                    </button>
                                </td>
                                <td>
                                    <span :class="offre.est_active ? 'badge-active' : 'badge-inactive'">
                                        {{ offre.est_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="td-actions">
                                    <button class="icon-btn edit" @click="openEdit(offre)" title="Modifier">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="icon-btn del" @click="deleteOffre(offre.id_opportunite)" title="Supprimer">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ── CANDIDATURES ── -->
            <div v-if="activeTab === 'candidatures'">
                <!-- Filtres -->
                <div class="filters">
                    <select v-model="offreFilter">
                        <option value="all">Toutes les offres</option>
                        <option v-for="o in opportunites" :key="o.id_opportunite" :value="o.id_opportunite">
                            {{ o.titre_opportunite }}
                        </option>
                    </select>
                    <select v-model="statutFilter">
                        <option value="all">Tous les statuts</option>
                        <option v-for="(label, key) in statutLabel" :key="key" :value="key">{{ label }}</option>
                    </select>
                    <button v-if="statutFilter !== 'all' || offreFilter !== 'all'" class="reset-btn"
                            @click="statutFilter = 'all'; offreFilter = 'all'">
                        <i class="bi bi-x-circle"></i> Réinitialiser
                    </button>
                </div>

                <div v-if="filteredCandidatures.length === 0" class="empty-state">
                    <i class="bi bi-inbox" style="font-size:2.5rem; color:#4b5563;"></i>
                    <p>Aucune candidature pour cette sélection.</p>
                </div>

                <div v-else class="candidatures-list">
                    <div v-for="c in filteredCandidatures" :key="c.id_candidature" class="candidature-row">

                        <!-- Avatar + identité -->
                        <div class="cand-avatar">{{ c.prenom_candidat[0] }}{{ c.nom_candidat[0] }}</div>

                        <div class="cand-identity">
                            <div class="cand-name">{{ c.prenom_candidat }} {{ c.nom_candidat }}</div>
                            <div class="cand-email">{{ c.email_candidat }}</div>
                        </div>

                        <!-- Offre -->
                        <div class="cand-offre-col" v-if="c.opportunite">
                            <span class="contract-badge"
                                  :style="{ background: contractColors[c.opportunite.type_contrat]?.bg, color: contractColors[c.opportunite.type_contrat]?.color }">
                                {{ c.opportunite.type_contrat }}
                            </span>
                            <span class="cand-offre-titre">{{ c.opportunite.titre_opportunite }}</span>
                        </div>

                        <!-- Date -->
                        <span class="cand-date"><i class="bi bi-clock"></i> {{ formatDate(c.created_at) }}</span>

                        <!-- Statut -->
                        <span :class="['cand-statut', statutClass[c.statut]]">{{ statutLabel[c.statut] }}</span>

                        <!-- CV badge -->
                        <span v-if="c.cv_path" class="cv-badge"><i class="bi bi-paperclip"></i> CV</span>
                        <span v-else class="cv-badge cv-badge--none">Sans CV</span>

                        <!-- Bouton détail -->
                        <button class="btn-voir" @click="openDetail(c)">
                            <i class="bi bi-eye-fill"></i> Voir
                        </button>

                    </div>
                </div>
            </div>

        </div>

        <!-- ── MODAL offre ── -->
        <div v-if="showModal" class="modal-overlay" @click.self="showModal = false">
            <div class="modal-box">
                <div class="modal-header">
                    <h3>{{ editTarget ? 'Modifier l\'offre' : 'Nouvelle offre' }}</h3>
                    <button @click="showModal = false"><i class="bi bi-x-lg"></i></button>
                </div>
                <form @submit.prevent="saveOffre">
                    <div class="form-group">
                        <label>Titre <span class="req">*</span></label>
                        <input v-model="form.titre_opportunite" type="text" required placeholder="ex: Développeur Full Stack" />
                        <span v-if="form.errors.titre_opportunite" class="field-error">{{ form.errors.titre_opportunite }}</span>
                    </div>
                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Type de contrat <span class="req">*</span></label>
                            <select v-model="form.type_contrat">
                                <option>CDI</option><option>CDD</option><option>Stage</option>
                                <option>Alternance</option><option>Freelance</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Lieu</label>
                            <input v-model="form.lieu_opportunite" type="text" placeholder="ex: Nouakchott" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Date limite de candidature</label>
                        <input v-model="form.date_limite" type="date" />
                    </div>
                    <div class="form-group">
                        <label>Description <span class="req">*</span></label>
                        <textarea v-model="form.description_opportunite" rows="7" required
                                  placeholder="Missions, profil recherché, compétences requises…"></textarea>
                        <span v-if="form.errors.description_opportunite" class="field-error">{{ form.errors.description_opportunite }}</span>
                    </div>
                    <div class="form-group toggle-group">
                        <label>
                            <input type="checkbox" v-model="form.est_active" />
                            Offre active (visible sur le site)
                        </label>
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn-cancel" @click="showModal = false">Annuler</button>
                        <button type="submit" class="btn-save" :disabled="form.processing">
                            {{ form.processing ? 'Enregistrement…' : 'Enregistrer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ── MODAL détail candidature ── -->
        <div v-if="showDetailModal && detailCandidat" class="modal-overlay detail-overlay" @click.self="showDetailModal = false">
            <div class="detail-box">

                <!-- En-tête -->
                <div class="detail-header">
                    <div class="detail-header-left">
                        <div class="detail-avatar">
                            {{ detailCandidat.prenom_candidat[0] }}{{ detailCandidat.nom_candidat[0] }}
                        </div>
                        <div>
                            <h3>{{ detailCandidat.prenom_candidat }} {{ detailCandidat.nom_candidat }}</h3>
                            <p>{{ detailCandidat.email_candidat }}</p>
                        </div>
                    </div>
                    <div class="detail-header-right">
                        <select class="statut-select-lg"
                                :value="detailCandidat.statut"
                                @change="updateStatut(detailCandidat, $event.target.value)">
                            <option v-for="(label, key) in statutLabel" :key="key" :value="key">{{ label }}</option>
                        </select>
                        <button class="close-btn" @click="showDetailModal = false"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>

                <!-- Corps : deux colonnes -->
                <div class="detail-body">

                    <!-- Colonne gauche : informations -->
                    <div class="detail-info">

                        <div class="info-block">
                            <div class="info-label"><i class="bi bi-briefcase-fill"></i> Offre visée</div>
                            <div class="info-value" v-if="detailCandidat.opportunite">
                                <span class="contract-badge"
                                      :style="{ background: contractColors[detailCandidat.opportunite.type_contrat]?.bg, color: contractColors[detailCandidat.opportunite.type_contrat]?.color }">
                                    {{ detailCandidat.opportunite.type_contrat }}
                                </span>
                                {{ detailCandidat.opportunite.titre_opportunite }}
                            </div>
                        </div>

                        <div v-if="detailCandidat.telephone_candidat" class="info-block">
                            <div class="info-label"><i class="bi bi-telephone-fill"></i> Téléphone</div>
                            <div class="info-value">{{ detailCandidat.telephone_candidat }}</div>
                        </div>

                        <div class="info-block">
                            <div class="info-label"><i class="bi bi-calendar3"></i> Date de candidature</div>
                            <div class="info-value">{{ formatDateTime(detailCandidat.created_at) }}</div>
                        </div>

                        <div class="info-block">
                            <div class="info-label"><i class="bi bi-chat-left-text-fill"></i> Lettre de motivation</div>
                            <div class="info-value motivation-text">{{ detailCandidat.message_candidature }}</div>
                        </div>

                        <!-- Boutons CV -->
                        <div v-if="detailCandidat.cv_path" class="cv-actions">
                            <a :href="route('candidatures.cv.download', detailCandidat.id_candidature)"
                               class="btn-dl">
                                <i class="bi bi-download"></i> Télécharger le CV
                            </a>
                        </div>
                        <p v-else class="no-cv"><i class="bi bi-file-earmark-x"></i> Aucun CV joint</p>

                    </div>

                    <!-- Colonne droite : prévisualisation CV -->
                    <div class="detail-preview">
                        <div class="preview-header">
                            <span><i class="bi bi-file-earmark-pdf-fill"></i> Prévisualisation du CV</span>
                        </div>

                        <div v-if="!detailCandidat.cv_path" class="preview-empty">
                            <i class="bi bi-file-earmark-x" style="font-size:3rem;"></i>
                            <p>Aucun CV joint à cette candidature</p>
                        </div>

                        <template v-else-if="isPdf">
                            <iframe
                                :src="route('candidatures.cv', detailCandidat.id_candidature)"
                                class="cv-iframe"
                                type="application/pdf"
                            ></iframe>
                        </template>

                        <div v-else class="preview-empty">
                            <i class="bi bi-file-earmark-word" style="font-size:3rem; color:#2563eb;"></i>
                            <p>Prévisualisation non disponible pour les fichiers <strong>.{{ cvExt }}</strong></p>
                            <a :href="route('candidatures.cv.download', detailCandidat.id_candidature)"
                               class="btn-dl">
                                <i class="bi bi-download"></i> Télécharger pour lire
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>
.page-wrap { padding: 32px; max-width: 1200px; }

.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}
.page-header h1 { font-size: 26px; font-weight: 700; color: var(--text-primary); margin: 0 0 4px; }
.page-header p  { color: var(--text-secondary); font-size: 14px; margin: 0; }

.btn-create {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
}
.btn-create:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(241,90,45,.4); }

/* Tabs */
.tabs {
    display: flex;
    gap: 4px;
    border-bottom: 2px solid var(--border-color);
    margin-bottom: 24px;
}
.tab {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border: none;
    background: none;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: all .2s;
    font-family: inherit;
}
.tab:hover { color: var(--text-primary); }
.tab.active { color: #f15a2d; border-bottom-color: #f15a2d; }
.tab-count {
    background: var(--card-hover);
    color: var(--text-secondary);
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 100px;
    font-weight: 700;
}
.tab.active .tab-count { background: rgba(241,90,45,.15); color: #f15a2d; }

/* Table */
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead th {
    text-align: left;
    padding: 12px 16px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--text-secondary);
    border-bottom: 1px solid var(--border-color);
    white-space: nowrap;
}
tbody tr { border-bottom: 1px solid var(--border-color); transition: background .15s; }
tbody tr:hover { background: var(--card-hover); }
tbody td { padding: 14px 16px; font-size: 14px; color: var(--text-primary); vertical-align: middle; }
.td-title { font-weight: 600; max-width: 280px; }

.contract-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
}
.badge-active   { background: rgba(46,204,113,.15); color: #2ecc71; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600; }
.badge-inactive { background: rgba(231,76,60,.15);  color: #e74c3c; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600; }

.count-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    background: var(--card-hover);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
}
.count-btn:hover { border-color: #f15a2d; color: #f15a2d; }

.td-actions { display: flex; gap: 8px; }
.icon-btn {
    width: 32px; height: 32px;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: none;
    cursor: pointer;
    transition: all .2s;
    font-size: 13px;
}
.icon-btn.edit { color: #3498db; }
.icon-btn.edit:hover { background: rgba(52,152,219,.15); border-color: #3498db; }
.icon-btn.del  { color: #e74c3c; }
.icon-btn.del:hover  { background: rgba(231,76,60,.15); border-color: #e74c3c; }

/* Filters */
.filters {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
    flex-wrap: wrap;
    align-items: center;
}
.filters select {
    padding: 9px 14px;
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 13px;
    font-family: inherit;
    cursor: pointer;
}
.reset-btn {
    display: flex; align-items: center; gap: 6px;
    padding: 8px 14px;
    background: none;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-secondary);
    font-size: 13px;
    cursor: pointer;
    transition: all .2s;
}
.reset-btn:hover { border-color: #e74c3c; color: #e74c3c; }

/* ── Candidatures list ───────────────────────────────────────────────────── */
.candidatures-list { display: flex; flex-direction: column; gap: 8px; }

.candidature-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 18px;
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    transition: border-color .2s, background .2s;
    flex-wrap: wrap;
}
.candidature-row:hover { border-color: rgba(241,90,45,.35); background: var(--card-hover); }

.cand-avatar {
    width: 40px; height: 40px; flex-shrink: 0;
    border-radius: 50%;
    background: linear-gradient(135deg, #1b449c, #f15a2d);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: #fff;
}

.cand-identity { min-width: 160px; flex: 1; }
.cand-name  { font-size: 14px; font-weight: 700; color: var(--text-primary); }
.cand-email { font-size: 12px; color: var(--text-secondary); }

.cand-offre-col { display: flex; align-items: center; gap: 8px; flex: 2; min-width: 180px; }
.cand-offre-titre { font-size: 13px; color: var(--text-secondary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px; }

.cand-date { font-size: 12px; color: var(--text-secondary); display: flex; align-items: center; gap: 5px; white-space: nowrap; }

.cand-statut { font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 100px; white-space: nowrap; }
.badge-waiting { background: rgba(243,156,18,.15);  color: #f39c12; }
.badge-seen    { background: rgba(52,152,219,.15);  color: #3498db; }
.badge-ok      { background: rgba(46,204,113,.15);  color: #2ecc71; }
.badge-no      { background: rgba(231,76,60,.15);   color: #e74c3c; }

.cv-badge {
    font-size: 11px; font-weight: 600;
    padding: 3px 10px; border-radius: 100px;
    background: rgba(27,68,156,.12); color: #3498db;
    white-space: nowrap;
    display: flex; align-items: center; gap: 4px;
}
.cv-badge--none { background: rgba(100,116,139,.1); color: #64748b; }

.btn-voir {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 16px;
    background: linear-gradient(135deg, #1b449c, #2d5cc8);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
    font-family: inherit;
    margin-left: auto;
}
.btn-voir:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(27,68,156,.4); }

/* ── Modal détail candidature ────────────────────────────────────────────── */
.detail-overlay { padding: 16px; }

.detail-box {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 18px;
    width: 100%;
    max-width: 1100px;
    max-height: 92vh;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* En-tête modal */
.detail-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 28px;
    border-bottom: 1px solid var(--border-color);
    gap: 16px;
    flex-wrap: wrap;
}
.detail-header-left { display: flex; align-items: center; gap: 14px; }
.detail-avatar {
    width: 50px; height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1b449c, #f15a2d);
    display: flex; align-items: center; justify-content: center;
    font-size: 17px; font-weight: 700; color: #fff; flex-shrink: 0;
}
.detail-header-left h3 { font-size: 17px; font-weight: 700; color: var(--text-primary); margin: 0 0 3px; }
.detail-header-left p  { font-size: 13px; color: var(--text-secondary); margin: 0; }
.detail-header-right { display: flex; align-items: center; gap: 12px; }

.statut-select-lg {
    padding: 8px 14px;
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 13px;
    font-family: inherit;
    cursor: pointer;
}

.close-btn {
    width: 36px; height: 36px;
    background: none; border: 1px solid var(--border-color);
    border-radius: 8px; color: var(--text-secondary);
    cursor: pointer; font-size: 14px; transition: all .2s;
    display: flex; align-items: center; justify-content: center;
}
.close-btn:hover { background: var(--card-hover); color: var(--text-primary); }

/* Corps : deux colonnes */
.detail-body {
    display: grid;
    grid-template-columns: 340px 1fr;
    flex: 1;
    overflow: hidden;
    min-height: 0;
}

/* Colonne gauche */
.detail-info {
    padding: 24px 28px;
    border-right: 1px solid var(--border-color);
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-label {
    font-size: 11px; font-weight: 700; text-transform: uppercase;
    letter-spacing: .06em; color: var(--text-secondary);
    display: flex; align-items: center; gap: 6px;
    margin-bottom: 6px;
}
.info-label i { color: #f15a2d; }
.info-value { font-size: 14px; color: var(--text-primary); line-height: 1.5; }

.motivation-text {
    background: var(--dark-bg);
    border-left: 3px solid #1b449c;
    padding: 14px 16px;
    border-radius: 0 8px 8px 0;
    font-size: 13px;
    line-height: 1.7;
    color: var(--text-secondary);
    white-space: pre-wrap;
    max-height: 200px;
    overflow-y: auto;
}

.cv-actions { margin-top: 4px; }
.btn-dl {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13px; font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: all .2s;
}
.btn-dl:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(241,90,45,.4); color: #fff; }

.no-cv { font-size: 13px; color: var(--text-secondary); display: flex; align-items: center; gap: 6px; }

/* Colonne droite : preview */
.detail-preview {
    display: flex;
    flex-direction: column;
    overflow: hidden;
}
.preview-header {
    padding: 14px 20px;
    border-bottom: 1px solid var(--border-color);
    font-size: 13px; font-weight: 600;
    color: var(--text-secondary);
    display: flex; align-items: center; gap: 8px;
}
.preview-header i { color: #e74c3c; }

.cv-iframe {
    flex: 1;
    width: 100%;
    height: 100%;
    border: none;
    min-height: 500px;
    background: #f1f5f9;
}

.preview-empty {
    flex: 1;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    gap: 16px;
    color: var(--text-secondary);
    padding: 40px;
    text-align: center;
}
.preview-empty p { font-size: 14px; margin: 0; }

.statut-select {
    padding: 6px 10px;
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 12px;
    font-family: inherit;
    cursor: pointer;
}

/* Empty */
.empty-state {
    text-align: center;
    padding: 60px 24px;
    color: var(--text-secondary);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}
.empty-state p { font-size: 14px; margin: 0; }

/* Modal */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.6);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    padding: 24px;
}
.modal-box {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    width: 100%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    padding: 28px;
}
.modal-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px;
}
.modal-header h3 { font-size: 18px; font-weight: 700; color: var(--text-primary); margin: 0; }
.modal-header button {
    width: 32px; height: 32px;
    background: none; border: 1px solid var(--border-color);
    border-radius: 8px; color: var(--text-secondary);
    cursor: pointer; font-size: 14px; transition: all .2s;
}
.modal-header button:hover { background: var(--card-hover); color: var(--text-primary); }

.form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 18px; }
.form-group label { font-size: 13px; font-weight: 600; color: var(--text-secondary); }
.req { color: #f15a2d; }
.form-group input, .form-group select, .form-group textarea {
    padding: 10px 14px;
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: border-color .2s;
    resize: vertical;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    border-color: #1b449c;
}
.form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.toggle-group label { display: flex; align-items: center; gap: 10px; cursor: pointer; }
.toggle-group input[type="checkbox"] { width: 16px; height: 16px; accent-color: #f15a2d; }
.field-error { font-size: 12px; color: #e74c3c; }

.modal-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 8px; }
.btn-cancel {
    padding: 10px 20px;
    background: none;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-secondary);
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
}
.btn-cancel:hover { border-color: var(--text-primary); color: var(--text-primary); }
.btn-save {
    padding: 10px 24px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
}
.btn-save:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(241,90,45,.4); }
.btn-save:disabled { opacity: .65; cursor: not-allowed; }

@media (max-width: 900px) {
    .detail-body { grid-template-columns: 1fr; }
    .detail-preview { min-height: 400px; }
    .detail-info { border-right: none; border-bottom: 1px solid var(--border-color); }
}
@media (max-width: 640px) {
    .candidature-row { flex-wrap: wrap; gap: 10px; }
    .cand-offre-col, .cand-date { display: none; }
    .btn-voir { margin-left: 0; }
    .form-row-2 { grid-template-columns: 1fr; }
    .page-wrap { padding: 16px; }
    .detail-box { max-height: 98vh; border-radius: 12px; }
}
</style>
