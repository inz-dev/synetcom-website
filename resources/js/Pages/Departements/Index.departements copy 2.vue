<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, router, usePage } from "@inertiajs/vue3";
import { onMounted, watch, ref, shallowRef, toRef } from "vue";
const props = defineProps({ allDepartments: Array }, { errors: Object });
let newSet = new Set();
let uniqueDepts;
const departements = [];
if (props.allDepartments || props.allDepartments.length != 0) {
    props.allDepartments.forEach((element, index) => {
        /* console.log("element:", element) */
        departements.push({
            index: index + 1,
            ...element,
        });
    });
    uniqueDepts = props.allDepartments.filter(
        ({ id_departement }) =>
            !newSet.has(id_departement) && newSet.add(id_departement),
    );
}

//const plainArray=uniqueDepts.map(obj =>({ obj }) )

const plainArray = uniqueDepts.map((proxy, index) => {
    /*  console.log('index:', index)
    console.log('proxy:', proxy) */
    return {
        index: index + 1,
        id_dept: proxy.id_departement,
        nom_dept: proxy.nom_departement,
    };
});
console.log("plainArray:", departements);
const headersT = [
    { title: "N° Service", key: "index" },
    { title: "Service", sortable: false, key: "nom_service" },
    { title: "Description", key: "description_service", align: "end" },
    { title: "Actions", key: "actions", align: "end", sortable: false },
];
const groupByT = [{ key: "departements.nom_departement", order: "asc" }];

const groupBy = [{ key: "type", order: "asc" }];


const search = ref("");

onMounted(() => {
    console.log("props.allDepartments:", props.allDepartments);
    /* console.log("departments:", departements) */
    //departements.map(el=> console.log(el))
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="container mb-2">
            <div class="row gy-2 gy-xl-0 mt-4">
                <v-text-field
                    v-model="search"
                    prepend-inner-icon="mdi-magnify"
                    label="Recherche"
                    single-line
                    variant="outlined"
                    color="secondary"
                    clearable
                    hide-details
                    class="mt-4 py-4"
                    solo
                    style="max-width: 350px"
                />
                <v-data-table
                    :group-by="groupByT"
                    :headers="headersT"
                    :items="departements"
                    :items-per-page="-1"
                    item-value="nom_service"
                    fixed-header
       sort-asc-icon="mdi-sort-ascending"
    sort-desc-icon="mdi-sort-descending"
    sort-icon="mdi-swap-vertical"
                >
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-toolbar-title color="primary">
                                <v-icon
                                    color="primary"
                                    icon="mdi-book-multiple"
                                    size="x-small"
                                    start
                                ></v-icon>
                                <span style="color: #1b449c">Départements</span>
                            </v-toolbar-title>

                            <v-btn
                                class="me-2"
                                prepend-icon="mdi-plus"
                                rounded="lg"
                                text="Ajouter"
                                border
                                color="primary"
                                @click="addDepartements"
                            ></v-btn>
                        </v-toolbar>
                    </template>
                    <template v-slot:group-summary="{ item, columns }">
                        {{ console.log("columns:", item) }}
                        <tr class="font-weight-bold text-red">
                            <td
                                v-for="c in columns"
                                :key="c.key"
                                :class="[
                                    'v-data-table__td',
                                    c.align
                                        ? `v-data-table-column--align-${c.align}`
                                        : '',
                                ]"
                            ></td>
                        </tr>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <div class="d-flex ga-2 justify-end">
                            <v-icon
                                color="orange"
                                icon="mdi-pencil"
                                :key="item"
                                size="small"
                            ></v-icon>

                            <v-icon
                                color="red"
                                icon="mdi-delete"
                                size="small"
                            ></v-icon>
                        </div>
                    </template>
                </v-data-table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
