<template>
    <div class="modal fade" id="editarFormatoNegocioModal" tabindex="-1" aria-labelledby="editarFormatoNegocioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarFormatoNegocioModalLabel"><i class="bi bi-pencil-square"></i> Editar Formato Negocio</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="formEditarFormatoNegocio">
                        <div class="mb-3">
                            <label for="formato_negocio_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="formato_negocio_nombre" v-model="editarFormatoNegocio.nombre"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="formato_negocio in errors.nombre">
                                {{ formato_negocio }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="editarFormatoNegocio.nombre == ''">Guardar
                            Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import formatosNegociosMixin from '../../mixins/formato_negocio/formatosNegociosMixin';

export default {
    mixins: [formatosNegociosMixin],
    props: {
        formato_negocio: Object
    },
    data() {
        return {
            editarFormatoNegocio: {
                nombre: ''
            }
        };
    },
    watch: {
        formato_negocio: {
            immediate: true,
            handler(FormatoNegocio) {
                if (FormatoNegocio) {
                    this.editarFormatoNegocio.nombre = FormatoNegocio.nombre;
                }
            }
        }
    },
    methods: {
        open() {
            this.errors = null;
            this.editarFormatoNegocio.nombre = '';
            const modalElement = document.getElementById('editarFormatoNegocioModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editarFormatoNegocioModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async formEditarFormatoNegocio() {
            const response = await this.actualizarFormatoNegocio({
                formato_negocio_id: this.formato_negocio.id,
                nombre: this.editarFormatoNegocio.nombre
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('formato-negocio-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
