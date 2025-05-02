<template>
    <a :href="`/propiedad/${propiedad.titulo.toLowerCase().replace(/\s+/g, '-')}`" class="text-decoration-none">
        <div class="card card-imagenes-destacadas bg-white mb-3">
            <template v-if="propiedad.imagenes.length > 0">
                <img v-for="(imagen, index) in propiedad.imagenes" v-if="imagen.principal"
                    :src="imagen.url ?? imagen.ruta_imagen" class="card-img-top" alt="...">
                <img v-if="!propiedad.imagenes.some(imagen => imagen.principal)" src="/images/propiedad_defecto.webp"
                    class="card-img-top" alt="...">
            </template>
            <template v-else>
                <img src="/images/propiedad_defecto.webp" class="card-img-top" alt="...">
            </template>

            <div class="card-img-overlay">
                <div class="d-flex gap-2">
                    <div class="card-tipo-publicacion" v-if="propiedad.categoria_secundaria">
                        <h5 v-if="propiedad.categoria_secundaria.nombre !== 'Estandar'">
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
                <p class="card-text" v-if="propiedad.direccion.length > 0 || propiedad.ubicacion.length > 0">
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
                <div class="d-flex gap-2 align-items-center" v-if="propiedad.users.imagenes.length > 0">
                    <div class="container-imagen-agente">
                        <img :src="propiedad.users.imagenes[0].ruta_imagen" class="img-agente-miniatura">
                    </div>
                    <span class="text-dark">{{ propiedad.users.name }}</span>
                </div>
                <div class="text-dark fw-bold fs-4">{{ propiedad.tipo_valor }} {{
                    propiedad.valor_pesos }}
                </div>
            </div>
        </div>
    </a>
</template>


<script>
export default {
    props: ['propiedad']
}
</script>