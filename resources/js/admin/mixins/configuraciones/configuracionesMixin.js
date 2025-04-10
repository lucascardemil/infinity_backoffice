import axios from 'axios';

export default {
    data() {
        return {
            todas_configuraciones: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchAllConfiguraciones() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/configuraciones/all');
                this.todas_configuraciones = response.data;
            } catch (error) {
                this.errors = 'Failed to load configuraciones';
                console.error('Error fetching configuraciones:', error);
            } finally {
                this.loading = false;
            }
        },

        async guardarConfiguracion(configuraciones) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/configuraciones/store', {
                    configuraciones: configuraciones
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors = 'Failed to load configuraciones';
                console.error('Error crear configuraciones:', error);
            } finally {
                this.loading = false;
            }
        },
    }
};
