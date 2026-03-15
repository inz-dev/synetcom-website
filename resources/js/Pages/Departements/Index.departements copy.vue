<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, router, usePage } from '@inertiajs/vue3';

  import { onMounted,watch, ref, shallowRef, toRef } from 'vue'

const currentYear = new Date().getFullYear()
const props=defineProps(
    {allDepartments:Array},
    {errors:Object}
)
const search = ref('');
const loading = ref(false);
watch(search, (newSearchTerm, oldSearchTerm) => {
  // Perform actions here, e.g., an API call (especially for server-side tables)
  console.log(`Search term changed from ${oldSearchTerm} to ${newSearchTerm}`);
  updateData()
});
const page = usePage()
const errors = page.props.errors
  const departements=[]
  if(props.allDepartments || props.allDepartments.length!=0)
{props.allDepartments.forEach((el, index)=>{
     if(el){
    /*console.log('el:', el); */
    departements.push({
        index:index+1,
        ...el
    })
    }
})}

function reset(){
    search.value=""
    //departements=[...props.allDepartments]
}
function updateData() {
      router.get("/departements", {
        preserveState: true,
        preverseScroll: true,
        onSuccess: () => {
          console.log("herre")
        },
      });
    }
const formModel =useForm ({
    id_departement:null,
      nom_departement: '',
    }
)
  const dialog = shallowRef(false)
  const isEditing = toRef(() => !!formModel.id_departement)

  const headers = ref([
    { title: 'N°', key: 'index', align: 'start' },
    { title: 'Titre', key: 'nom_departement', align: 'start' },
    { title: 'Actions', key: 'actions', align: 'end', sortable: false },
  ])
const addDepartements=(e)=>{
    e.preventDefault();
    dialog.value = true

}
let TErrors=[]
const add= (e)=>{
        console.log("ajout")
      formModel.post(route('departements.store'),{
        onSuccess:(e)=>{
            console.log('success:', e)
            dialog.value=false
            loading.value=true
        },
        onError:(e)=>{
            console.log('error:', e)
            TErrors.push(e)
        }

       })
       loading.value=false

    }
const save=(e)=>{
    e.preventDefault();
    if (isEditing.value){

    }

    /* if (errors) dialog.value = true */
    dialog.value = false

}

  onMounted(() => {
    console.log("props.allDepartments:",errors)
     //console.log("departments:",departements, departements[0])
    //departements.map(el=> console.log(el))

  })


</script>


<template>
<AuthenticatedLayout>
<div class="container mb-2" id="cont">
  <div class="row gy-2 gy-xl-0 m-4">
 <v-sheet border rounded >

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
      :hide-default-footer="departements.length < 3"
      :items="departements"
      :search="search"
      :loading="loading"
       fixed-header
       sort-asc-icon="mdi-sort-ascending"
    sort-desc-icon="mdi-sort-descending"
    sort-icon="mdi-swap-vertical"
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
<!-- <template v-slot:item.id="{ value }">

</template> -->
      <template v-slot:item.nom_departement="{ value }">
      <span>{{ value }}</span>


        <!-- <v-chip :text="value" border="thin opacity-25" prepend-icon="mdi-book" label>
          <template v-slot:prepend>
            <v-icon color="medium-emphasis"></v-icon>
          </template>
        </v-chip> -->
      </template>

      <template v-slot:item.actions="{ item }">
        <div class="d-flex ga-2 justify-end">
          <v-icon color="orange"  icon="mdi-pencil" :key="item" size="small" ></v-icon>

          <v-icon color="red" icon="mdi-delete" size="small" ></v-icon>
        </div>
      </template>

      <template v-slot:no-data>
        <v-btn
          prepend-icon="mdi-backup-restore"
          rounded="lg"
          text="Réinitialiser les données"
          variant="text"
          border
          @click="reset"

        ></v-btn>
      </template>
    </v-data-table>
  </v-sheet>

  <v-dialog v-model="dialog" max-width="500">
    <v-card
      :subtitle="`${isEditing ? 'Mise à jour d\'' : 'Création d\''} un département`"
      :title="`${isEditing ? 'Modifier' : 'Ajouter'} un département`"
    >
      <template v-slot:text>
        <v-row>
          <v-col cols="12">
            <v-text-field v-model="formModel.nom_departement"

            aria-required="true"
            :error-messages="formModel.errors.nom_departement"
            >
            <template v-slot:label>
        Nom du département<span class="text-red-500">&nbsp;*</span>
      </template>
            </v-text-field>
                      <span v-if="formModel.errors.nom_departement">{{ formModel.errors.nom_departement }}</span>
          </v-col>

        </v-row>
      </template>

      <v-divider></v-divider>

      <v-card-actions class="bg-surface-light">
        <v-btn text="Annuler" variant="plain" @click="dialog = false"></v-btn>

        <v-spacer></v-spacer>

        <v-btn text="Enregistrer" :loading="formModel.processing" @click="add" ></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

 </div>
</div>

</AuthenticatedLayout>
</template>
<style>
.text-red-500 {
  font-size: 1.2em;
  margin-left: 2px;
   color: #ef4444;
}

</style>
