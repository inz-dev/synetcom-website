<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, router } from '@inertiajs/vue3';

  import { onMounted, ref, shallowRef, toRef } from 'vue'

  const currentYear = new Date().getFullYear()
const props=defineProps(
    {allDepartments:Array}
)
const createNewRecord=()=>useForm ({
      nom_departement: '',
    }
)

  const departements =[...props.allDepartments]
  const formModel = createNewRecord()
  const dialog = shallowRef(false)
  const isEditing = toRef(() => !!formModel.id_departement)

  const headers = [
    { id: 'N°', key: 'num', align: 'start' },
    { title: 'Titre', key: 'nom_departement', align: 'start' },
    { title: 'Actions', key: 'actions', align: 'end', sortable: false },
  ]

  onMounted(() => {
    console.log("props.allDepartments:",props.allDepartments)
     console.log("departments:",departements, departements[0])
    //departements.map(el=> console.log(el))
    reset()
  })

  function add () {
    formModel = createNewRecord()
    dialog.value = true
  }

  function edit (item) {

    const found = departements?
    departements.find(dept => dept.id_departement === item.id_departement):[]

if(found || found.length!=0){


    formModel = {
      id_departement: found.id_departement,
      nom_departement: found.nom_departement,
    }
    }

    dialog.value = true
  }

  function remove (item) {
    console.log('item from remove:', item);

    const index = departements.findIndex(dept => dept.id_departement === item.id_departement)
    departements.splice(index, 1)
  }

  function save () {
    console.log('formModel:',formModel);

    if (isEditing.value) {
      const index = departements.findIndex(dept =>dept.id_departement=== formModel.id_departement)
      const idUpdating= formModel.id_departement
      console.log('index from save:', index, idUpdating);
    /*   router.post(`/departement/${}`,{

      }) */
      departements[index] = formModel
      console.log(departements[index] );

    } else {
      formModel.id_departement = departements.length + 1
      departements.push(formModel)
    }

    dialog.value = false
  }

  function reset () {
    dialog.value = false
    formModel = createNewRecord()
    departements = [props.allDepartments]
  }
</script>


<template>
<AuthenticatedLayout>
<div class="container mb-2" id="cont">
  <div class="row gy-2 gy-xl-0 m-4">
 <v-sheet border rounded >
    <v-data-table
      :headers="headers"
      :hide-default-footer="departements.length < 3"
      :items="departements"
       fixed-header
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>
            <v-icon color="medium-emphasis" icon="mdi-book-multiple" size="x-small" start></v-icon>

            Départements
          </v-toolbar-title>

          <v-btn
            class="me-2"
            prepend-icon="mdi-plus"
            rounded="lg"
            text="Ajouter"
            border
            color="blue"
            @click="add"
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
          <v-icon color="orange"  icon="mdi-pencil" :key="item" size="small" @click="edit(item)"></v-icon>

          <v-icon color="red" icon="mdi-delete" size="small" @click="remove(item.id_departement)"></v-icon>
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
            <v-text-field v-model="formModel.nom_departement" label="Nom du département"></v-text-field>
          </v-col>
        </v-row>
      </template>

      <v-divider></v-divider>

      <v-card-actions class="bg-surface-light">
        <v-btn text="Annuler" variant="plain" @click="dialog = false"></v-btn>

        <v-spacer></v-spacer>

        <v-btn text="Enregistrer" @click="save"></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

 </div>
</div>

</AuthenticatedLayout>
</template>
<style>

</style>
