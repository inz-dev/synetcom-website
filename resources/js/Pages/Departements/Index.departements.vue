
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, router, usePage } from '@inertiajs/vue3';

  import { onMounted,watch, ref, shallowRef, toRef } from 'vue'
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


}

 const headersT = [
    { width: 50, title: 'N°', key: 'index', align: 'start', sortable: true },
   { width: 180, title: 'Département', key: 'nom_departement', sortable: true },
    { width: 200, title: 'Infos', key: 'description_departement' },
    { width: 80, key: 'data-table-expand' }, // optional, to keep it as short as possible
    { title: "Actions", key: "actions", align: "end", sortable: false },
  ]

  onMounted(() => {
    console.log("props.allDepartments:", props.allDepartments);
     console.log("departments:", departements)
    //departements.map(el=> console.log(el))
});
function rowClass(item, index){
    return index %2==0?'even-line':'odd-line'

}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container mb-2">
           <div class="row gy-2 gy-xl-0 mt-4">
           <v-data-table
    :headers="headersT"
    :items="departements"
    item-value="nom_departement"
                        fixed-header
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
    <template v-slot:item.data-table-expand="{ internalItem, isExpanded, toggleExpand }">
      <v-btn
        :append-icon="isExpanded(internalItem) ? 'mdi-chevron-up' : 'mdi-chevron-down'"
        :text="isExpanded(internalItem) ? 'Ses services' : 'Voir Services'"
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
              <tbody >
                <tr class="bg-secondary">
                <th>Numéro</th>
                  <th>Service</th>
                  <th>Description</th>

                </tr>
              </tbody>

              <tbody v-for="(service,i) in item.services">
                <tr :key="i">
                  <td class="py-2">{{ i+1 }} </td>
                      <td class="py-2">{{ service.nom_service }}</td>

                  <td class="py-2">{{ service.description_service }}</td>

                </tr>
              </tbody>
            </v-table>
          </v-sheet>
        </td>
      </tr>
    </template>
  </v-data-table>
           </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>


 .v-table tbody tr:hover{
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
