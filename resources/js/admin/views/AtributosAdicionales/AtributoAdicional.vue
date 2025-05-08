<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white">Atributos Adicionales</h3>
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
                        <th scope="col">Icono</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="atributos_adicionales.length">
                        <tr v-for="(atributo_adicional, index) in ListaAtributosAdicionales" :key="atributo_adicional.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ atributo_adicional.nombre }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="atributo_adicional.id" v-model="atributo_adicional.estado"
                                        @change="handleEnabledChange(atributo_adicional.id, atributo_adicional.estado)">
                                </div>
                            </td>
                            <td v-if="atributo_adicional.ruta_imagen">
                                <img :src="atributo_adicional.ruta_imagen" alt="Icono" class="icono-atributo-adicional"/>
                            </td>
                            <td v-else>
                            </td>
                            <td>
                                <button type="button" class="btn btn-base-dv" @click="openEditModal(atributo_adicional)"><i
                                        class="bi bi-pencil-square"></i> Editar</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay atributos adicionales.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearAtributoAdicionalModal ref="crearAtributoAdicionalModal" @atributo-adicional-updated="fetchAtributosAdicionales" />
        <EditarAtributoAdicionalModal ref="editarAtributoAdicionalModal" :atributo_adicional="selectedAtributoAdicional" @atributo-adicional-updated="fetchAtributosAdicionales" />

        <PaginacionComponent :paginaActual="paginaActual" :totalPaginas="totalPaginas" @cambiar-pagina="cambiarPagina"
            @cambiar-pagina-actual="cambiarPaginaActual" />
    </div>
</template>

<script>
import atributosAdicionalesMixin from '../../mixins/atributo_adicional/atributosAdicionalesMixin';
import CrearAtributoAdicionalModal from './CrearAtributoAdicionalModal.vue';
import EditarAtributoAdicionalModal from './EditarAtributoAdicionalModal.vue';
import LoadingComponent from '../../components/LoadingComponent.vue';
import PaginacionComponent from '../../components/PaginacionComponent.vue';

export default {
    mixins: [atributosAdicionalesMixin],
    components: {
        CrearAtributoAdicionalModal,
        EditarAtributoAdicionalModal,
        LoadingComponent,
        PaginacionComponent
    },
    data() {
        return {
            selectedAtributoAdicional: null,
            checkbox: [],
            paginaActual: 1,
            filasPorPagina: 10,
        };
    },
    computed: {
        totalPaginas() {
            return Math.ceil(this.atributos_adicionales.length / this.filasPorPagina);
        },
        ListaAtributosAdicionales() {
            const start = (this.paginaActual - 1) * this.filasPorPagina;
            const end = start + this.filasPorPagina;
            return this.atributos_adicionales.slice(start, end);
        }
    },
    methods: {
        openCrearModal() {
            this.$refs.crearAtributoAdicionalModal.open();
        },
        openEditModal(atributo_adicional) {
            if (atributo_adicional) {
                this.selectedAtributoAdicional = { ...atributo_adicional };
                this.$refs.editarAtributoAdicionalModal.open();
            }
        },
        async handleEnabledChange(atributo_adicional_id, estado) {
            const checkbox = { atributo_adicional_id: atributo_adicional_id, estado: estado };

            try {
                const response = await this.actualizarStatus(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('atributo-adicional-updated');
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
        this.fetchAtributosAdicionales();
    }
}
</script>

<style scoped></style>
