<template>
    <div>
        <BloqueImagenes :imagenes="propiedad.imagenes"></BloqueImagenes>
        <BloqueDetallePropiedad :propiedad="propiedad" :propiedades_destacadas="propiedades"></BloqueDetallePropiedad>
    </div>
</template>
<script>
import servicesPropiedades from '../mixins/propiedades/servicesPropiedades';
import servicesAgentes from '../mixins/agentes/servicesAgentes';

import BloqueImagenes from '../components/DetallePropiedad/BloqueImagenes.vue';
import BloqueDetallePropiedad from '../components/DetallePropiedad/BloqueDetallePropiedad.vue';

export default {
    mixins: [servicesPropiedades, servicesAgentes],
    components: {
        BloqueImagenes,
        BloqueDetallePropiedad
    },
    props: ['propiedad'],
    created() {
        this.fetchAllPropiedades();
        this.fetchAllAgentes();
    },
}
</script>
