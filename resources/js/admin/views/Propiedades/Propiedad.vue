<template>
    <div>
        <div class="row justify-content-between mb-3">
            <div class="col-lg-10 col-md-12">
                <h3 class="text-white mb-3" v-if="activeTab === 'crear'">Crear Propiedad</h3>
                <h3 class="text-white mb-3" v-else-if="activeTab === 'administrar'">Administrar Propiedades</h3>
            </div>
            <div class="col-lg-2 col-md-12">
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-base-dv" v-if="activeTab === 'crear'"
                        @click.prevent="activeTab = 'administrar'">
                        <i class="bi bi-arrow-left"></i> Administrar Propiedades
                    </button>
                    <button type="button" class="btn btn-base-dv" v-if="activeTab === 'administrar'"
                        @click.prevent="activeTab = 'crear'">
                        <i class="bi bi-plus-circle"></i> Crear Propiedad
                    </button>
                </div>
            </div>
        </div>

        <div v-if="activeTab === 'crear'">
            <CrearPropiedad v-bind="sharedProps" @crear-propiedad="volverAdministracionPropiedad" />
        </div>
        <div v-else-if="activeTab === 'administrar'">
            <AdministracionPropiedad v-bind="sharedProps" @imagenes-eliminadas-administracion="fetchAllPropiedades"
                @eliminar-propiedad-administracion="fetchAllPropiedades" />
        </div>
    </div>
</template>

<script>
import CrearPropiedad from './CrearPropiedad.vue';
import AdministracionPropiedad from './AdministracionPropiedad.vue';

import tiposPropiedadesMixin from '../../mixins/tipo_propiedad/tiposPropiedadesMixin';
import formatosNegociosMixin from '../../mixins/formato_negocio/formatosNegociosMixin';
import ubicacionesMixin from '../../mixins/ubicacion/ubicacionesMixin';
import categoriasSecundariasMixin from '../../mixins/categoria_secundaria/categoriasSecundariasMixin';
import atributosAdicionalesMixin from '../../mixins/atributo_adicional/atributosAdicionalesMixin';
import propiedadMixin from '../../mixins/propiedad/servicesPropiedadMixin';

export default {
    mixins: [tiposPropiedadesMixin, formatosNegociosMixin, ubicacionesMixin, categoriasSecundariasMixin, atributosAdicionalesMixin, propiedadMixin],
    components: {
        CrearPropiedad,
        AdministracionPropiedad
    },
    data() {
        return {
            activeTab: 'administrar',
        };
    },
    computed: {
        sharedProps() {
            return {
                tipos_propiedades: this.tipos_propiedades,
                formatos_negocios: this.formatos_negocios,
                ubicaciones: this.ubicaciones,
                categorias_secundarias: this.categorias_secundarias,
                atributos_adicionales: this.atributos_adicionales,
                loading_propiedades: this.loading_propiedades,
                propiedades: this.propiedades,
                errors: this.errors,
                botones: this.botones
            };
        }
    },
    methods: {
        volverAdministracionPropiedad() {
            this.activeTab = 'administrar';
            this.fetchAllPropiedades();
        }
    },
    created() {
        this.fetchTiposPropiedadesSelect();
        this.fetchFormatosNegociosSelect();
        this.fetchUbicacionesSelect();
        this.fetchCategoriasSecundariasSelect();
        this.fetchAtributosAdicionalesSelect();
        this.fetchAllPropiedades();
    },
}
</script>
