<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white">Categorias Secundarias</h3>
            <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i class="bi bi-plus-circle"></i>
                Agregar</button>
        </div>
        <LoadingComponent v-if="loading" />
        <div v-else class="table-responsive">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Bloque Pagina Inicio</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="categorias_secundarias.length">
                        <tr v-for="(categoria_secundaria, index) in categorias_secundarias"
                            :key="categoria_secundaria.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ categoria_secundaria.nombre }}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        :id="categoria_secundaria.id" v-model="categoria_secundaria.estado"
                                        @change="habilidarCategoria(categoria_secundaria.id, categoria_secundaria.estado ? true : false)"
                                        :disabled="categoria_secundaria.estado === false && cantidad_categorias_secundarias.length >= 2">
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-base-dv"
                                    @click="openEditModal(categoria_secundaria)"><i class="bi bi-pencil-square"></i>
                                    Editar</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay categorias secundarias.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <CrearCategoriaSecundariaModal ref="crearCategoriaSecundariaModal"
            @categoria-secundaria-updated="fetchCategoriasSecundarias" />
        <EditarCategoriaSecundariaModal ref="editarCategoriaSecundariaModal"
            :categoria_secundaria="selectedCategoriaSecundaria"
            @categoria-secundaria-updated="fetchCategoriasSecundarias" />
    </div>
</template> 

<script>
import categoriasSecundariasMixin from '../../mixins/categoria_secundaria/categoriasSecundariasMixin';
import CrearCategoriaSecundariaModal from './CrearCategoriaSecundariaModal.vue';
import EditarCategoriaSecundariaModal from './EditarCategoriaSecundariaModal.vue';
import LoadingComponent from '../../components/LoadingComponent.vue';

export default {
    mixins: [categoriasSecundariasMixin],
    components: {
        CrearCategoriaSecundariaModal,
        EditarCategoriaSecundariaModal,
        LoadingComponent
    },
    data() {
        return {
            selectedCategoriaSecundaria: null,
            checkbox: [],
            cantidad_categorias_secundarias: []
        };
    },
    watch: {
        categorias_secundarias: function () {
            this.cantidad_categorias_secundarias = [];
            this.categorias_secundarias.forEach(categoria_secundaria => {
                if (categoria_secundaria.estado === true) {
                    this.cantidad_categorias_secundarias.push(categoria_secundaria.id);
                }
            });
        },


        cantidad_categorias_secundarias: function (val) {
            if (val.length > 2) {
                this.$notyf.error('No se pueden habilitar más de 2 categorías secundarias a la vez.');
                this.cantidad_categorias_secundarias.pop();
            }
        }
    },
    methods: {
        openCrearModal() {
            this.$refs.crearCategoriaSecundariaModal.open();
        },
        openEditModal(categoria_secundaria) {
            if (categoria_secundaria) {
                this.selectedCategoriaSecundaria = { ...categoria_secundaria };
                this.$refs.editarCategoriaSecundariaModal.open();
            }
        },
        async habilidarCategoria(categoria_secundaria_id, estado) {
            const checkbox = { categoria_secundaria_id: categoria_secundaria_id, estado: estado };

            this.maximoCategoriasSecundarias(categoria_secundaria_id, estado);

            try {
                const response = await this.actualizarStatus(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                    this.$emit('categoria-secundaria-updated');
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }

        },

        maximoCategoriasSecundarias(categoria_secundaria_id, estado) {
            if (estado) {
                this.cantidad_categorias_secundarias.push(categoria_secundaria_id);
            } else {
                const index = this.cantidad_categorias_secundarias.indexOf(categoria_secundaria_id);
                if (index > -1) {
                    this.cantidad_categorias_secundarias.splice(index, 1);
                }
            }
        }

    },
    created() {
        this.fetchCategoriasSecundarias();
    }
}
</script>

<style scoped></style>
