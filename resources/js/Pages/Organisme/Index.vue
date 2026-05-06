<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref,onMounted } from 'vue';

const props = defineProps({
    organisme:  { type: Object, default: null },
    telephones: { type: Array,  default: () => [] },
    emails:     { type: Array,  default: () => [] },
});

// ── Infos générales ──────────────────────────────────────────────────────────
const infoForm = useForm({
    nom_organisme:      props.organisme?.nom_organisme      ?? '',
    adresse_organisme:  props.organisme?.adresse_organisme  ?? '',
    slogan_organisme:   props.organisme?.slogan_organisme   ?? '',
    lien_map_organisme: props.organisme?.lien_map_organisme ?? '',
});

const saveInfo = () => {
    infoForm.put(route('organisme.update', props.organisme.id_organisme));
};

// ── Téléphones ───────────────────────────────────────────────────────────────
const telForm = useForm({ code_telephone: '+227', telephone: '' });

const addTel = () => {
    telForm.post(route('organisme.telephones.store'), {
        onSuccess: () => telForm.reset('telephone'),
    });
};

const deleteTel = (id) => {
    if (confirm('Supprimer ce numéro ?')) {
        router.delete(route('organisme.telephones.destroy', id), { preserveScroll: true });
    }
};

// ── Emails ───────────────────────────────────────────────────────────────────
const emailForm = useForm({ email: '' });

const addEmail = () => {
    emailForm.post(route('organisme.emails.store'), {
        onSuccess: () => emailForm.reset(),
    });
};

const deleteEmail = (id) => {
    if (confirm('Supprimer cet email ?')) {
        router.delete(route('organisme.emails.destroy', id), { preserveScroll: true });
    }
};

// ── Helpers ──────────────────────────────────────────────────────────────────
const formatTel = (t) => {
    const s = String(t.telephone).replace(/\D/g, '');
    const parts = s.match(/.{1,2}/g) ?? [s];
    return `${t.code_telephone} ${parts.join(' ')}`;
};

onMounted(() => {
    console.log('telephones:', props.telephones)
})
</script>

<template>
    <Head title="Organisme" />
    <AuthenticatedLayout>
        <div class="page-wrap">

            <div class="page-header">
                <div>
                    <h1><i class="bi bi-building-fill"></i> Organisme</h1>
                    <p>Configurez les informations de Synetcom affichées sur le site (pied de page, page contact).</p>
                </div>
            </div>

            <!-- ── Infos générales ── -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-info-circle-fill"></i> Informations générales
                </div>
                <form @submit.prevent="saveInfo" class="card-body">
                    <div class="form-row-2">
                        <div class="form-group">
                            <label>Nom de l'organisme <span class="req">*</span></label>
                            <input v-model="infoForm.nom_organisme" type="text" required placeholder="ex: Synetcom" />
                            <span v-if="infoForm.errors.nom_organisme" class="field-error">{{ infoForm.errors.nom_organisme }}</span>
                        </div>
                        <div class="form-group">
                            <label>Adresse <span class="req">*</span></label>
                            <input v-model="infoForm.adresse_organisme" type="text" required placeholder="Adresse physique" />
                            <span v-if="infoForm.errors.adresse_organisme" class="field-error">{{ infoForm.errors.adresse_organisme }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Slogan <span class="req">*</span></label>
                        <textarea v-model="infoForm.slogan_organisme" rows="3" required placeholder="Slogan affiché sur la page d'accueil et le pied de page"></textarea>
                        <span v-if="infoForm.errors.slogan_organisme" class="field-error">{{ infoForm.errors.slogan_organisme }}</span>
                    </div>
                    <div class="form-group">
                        <label>Lien Google Maps</label>
                        <input v-model="infoForm.lien_map_organisme" type="text" placeholder="https://maps.google.com/?q=..." />
                        <span class="form-hint">Ce lien est utilisé pour le bouton itinéraire sur la page contact.</span>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn-save" :disabled="infoForm.processing">
                            <i class="bi bi-check-lg"></i>
                            {{ infoForm.processing ? 'Enregistrement…' : 'Enregistrer les informations' }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- ── Téléphones ── -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-telephone-fill"></i> Numéros de téléphone
                    <span class="count-badge">{{ telephones.length }}</span>
                </div>
                <div class="card-body">
                    <!-- Liste -->
                    <div v-if="telephones.length" class="contacts-list">
                        <div v-for="t in telephones" :key="t.id_telephone" class="contact-row">
                            <div class="contact-icon-wrap"><i class="bi bi-telephone-fill"></i></div>
                            <span class="contact-value">{{ formatTel(t) }}</span>
                            <a :href="`tel:${t.code_telephone}${t.telephone}`" class="contact-link" target="_blank">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            <button class="del-btn" @click="deleteTel(t.id_telephone)" title="Supprimer">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                    <p v-else class="empty-hint">Aucun numéro enregistré.</p>

                    <!-- Ajouter -->
                    <form @submit.prevent="addTel" class="add-form">
                        <select v-model="telForm.code_telephone" class="code-select">
                            <option>+227</option>
                            <option>+33</option>
                            <option>+1</option>
                            <option>+44</option>
                            <option>+221</option>
                            <option>+223</option>
                        </select>
                        <input
                            v-model="telForm.telephone"
                            type="number"
                            required
                            placeholder="Numéro (ex: 90717476)"
                            class="add-input"
                        />
                        <button type="submit" class="btn-add" :disabled="telForm.processing">
                            <i class="bi bi-plus-lg"></i> Ajouter
                        </button>
                    </form>
                    <span v-if="telForm.errors.telephone" class="field-error">{{ telForm.errors.telephone }}</span>
                </div>
            </div>

            <!-- ── Emails ── -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-envelope-fill"></i> Adresses email
                    <span class="count-badge">{{ emails.length }}</span>
                </div>
                <div class="card-body">
                    <!-- Liste -->
                    <div v-if="emails.length" class="contacts-list">
                        <div v-for="e in emails" :key="e.id_email" class="contact-row">
                            <div class="contact-icon-wrap"><i class="bi bi-envelope-fill"></i></div>
                            <span class="contact-value">{{ e.email }}</span>
                            <a :href="`mailto:${e.email}`" class="contact-link" target="_blank">
                                <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                            <button class="del-btn" @click="deleteEmail(e.id_email)" title="Supprimer">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                    <p v-else class="empty-hint">Aucune adresse email enregistrée.</p>

                    <!-- Ajouter -->
                    <form @submit.prevent="addEmail" class="add-form">
                        <input
                            v-model="emailForm.email"
                            type="email"
                            required
                            placeholder="ex: contact@synetcom.ne"
                            class="add-input"
                        />
                        <button type="submit" class="btn-add" :disabled="emailForm.processing">
                            <i class="bi bi-plus-lg"></i> Ajouter
                        </button>
                    </form>
                    <span v-if="emailForm.errors.email" class="field-error">{{ emailForm.errors.email }}</span>
                </div>
            </div>

            <!-- Aperçu pied de page -->
            <div class="card preview-card">
                <div class="card-header">
                    <i class="bi bi-eye-fill"></i> Aperçu pied de page
                </div>
                <div class="card-body preview-body">
                    <div class="preview-block">
                        <div class="preview-label">Adresse</div>
                        <div class="preview-value">{{ infoForm.adresse_organisme || '—' }}</div>
                    </div>
                    <div class="preview-block">
                        <div class="preview-label">Téléphones</div>
                        <div class="preview-value">
                            <span v-if="telephones.length">{{ telephones.map(formatTel).join(' / ') }}</span>
                            <span v-else class="text-muted">—</span>
                        </div>
                    </div>
                    <div class="preview-block">
                        <div class="preview-label">Emails</div>
                        <div class="preview-value">
                            <span v-if="emails.length">{{ emails.map(e => e.email).join(', ') }}</span>
                            <span v-else class="text-muted">—</span>
                        </div>
                    </div>
                    <div class="preview-block">
                        <div class="preview-label">Slogan</div>
                        <div class="preview-value">{{ infoForm.slogan_organisme || '—' }}</div>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.page-wrap { padding: 32px; max-width: 900px; }

.page-header { margin-bottom: 28px; }
.page-header h1 {
    font-size: 24px; font-weight: 700;
    color: var(--text-primary); margin: 0 0 4px;
    display: flex; align-items: center; gap: 10px;
}
.page-header h1 i { color: #f15a2d; }
.page-header p { color: var(--text-secondary); font-size: 14px; margin: 0; }

/* Cards */
.card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    margin-bottom: 24px;
    overflow: hidden;
}
.card-header {
    padding: 16px 24px;
    border-bottom: 1px solid var(--border-color);
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,.02);
}
.card-header i { color: #f15a2d; font-size: 16px; }
.card-body { padding: 24px; }

.count-badge {
    margin-left: auto;
    background: var(--card-hover);
    color: var(--text-secondary);
    font-size: 11px;
    padding: 2px 9px;
    border-radius: 100px;
    font-weight: 700;
}

/* Forms */
.form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
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
.form-hint { font-size: 12px; color: var(--text-secondary); margin-top: 4px; }
.field-error { font-size: 12px; color: #e74c3c; margin-top: 2px; }

.form-footer { display: flex; justify-content: flex-end; padding-top: 4px; }
.btn-save {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 24px;
    background: linear-gradient(135deg, #f15a2d, #e04518);
    color: #fff; border: none; border-radius: 8px;
    font-size: 14px; font-weight: 700; cursor: pointer;
    transition: all .2s; font-family: inherit;
}
.btn-save:hover:not(:disabled) { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(241,90,45,.4); }
.btn-save:disabled { opacity: .65; cursor: not-allowed; }

/* Contacts list */
.contacts-list { display: flex; flex-direction: column; gap: 8px; margin-bottom: 20px; }
.contact-row {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 16px;
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    transition: border-color .2s;
}
.contact-row:hover { border-color: rgba(241,90,45,.3); }

.contact-icon-wrap {
    width: 34px; height: 34px; flex-shrink: 0;
    border-radius: 8px;
    background: rgba(27,68,156,.15);
    display: flex; align-items: center; justify-content: center;
    color: #3498db; font-size: 14px;
}
.contact-value { flex: 1; font-size: 14px; color: var(--text-primary); font-weight: 500; }
.contact-link {
    color: var(--text-secondary);
    font-size: 13px;
    text-decoration: none;
    padding: 4px 8px;
    border-radius: 6px;
    transition: all .2s;
}
.contact-link:hover { color: #3498db; background: rgba(52,152,219,.1); }
.del-btn {
    width: 30px; height: 30px;
    display: flex; align-items: center; justify-content: center;
    background: none;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    color: var(--text-secondary);
    cursor: pointer; font-size: 12px; transition: all .2s;
}
.del-btn:hover { background: rgba(231,76,60,.1); border-color: #e74c3c; color: #e74c3c; }

.empty-hint { font-size: 13px; color: var(--text-secondary); margin-bottom: 16px; }

/* Add form */
.add-form { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
.code-select {
    padding: 9px 10px;
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 13px;
    font-family: inherit;
    width: 90px;
}
.add-input {
    flex: 1;
    padding: 9px 14px;
    background: var(--dark-bg);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    color: var(--text-primary);
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: border-color .2s;
    min-width: 180px;
}
.add-input:focus { border-color: #1b449c; }
.btn-add {
    display: flex; align-items: center; gap: 6px;
    padding: 9px 18px;
    background: #1b449c;
    color: #fff; border: none; border-radius: 8px;
    font-size: 13px; font-weight: 600; cursor: pointer;
    transition: all .2s; white-space: nowrap; font-family: inherit;
}
.btn-add:hover:not(:disabled) { background: #2d5cc8; }
.btn-add:disabled { opacity: .65; cursor: not-allowed; }

/* Preview */
.preview-card { border-color: rgba(241,90,45,.25); }
.preview-body { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.preview-block {}
.preview-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--text-secondary); margin-bottom: 6px; }
.preview-value { font-size: 14px; color: var(--text-primary); line-height: 1.5; }
.text-muted { color: var(--text-secondary); }

@media (max-width: 640px) {
    .page-wrap { padding: 16px; }
    .form-row-2 { grid-template-columns: 1fr; }
    .preview-body { grid-template-columns: 1fr; }
    .add-form { flex-direction: column; align-items: stretch; }
    .code-select { width: 100%; }
}
</style>
