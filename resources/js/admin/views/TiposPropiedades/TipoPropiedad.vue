<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white">Tipos Propiedades</h3>
            <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i class="bi bi-plus-circle"></i>
                Agregar</button>
        </div>
        <LoadingComponent v-if="loading"/>
        <div v-else class="table-responsive">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Habilitar</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="tipos_propiedades.length">
                        <tr v-for="(tipo_propiedad, index) in tipos_propiedades" :key="tipo_propiedad.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ tipo_propiedad.nombre }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="tipo_propiedad.id" v-model="tipo_propiedad.estado"
                                        @change="handleEnabledChange(tipo_propiedad.id, tipo_propiedad.estado)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-base-dv" @click="openEditModal(tipo_propiedad)"><i
                                        class="bi bi-pencil-square"></i> Editar</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay tipos propiedades.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearTipoPropiedadModal ref="crearTipoPropiedadModal" @tipo-propiedad-updated="fetchTiposPropiedades" />
        <EditarTipoPropiedadModal ref="editarTipoPropiedadModal" :tipo_propiedad="selectedTipoPropiedad" @tipo-propiedad-updated="fetchTiposPropiedades" />
    </div>
</template>

<script>
import tiposPropiedadesMixin from '../../mixins/tipo_propiedad/tiposPropiedadesMixin';
import CrearTipoPropiedadModal from './CrearTipoPropiedadModal.vue';
import EditarTipoPropiedadModal from './EditarTipoPropiedadModal.vue';
import LoadingComponent from '../../components/LoadingComponent.vue';

export default {
    mixins: [tiposPropiedadesMixin],
    components: {
        CrearTipoPropiedadModal,
        EditarTipoPropiedadModal,
        LoadingComponent
    },
    data() {
        return {
            selectedTipoPropiedad: null,
            checkbox: []
        };
    },
    methods: {
        openCrearModal() {
            this.$refs.crearTipoPropiedadModal.open();
        },
        openEditModal(tipo_propiedad) {
            if (tipo_propiedad) {
                this.selectedTipoPropiedad = { ...tipo_propiedad };
                this.$refs.editarTipoPropiedadModal.open();
            }
        },
        async handleEnabledChange(tipo_propiedad_id, estado) {
            const checkboxStatus = estado ? 1 : 0;
            const checkbox = { tipo_propiedad_id: tipo_propiedad_id, estado: checkboxStatus };

            try {
                const response = await this.actualizarStatus(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('tipo-propiedad-updated');
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        }

    },
    created() {
        this.fetchTiposPropiedades();
    }
}
</script>

<style scoped></style>
