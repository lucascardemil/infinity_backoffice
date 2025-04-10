<template>
    <div class="modal fade" id="crearTipoPropiedadModal" tabindex="-1" aria-labelledby="crearTipoPropiedadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearTipoPropiedadModalLabel">Crear Tipo Propiedad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="guardarTipoPropiedad">
                        <div class="mb-3">
                            <label for="tipo_propiedad_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="tipo_propiedad_nombre" v-model="tipo_propiedad.nombre"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="tipo_propiedad in errors.nombre">
                                {{ tipo_propiedad }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="tipo_propiedad.nombre == ''">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import tiposPropiedadesMixin from '../../mixins/tipo_propiedad/tiposPropiedadesMixin';
import { limpiarCampos } from '../../utils/limpiarCampos';
import { capitalize } from '../../utils/capitalize';

export default {
    mixins: [tiposPropiedadesMixin],
    data() {
        return {
            tipo_propiedad: {
                nombre: '',
            }
        };
    },
    watch: {
        'tipo_propiedad.nombre': function(newValue) {
            this.tipo_propiedad.nombre = capitalize(newValue);
        },
    },
    methods: {
        open() {
            limpiarCampos(this.tipo_propiedad);
            this.errors = null;
            const modalElement = document.getElementById('crearTipoPropiedadModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearTipoPropiedadModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async guardarTipoPropiedad() {
            const response = await this.crearTipoPropiedad(this.tipo_propiedad);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                limpiarCampos(this.tipo_propiedad);
                this.$emit('tipo-propiedad-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
