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
                    <CardPropiedades :propiedad="propiedad"></CardPropiedades>
                </swiper-slide>
            </swiper>
        </div>
    </div>
</template>

<script>
import { Navigation, Pagination, Autoplay } from "swiper";
import { SwiperCore, Swiper, SwiperSlide } from "swiper-vue2";
import { formatoMiles } from '../../utils/formatoMiles';
import CardPropiedades from "../CardPropiedades/CardPropiedades.vue";

// Import Swiper styles
import "swiper/swiper-bundle.css";

SwiperCore.use([Navigation, Pagination, Autoplay]);

export default {
    props: ['propiedades_destacadas', 'propiedad_seleccionada'],
    components: {
        Swiper,
        SwiperSlide,
        CardPropiedades
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