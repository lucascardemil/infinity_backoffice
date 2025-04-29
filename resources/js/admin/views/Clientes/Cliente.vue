<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white">Clientes</h3>
        </div>
        <LoadingComponent v-if="loading" />
        <div v-else class="table-responsive">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Mensaje</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Contactado</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="clientes.length">
                        <tr v-for="(cliente, index) in ListaClientes" :key="cliente.id">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ cliente.nombre }}</td>
                            <td>{{ cliente.email }}</td>
                            <td>{{ cliente.telefono }}</td>
                            <td>{{ cliente.mensaje }}</td>
                            <td v-if="cliente.estado == 0">
                                <span class="badge rounded-pill bg-danger">No Contactado</span>
                            </td>
                            <td v-else-if="cliente.estado == 1">
                                <span class="badge rounded-pill bg-success">Contactado</span>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" :id="cliente.id"
                                        v-model="cliente.estado"
                                        @change="handleEnabledChange(cliente.id, cliente.estado)">
                                </div>
                            </td>
                        </tr>
                    </template>
                    <p v-else>No hay clientes.</p>
                    <p v-if="errors">{{ errors }}</p>
                </tbody>
            </table>
        </div>

        <PaginacionComponent :paginaActual="paginaActual" :totalPaginas="totalPaginas" @cambiar-pagina="cambiarPagina"
            @cambiar-pagina-actual="cambiarPaginaActual" />

    </div>
</template>

<script>
import servicesClientes from '../../mixins/clientes/servicesClientes';
import LoadingComponent from '../../components/LoadingComponent.vue';
import PaginacionComponent from '../../components/PaginacionComponent.vue';

export default {
    mixins: [servicesClientes],
    components: {
        LoadingComponent,
        PaginacionComponent
    },
    data() {
        return {
            paginaActual: 1,
            filasPorPagina: 3,
        };
    },
    computed: {
        totalPaginas() {
            return Math.ceil(this.clientes.length / this.filasPorPagina);
        },
        ListaClientes() {
            const start = (this.paginaActual - 1) * this.filasPorPagina;
            const end = start + this.filasPorPagina;
            return this.clientes.slice(start, end);
        }
    },
    methods: {
        async handleEnabledChange(cliente_id, estado) {
            const checkboxStatus = estado ? 1 : 0;
            const checkbox = { cliente_id: cliente_id, estado: checkboxStatus };

            try {
                const response = await this.actualizarStatus(checkbox);
                if (this.errors === null) {
                    this.$notyf.success(response.message);
                }
            } catch (error) {
                console.error('Error actualizando el estado:', error);
            }
        },

        cambiarPaginaActual(newPage) {
            this.paginaActual = newPage;
        },
        cambiarPagina(newPage) {
            this.paginaActual = newPage;
        },

    },
    created() {
        this.fetchClientesSelect();
    }
}
</script>

<style scoped></style>
