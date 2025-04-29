<template>
    <div>
        <header>
            <div id="carouselExampleCaptions" class="carousel slide mb-5" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="/images/FONDO-1.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption p-0 d-flex justify-content-center align-items-center">
                            <div class="bg-dark p-lg-4 p-md-3 text-white bg-opacity-75 rounded">
                                <h1 class="titulo-carrusel fw-bold">Búsqueda de Bienes Raíces</h1>
                                <p class="subtitulo-carrusel mb-0">
                                    INFINITY, pone a disposición su Plataforma Comercial para la Compra, Venta o
                                    Arriendo de un Bien Raíz. Sean estas para fines Comerciales, Productivos o
                                    Habitacionales.
                                </p>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="carousel-item">
                        <img src="/images/FONDO-2.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption p-0 d-flex justify-content-center align-items-center">
                            <div class="bg-dark p-lg-4 p-md-3 text-white bg-opacity-75 rounded">
                                <h1 class="titulo-carrusel fw-bold">Administración de Arriendo</h1>
                                <p class="subtitulo-carrusel mb-0">INFINITY, pone a disposición su Estructura
                                    Organizacional
                                    para llevar a
                                    cabo
                                    la Administración del Bien Raíz de manera integral, desde la Cobranza al pago de los
                                    Gastos
                                    Comunes y solución de controversias.</p>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="carousel-item">
                        <img src="/images/FONDO-3.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption p-0 d-flex justify-content-center align-items-center">
                            <div class="bg-dark p-lg-4 p-md-3 text-white bg-opacity-75 rounded">
                                <h1 class="titulo-carrusel fw-bold">Gestión de Compra y Venta de Propiedades</h1>
                                <p class="subtitulo-carrusel mb-0">INFINITY, apoya y asesora en todo momento en la
                                    recepción del Bien Raíz
                                    para
                                    su Venta, así como en las gestiones para su Adquisición, sean estos para fines
                                    Habitacionales, Comerciales o Productivos.</p>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <div class="carousel-item">
                        <img src="/images/FONDO-4.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption p-0 d-flex justify-content-center align-items-center">
                            <div class="bg-dark p-lg-4 p-md-3 text-white bg-opacity-75 rounded">
                                <h1 class="titulo-carrusel fw-bold">Arriendo de Propiedades</h1>
                                <p class="subtitulo-carrusel mb-0">INFINITY, pone a disposición su Estructura
                                    Organizacional para llevar a
                                    cabo
                                    la Administración del Bien Raíz de manera integral, desde la Cobranza al pago de los
                                    Gastos
                                    Comunes y solución de controversias.</p>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
        <BloquePropiedades :propiedades="propiedades" />
        <BloqueServicios />
        <BloqueAgentes :agentes="agentes" />
        <BloqueSucursales />
        <BloqueColaboradores />
    </div>
</template>
<script>
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
        BloqueColaboradores
    },
    data() {
        return {

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
