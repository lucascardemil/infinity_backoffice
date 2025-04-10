<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white">Regiones y Ciudades</h3>
            <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i class="bi bi-plus-circle"></i>
                Agregar</button>
        </div>
        <LoadingComponent v-if="loading"/>
        <div v-else class="table-responsive">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Region</th>
                        <th scope="col">Ciudad</th>
                        <th scope="col">Habilitar</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="ubicaciones.length">
                        <tr v-for="(ubicacion, index) in ubicaciones" :key="ubicacion.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ ubicacion.region }}</td>
                            <td>{{ ubicacion.ciudad }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="ubicacion.id" v-model="ubicacion.estado"
                                        @change="handleEnabledChange(ubicacion.id, ubicacion.estado)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-base-dv" @click="openEditModal(ubicacion)"><i
                                        class="bi bi-pencil-square"></i> Editar</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay regiones y ciudades.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearUbicacionModal ref="crearUbicacionModal" @ubicacion-updated="fetchUbicaciones" />
        <EditarUbicacionModal ref="editarUbicacionModal" :ubicacion_props="selectedUbicacion" @ubicacion-updated="fetchUbicaciones" />
    </div>
</template>

<script>
import ubicacionesMixin from '../../mixins/ubicacion/ubicacionesMixin';
import CrearUbicacionModal from './CrearUbicacionModal.vue';
import EditarUbicacionModal from './EditarUbicacionModal.vue';
import LoadingComponent from '../../components/LoadingComponent.vue';

export default {
    mixins: [ubicacionesMixin],
    components: {
        CrearUbicacionModal,
        EditarUbicacionModal,
        LoadingComponent
    },
    data() {
        return {
            selectedUbicacion: null,
            checkbox: []
        };
    },
    methods: {
        openCrearModal() {
            this.$refs.crearUbicacionModal.open();
        },
        openEditModal(ubicacion) {
            if (ubicacion) {
                this.selectedUbicacion = { ...ubicacion };
                this.$refs.editarUbicacionModal.open();
            }
        },
        async handleEnabledChange(ubicacion_id, estado) {
            const checkboxStatus = estado ? 1 : 0;
            const checkbox = { ubicacion_id: ubicacion_id, estado: checkboxStatus };
            try {
                const response = await this.actualizarStatus(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('ubicacion-updated');
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        }

    },
    created() {
        this.fetchUbicaciones();
    }
}
</script>

<style scoped></style>
