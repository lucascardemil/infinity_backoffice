<template>
    <div class="modal fade" id="crearUbicacionModal" tabindex="-1" aria-labelledby="crearUbicacionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearUbicacionModalLabel">Crear Regiones y Ciudades</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="guardarUbicacion">
                        <div class="mb-3">
                            <label for="ubicacion_region" class="form-label">Region</label>
                            <input type="text" class="form-control" id="ubicacion_region" v-model="ubicacion.region"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="ubicacion_ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ubicacion_ciudad" v-model="ubicacion.ciudad"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="ubicacion in errors.region">
                                {{ ubicacion }}
                            </div>
                            <div class="alert alert-danger" role="alert" v-for="ubicacion in errors.ciudad">
                                {{ ubicacion }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv"
                            :disabled="ubicacion.region == '' && ubicacion.ciudad == ''">Guardar
                            Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import ubicacionesMixin from '../../mixins/ubicacion/ubicacionesMixin';
import { capitalize } from '../../utils/capitalize';
import { limpiarCampos } from '../../utils/limpiarCampos';

export default {
    mixins: [ubicacionesMixin],
    data() {
        return {
            ubicacion: {
                region: '',
                ciudad: ''
            }
        };
    },
    watch: {
        'ubicacion.region': function(newValue) {
            this.ubicacion.region = capitalize(newValue);
        },
        'ubicacion.ciudad': function(newValue) {
            this.ubicacion.ciudad = capitalize(newValue);
        }
    },
    methods: {
        open() {
            limpiarCampos(this.ubicacion);
            this.errors = null;
            const modalElement = document.getElementById('crearUbicacionModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearUbicacionModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        async guardarUbicacion() {
            const response = await this.crearUbicacion(this.ubicacion);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                limpiarCampos(this.ubicacion);
                this.$emit('ubicacion-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
