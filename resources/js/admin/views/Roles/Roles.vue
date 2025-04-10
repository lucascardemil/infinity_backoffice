<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white">Roles</h3>

            <button type="button" class="btn btn-base-dv" @click="openCrearModal()"><i class="bi bi-plus-circle"></i>
                Agregar</button>
        </div>

        <LoadingComponent v-if="loading"></LoadingComponent>
        <div v-else class="table-responsive">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="roles.length">
                        <tr v-for="(role, index) in roles" :key="role.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ role.name }}</td>
                            <td>
                                <button type="button" class="btn btn-base-dv" @click="openEditModal(role)"><i
                                        class="bi bi-pencil-square"></i> Editar
                                    Permisos</button>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay roles.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>

        <CrearRolModal ref="crearRolModal" @role-updated="fetchRoles" />
        <EditarRolModal ref="editRoleModal" :role="selectedRole" @role-updated="fetchRoles" />
    </div>
</template>

<script>
import roleMixin from '../../mixins/roles/roleMixin';
import EditarRolModal from './EditarRolModal.vue';
import CrearRolModal from './CrearRolModal.vue';
import LoadingComponent from '../../components/LoadingComponent.vue';

export default {
    mixins: [roleMixin],
    components: {
        EditarRolModal,
        CrearRolModal,
        LoadingComponent
    },
    data() {
        return {
            selectedRole: null,
        };
    },
    methods: {
        openCrearModal() {
            this.$refs.crearRolModal.open();
        },
        openEditModal(role) {
            if (role) {
                this.selectedRole = { ...role };
                this.$refs.editRoleModal.open();
            }
        }
    },
    created() {
        this.fetchRoles();
    }
}
</script>

<style scoped></style>
