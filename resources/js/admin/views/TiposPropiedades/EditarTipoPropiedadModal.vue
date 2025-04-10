<template>
    <div class="modal fade" id="editarTipoPropiedadModal" tabindex="-1" aria-labelledby="editarTipoPropiedadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarTipoPropiedadModalLabel"><i class="bi bi-pencil-square"></i>
                        Editar Tipo Propiedad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="formEditarTipoPropiedad">
                        <div class="mb-3">
                            <label for="tipo_propiedad_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="tipo_propiedad_nombre"
                                v-model="editarTipoPropiedad.nombre" required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="tipo_propiedad in errors.nombre">
                                {{ tipo_propiedad }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv"
                            :disabled="editarTipoPropiedad.nombre == ''">Guardar
                            Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import tiposPropiedadesMixin from '../../mixins/tipo_propiedad/tiposPropiedadesMixin';
import { capitalize } from '../../utils/capitalize';

export default {
    mixins: [tiposPropiedadesMixin],
    props: {
        tipo_propiedad: Object
    },
    data() {
        return {
            editarTipoPropiedad: {
                nombre: ''
            }
        };
    },
    watch: {
        tipo_propiedad: {
            immediate: true,
            handler(TipoPropiedad) {
                if (TipoPropiedad) {
                    this.editarTipoPropiedad.nombre = TipoPropiedad.nombre;
                }
            }
        },
        'editarTipoPropiedad.nombre': function (newValue) {
            this.editarTipoPropiedad.nombre = capitalize(newValue);
        },
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('editarTipoPropiedadModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editarTipoPropiedadModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async formEditarTipoPropiedad() {
            const response = await this.actualizarTipoPropiedad({
                tipo_propiedad_id: this.tipo_propiedad.id,
                nombre: this.editarTipoPropiedad.nombre
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('tipo-propiedad-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
