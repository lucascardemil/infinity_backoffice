<template>
    <div class="modal fade" id="crearCategoriaSecundariaModal" tabindex="-1" aria-labelledby="crearCategoriaSecundariaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearCategoriaSecundariaModalLabel">Crear Categoria Secundaria</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="guardarCategoriaSecundaria">
                        <div class="mb-3">
                            <label for="categoria_secundaria_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="categoria_secundaria_nombre" v-model="categoria_secundaria.nombre"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="categoria_secundaria in errors.nombre">
                                {{ categoria_secundaria }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="categoria_secundaria.nombre == ''">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import categoriasSecundariasMixin from '../../mixins/categoria_secundaria/categoriasSecundariasMixin';
import { limpiarCampos } from '../../utils/limpiarCampos';
import { capitalize } from '../../utils/capitalize';

export default {
    mixins: [categoriasSecundariasMixin],
    data() {
        return {
            categoria_secundaria: {
                nombre: '',
            }
        };
    },
    watch: {
        'categoria_secundaria.nombre': function(newValue) {
            this.categoria_secundaria.nombre = capitalize(newValue);
        }
    },
    methods: {
        open() {
            limpiarCampos(this.categoria_secundaria);
            this.errors = null;
            const modalElement = document.getElementById('crearCategoriaSecundariaModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearCategoriaSecundariaModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async guardarCategoriaSecundaria() {
            const response = await this.crearCategoriaSecundaria(this.categoria_secundaria);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                limpiarCampos(this.categoria_secundaria);
                this.$emit('categoria-secundaria-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
