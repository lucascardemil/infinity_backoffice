<template>
    <div class="container pt-5 pb-5">
        <div class="row justify-content-center pb-5">
            <div class="col-auto">
                <p class="text-center texto-titulo">PROPIEDADES</p>
                <h2>Recomendado para ti</h2>
            </div>
        </div>

        <ul class="nav nav-pills nav-fill flex-column flex-sm-row mb-5">
            <li class="nav-item">
                <button class="nav-link texto-subtitulo" :class="{ 'texto-subtitulo-active': marcarBotonActivo === 0 }"
                    @click="mostrarTodasPropiedades()">Ver Todas</button>
            </li>
            <template v-for="tipo_propiedad in tipos_propiedades">
                <li class="nav-item">
                    <button class="nav-link texto-subtitulo"
                        :class="{ 'texto-subtitulo-active': marcarBotonActivo === tipo_propiedad.id }"
                        @click="mostrarPorTipoPropiedad(tipo_propiedad.id)">{{
                            tipo_propiedad.nombre }}</button>
                </li>
            </template>
        </ul>

        <div class="row">
            <div
                class="col-lg-4 col-md-12"
                v-for="(propiedad, idx) in obtenerPropiedadesPorTipo.slice(0, propiedadesMostradas)"
                :key="propiedad.id"
            >
                <CardPropiedades :propiedad="propiedad"></CardPropiedades>
            </div>
        </div>
        <div class="row" v-if="obtenerPropiedadesPorTipo.length > propiedadesMostradas">
            <div class="col-12 text-center mt-3">
                <button class="btn btn-base-dv" @click="verMasPropiedades">
                    Ver más propiedades
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import CardPropiedades from '../CardPropiedades/CardPropiedades.vue';
import { formatoMiles } from '../../utils/formatoMiles';

export default {
    props: {
        propiedades: {
            type: Array,
            required: true,
        },
    },
    components: {
        CardPropiedades
    },
    data() {
        return {
            tipos_propiedades: [],
            obtenerPropiedadesPorTipo: [],
            marcarBotonActivo: null,
            propiedadesMostradas: 3, // Mostrar solo 3 al inicio
        };
    },
    watch: {
        propiedades: {
            immediate: true,
            handler(propiedades) {
                if (!propiedades || propiedades.length === 0) {
                    return;
                }
                propiedades.forEach(propiedad => {
                    propiedad.valor_pesos = formatoMiles(propiedad.valor_pesos);
                });
                this.obtenerTipoPropiedades(propiedades);
                this.mostrarTodasPropiedades();
            },
        },
    },
    methods: {
        obtenerTipoPropiedades(propiedades) {
            const tiposUnicos = [];
            propiedades.forEach((propiedad) => {
                if (!tiposUnicos.some(tipo => tipo.id === propiedad.tipo_propiedad.id)) {
                    tiposUnicos.push(propiedad.tipo_propiedad);
                }
            });
            this.tipos_propiedades = tiposUnicos;
        },

        mostrarTodasPropiedades() {
            this.marcarBotonActivo = 0;
            this.obtenerPropiedadesPorTipo = this.propiedades;
            this.propiedadesMostradas = 3; // Reinicia el contador al cambiar filtro
        },

        mostrarPorTipoPropiedad(id) {
            this.marcarBotonActivo = id;
            this.obtenerPropiedadesPorTipo = this.propiedades.filter(
                propiedad => propiedad.tipo_propiedad.id === id
            );
            this.propiedadesMostradas = 3; // Reinicia el contador al cambiar filtro
        },

        verMasPropiedades() {
            this.propiedadesMostradas += 3;
        }
    }
}
</script>