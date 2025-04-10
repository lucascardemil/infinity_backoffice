<template>
    <div class="modal fade" id="crearFormatoNegocioModal" tabindex="-1" aria-labelledby="crearFormatoNegocioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearFormatoNegocioModalLabel">Crear Formato Negocio</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="guardarFormatoNegocio">
                        <div class="mb-3">
                            <label for="formato_negocio_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="formato_negocio_nombre" v-model="formato_negocio.nombre"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="formato_negocio in errors.nombre">
                                {{ formato_negocio }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="formato_negocio.nombre == ''">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import formatosNegociosMixin from '../../mixins/formato_negocio/formatosNegociosMixin';
import { limpiarCampos } from '../../utils/limpiarCampos';

export default {
    mixins: [formatosNegociosMixin],
    data() {
        return {
            formato_negocio: {
                nombre: '',
            }
        };
    },
    methods: {
        open() {
            limpiarCampos(this.formato_negocio);
            this.errors = null;
            const modalElement = document.getElementById('crearFormatoNegocioModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearFormatoNegocioModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async guardarFormatoNegocio() {
            const response = await this.crearFormatoNegocio(this.formato_negocio);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                limpiarCampos(this.formato_negocio);
                this.$emit('formato-negocio-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
