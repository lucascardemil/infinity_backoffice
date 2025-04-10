<template>
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel"><i class="bi bi-pencil-square"></i> Editar Rol</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editRole">
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control" id="roleName" v-model="selectedRole.name" required>
                        </div>
                        <div class="mb-3">
                            <p class="form-label">Permisos</p>
                            <div class="form-check" v-for="permission in permissionsSelected" :key="permission.id">
                                <input class="form-check-input" type="checkbox" :id="'permission-' + permission.id"
                                    :value="permission.id" @change="handlePermissionChange(permission.id)"
                                    v-model="permission.selected">
                                <label class="form-check-label" :for="'permission-' + permission.id">
                                    {{ permission.name }}
                                </label>
                            </div>
                        </div>
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
import permissionMixin from '../../mixins/roles/permissionMixin';

export default {
    mixins: [permissionMixin, roleMixin],
    props: {
        role: Object
    },
    data() {
        return {
            permissionsSelected: [],
            selectedRole: {
                id: 0,
                name: '',
                permissionIds: []
            },
        };
    },
    watch: {
        role: {
            immediate: true,
            handler(newRole) {
                if (newRole) {
                    this.selectedRole.id = newRole.id;
                    this.selectedRole.name = newRole.name;
                    this.selectedRole.permissionIds = newRole.permissions.map(permission => permission.id);

                    this.permissionsSelected = this.permissions.map(permission => ({
                        id: permission.id,
                        name: permission.name,
                        selected: this.selectedRole.permissionIds.includes(permission.id)
                    }));
                }
            }
        }
    },
    methods: {
        open() {
            const modalElement = document.getElementById('editRoleModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editRoleModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        handlePermissionChange(permissionId) {
            const index = this.selectedRole.permissionIds.indexOf(permissionId);
            if (index === -1) {
                this.selectedRole.permissionIds.push(permissionId);
            } else {
                this.selectedRole.permissionIds.splice(index, 1);
            }
        },

        async editRole() {
            const response = await this.updateRoles({
                id: this.selectedRole.id,
                name: this.selectedRole.name,
                permissions: this.selectedRole.permissionIds
            });

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('role-updated');
                this.close();
            }
        }
    },
    created() {
        this.fetchPermissions();
    }
}
</script>

<style scoped></style>
