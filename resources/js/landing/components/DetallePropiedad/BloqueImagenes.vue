<template>
    <div class="pb-5">
        <template v-if="imagenes_propiedades.length > 1">
            <swiper 
                :slides-per-view="slidesPerView" 
                :space-between="spaceBetween"
                :loop="true"
                :navigation="true"
                :breakpoints="{
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
                        slidesPerView: 3,
                        spaceBetween: 20,
                    }
                }">
                <swiper-slide class="swiper-slide" v-for="(imagen, index) in imagenes_propiedades" :key="index">
                    <img :src="imagen.ruta_imagen" alt="Imagen de propiedad" :class="{ 'ancho-imagen': ancho_imagen }" width="100%"/>
                </swiper-slide>
            </swiper>
        </template>

        <template v-else v-for="(imagen, index) in imagenes_propiedades">
            <div class="container-imagen">
                <img :src="imagen.ruta_imagen" class="imagen-propiedad" alt="Imagen de propiedad" />
            </div>
        </template>
    </div>
</template>

<script>
import { Navigation, Pagination } from "swiper";
import { SwiperCore, Swiper, SwiperSlide } from "swiper-vue2";

// Import Swiper styles
import "swiper/swiper-bundle.css";

SwiperCore.use([Navigation, Pagination]);

export default {
    props: ['imagenes'],
    components: {
        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            slidesPerView: 3,
            spaceBetween: 20,
            ancho_imagen: false,
            imagenes_propiedades: []
        }
    },
    watch: {
        imagenes: {
            immediate: true,
            handler(imagenes) {
                this.imagenes_propiedades = imagenes
                this.ancho_imagen = this.imagenes_propiedades.length >= 3
            },
        },
    },
    mounted() {
        this.slidesPerView = this.imagenes_propiedades.length >= 3 ? 3 : this.slidesPerView
        this.spaceBetween = this.imagenes_propiedades.length > 3 ? 10 : this.spaceBetween
    }
}
</script>

<style>
.ancho-imagen {
    max-height: 550px;
}

.container-imagen {
    height: 500px;
    width: 100%;
    overflow: hidden;
    position: relative;

    @media  (max-width: 1024px) {
        height: auto;
    }
}

.imagen-propiedad {
    width: 100%;
    position: absolute;
    top: -70%;

    @media  (max-width: 1024px) {
        position: relative;
        top: 0;
    }
}

.swiper-button-prev {
    left: 30px;
}

.swiper-button-next {
    right: 30px;
}

.swiper-button-prev,
.swiper-button-next {
    background-color: #c28501;
    padding: 25px;
    border-radius: 10px;
    transition: background-color 0.3s ease;
}

.swiper-button-prev:after,
.swiper-button-next:after {
    font-size: 20px;
    color: #fff;
}

.swiper-button-prev:hover,
.swiper-button-next:hover {
    background-color: #a66a00;
}
</style>