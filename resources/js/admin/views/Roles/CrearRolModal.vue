<template>
    <div class="modal fade" id="crearRolModal" tabindex="-1" aria-labelledby="crearRolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearRolModalLabel">Crear Rol</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveRole">
                        <div class="mb-3">
                            <label for="rolNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="rolNombre" v-model="newRole.name" required>
                        </div>

                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert" v-for="email in errors.email">
                                {{ email }}
                            </div>
                        </template>
                        <button type="submit" class="btn btn-base-dv">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import roleMixin from '../../mixins/roles/roleMixin';

export default {
    mixins: [roleMixin],
    data() {
        return {
            newRole: {
                name: '',
            }
        };
    },
    methods: {
        open() {
            this.errors = null;
            const modalElement = document.getElementById('crearRolModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('crearRolModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async saveRole() {
            const response = await this.createRol(this.newRole);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('role-updated');
                this.close();
            }
        }
    }
}
</script>

<style scoped></style>
