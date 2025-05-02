<template>
    <div>
        <LoadingComponent v-if="loading_propiedades" />
        <div v-else class="table-responsive">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Propiedad</th>
                        <th scope="col">Vendidas</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="propiedades.length">
                        <tr v-for="(propiedad, index) in propiedades" :key="propiedad.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ propiedad.titulo }}</td>
                            <td>
                                <h5 class="mb-0">
                                    <span v-if="propiedad.estado === 'disponible'"
                                        class="badge rounded-pill bg-primary">Disponible</span>
                                    <span v-if="propiedad.estado === 'no_disponible'"
                                        class="badge rounded-pill bg-secondary">No Disponible</span>
                                    <span v-if="propiedad.estado === 'vendida'"
                                        class="badge rounded-pill bg-success">Vendida</span>
                                </h5>
                            </td>
                            <td>
                                <button v-if="botones.ver" type="button" class="btn btn-secondary" @click="openVerPropiedad(propiedad)">
                                    <i class="bi bi-eye-fill"></i> Ver
                                </button>
                                <button v-if="botones.editar" type="button" class="btn btn-base-dv" @click="openEditModal(propiedad)">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </button>
                                <button v-if="botones.eliminar" type="button" class="btn btn-danger" @click="openEliminarModal(propiedad)">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>

                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay propiedades.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>
        <EditarPropiedad ref="editarPropiedadModal" :propiedad_editar="selectedPropiedad"
            :tipos_propiedades="tipos_propiedades" :formatos_negocios="formatos_negocios" :ubicaciones="ubicaciones"
            :categorias_secundarias="categorias_secundarias" :atributos_adicionales="atributos_adicionales"
            @imagenes-eliminadas-editar="imagenesEliminadasEditar" />
        
        <EliminarPropiedad ref="eliminarPropiedadModal" 
            :propiedad_eliminar="selectedPropiedad"
            @eliminar-propiedad="eliminarPropiedad" />
    </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue';
import EditarPropiedad from './EditarPropiedad.vue';
import EliminarPropiedad from './EliminarPropiedad.vue';

export default {
    props: {
        tipos_propiedades: Array,
        formatos_negocios: Array,
        ubicaciones: Array,
        categorias_secundarias: Array,
        atributos_adicionales: Array,
        loading_propiedades: Boolean,
        propiedades: Array,
        errors: Array,
        botones: Object
    },
    components: {
        LoadingComponent,
        EditarPropiedad, 
        EliminarPropiedad
    },
    data() {
        return {
            selectedPropiedad: null,
        };
    },
    methods: {
        openVerPropiedad(propiedad) {
            if (propiedad) {
            if (propiedad.estado === 'no_disponible') {
                this.$notyf.error('Debe dejar la propiedad disponible para poder verla.');
                return;
            }
            const url = `/propiedad/${propiedad.titulo.toLowerCase().replace(/\s+/g, '-')}`;
            window.open(url, '_blank');
            }
        },
        openEditModal(propiedad) {
            if (propiedad) {
                this.selectedPropiedad = { ...propiedad };
                this.$refs.editarPropiedadModal.open();
            }
        },
        openEliminarModal(propiedad) {
            if (propiedad) {
                this.selectedPropiedad = { ...propiedad };
                this.$refs.eliminarPropiedadModal.open();
            }
        },
        imagenesEliminadasEditar() {
            this.$emit('imagenes-eliminadas-administracion');
        },
        eliminarPropiedad() {
            this.$emit('eliminar-propiedad-administracion');
        }
    },
}
</script>
