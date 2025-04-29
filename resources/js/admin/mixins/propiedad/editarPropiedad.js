export default {
    watch: {
        'editar.editar.valor_uf': function (val) {
            if (!val) {
                this.convertir();
            }
        },
        'editar.titulo': function (val) {
            this.limpiarError('titulo');
            this.editar.titulo = this.capitalize(val);
        },
        'editar.tipo_propiedad_id': function (val) {
            if (val) {
                this.editar.nombre_tipo_propiedad = this.getNombre(val, this.tipos_propiedades);
                this.limpiarError('tipo_propiedad_id');
            }
        },
        'editar.formato_negocio_id': function (val) {
            if (val) {
                this.editar.nombre_formato_negocio = this.getNombre(val, this.formatos_negocios);
                this.limpiarError('formato_negocio_id');
            }
        },
        'editar.valor_pesos': function (val) {
            if (val.length > 0) {
                this.limpiarError('valor_pesos');
            }
        },
        'editar.region': function (val) {
            if (val) {
                this.editar.nombre_region = this.getNombreUbicacion(val, 'region');
                this.limpiarError('ubicacion_id');
            }
        },
        'editar.ciudad': function (val) {
            if (val) {
                this.editar.nombre_ciudad = this.getNombreUbicacion(val, 'ciudad');
                this.limpiarError('ubicacion_id');
            }
        },
        'editar.categoria_secundaria_id': function (val) {
            if (val) {
                this.editar.nombre_tipo_publicacion = this.getNombre(val, this.categorias_secundarias);
                this.limpiarError('categoria_secundaria_id');
            }
        },
        'editar.descripcion': function (val) {
            if (val.length > 0) {
                this.limpiarError('descripcion');
            }
        },
        'editar.direccion': function (val) {
            if (val.length > 0) {
                this.limpiarError('direccion', 'errors');
            }
        }
    },
    methods: {
        limpiarError(campo, tipoError = 'errors_editar') {
            if (!this[tipoError]) {
                this[tipoError] = {};
            }
            if (this[tipoError][campo]) {
                this[tipoError][campo] = [];
            }
        },
        getNombre(id, lista) {
            const item = lista.find(elemento => elemento.id === id);
            return item ? item.nombre : '';
        },
        getNombreUbicacion(valor, tipo) {


            if (tipo === 'region') {
                const region = this.ubicaciones.find(ubicacion => ubicacion.region === valor);
                return region ? region.region : '';
            } else if (tipo === 'ciudad') {
                let ciudad = ''; 
                
                this.ubicaciones.forEach(ubicacion => {
                    if(ubicacion.ciudades) {
                        ubicacion.ciudades.forEach(ciudadItem => {
                            if (ciudadItem.id === valor) {
                                ciudad = ciudadItem.ciudad;
                            }
                        });
                    }
                });

                return ciudad;
            }
        },
        capitalize(texto) {
            return texto.charAt(0).toUpperCase() + texto.slice(1);
        },
        convertir() {
            if (!this.editar.cantidad || isNaN(this.editar.cantidad) || !this.editar.valor_uf) {
                this.editar.valor_pesos = 0;
                this.editar.cantidad = '';
                return;
            }

            if (this.tipoConversion === "UF a Pesos") {
                this.editar.tipo_valor = "$";
                this.editar.valor_pesos = Math.round(this.editar.cantidad * this.editar.valor_uf);
            } else {
                this.editar.tipo_valor = "UF";
                this.editar.valor_pesos = Math.round(this.editar.cantidad / this.editar.valor_uf);
            }

            this.editar.valor_pesos = this.editar.valor_pesos !== '' ? Number(this.editar.valor_pesos).toLocaleString('es-CL') : '';
        },
    }
};
