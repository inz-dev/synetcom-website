<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm, router, usePage,Head } from "@inertiajs/vue3";


import { onMounted, watch, ref, shallowRef, toRef } from "vue";
const props = defineProps({ allDepartments: Array }, { errors: Object });
const departements = [];
if (props.allDepartments || props.allDepartments.length != 0) {
    props.allDepartments.forEach((element, index) => {
        /* console.log("element:", element) */
        departements.push({
            index: index + 1,
            ...element,
        });
    });
}

const headers = [
    { width: 50, title: "N°", key: "index", align: "start", sortable: true },
    {
        width: 180,
        title: "Département",
        key: "nom_departement",
        sortable: true,
    },
    { width: 200, title: "Infos", key: "description_departement" },
    { width: 80, key: "data-table-expand" }, // optional, to keep it as short as possible
    { title: "Actions", key: "actions", align: "end", sortable: false },
];
function updateData() {
      router.get("/departements", {
        preserveState: true,
        /* preverseScroll: true, */
        onSuccess: () => {
          console.log("herre")
        },
      });
    }
const formModel =useForm ({
    id_departement:null,
      nom_departement: '',
      description_departement:""
    }
)
const search = ref('');
let params;
  const dialog = shallowRef(false)
  const isEditing = toRef(() => !!formModel.id_departement)
onMounted(() => {
    console.log("props.allDepartments:", props.allDepartments);
    console.log("departments:", departements);
    //departements.map(el=> console.log(el))
});
watch(search,(newSearchTerm, oldSearchTerm)  => {
    console.log('search:', search,newSearchTerm, oldSearchTerm)
    search:()=>{params.search=val}
 /*  updateData() */
})
const addDepartements=(e)=>{
    e.preventDefault();
    dialog.value = true

}
let TErrors=[]
const saveDept= (e)=>{
        console.log("ajout:", formModel)
      formModel.post(route('departements.store'),{
        onSuccess:(e)=>{
            console.log('success:', e)

        },
        onError:(e)=>{
            console.log('error:', e)
            TErrors.push(e)
        }

       })
       dialog.value=false
    }
</script>

<template>
          <Head title="Départements"/>

    <AuthenticatedLayout>
        <div class="container mb-2">
            <div class="row gy-2 gy-xl-0 mt-4">
            <v-sheet border rounded class="mb-4">
            <v-text-field v-model="search"
 prepend-inner-icon="mdi-magnify"
        label="Recherche"
        single-line
      variant="outlined"
      color="secondary"
        clearable
        hide-details
        class="py-4"
        solo
        style="max-width: 300px" />
                <v-data-table
                    :headers="headers"
                    :search="search"
                    :items="departements"
                    item-value="nom_departement"
                    fixed-header
                    height="450"
                   :hide-default-footer="departements.length < 11"
                    sort-asc-icon="mdi-sort-ascending"
                    sort-desc-icon="mdi-sort-descending"
                    sort-icon="mdi-swap-vertical"
                    show-expand
                >
                    <template v-slot:top>
                        <v-toolbar flat class="mt-4 bg-primary">
                            <v-toolbar-title color="white">
                                <v-icon
                                    color="primary"
                                    icon="mdi-book-multiple"
                                    size="x-small"
                                    start
                                ></v-icon>
                                <span style="color: white">Départements</span>
                            </v-toolbar-title>

                            <v-btn
                                class="me-2 bg-white"
                                prepend-icon="mdi-plus"
                                rounded="lg"
                                text="Ajouter"
                                border
                                color="primary"
                                @click="addDepartements"
                            ></v-btn>
                        </v-toolbar>
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
                    <template
                        v-slot:item.data-table-expand="{
                            internalItem,
                            isExpanded,
                            toggleExpand,
                        }"
                    >
                        <v-btn
                            :append-icon="
                                isExpanded(internalItem)
                                    ? 'mdi-chevron-up'
                                    : 'mdi-chevron-down'
                            "
                            :text="
                                isExpanded(internalItem)
                                    ? 'Ses services'
                                    : 'Voir Services'
                            "
                            class="text-none"
                            size="small"
                            variant="text"
                            width="150"
                            border
                            slim
                            @click="toggleExpand(internalItem)"
                        ></v-btn>
                    </template>

                    <template v-slot:expanded-row="{ columns, item }">
                        <tr>
                            <td :colspan="columns.length" class="py-2">
                                <v-sheet rounded="lg" border>
                                    <v-table density="compact">
                                        <tbody>
                                            <tr class="bg-secondary">
                                                <th>Numéro</th>
                                                <th>Service</th>
                                                <th>Description</th>
                                            </tr>
                                        </tbody>

                                        <tbody
                                            v-for="(
                                                service, i
                                            ) in item.services"
                                        >
                                            <tr :key="i">
                                                <td class="py-2">
                                                    {{ i + 1 }}
                                                </td>
                                                <td class="py-2">
                                                    {{ service.nom_service }}
                                                </td>

                                                <td class="py-2">
                                                    {{
                                                        service.description_service
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </v-table>
                                </v-sheet>
                            </td>
                        </tr>
                    </template>
                </v-data-table>
                </v-sheet>
            </div>

              <v-dialog v-model="dialog" max-width="500">
    <v-card

      :title="`${isEditing ? 'Modifier' : 'Ajouter'} un département`"
    >
      <template v-slot:text>
        <v-row>
          <v-col cols="12">
            <v-text-field v-model="formModel.nom_departement" variant="outlined" label="Département" required color="primary"></v-text-field>
          </v-col>

          <v-col cols="12">
            <v-textarea v-model="formModel.description_departement" variant="outlined" label="Description" color="primary"></v-textarea>
          </v-col>
        </v-row>
      </template>

      <v-divider></v-divider>

      <v-card-actions >
        <v-btn text="Annuler" variant="plain" @click="dialog = false"></v-btn>

        <v-spacer></v-spacer>

        <v-btn text="Valider" @click="saveDept"></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

        </div>
    </AuthenticatedLayout>
</template>

<style>
.v-table tbody tr:hover {
    color: var(--primary-color);
    cursor: pointer;
}
.v-table tbody tr:nth-child(even) {
    background-color: #a9a9a9;
    /*  border: 2px solid #000; */
}

.v-table tbody tr:nth-child(odd) {
    background-color: lightgray;
    /*  border: 2px solid #000; */
}
</style>
