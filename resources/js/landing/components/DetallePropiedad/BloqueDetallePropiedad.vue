<template>
    <div class="pb-5">
        <div class="container">
            <div class="row align-items-end justify-content-between pb-4">
                <div class="col-auto">
                    <div class="d-flex gap-2 mb-4">
                        <!-- <span class="badge bg-success text-white">{{ propiedad.tipo_propiedad.nombre }}</span> -->
                        <span class="badge bg-danger text-white">{{ propiedad.formato_negocio.nombre }}</span>
                    </div>
                    <h1 class="mb-0">{{ propiedad.titulo }}</h1>
                </div>
                <div class="col-auto mt-4">
                    <h1 class="mb-0">{{ propiedad.tipo_valor }} {{ propiedad.valor_pesos }}</h1>
                </div>
            </div>
            <hr>

            <div class="row justify-content-between pt-4">
                <div class="col-lg-8 col-md-12">
                    <div class="d-flex gap-2 mb-5">
                        <h5><i class="bi bi-calendar-check texto-titulo"></i> <span class="texto-titulo-weight">{{
                            formatDate(propiedad.created_at) }}</span></h5>
                        <h5><i class="bi bi-geo-alt texto-titulo"></i> <span class="texto-titulo-weight">{{
                            propiedad.ubicacion.region }}, {{ propiedad.ubicacion.ciudad }}</span></h5>
                    </div>

                    <div class="my-5">
                        <h4 class="fw-bolder">Descripción</h4>
                        <p class="text-muted fs-5">{{ propiedad.descripcion }}</p>
                    </div>
                    <hr>

                    <div class="my-5">
                        <h4 class="fw-bolder">Características</h4>
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 align-items-center">
                            <div class="col mt-3 position-relative align-items-center">
                                <div class="d-flex position-relative align-items-center gap-3">
                                    <div>
                                        <button type="button" class="btn btn-base-dv p-2">
                                            <img src="/images/pisos.svg" alt="Icono" class="flex-shrink-0" width="28px"
                                                height="28px">
                                        </button>
                                    </div>
                                    <div class="lh-sm">
                                        <p class="mb-0 fs-5 text-muted">Pisos:</p>
                                        <p class="mb-0 fs-5 fw-bold">{{ propiedad.pisos }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col mt-3 position-relative align-items-center">
                                <div class="d-flex position-relative align-items-center gap-3">
                                    <div>
                                        <button type="button" class="btn btn-base-dv p-2">
                                            <img src="/images/dormitorios.svg" alt="Icono" class="flex-shrink-0"
                                                width="28px" height="28px">
                                        </button>
                                    </div>
                                    <div class="lh-sm">
                                        <p class="mb-0 fs-5 text-muted">Dormitorios:</p>
                                        <p class="mb-0 fs-5 fw-bold">{{ propiedad.dormitorios }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col mt-3 position-relative align-items-center">
                                <div class="d-flex position-relative align-items-center gap-3">
                                    <div>
                                        <button type="button" class="btn btn-base-dv p-2">
                                            <img src="/images/banos.svg" alt="Icono" class="flex-shrink-0" width="28px"
                                                height="28px">
                                        </button>
                                    </div>
                                    <div class="lh-sm">
                                        <p class="mb-0 fs-5 text-muted">Baños:</p>
                                        <p class="mb-0 fs-5 fw-bold">{{ propiedad.banos }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col mt-3 position-relative align-items-center">
                                <div class="d-flex position-relative align-items-center gap-3">
                                    <button type="button" class="btn btn-base-dv p-2">
                                        <img src="/images/construidos.svg" class="flex-shrink-0" alt="..." width="28px"
                                            height="28px">
                                    </button>
                                    <div>
                                        <h5 class="m-0 fs-5 text-muted">Construidos m2:</h5>
                                        <p class="mb-0 fs-5 fw-bold">{{ propiedad.m2_construido }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col mt-3 position-relative align-items-center">
                                <div class="d-flex position-relative align-items-center gap-3">
                                    <button type="button" class="btn btn-base-dv p-2">
                                        <img src="/images/superficie.svg" class="flex-shrink-0" alt="..." width="28px"
                                            height="28px">
                                    </button>
                                    <div>
                                        <h5 class="m-0 fs-5 text-muted">Superficie m2:</h5>
                                        <p class="mb-0 fs-5 fw-bold">{{ propiedad.m2_superficie }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="my-5">
                        <h4 class="fw-bolder">Servicios</h4>
                        <ul class="d-flex flex-wrap gap-3 p-0">
                            <template v-for="atributo_adicional in atributos_adicionales">
                                <li class="d-flex align-items-center gap-2">
                                    <img :src="atributo_adicional.ruta_imagen" alt="Icono" class="img-fluid"
                                        width="28px" height="28px" style="filter: brightness(0.8);">

                                    <span class="mb-0 fs-5 text-muted">{{ atributo_adicional.nombre }}</span>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <hr>

                    <div class="my-5">
                        <div class="mb-4">
                            <h4 class="fw-bolder">Ubicación</h4>
                            <BloqueMapaDireccion
                                :value="`${propiedad.direccion}, ${propiedad.ubicacion.ciudad}, ${propiedad.ubicacion.region}`">
                            </BloqueMapaDireccion>
                        </div>
                        <div class="mb-4">
                            <h5 class="fw-bolder">Dirección</h5>
                            <p class="fs-5">{{ propiedad.direccion }}, {{ propiedad.ubicacion.ciudad }}, {{
                                propiedad.ubicacion.region }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <BloqueContactar :propiedad="propiedad" :propiedades_destacadas="propiedades_destacadas">
                    </BloqueContactar>
                </div>
            </div>
            <hr>
            <BloqueImagenesDestacadas :propiedades_destacadas="propiedades_destacadas"
                :propiedad_seleccionada="propiedad.id">
            </BloqueImagenesDestacadas>

        </div>


    </div>
</template>

<script>

import BloqueImagenesDestacadas from './BloqueImagenesDestacadas.vue';
import BloqueMapaDireccion from './BloqueMapaDireccion.vue';
import BloqueContactar from './BloqueContactar.vue';
import { formatoMiles } from '../../utils/formatoMiles';

export default {
    props: ['propiedad', 'propiedades_destacadas'],
    components: {
        BloqueMapaDireccion,
        BloqueImagenesDestacadas,
        BloqueContactar
    },
    data() {
        return {
            atributos_adicionales: [],
        }
    },
    methods: {
        formatDate(date) {
            const options = { year: 'numeric', month: 'short', day: 'numeric' };
            return new Date(date).toLocaleDateString('en-CL', options);
        }
    },
    watch: {
        propiedad: {
            immediate: true,
            handler(propiedad) {
                if (propiedad) {
                    propiedad.valor_pesos = formatoMiles(propiedad.valor_pesos);
                    this.atributos_adicionales = JSON.parse(propiedad.atributos_adicionales);
                }
            },
        },
    },
}
</script>

<style>
.badge {
    line-height: inherit;
}
</style>