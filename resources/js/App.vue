<template>
    <div class="container">

        <h1>Aliens CRUD Vue & Laravel</h1>

        <h3>Insertar alien</h3>

        <form @submit.prevent="guardarAlien">

            <input
                v-model="form.name"
                placeholder="Nombre"
            />

            <br><br>

            <input
                v-model="form.planet"
                placeholder="Planeta"
            />

            <br><br>

            <input
                v-model="form.age"
                type="number"
                placeholder="Edad"
            />

            <br><br>

            <button type="submit">
                {{ editingId ? 'Actualizar' : 'Guardar' }}
            </button>

        </form>

        <hr>

        <h3>Lista de aliens</h3>

        <table border="1" cellpadding="10">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Planeta</th>
                    <th>Edad</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                <tr
                    v-for="alien in aliens"
                    :key="alien.id"
                >
                    <td>{{ alien.id }}</td>
                    <td>{{ alien.name }}</td>
                    <td>{{ alien.planet }}</td>
                    <td>{{ alien.age }}</td>
                    <td style="white-space: nowrap;">
                        <button class="btn-edit" @click="editarAlien(alien)">
                            Editar
                        </button>
                        <button class="btn-delete" @click="eliminarAlien(alien.id)">
                            Eliminar
                        </button>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>
</template>

<script setup>

import { ref, onMounted } from 'vue'
import axios from 'axios'

const aliens = ref([])

const editingId = ref(null)

const form = ref({
    name: '',
    planet: '',
    age: ''
})

const cargarAliens = async () => {

    const response = await axios.get('/api/aliens')

    aliens.value = response.data
}

const guardarAlien = async () => {

    if (editingId.value) {

        await axios.put(
            `/api/aliens/${editingId.value}`,
            form.value
        )

        editingId.value = null

    } else {

        await axios.post(
            '/api/aliens',
            form.value
        )
    }

    form.value = {
        name: '',
        planet: '',
        age: ''
    }

    cargarAliens()
}

const editarAlien = (alien) => {

    editingId.value = alien.id

    form.value = {
        name: alien.name,
        planet: alien.planet,
        age: alien.age
    }
}

const eliminarAlien = async (id) => {

    await axios.delete(`/api/aliens/${id}`)

    cargarAliens()
}

onMounted(() => {
    cargarAliens()
})

</script>