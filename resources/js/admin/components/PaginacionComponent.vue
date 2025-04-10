
<template>
    <div class="btn-toolbar justify-content-end my-3" v-if="totalPaginas > 1">
        <div class="btn-group">
            <button class="btn btn-base-dv" @click="anteriorPagina" v-if="paginaActual !== 1">Anterior</button>
            <button class="btn btn-base-dv" v-for="pagina in totalPaginas"
                v-bind:class="[pagina === paginaActiva ? 'active' : '']" @click="irPagina(pagina)">{{ pagina }}</button>
            <button class="btn btn-base-dv" @click="siguientePagina"
            v-if="paginaActual !== totalPaginas">Siguiente</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        paginaActual: {
            type: Number,
            required: true
        },
        totalPaginas: {
            type: Number,
            required: true
        }
    },
    computed: {
        paginaActiva() {
            return this.paginaActual
        },
    },
    methods: {
        irPagina(pagina){
            this.$emit('cambiar-pagina-actual', pagina);
        },
        siguientePagina() {
            if (this.paginaActual < this.totalPaginas) {
                this.$emit('cambiar-pagina', this.paginaActual + 1);
            }
        },
        anteriorPagina() {
            if (this.paginaActual > 1) {
                this.$emit('cambiar-pagina', this.paginaActual - 1);
            }
        }
    }
};
</script>