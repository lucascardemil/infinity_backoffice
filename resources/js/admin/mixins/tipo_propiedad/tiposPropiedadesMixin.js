import axios from 'axios';

export default {
    data() {
        return {
            tipos_propiedades: [],
            loading: false,
            errors: null,
        };
    },
    methods: {

        async fetchTiposPropiedadesSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/tipos_propiedades/all-select');
                this.tipos_propiedades = response.data;
            } catch (error) {
                this.errors = 'Failed to load tipos_propiedades';
                console.error('Error fetching tipos_propiedades:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchTiposPropiedades() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/tipos_propiedades/all');
                this.tipos_propiedades = response.data;
            } catch (error) {
                this.errors = 'Failed to load tipos_propiedades';
                console.error('Error fetching tipos_propiedades:', error);
            } finally {
                this.loading = false;
            }
        },

        async crearTipoPropiedad(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/tipos_propiedades/store', {
                    nombre: data.nombre
                });
        
                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }
        
                // Maneja la respuesta exitosa, si es necesario
                return response.data;
        
            } catch (error) {
                this.errors = 'Failed to load tipo_propiedad';
                console.error('Error crear tipo_propiedad:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarTipoPropiedad(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/tipos_propiedades/update/' + data.tipo_propiedad_id, {
                    nombre: data.nombre
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load tipo_propiedad';
                console.error('Error actualizar tipo_propiedad:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/tipos_propiedades/update-status/' + data.tipo_propiedad_id, {
                    estado: data.estado
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load tipo_propiedad';
                console.error('Error actualizar tipo_propiedad:', error);
            } finally {
                this.loading = false;
            }
        }
    }
};
