import axios from 'axios';

export default {
    data() {
        return {
            botones: {},
            propiedades: [],
            imagenes_eliminadas: [],
            loading_propiedades: false,
            loading_crear_propiedad: false,
            loading_editar_propiedad: false,
            loading_subir_imagen: false,
            loading_eliminar_imagen: false,
            loading_eliminar_propiedad: false,
            errors: null,
            errors_editar: null,
            errors_eliminar_imagen: null,
            errors_eliminar_propiedad: null
        };
    },
    methods: {

        async fetchAllPropiedades() {
            this.loading_propiedades = true;
            this.errors = null;
            try {
                const response = await axios.get('/propiedad/all');
                this.propiedades = response.data.propiedades;
                this.botones = response.data.botones;
            } catch (error) {
                this.errors = 'Failed to load propiedades';
                console.error('Error fetching propiedades:', error);
            } finally {
                this.loading_propiedades = false;
            }
        },

        async crearPropiedad(propiedad) {
            this.loading_crear_propiedad = true;
            this.errors = null;

            await new Promise(resolve => setTimeout(resolve, 2000));

            try {
                const response = await axios.post('/propiedad/store', propiedad, {
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
                this.errors = 'Failed to load propiedad';
                console.error('Error crear propiedad:', error);
            } finally {
                this.loading_crear_propiedad = false;
            }
        },

        async actualizarPropiedad(propiedad) {
            this.loading_editar_propiedad = true;
            this.errors_editar = null;

            await new Promise(resolve => setTimeout(resolve, 2000));

            try {
                const response = await axios.post('/propiedad/update', propiedad, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                // Verifica si la respuesta tiene errores de validación
                if (response.data.errors) {
                    this.errors_editar = response.data.errors;
                }

                // Maneja la respuesta exitosa, si es necesario
                return response.data;

            } catch (error) {
                this.errors_editar = 'Failed to load propiedad';
                console.error('Error crear propiedad:', error);
            } finally {
                this.loading_editar_propiedad = false;
            }
        },

        async eliminarImagenPropiedad(id, ruta_imagen) {
            this.loading_eliminar_imagen = id;
            this.errors_eliminar_imagen = null;
            try {
                const response = await axios.post('/propiedad/delete-imagen/', {
                    id: id,
                    ruta_imagen: ruta_imagen
                });

                this.imagenes_eliminadas = response.data;
            } catch (error) {
                this.errors_eliminar_imagen = 'Failed to delete propiedad';
                console.error('Error deleting propiedad:', error);
            } finally {
                this.loading_eliminar_imagen = false;
            }
        },

        async actualizarImagenPrincipal(imagenes) {
            this.loading_editar_propiedad = true;
            this.errors_editar = null;
            try {
                const response = await axios.post('/propiedad/update-imagen-principal/', {
                    imagenes: imagenes
                });
                return response.data;
            } catch (error) {
                this.errors_editar = 'Failed to delete propiedad';
                console.error('Error deleting propiedad:', error);
            } finally {
                this.loading_editar_propiedad = false;
            }
        },

        async eliminarPropiedad(id) {
            this.loading_eliminar_propiedad = true;
            this.errors_eliminar_propiedad = null;
            try {
                const response = await axios.delete('/propiedad/delete/' + id);
                return response.data;
            } catch (error) {
                this.errors_eliminar_propiedad = 'Failed to delete propiedad';
                console.error('Error deleting propiedad:', error);
            } finally {
                this.loading_eliminar_propiedad = false;
            }
        }
    }
};
