<template>
    <div>
        <swiper :slides-per-view="slidesPerView" :space-between="spaceBetween" :loop="true" :navigation="false"
            :autoplay="{ delay: 3000, disableOnInteraction: false }">
            <swiper-slide class="swiper-slide position-relative">
                <img src="/images/FONDO-1.webp" class="d-block w-100" alt="...">
                <div class="slide-caption-overlay d-flex flex-column justify-content-center align-items-center">
                    <div class="slide-caption-content text-white text-center p-4 rounded">
                        <h1 class="fw-bold mb-2">Búsqueda de Bienes Raíces</h1>
                        <p class="mb-0">
                            INFINITY, pone a disposición su Plataforma Comercial para la Compra, Venta o
                            Arriendo de un Bien Raíz. Sean estas para fines Comerciales, Productivos o
                            Habitacionales.
                        </p>
                    </div>
                </div>
            </swiper-slide>
            <swiper-slide class="swiper-slide position-relative">
                <img src="/images/FONDO-2.webp" class="d-block w-100" alt="...">
                <div class="slide-caption-overlay d-flex flex-column justify-content-center align-items-center">
                    <div class="slide-caption-content text-white text-center p-4 rounded">
                        <h1 class="fw-bold mb-2">Administración de Arriendo</h1>
                        <p class="mb-0">
                            INFINITY, pone a disposición su Estructura Organizacional para llevar a cabo la
                            Administración
                            del Bien Raíz de manera integral, desde la Cobranza al pago de los Gastos Comunes y solución
                            de
                            controversias.
                        </p>
                    </div>
                </div>
            </swiper-slide>
            <swiper-slide class="swiper-slide position-relative">
                <img src="/images/FONDO-3.webp" class="d-block w-100" alt="...">
                <div class="slide-caption-overlay d-flex flex-column justify-content-center align-items-center">
                    <div class="slide-caption-content text-white text-center p-4 rounded">
                        <h1 class="fw-bold mb-2">Gestión de Compra y Venta de Propiedades</h1>
                        <p class="mb-0">
                            INFINITY, apoya y asesora en todo momento en la recepción del Bien Raíz para su Venta, así
                            como
                            en las gestiones para su Adquisición, sean estos para fines Habitacionales, Comerciales o
                            Productivos.
                        </p>
                    </div>
                </div>
            </swiper-slide>
            <swiper-slide class="swiper-slide position-relative">
                <img src="/images/FONDO-4.webp" class="d-block w-100" alt="...">
                <div class="slide-caption-overlay d-flex flex-column justify-content-center align-items-center">
                    <div class="slide-caption-content text-white text-center p-4 rounded">
                        <h1 class="fw-bold mb-2">Arriendo de Propiedades</h1>
                        <p class="mb-0">
                            INFINITY, pone a disposición su Estructura Organizacional para llevar a cabo la
                            Administración
                            del Bien Raíz de manera integral, desde la Cobranza al pago de los Gastos Comunes y solución
                            de
                            controversias.
                        </p>
                    </div>
                </div>
            </swiper-slide>
        </swiper>
        <BloquePropiedades :propiedades="propiedades" />
        <BloqueServicios />
        <BloqueAgentes :agentes="agentes" />
        <BloqueSucursales />
        <BloqueColaboradores />
    </div>
</template>
<script>
import { Navigation, Pagination, Autoplay } from "swiper";
import { SwiperCore, Swiper, SwiperSlide } from "swiper-vue2";

import "swiper/swiper-bundle.css";

SwiperCore.use([Navigation, Pagination, Autoplay]);


import servicesPropiedades from '../mixins/propiedades/servicesPropiedades';
import servicesAgentes from '../mixins/agentes/servicesAgentes';

import BloqueAgentes from '../components/Home/BloqueAgentes.vue';
import BloquePropiedades from '../components/Home/BloquePropiedades.vue';
import BloqueServicios from '../components/Home/BloqueServicios.vue';
import BloqueSucursales from '../components/Home/BloqueSucursales.vue';
import BloqueColaboradores from '../components/Home/BloqueColaboradores.vue';

export default {
    mixins: [servicesPropiedades, servicesAgentes],
    components: {
        BloquePropiedades,
        BloqueServicios,
        BloqueAgentes,
        BloqueSucursales,
        BloqueColaboradores,

        Swiper,
        SwiperSlide,
    },
    data() {
        return {
            slidesPerView: 1,
            spaceBetween: 0
        };
    },
    computed: {

    },
    created() {
        this.fetchAllPropiedades();
        this.fetchAllAgentes();
    },
}
</script>
