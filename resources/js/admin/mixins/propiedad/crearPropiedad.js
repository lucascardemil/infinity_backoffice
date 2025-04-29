export default {
    watch: {
        'propiedad.propiedad.valor_uf': function (val) {
            if (!val) {
                this.convertir();
            }
        },
        'propiedad.titulo': function (val) {
            this.limpiarError('titulo');
            this.propiedad.titulo = this.capitalize(val);
        },
        'propiedad.tipo_propiedad_id': function (val) {
            if (val) {
                this.propiedad.nombre_tipo_propiedad = this.getNombre(val, this.tipos_propiedades);
                this.limpiarError('tipo_propiedad_id');
            }
        },
        'propiedad.formato_negocio_id': function (val) {
            if (val) {
                this.propiedad.nombre_formato_negocio = this.getNombre(val, this.formatos_negocios);
                this.limpiarError('formato_negocio_id');
            }
        },
        'propiedad.valor_pesos': function (val) {
            if (val.length > 0) {
                this.limpiarError('valor_pesos');
            }
        },
        'propiedad.region': function (val) {
            if (val) {
                this.propiedad.nombre_region = this.getNombreUbicacion(val, 'region');
                this.limpiarError('ubicacion_id');
            }
        },
        'propiedad.ciudad': function (val) {
            if (val) {
                this.propiedad.nombre_ciudad = this.getNombreUbicacion(val, 'ciudad');
                this.limpiarError('ubicacion_id');
            }
        },
        'propiedad.categoria_secundaria_id': function (val) {
            if (val) {
                this.propiedad.nombre_tipo_publicacion = this.getNombre(val, this.categorias_secundarias);
                this.limpiarError('categoria_secundaria_id');
            }
        },
        'propiedad.descripcion': function (val) {
            if (val.length > 0) {
                this.limpiarError('descripcion');
            }
        },
        'propiedad.direccion': function (val) {
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
            if (!this.propiedad.cantidad || isNaN(this.propiedad.cantidad) || !this.propiedad.valor_uf) {
                this.propiedad.valor_pesos = 0;
                this.propiedad.cantidad = '';
                return;
            }

            if (this.tipoConversion === "UF a Pesos") {
                this.propiedad.tipo_valor = "$";
                this.propiedad.valor_pesos = Math.round(this.propiedad.cantidad * this.propiedad.valor_uf);
            } else {
                this.propiedad.tipo_valor = "UF";
                this.propiedad.valor_pesos = Math.round(this.propiedad.cantidad / this.propiedad.valor_uf);
            }

            this.propiedad.valor_pesos = this.propiedad.valor_pesos !== '' ? Number(this.propiedad.valor_pesos).toLocaleString('es-CL') : '';
        },
    }
};
