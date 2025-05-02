<template>
    <div>
        <div class="card text-white mb-3">
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
                    <div class="card-tipo-publicacion" v-if="propiedad.nombre_tipo_publicacion !== '' && propiedad.nombre_tipo_publicacion !==
                        'Estandar'">
                        <h5>
                            <span class="badge bg-success text-white">{{ propiedad.nombre_tipo_publicacion
                                }}</span>
                        </h5>
                    </div>
                    <div class="card-formato-negocio" v-if="propiedad.nombre_formato_negocio !== ''">
                        <h5>
                            <span class="badge bg-danger text-white">{{ propiedad.nombre_formato_negocio
                                }}</span>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-tipo-propiedad" v-if="propiedad.nombre_tipo_propiedad !== ''">
                <h5>
                    <span class="badge bg-light text-dark">{{ propiedad.nombre_tipo_propiedad }}</span>
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
                <h5 class="card-title" v-if="propiedad.titulo.length > 0">{{ propiedad.titulo }}</h5>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center gap-2" v-if="propiedad.m2_superficie.length > 0">
                        <img src="/images/superficie.svg">
                        <b class="card-text mb-0">{{ propiedad.m2_superficie }} m2</b>
                    </div>
                    <div class="d-flex align-items-center gap-2" v-if="propiedad.m2_construido.length > 0">
                        <img src="/images/construidos.svg">
                        <b class="card-text mb-0">{{ propiedad.m2_construido }} m2</b>
                    </div>
                    <div class="d-flex align-items-center gap-2" v-if="propiedad.pisos.length > 0">
                        <img src="/images/pisos.svg">
                        <b class="card-text mb-0">{{ propiedad.pisos }}</b>
                    </div>
                    <div class="d-flex align-items-center gap-2" v-if="propiedad.dormitorios.length > 0">
                        <img src="/images/dormitorios.svg">
                        <b class="card-text mb-0">{{ propiedad.dormitorios }}</b>
                    </div>
                    <div class="d-flex align-items-center gap-2" v-if="propiedad.banos.length > 0">
                        <img src="/images/banos.svg">
                        <b class="card-text mb-0">{{ propiedad.banos }}</b>
                    </div>
                </div>
            </div>
            <ul class="list-group list-group-flush align-items-end" v-if="propiedad.valor_pesos.length > 0">
                <li class="list-group-item text-white fw-bold fs-5">{{ propiedad.tipo_valor }} {{
                    propiedad.valor_pesos }}
                </li>
            </ul>
        </div>
        <div class="card text-white mb-3" v-if="propiedad.atributos_adicionales_selected.length > 0">
            <div class="card-header">
                <h5 class="card-title mb-0">Atributos Adicionales</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <template v-for="atributo_adicional in propiedad.atributos_adicionales_selected">
                        <div class="d-flex align-items-center gap-2">
                            <img :src="atributo_adicional.ruta_imagen" width="20px">
                            <b class="card-text mb-0">{{ atributo_adicional.nombre }}</b>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div class="card text-white mb-3" v-if="propiedad.descripcion.length > 0">
            <div class="card-header">
                <h5 class="card-title mb-0">Descripción</h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ propiedad.descripcion }}</p>
            </div>
        </div>
        <div class="card text-white mb-3" v-if="propiedad.direccion.length > 0 || propiedad.nombre_region.length > 0 ||
            propiedad.nombre_ciudad.length > 0">
            <div class="card-header">
                <h5 class="card-title mb-0">Direccion</h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    <i class="bi bi-geo-alt-fill"></i>
                    {{ propiedad.direccion }}, {{ propiedad.nombre_ciudad }}, {{ propiedad.nombre_region }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        propiedad: Object,
        errors: Object
    }
};
</script>
