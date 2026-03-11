<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import { onMounted,watch, ref, shallowRef, toRef } from 'vue'
const props=defineProps(
    {allDepartments:Array},
    {errors:Object}
)
let newSet= new Set();
let uniqueDepts
const departements=[]
  if(props.allDepartments || props.allDepartments.length!=0)
{
      props.allDepartments.forEach((element,index) => {
/* console.log("element:", element) */
departements.push({
    index:index+1,
    ...element})
      })
    uniqueDepts =props.allDepartments.filter(({ id_departement }) => !newSet.has(id_departement) && newSet.add(id_departement));
}

//const plainArray=uniqueDepts.map(obj =>({ obj }) )

const plainArray = uniqueDepts.map((proxy,index) => {
   /*  console.log('index:', index)
    console.log('proxy:', proxy) */
  return {
    index:index+1,
    id_dept: proxy.id_departement,
    nom_dept: proxy.nom_departement
  };
});
console.log('plainArray:', departements)
const headersT = [
    { title: "N° Service", key: "index" },
    { title: "Service", sortable: false, key: "nom_service" },
    { title: "Description", key: "description_service", align: "end" },


];
const groupByT = [{ key: "departements.nom_departement", order: "asc" }];

const groupBy = [{ key: "type", order: "asc" }];

const headers = [
    { title: "Tool Name", sortable: false, key: "name" },
    { title: "Weight(kg)", key: "weight", align: "end" },
    { title: "Length(cm)", key: "length", align: "end" },
    { title: "Price($)", key: "price", align: "end" },
];
const search = ref('');
const tools = [
    { name: "Hammer", weight: 0.5, length: 30, price: 10, type: "hand" },
    { name: "Screwdriver", weight: 0.2, length: 20, price: 5, type: "hand" },
    { name: "Drill", weight: 1.5, length: 25, price: 50, type: "power" },
    { name: "Saw", weight: 0.7, length: 50, price: 15, type: "hand" },
    {
        name: "Tape Measure",
        weight: 0.3,
        length: 10,
        price: 8,
        type: "measuring",
    },
    { name: "Level", weight: 0.4, length: 60, price: 12, type: "measuring" },
    { name: "Wrench", weight: 0.6, length: 25, price: 10, type: "hand" },
    { name: "Pliers", weight: 0.3, length: 15, price: 7, type: "hand" },
    { name: "Sander", weight: 2.0, length: 30, price: 60, type: "power" },
    {
        name: "Multimeter",
        weight: 0.5,
        length: 15,
        price: 30,
        type: "measuring",
    },
];

  onMounted(() => {
     console.log("props.allDepartments:",props.allDepartments)
 /* console.log("departments:", departements) */
    //departements.map(el=> console.log(el))

  })
</script>

<template>
    <AuthenticatedLayout>
        <div class="container mb-2">
            <div class="row gy-2 gy-xl-0 m-4">
            <v-text-field v-model="search"  prepend-inner-icon="mdi-magnify"
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
                    :group-by="groupByT"
                    :headers="headersT"
                    :items="departements"
                    :items-per-page="-1"
                    item-value="nom_service"
                    hide-default-footer
                >
                 <template v-slot:top>

        <v-toolbar flat>

          <v-toolbar-title color="primary">
            <v-icon color="primary" icon="mdi-book-multiple" size="x-small" start></v-icon>
<span style="color:#1B449C">Départements</span>

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
                    {{ console.log('columns:',item) }}
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
                            >

                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
