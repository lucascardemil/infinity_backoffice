<template>
    <div class="modal fade" id="editarCategoriaSecundariaModal" tabindex="-1" aria-labelledby="editarCategoriaSecundariaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarCategoriaSecundariaModalLabel"><i class="bi bi-pencil-square"></i> Editar Categoria Secundaria</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="formEditarCategoriaSecundaria">
                        <div class="mb-3">
                            <label for="categoria_secundaria_nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="categoria_secundaria_nombre" v-model="editarCategoriaSecundaria.nombre"
                                required>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="categoria_secundaria in errors.nombre">
                                {{ categoria_secundaria }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv" :disabled="editarCategoriaSecundaria.nombre == ''">Guardar
                            Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import categoriasSecundariasMixin from '../../mixins/categoria_secundaria/categoriasSecundariasMixin';
import { capitalize } from '../../utils/capitalize';

export default {
    mixins: [categoriasSecundariasMixin],
    props: {
        categoria_secundaria: Object
    },
    data() {
        return {
            editarCategoriaSecundaria: {
                nombre: ''
            }
        };
    },
    watch: {
        categoria_secundaria: {
            immediate: true,
            handler(CategoriaSecundaria) {
                if (CategoriaSecundaria) {
                    this.editarCategoriaSecundaria.nombre = CategoriaSecundaria.nombre;
                }
            }
        },
        'editarCategoriaSecundaria.nombre': function(newValue) {
            this.editarCategoriaSecundaria.nombre = capitalize(newValue);
        }
    },
    methods: {
        open() {
            this.errors = null;
            this.editarCategoriaSecundaria.nombre = '';
            const modalElement = document.getElementById('editarCategoriaSecundariaModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editarCategoriaSecundariaModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async formEditarCategoriaSecundaria() {
            const response = await this.actualizarCategoriaSecundaria({
                categoria_secundaria_id: this.categoria_secundaria.id,
                nombre: this.editarCategoriaSecundaria.nombre
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('categoria-secundaria-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
