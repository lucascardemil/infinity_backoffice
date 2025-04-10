<template>
    <div class="modal fade" id="editPasswordUsuarioModal" tabindex="-1" aria-labelledby="editPasswordUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPasswordUsuarioModalLabel"><i class="bi bi-pencil-square"></i>
                        Editar Contraseña</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editPasswordUsuario">
                        <div class="mb-3">
                            <label for="editUsuarioPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control"
                                :class="error_password ? error_password.password ? 'is-invalid' : '' : ''"
                                id="editUsuarioPassword" v-model="editUsuarioPassword.password" required>

                            <div id="password" :class="error_password ? 'invalid-feedback' : ''">
                                {{ error_password ? error_password.password : '' }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editUsuarioConfirmarPassword" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="editUsuarioConfirmarPassword"
                                :class="error_password ? error_password.password_confirmation ? 'is-invalid' : '' : ''"
                                v-model="editUsuarioPassword.password_confirmation" required>

                            <div id="password_confirmation" :class="error_password ? 'invalid-feedback' : ''">
                                {{ error_password ? error_password.password_confirmation : '' }}
                            </div>
                        </div>
                        <template v-if="errors">
                            <div class="alert alert-danger" role="alert">
                                {{ errors.password[0] }}
                            </div>
                        </template>

                        <button type="submit" class="btn btn-base-dv"
                            :disabled="editUsuarioPassword.password == null || loading">
                            <span v-if="loading">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Cargando...</span>
                            <span v-else>Guardar
                                Cambios</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import usuariosMixin from '../../mixins/usuarios/usuariosMixin';
import { limpiarCampos } from '../../utils/limpiarCampos';
import { validarPassword } from '../../utils/validarPassword';

export default {
    mixins: [usuariosMixin],
    props: {
        usuario_props: Object
    },
    data() {
        return {
            editUsuarioPassword: {
                usuario_id: 0,
                password: '',
                password_confirmation: ''
            },
            error_password: null,
        };
    },
    watch: {
        usuario_props: {
            immediate: true,
            handler(usuario) {
                if (usuario) {
                    this.editUsuarioPassword.usuario_id = usuario.id
                }
            }
        },
        'editUsuarioPassword.password': function () {
            this.error_password = validarPassword(this.editUsuarioPassword.password, this.editUsuarioPassword.password_confirmation);
        },
        'editUsuarioPassword.password_confirmation': function () {
            this.error_password = validarPassword(this.editUsuarioPassword.password, this.editUsuarioPassword.password_confirmation);
        }

    },
    methods: {
        open() {
            this.errors = null;
            this.error_password = null;
            limpiarCampos(this.editUsuarioPassword);
            const modalElement = document.getElementById('editPasswordUsuarioModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            this.errors = null;
            this.error_password = null;
            limpiarCampos(this.editUsuarioPassword);
            const modalElement = document.getElementById('editPasswordUsuarioModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },

        async editPasswordUsuario() {
            const response = await this.actualizarPasswordUsuario(this.editUsuarioPassword);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.close();

                if (response.logout) {
                    await this.logoutUsuario();
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1000);
                }
            }
        }
    }
}
</script>

<style scoped></style>
