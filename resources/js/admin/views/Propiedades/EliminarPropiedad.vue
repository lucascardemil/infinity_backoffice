<template>
    <div class="modal fade" id="eliminarPropiedadModal" tabindex="-1" aria-labelledby="eliminarPropiedadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPropiedadModalLabel"><i class="bi bi-trash"></i>
                        Eliminar Propiedad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <!-- <loading-component></loading-component> -->
                        <h5 class="text-white">
                            ¿Está seguro de que desea eliminar la propiedad {{ propiedad_eliminar?.titulo }}?
                        </h5>
                        <p class="text-white">Esta acción no se puede deshacer.</p>
                        <p class="text-white">¿Está seguro de que desea continuar?</p>
                        <p v-if="errors" class="text-danger">{{ errors }}</p>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                    <button type="button" @click="eliminar" class="btn btn-danger" :disabled="loading_eliminar_propiedad">
                        <span v-if="loading_eliminar_propiedad">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Cargando...
                        </span>
                        <span v-else><i class="bi bi-trash"></i> Eliminar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import LoadingComponent from '../../components/LoadingComponent.vue';
import servicesPropiedadMixin from '../../mixins/propiedad/servicesPropiedadMixin';

export default {
    mixins: [servicesPropiedadMixin],
    props: {
        propiedad_eliminar: Object,
    },
    components: {
        LoadingComponent
    },
    data() {
        return {

        };
    },
    watch: {

    },
    methods: {
        open() {
            const modalElement = document.getElementById('eliminarPropiedadModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('eliminarPropiedadModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async eliminar() {
            const response = await this.eliminarPropiedad(this.propiedad_eliminar.id);

            if (this.errors_eliminar_propiedad === null) {
                this.$notyf.success(response.message);
                this.$emit('eliminar-propiedad');
                this.close();
            }
        }

    }
}
</script>
