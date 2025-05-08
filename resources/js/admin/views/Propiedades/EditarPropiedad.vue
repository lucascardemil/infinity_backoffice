<template>
    <div class="modal fade" id="editarPropiedadModal" tabindex="-1" aria-labelledby="editarPropiedadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPropiedadModalLabel"><i class="bi bi-pencil-square"></i>
                        Editar Propiedad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col">
                            <div class="d-flex justify-content-center align-items-center flex-column cargando-propiedad-creada"
                                v-if="loading_editar_propiedad">
                                <img src="/images/cargando_home.gif">
                                <h3 class="texto-cargando-propiedad">Editar Propiedad...</h3>
                            </div>
                            <div v-else class="row editar-propiedad-container">
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <!--Formulario-->
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadTitulo"
                                                    class="form-label">Titulo</label>
                                                <input type="text" autocomplete="off" class="form-control"
                                                    :class="{ 'is-invalid': errors_editar?.titulo ? errors_editar?.titulo.length > 0 : '' }"
                                                    id="inputEditarPropiedadTitulo" placeholder="Titulo"
                                                    v-model="editar.titulo">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadTipoPropiedad" class="form-label">Tipo
                                                    Propiedad</label>
                                                <select class="form-select"
                                                    :class="{ 'is-invalid': errors_editar?.tipo_propiedad_id ? errors_editar?.tipo_propiedad_id.length > 0 : '' }"
                                                    id="inputEditarPropiedadTipoPropiedad" aria-label="Tipo Propiedad"
                                                    v-model="editar.tipo_propiedad_id">
                                                    <option :value="null" disabled selected>Seleccione un Tipo Propiedad
                                                    </option>
                                                    <template v-for="tipos_propiedad in tipos_propiedades">
                                                        <option :value="tipos_propiedad.id">
                                                            {{ tipos_propiedad.nombre }}
                                                        </option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadFormatoNegocio"
                                                    class="form-label">Formato
                                                    Negocio</label>
                                                <select class="form-select"
                                                    :class="{ 'is-invalid': errors_editar?.formato_negocio_id ? errors_editar?.formato_negocio_id.length > 0 : '' }"
                                                    id="inputEditarPropiedadFormatoNegocio" aria-label="Formato Negocio"
                                                    v-model="editar.formato_negocio_id">
                                                    <option :value="null" disabled selected>Seleccione un Formato
                                                        Negocio
                                                    </option>
                                                    <template v-for="formato_negocio in formatos_negocios">
                                                        <option :value="formato_negocio.id">
                                                            {{ formato_negocio.nombre }}
                                                        </option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <div class="mb-3">
                                                    <input class="form-control"
                                                        :class="{ 'is-invalid': errors_editar?.valor_pesos ? errors_editar?.valor_pesos.length > 0 : '' }"
                                                        v-model="editar.valor_uf" placeholder="Valor UF"
                                                        id="inputEditarPropiedadValorUF" @input="convertir" />
                                                </div>
                                                <div class="input-group mb-3">
                                                    <select class="form-select" id="selectValorUF"
                                                        v-model="tipoConversion">
                                                        <option value="$">UF a Pesos</option>
                                                        <option value="UF">Pesos a UF</option>
                                                    </select>
                                                    <input class="form-control"
                                                        :class="{ 'is-invalid': errors_editar?.valor_pesos ? errors_editar?.valor_pesos.length > 0 : '' }"
                                                        v-model="editar.cantidad" id="cantidadValorUF"
                                                        placeholder="Ingrese cantidad" @input="convertir" />
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadValorPesos" class="form-label
                                        ">{{ tipoConversion === "UF a Pesos" ? "Valor Pesos" : "Valor UF" }}</label>
                                                <input type="text" autocomplete="off" class="form-control"
                                                    :class="{ 'is-invalid': errors_editar?.valor_pesos ? errors_editar?.valor_pesos.length > 0 : '' }"
                                                    id="inputEditarPropiedadValorPesos" :placeholder="tipoConversion"
                                                    v-model="editar.valor_pesos" min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadRegion"
                                                    class="form-label">Region</label>
                                                <select class="form-select"
                                                    :class="{ 'is-invalid': errors_editar?.ubicacion_id ? errors_editar?.ubicacion_id.length > 0 : '' }"
                                                    id="inputEditarPropiedadRegion" aria-label="Region"
                                                    @change="seleccionarRegion" v-model="editar.region">
                                                    <option :value="null" disabled selected>Seleccione un Region
                                                    </option>
                                                    <template v-for="ubicacion in ubicaciones">
                                                        <option :value="ubicacion.region">
                                                            {{ ubicacion.region }}
                                                        </option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadCiudad"
                                                    class="form-label">Ciudad</label>
                                                <select class="form-select"
                                                    :class="{ 'is-invalid': errors_editar?.ubicacion_id ? errors_editar?.ubicacion_id.length > 0 : '' }"
                                                    id="inputEditarPropiedadCiudad" aria-label="Ciudad"
                                                    v-model="editar.ciudad">
                                                    <option :value="null" disabled selected>Seleccione un Ciudad
                                                    </option>
                                                    <template v-for="ciudad in ciudades">
                                                        <option :value="ciudad.id">{{ ciudad.ciudad }}
                                                        </option>
                                                    </template>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadDireccion"
                                                    class="form-label">Dirección</label>
                                                <input type="text" autocomplete="off" class="form-control"
                                                    :class="{ 'is-invalid': errors_editar?.direccion ? errors_editar?.direccion.length > 0 : '' }"
                                                    id="inputEditarPropiedadDireccion" v-model="editar.direccion"
                                                    placeholder="Ingrese una dirección" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadSuperficie" class="form-label">M2
                                                    Superficie</label>
                                                <input type="number" class="form-control"
                                                    :class="{ 'is-invalid': errors_editar?.m2_superficie ? errors_editar?.m2_superficie.length > 0 : '' }"
                                                    id="inputEditarPropiedadSuperficie" placeholder="M2 Superficie"
                                                    v-model="editar.m2_superficie" min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadConstruido" class="form-label">M2
                                                    Construido</label>
                                                <input type="number" class="form-control"
                                                    :class="{ 'is-invalid': errors_editar?.m2_construido ? errors_editar?.m2_construido.length > 0 : '' }"
                                                    id="inputEditarPropiedadConstruido" placeholder="M2 Construido"
                                                    v-model="editar.m2_construido" min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadPisos" class="form-label">Pisos</label>
                                                <input type="number" class="form-control"
                                                    :class="{ 'is-invalid': errors_editar?.pisos ? errors_editar?.pisos.length > 0 : '' }"
                                                    id="inputEditarPropiedadPisos" placeholder="Pisos"
                                                    v-model="editar.pisos" min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadDormitorios"
                                                    class="form-label">Dormitorios</label>
                                                <input type="number" class="form-control"
                                                    :class="{ 'is-invalid': errors_editar?.dormitorios ? errors_editar?.dormitorios.length > 0 : '' }"
                                                    id="inputEditarPropiedadDormitorios" placeholder="Dormitorios"
                                                    v-model="editar.dormitorios" min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadBanos" class="form-label">Baños</label>
                                                <input type="number" class="form-control"
                                                    :class="{ 'is-invalid': errors_editar?.banos ? errors_editar?.banos.length > 0 : '' }"
                                                    id="inputEditarPropiedadBanos" placeholder="Baños"
                                                    v-model="editar.banos" min="0">
                                            </div>
                                            <div class="mb-3">
                                                <label for="inputEditarPropiedadTipoPublicacion" class="form-label">Tipo
                                                    Publicación</label>
                                                <select class="form-select"
                                                    :class="{ 'is-invalid': errors_editar?.categoria_secundaria_id ? errors_editar?.categoria_secundaria_id.length > 0 : '' }"
                                                    id="inputEditarPropiedadTipoPublicacion"
                                                    aria-label="Tipo Publicación"
                                                    v-model="editar.categoria_secundaria_id">
                                                    <option :value="null" disabled selected>Seleccione un Tipo
                                                        Publicación
                                                    </option>
                                                    <template v-for="categoria_secundaria in categorias_secundarias">
                                                        <option :value="categoria_secundaria.id">
                                                            {{ categoria_secundaria.nombre }}
                                                        </option>
                                                    </template>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Atributos Adicionales-->
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h4 class="text-white mb-0">Atributos Adicionales</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <div class="form-check"
                                                    v-for="atributo_adicional in atributos_adicionales"
                                                    :key="atributo_adicional.id">
                                                    <input class="form-check-input" type="checkbox"
                                                        :id="'atributo-adicional-' + atributo_adicional.id"
                                                        :value="atributo_adicional.id"
                                                        @change="agregarAtributosAdicionales(atributo_adicional)"
                                                        :checked="editar.atributos_adicionales_selected.some(atributo => atributo.id === atributo_adicional.id)"
                                                        :disabled="deshabilitarAtributosAdicionales(atributo_adicional.id)">
                                                    <label class="form-check-label"
                                                        :for="'atributo-adicional-' + atributo_adicional.id">
                                                        {{ atributo_adicional.nombre }}
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="alert alert-danger"
                                                v-if="errors_editar?.atributos_adicionales ? errors_editar?.atributos_adicionales.length > 0 : false"
                                                role="alert">
                                                <i class="bi bi-exclamation-triangle-fill"></i> Debe seleccionar un
                                                máximo de 5 atributos adicionales.
                                            </div>
                                        </div>
                                    </div>
                                    <!--Descripcion-->
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h4 class="text-white mb-0">Descripción</h4>
                                        </div>
                                        <div class="card-body">
                                            <textarea class="form-control"
                                                :class="{ 'is-invalid': errors_editar?.descripcion ? errors_editar?.descripcion.length > 0 : '' }"
                                                id="inputEditarPropiedadDescripcion" rows="10"
                                                v-model="editar.descripcion"></textarea>
                                        </div>
                                    </div>
                                    <!--Imagenes-->
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h4 class="text-white mb-0">Imagenes</h4>
                                        </div>
                                        <div class="card-body">
                                            <ImagenesPropiedad :propiedad="editar" :errors_editar="errors_editar"
                                                @imagenes-eliminadas="imagenesEliminadas" />
                                        </div>
                                    </div>
                                    <!--Estado Propiedad-->
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h4 class="text-white mb-0">Estado Propiedad</h4>
                                        </div>
                                        <div class="card-body">
                                            <select class="form-select"
                                                :class="{ 'is-invalid': errors_editar?.estado_propiedad ? errors_editar?.estado_propiedad.length > 0 : '' }"
                                                id="inputEditarPropiedadEstadoPropiedad" aria-label="Estado Propiedad"
                                                v-model="editar.estado_propiedad">
                                                <option :value="null" disabled selected>Seleccione Estado Propiedad
                                                </option>
                                                <option value="vendida">Vendida</option>
                                                <option value="no_disponible">No Disponible</option>
                                                <option value="disponible">Disponible</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-base-dv" @click="editarPropiedad"
                                        :disabled="loading_editar_propiedad">
                                        <i class="bi bi-plus-circle"></i> Editar Propiedad
                                    </button>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <VistaPreviaPropiedad :propiedad="editar" :errors_editar="errors_editar" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Modal } from 'bootstrap';
import LoadingComponent from '../../components/LoadingComponent.vue';
import VistaPreviaPropiedad from './VistaPreviaPropiedad.vue';
import ImagenesPropiedad from './ImagenesPropiedad.vue';
import draggable from "vuedraggable";
import servicesPropiedadMixin from '../../mixins/propiedad/servicesPropiedadMixin';
import editarPropiedad from '../../mixins/propiedad/editarPropiedad';

export default {
    mixins: [servicesPropiedadMixin, editarPropiedad],
    props: {
        propiedad_editar: Object,
        tipos_propiedades: Array,
        formatos_negocios: Array,
        ubicaciones: Array,
        categorias_secundarias: Array,
        atributos_adicionales: Array,
    },
    components: {
        LoadingComponent,
        draggable,
        VistaPreviaPropiedad,
        ImagenesPropiedad
    },
    data() {
        return {
            cantidad: '',
            resultado: 0,
            tipoConversion: "UF a Pesos",
            ciudades: [],
            editar: {
                id: 0,
                titulo: '',
                tipo_propiedad_id: null,
                nombre_tipo_propiedad: '',
                formato_negocio_id: null,
                nombre_formato_negocio: '',
                cantidad: '',
                valor_pesos: '',
                tipo_valor: '',
                valor_uf: '',
                region: null,
                nombre_region: '',
                ciudad: null,
                nombre_ciudad: '',
                m2_superficie: '',
                m2_construido: '',
                pisos: '',
                dormitorios: '',
                banos: '',
                categoria_secundaria_id: null,
                nombre_tipo_publicacion: '',
                atributos_adicionales_selected: [],
                descripcion: '',
                imagenes: [],
                direccion: '',
                estado_propiedad: null,
            },
            loading: false,
        };
    },
    watch: {
        propiedad_editar: {
            immediate: true,
            handler(propiedadEditar) {
                if (propiedadEditar) {
                    this.editar.id = propiedadEditar.id
                    this.editar.titulo = propiedadEditar.titulo
                    this.editar.tipo_propiedad_id = propiedadEditar.tipo_propiedad_id
                    this.editar.formato_negocio_id = propiedadEditar.formato_negocio_id
                    this.editar.valor_pesos = propiedadEditar.valor_pesos
                    this.editar.region = this.ubicaciones.find(ubicacion => ubicacion.ciudades.some(ciudad => ciudad.id === propiedadEditar.ubicacion_id))?.region
                    this.ciudades = this.ubicaciones.find(ubicacion => ubicacion.region == this.editar.region).ciudades
                    this.editar.ciudad = propiedadEditar.ubicacion_id
                    this.editar.m2_superficie = propiedadEditar.m2_superficie
                    this.editar.m2_construido = propiedadEditar.m2_construido
                    this.editar.pisos = propiedadEditar.pisos
                    this.editar.dormitorios = propiedadEditar.dormitorios
                    this.editar.banos = propiedadEditar.banos
                    this.editar.categoria_secundaria_id = propiedadEditar.categoria_secundaria_id
                    this.editar.atributos_adicionales_selected = JSON.parse(propiedadEditar.atributos_adicionales)
                    this.editar.descripcion = propiedadEditar.descripcion
                    this.editar.imagenes = propiedadEditar.imagenes
                    this.editar.direccion = propiedadEditar.direccion
                    this.editar.estado_propiedad = propiedadEditar.estado
                    this.editar.cantidad = propiedadEditar.cantidad
                    this.editar.valor_uf = propiedadEditar.valor_uf
                    this.tipoConversion = propiedadEditar.tipo_valor

                    if (this.tipoConversion === "UF a Pesos") {
                        this.editar.tipo_valor = "$";
                    } else {
                        this.editar.tipo_valor = "UF";
                    }
                }
            }
        },

    },
    methods: {
        open() {
            const modalElement = document.getElementById('editarPropiedadModal');
            const modal = new Modal(modalElement);
            modal.show();
        },
        close() {
            const modalElement = document.getElementById('editarPropiedadModal');
            const modal = Modal.getInstance(modalElement);
            if (modal) modal.hide();
        },
        seleccionarRegion: function (event) {
            const region = event.target.value;
            this.ciudades = this.ubicaciones.find(ubicacion => ubicacion.region == region).ciudades;
        },
        agregarAtributosAdicionales(atributoAdicional) {
            const index = this.editar.atributos_adicionales_selected.findIndex(atributo => atributo.id === atributoAdicional.id);
            if (index === -1) {
                if (this.editar.atributos_adicionales_selected.length < 5) {
                    this.editar.atributos_adicionales_selected.push({
                        id: atributoAdicional.id,
                        nombre: atributoAdicional.nombre,
                        ruta_imagen: atributoAdicional.ruta_imagen,
                        estado: true
                    });
                }
            } else {
                this.editar.atributos_adicionales_selected.splice(index, 1);
            }
        },
        deshabilitarAtributosAdicionales(atributoAdicionalId) {
            return this.editar.atributos_adicionales_selected.length >= 5 && !this.editar.atributos_adicionales_selected.some(atributo => atributo.id === atributoAdicionalId);
        },
        async editarPropiedad() {
            const formData = new FormData();
            formData.append('id', this.editar.id);
            formData.append('estado_propiedad', this.editar.estado_propiedad);
            formData.append('titulo', this.editar.titulo);
            formData.append('tipo_propiedad_id', this.editar.tipo_propiedad_id);
            formData.append('formato_negocio_id', this.editar.formato_negocio_id);
            formData.append('cantidad', this.editar.cantidad);
            formData.append('valor_uf', this.editar.valor_uf);
            formData.append('valor_pesos', this.editar.valor_pesos);
            formData.append('tipo_valor', this.editar.tipo_valor);
            formData.append('ubicacion_id', this.editar.ciudad);
            formData.append('m2_superficie', this.editar.m2_superficie);
            formData.append('m2_construido', this.editar.m2_construido);
            formData.append('pisos', this.editar.pisos);
            formData.append('dormitorios', this.editar.dormitorios);
            formData.append('banos', this.editar.banos);
            formData.append('categoria_secundaria_id', this.editar.categoria_secundaria_id);
            formData.append('descripcion', this.editar.descripcion);
            formData.append('direccion', this.editar.direccion);
            formData.append('atributos_adicionales', this.editar.atributos_adicionales_selected.length > 0
                ? JSON.stringify(this.editar.atributos_adicionales_selected)
                : '');

            if (this.editar.imagenes.length > 0) {
                this.editar.imagenes.forEach((imagen, index) => {
                    if (imagen.url !== undefined && imagen.url !== undefined) {
                        formData.append(`imagenes[${index}][url]`, imagen.url);
                        formData.append(`imagenes[${index}][archivo]`, imagen.archivo);
                        formData.append(`imagenes[${index}][principal]`, imagen.principal);
                    }
                });
            } else {
                formData.append('imagenes', JSON.stringify([]));
            }

            const response = await this.actualizarPropiedad(formData);

            if (this.errors_editar === null) {
                this.$notyf.success(response.message);
                this.$emit('imagenes-eliminadas-editar');
                this.close();
            }
        },
        imagenesEliminadas() {
            this.$emit('imagenes-eliminadas-editar');
        }
    },
}
</script>
<style scoped>
@media (max-width: 768px) {
    .editar-propiedad-container {
        flex-direction: column-reverse;
    }
}
</style>