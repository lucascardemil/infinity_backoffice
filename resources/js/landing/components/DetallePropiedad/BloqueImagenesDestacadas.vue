<template>
    <!-- <div class="row py-5">
        
    </div> -->
    <div class="row align-items-center" v-if="propiedades_filtradas.length > 0">
        <div class="col-12 py-5">
            <p class="texto-titulo">PROPIEDADES DESTACADAS</p>
            <h2>La propiedad más reciente</h2>
        </div>
        <div class="col-12">
            <swiper :slides-per-view="slidesPerView" :space-between="spaceBetween" :loop="true" :navigation="false"
                :autoplay="{ delay: 3000, disableOnInteraction: false }" :breakpoints="{
                    '320': {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    '375': {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    '425': {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    '768': {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    '1024': {
                        slidesPerView: propiedades_filtradas.length,
                        spaceBetween: 20,
                    },
                }">
                <swiper-slide class="swiper-slide" v-for="(propiedad, index) in propiedades_filtradas" :key="index">
                    <a :href="`/propiedad/${propiedad.titulo.toLowerCase().replace(/\s+/g, '-')}`"
                        class="text-decoration-none">
                        <div class="card card-imagenes-destacadas bg-white mb-3">
                            <template v-if="propiedad.imagenes.length > 0">
                                <img v-for="(imagen, index) in propiedad.imagenes" v-if="imagen.principal"
                                    :src="imagen.url ?? imagen.ruta_imagen" class="card-img-top" alt="...">
                                <img v-if="!propiedad.imagenes.some(imagen => imagen.principal)"
                                    src="/images/propiedad_defecto.webp" class="card-img-top" alt="...">
                            </template>
                            <template v-else>
                                <img src="/images/propiedad_defecto.webp" class="card-img-top" alt="...">
                            </template>

                            <div class="card-img-overlay">
                                <div class="d-flex gap-2">
                                    <div class="card-tipo-publicacion" v-if="propiedad.categoria_secundaria">
                                        <h5>
                                            <span class="badge bg-success text-white">{{
                                                propiedad.categoria_secundaria.nombre }}</span>
                                        </h5>
                                    </div>
                                    <div class="card-formato-negocio" v-if="propiedad.formato_negocio">
                                        <h5>
                                            <span class="badge bg-danger text-white">{{ propiedad.formato_negocio.nombre
                                                }}</span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-tipo-propiedad" v-if="propiedad.tipo_propiedad">
                                <h5>
                                    <span class="badge bg-light text-dark">{{ propiedad.tipo_propiedad.nombre }}</span>
                                </h5>
                            </div>
                            <div class="card-body" v-if="propiedad.titulo.length > 0 ||
                                propiedad.nombre_region.length > 0 ||
                                propiedad.nombre_ciudad.length > 0 ||
                                propiedad.m2_superficie.length > 0 ||
                                propiedad.m2_construido.length > 0 ||
                                propiedad.pisos.length > 0 ||
                                propiedad.dormitorios.length > 0 ||
                                propiedad.banos.length > 0">

                                <h5 class="card-title texto-subtitulo" v-if="propiedad.titulo.length > 0">
                                    {{ propiedad.titulo }}
                                </h5>
                                <p class="card-text"
                                    v-if="propiedad.direccion.length > 0 || propiedad.ubicacion.length > 0">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ propiedad.direccion }},
                                    {{ propiedad.ubicacion.ciudad }},
                                    {{ propiedad.ubicacion.region }}
                                </p>
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <div class="d-flex align-items-center gap-2" v-if="propiedad.m2_superficie > 0">
                                        <img src="/images/superficie.svg" class="imagen-oscura">
                                        <b class="card-text mb-0">{{ propiedad.m2_superficie }} m2</b>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" v-if="propiedad.m2_construido > 0">
                                        <img src="/images/construidos.svg" class="imagen-oscura">
                                        <b class="card-text mb-0">{{ propiedad.m2_construido }} m2</b>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" v-if="propiedad.pisos > 0">
                                        <img src="/images/pisos.svg" class="imagen-oscura">
                                        <b class="card-text mb-0">{{ propiedad.pisos }}</b>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" v-if="propiedad.dormitorios > 0">
                                        <img src="/images/dormitorios.svg" class="imagen-oscura">
                                        <b class="card-text mb-0">{{ propiedad.dormitorios }}</b>
                                    </div>
                                    <div class="d-flex align-items-center gap-2" v-if="propiedad.banos > 0">
                                        <img src="/images/banos.svg" class="imagen-oscura">
                                        <b class="card-text mb-0">{{ propiedad.banos }}</b>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex p-3 align-items-center justify-content-between"
                                v-if="propiedad.valor_pesos !== ''">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="container-imagen-agente" v-if="propiedad.users.imagenes.length > 0">
                                        <img :src="propiedad.users.imagenes[0].ruta_imagen"
                                            class="img-agente-miniatura">
                                    </div>
                                    <span class="text-dark">{{ propiedad.users.name }}</span>
                                </div>
                                <div class="text-dark fw-bold fs-4">{{ propiedad.tipo_valor }} {{
                                    propiedad.valor_pesos }}
                                </div>
                            </div>
                        </div>
                    </a>

                </swiper-slide>
            </swiper>
        </div>
    </div>
</template>

<script>
import { Navigation, Pagination, Autoplay } from "swiper";
import { SwiperCore, Swiper, SwiperSlide } from "swiper-vue2";
import { formatoMiles } from '../../utils/formatoMiles';

// Import Swiper styles
import "swiper/swiper-bundle.css";

SwiperCore.use([Navigation, Pagination, Autoplay]);

export default {
    props: ['propiedades_destacadas', 'propiedad_seleccionada'],
    components: {
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            slidesPerView: 3,
            spaceBetween: 20
        }
    },
    watch: {
        propiedades_destacadas: {
            immediate: true,
            handler(propiedades_destacadas) {
                if (!propiedades_destacadas || propiedades_destacadas.length === 0) {
                    return;
                }

                propiedades_destacadas.forEach(propiedad => {
                    if (propiedad.valor_pesos) {
                        propiedad.valor_pesos = formatoMiles(propiedad.valor_pesos);
                    }
                });
            },
        },
    },
    computed: {
        propiedades_filtradas() {
            return this.propiedades_destacadas.filter(propiedad => propiedad.id !== this.propiedad_seleccionada);
        }
    },

}
</script>

<style>
.card-imagenes-destacadas {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-imagenes-destacadas:hover {
    transform: scale(1.02);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    z-index: 2;
}

.container-imagen-agente {
    height: 40px;
    min-width: 40px;
    width: 40px;
    border-radius: 50%;

    .img-agente-miniatura {
        height: 100%;
        min-width: 100%;
        -o-object-fit: cover;
        object-fit: cover;
        width: 100%;
        border-radius: 50%;
    }
}
</style>