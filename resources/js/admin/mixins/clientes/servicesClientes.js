import axios from 'axios';

export default {
    data() {
        return {
            clientes: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchClientesSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/clientes/all');
                this.clientes = response.data;
            } catch (error) {
                this.errors = 'Failed to load clientes';
                console.error('Error fetching clientes:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/clientes/update-status/' + data.cliente_id, {
                    estado: data.estado
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load cliente';
                console.error('Error actualizar cliente:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
