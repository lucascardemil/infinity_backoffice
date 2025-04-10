<template>
    <div class="modal fade" id="editarUbicacionModal" tabindex="-1" aria-labelledby="editarUbicacionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarUbicacionModalLabel"><i class="bi bi-pencil-square"></i> Editar Regiones y Ciudades</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="formEditarUbicacion">
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
                        <button type="submit" class="btn btn-base-dv" :disabled="ubicacion.region == '' && ubicacion.ciudad == ''">Guardar
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

export default {
    mixins: [ubicacionesMixin],
    props: {
        ubicacion_props: Object
    },
    data() {
        return {
            ubicacion: {
                region: '',
                ciudad: ''
            }
        };
    },
    watch: {
        ubicacion_props: {
            immediate: true,
            handler(Ubicacion) {
                if (Ubicacion) {
                    this.ubicacion.region = Ubicacion.region;
                    this.ubicacion.ciudad = Ubicacion.ciudad;
                }
            }
        }
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('editarUbicacionModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editarUbicacionModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async formEditarUbicacion() {
            const response = await this.actualizarUbicacion({
                ubicacion_id: this.ubicacion_props.id,
                region: this.ubicacion.region,
                ciudad: this.ubicacion.ciudad,
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('ubicacion-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
