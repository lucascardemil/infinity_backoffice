import axios from 'axios';

export default {
    data() {
        return {
            atributos_adicionales: [],
            loading: false,
            errors: null,
            loading_imagen: false,
        };
    },
    methods: {

        async fetchAtributosAdicionalesSelect() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/atributo_adicionales/all-select');
                this.atributos_adicionales = response.data;
            } catch (error) {
                this.errors = 'Failed to load atributos_adicionales';
                console.error('Error fetching atributos_adicionales:', error);
            } finally {
                this.loading = false;
            }
        },

        async fetchAtributosAdicionales() {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.get('/atributo_adicionales/all');
                this.atributos_adicionales = response.data;
            } catch (error) {
                this.errors = 'Failed to load atributos_adicionales';
                console.error('Error fetching atributos_adicionales:', error);
            } finally {
                this.loading = false;
            }
        },

        async crearAtributoAdicional(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/atributo_adicionales/store', data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors = 'Failed to load atributo adicional';
                console.error('Error crear atributo adicional:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarAtributoAdicional(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.post('/atributo_adicionales/update' , data, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load atributo adicional';
                console.error('Error actualizar atributo adicional:', error);
            } finally {
                this.loading = false;
            }
        },

        async actualizarStatus(data) {
            this.loading = true;
            this.errors = null;
            try {
                const response = await axios.put('/atributo_adicionales/update-status/' + data.atributo_adicional_id, {
                    estado: data.estado
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Failed to load atributo adicional';
                console.error('Error actualizar atributo adicional:', error);
            } finally {
                this.loading = false;
            }
        },

        async eliminarImagen(url_imagen_cloudinary) {
            this.loading_imagen = true;
            this.errors = null;
            try {
                const response = await axios.post('/atributo_adicionales/eliminar-imagen/', {
                    url_imagen_cloudinary: url_imagen_cloudinary
                });

                if (response.data.errors) {
                    this.errors = response.data.errors;
                }

                return response.data;

            } catch (error) {
                this.errors = 'Error en eliminar la imagen', error;
                return false;
            } finally {
                this.loading_imagen = false;
            }
        }
    }
};
