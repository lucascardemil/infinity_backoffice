<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white">Formatos Negocios</h3>
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
                    <template v-if="formatos_negocios.length">
                        <tr v-for="(formato_negocio, index) in ListaFormatosNegocios" :key="formato_negocio.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ formato_negocio.nombre }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="formato_negocio.id" v-model="formato_negocio.estado"
                                        @change="handleEnabledChange(formato_negocio.id, formato_negocio.estado)">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-base-dv" @click="openEditModal(formato_negocio)"><i
                                        class="bi bi-pencil-square"></i> Editar</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay formatos de negocios.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearFormatoNegocioModal ref="crearFormatoNegocioModal" @formato-negocio-updated="fetchFormatosNegocios" />
        <EditarFormatoNegocioModal ref="editarFormatoNegocioModal" :formato_negocio="selectedFormatoNegocio" @formato-negocio-updated="fetchFormatosNegocios" />

        <PaginacionComponent :paginaActual="paginaActual" :totalPaginas="totalPaginas" @cambiar-pagina="cambiarPagina"
            @cambiar-pagina-actual="cambiarPaginaActual" />
    </div>
</template>

<script>
import formatosNegociosMixin from '../../mixins/formato_negocio/formatosNegociosMixin';
import CrearFormatoNegocioModal from './CrearFormatoNegocioModal.vue';
import EditarFormatoNegocioModal from './EditarFormatoNegocioModal.vue';
import LoadingComponent from '../../components/LoadingComponent.vue';
import PaginacionComponent from '../../components/PaginacionComponent.vue';

export default {
    mixins: [formatosNegociosMixin],
    components: {
        CrearFormatoNegocioModal,
        EditarFormatoNegocioModal,
        LoadingComponent,
        PaginacionComponent
    },
    data() {
        return {
            selectedFormatoNegocio: null,
            checkbox: [],
            paginaActual: 1,
            filasPorPagina: 10,
        };
    },
    computed: {
        totalPaginas() {
            return Math.ceil(this.formatos_negocios.length / this.filasPorPagina);
        },
        ListaFormatosNegocios() {
            const start = (this.paginaActual - 1) * this.filasPorPagina;
            const end = start + this.filasPorPagina;
            return this.formatos_negocios.slice(start, end);
        }
    },
    methods: {
        openCrearModal() {
            this.$refs.crearFormatoNegocioModal.open();
        },
        openEditModal(formato_negocio) {
            if (formato_negocio) {
                this.selectedFormatoNegocio = { ...formato_negocio };
                this.$refs.editarFormatoNegocioModal.open();
            }
        },
        async handleEnabledChange(formato_negocio_id, estado) {
            const checkboxStatus = estado ? 1 : 0;
            const checkbox = { formato_negocio_id: formato_negocio_id, estado: checkboxStatus };

            try {
                const response = await this.actualizarStatus(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('formato-negocio-updated');
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        },
        cambiarPaginaActual(newPage) {
            this.paginaActual = newPage;
        },
        cambiarPagina(newPage) {
            this.paginaActual = newPage;
        },

    },
    created() {
        this.fetchFormatosNegocios();
    }
}
</script>

<style scoped></style>
