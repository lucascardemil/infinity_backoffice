import axios from 'axios';

export default {
    data() {
        return {
            ubicaciones: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchUbicacionesSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/ubicaciones/all-select');
                this.ubicaciones = response.data;
            } catch (error) {
                this.errors = 'Failed to load ubicaciones';
                console.error('Error fetching ubicaciones:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchUbicaciones() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/ubicaciones/all');
                this.ubicaciones = response.data;
            } catch (error) {
                this.errors = 'Failed to load ubicaciones';
                console.error('Error fetching ubicaciones:', error);
            } finally {
                this.loading = false;
            }
        },

        async crearUbicacion(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/ubicaciones/store', {
                    region: data.region,
                    ciudad: data.ciudad
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors = 'Failed to load ubicacion';
                console.error('Error crear ubicacion:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarUbicacion(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/ubicaciones/update/' + data.ubicacion_id, {
                    region: data.region,
                    ciudad: data.ciudad
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load ubicacion';
                console.error('Error actualizar ubicacion:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/ubicaciones/update-status/' + data.ubicacion_id, {
                    estado: data.estado
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load ubicacion';
                console.error('Error actualizar ubicacion:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
