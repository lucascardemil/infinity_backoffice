<template>
    <div class="w-75">
        <div class="d-flex justify-content-center align-items-center flex-column cargando-propiedad-creada"
            v-if="loading_crear_propiedad">
            <img src="/images/cargando_home.gif">
            <h3 class="texto-cargando-propiedad">Creando Propiedad...</h3>
        </div>
        <div v-else class="row mb-5">
            <div class="col">
                <!--Formulario-->
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="inputCrearPropiedadTitulo" class="form-label">Titulo</label>
                            <input type="text" autocomplete="off" class="form-control"
                                :class="{ 'is-invalid': errors?.titulo ? errors?.titulo.length > 0 : '' }"
                                id="inputCrearPropiedadTitulo" placeholder="Titulo" v-model="propiedad.titulo">
                        </div>
                        <div class="mb-3">
                            <label for="inputCrearPropiedadTipoPropiedad" class="form-label">Tipo Propiedad</label>
                            <select class="form-select"
                                :class="{ 'is-invalid': errors?.tipo_propiedad_id ? errors?.tipo_propiedad_id.length > 0 : '' }"
                                id="inputCrearPropiedadTipoPropiedad" aria-label="Tipo Propiedad"
                                v-model="propiedad.tipo_propiedad_id">
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
                            <label for="inputCrearPropiedadFormatoNegocio" class="form-label">Formato Negocio</label>
                            <select class="form-select"
                                :class="{ 'is-invalid': errors?.formato_negocio_id ? errors?.formato_negocio_id.length > 0 : '' }"
                                id="inputCrearPropiedadFormatoNegocio" aria-label="Formato Negocio"
                                v-model="propiedad.formato_negocio_id">
                                <option :value="null" disabled selected>Seleccione un Formato Negocio
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
                                    :class="{ 'is-invalid': errors?.valor_pesos ? errors?.valor_pesos.length > 0 : '' }"
                                    v-model="propiedad.valor_uf" placeholder="Valor UF" id="inputCrearPropiedadValorUF" @input="convertir" />
                            </div>
                            <div class="input-group mb-3">
                                <select class="form-select" id="selectValorUF" v-model="tipoConversion">
                                    <option>UF a Pesos</option>
                                    <option>Pesos a UF</option>
                                </select>
                                <input class="form-control"
                                    :class="{ 'is-invalid': errors?.valor_pesos ? errors?.valor_pesos.length > 0 : '' }"
                                    v-model="propiedad.cantidad" id="cantidadValorUF" placeholder="Ingrese cantidad"
                                    @input="convertir" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputCrearPropiedadValorPesos" class="form-label
                                        ">{{ tipoConversion === "UF a Pesos" ? "Valor Pesos" : "Valor UF" }}</label>
                            <input type="text" autocomplete="off" class="form-control"
                                :class="{ 'is-invalid': errors?.valor_pesos ? errors?.valor_pesos.length > 0 : '' }"
                                id="inputCrearPropiedadValorPesos" :placeholder="tipoConversion"
                                v-model="propiedad.valor_pesos" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="inputCrearPropiedadRegion" class="form-label">Region</label>
                            <select class="form-select"
                                :class="{ 'is-invalid': errors?.ubicacion_id ? errors?.ubicacion_id.length > 0 : '' }"
                                id="inputCrearPropiedadRegion" aria-label="Region" @change="seleccionarRegion"
                                v-model="propiedad.region">
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
                            <label for="inputCrearPropiedadCiudad" class="form-label">Ciudad</label>
                            <select class="form-select"
                                :class="{ 'is-invalid': errors?.ubicacion_id ? errors?.ubicacion_id.length > 0 : '' }"
                                id="inputCrearPropiedadCiudad" aria-label="Ciudad" v-model="propiedad.ciudad">
                                <option :value="null" disabled selected>Seleccione un Ciudad
                                </option>
                                <template v-for="ciudad in ciudades">
                                    <option :value="ciudad.id">{{ ciudad.ciudad }}
                                    </option>
                                </template>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inputCrearPropiedadDireccion" class="form-label">Dirección</label>
                            <input type="text" autocomplete="off" class="form-control"
                                :class="{ 'is-invalid': errors?.direccion ? errors?.direccion.length > 0 : '' }"
                                id="inputCrearPropiedadDireccion" v-model="propiedad.direccion"
                                placeholder="Ingrese una dirección" />
                        </div>
                        <div class="mb-3">
                            <label for="inputCrearPropiedadSuperficie" class="form-label">M2 Superficie</label>
                            <input type="number" class="form-control"
                                :class="{ 'is-invalid': errors?.m2_superficie ? errors?.m2_superficie.length > 0 : '' }"
                                id="inputCrearPropiedadSuperficie" placeholder="M2 Superficie"
                                v-model="propiedad.m2_superficie" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="inputCrearPropiedadConstruido" class="form-label">M2 Construido</label>
                            <input type="number" class="form-control"
                                :class="{ 'is-invalid': errors?.m2_construido ? errors?.m2_construido.length > 0 : '' }"
                                id="inputCrearPropiedadConstruido" placeholder="M2 Construido"
                                v-model="propiedad.m2_construido" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="inputCrearPropiedadPisos" class="form-label">Pisos</label>
                            <input type="number" class="form-control"
                                :class="{ 'is-invalid': errors?.pisos ? errors?.pisos.length > 0 : '' }"
                                id="inputCrearPropiedadPisos" placeholder="Pisos" v-model="propiedad.pisos" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="inputCrearPropiedadDormitorios" class="form-label">Dormitorios</label>
                            <input type="number" class="form-control"
                                :class="{ 'is-invalid': errors?.dormitorios ? errors?.dormitorios.length > 0 : '' }"
                                id="inputCrearPropiedadDormitorios" placeholder="Dormitorios"
                                v-model="propiedad.dormitorios" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="inputCrearPropiedadBanos" class="form-label">Baños</label>
                            <input type="number" class="form-control"
                                :class="{ 'is-invalid': errors?.banos ? errors?.banos.length > 0 : '' }"
                                id="inputCrearPropiedadBanos" placeholder="Baños" v-model="propiedad.banos" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="inputCrearPropiedadTipoPublicacion" class="form-label">Tipo Publicación</label>
                            <select class="form-select"
                                :class="{ 'is-invalid': errors?.categoria_secundaria_id ? errors?.categoria_secundaria_id.length > 0 : '' }"
                                id="inputCrearPropiedadTipoPublicacion" aria-label="Tipo Publicación"
                                v-model="propiedad.categoria_secundaria_id">
                                <option :value="null" disabled selected>Seleccione un Tipo Publicación
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
                            <div class="form-check" v-for="atributo_adicional in atributos_adicionales"
                                :key="atributo_adicional.id">
                                <input class="form-check-input" type="checkbox"
                                    :id="'atributo-adicional-' + atributo_adicional.id" :value="atributo_adicional.id"
                                    @change="agregarAtributosAdicionales(atributo_adicional)"
                                    :checked="propiedad.atributos_adicionales_selected.some(atributo => atributo.id === atributo_adicional.id)"
                                    :disabled="deshabilitarAtributosAdicionales(atributo_adicional.id)">
                                <label class="form-check-label" :for="'atributo-adicional-' + atributo_adicional.id">
                                    {{ atributo_adicional.nombre }}
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-danger"
                            v-if="errors?.atributos_adicionales ? errors?.atributos_adicionales.length > 0 : false"
                            role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i> Debe seleccionar un máximo de 5
                            atributos adicionales.
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
                            :class="{ 'is-invalid': errors?.descripcion ? errors?.descripcion.length > 0 : '' }"
                            id="inputCrearPropiedadDescripcion" rows="10" v-model="propiedad.descripcion"></textarea>
                    </div>
                </div>
                <!--Imagenes-->
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="text-white mb-0">Imagenes</h4>
                    </div>
                    <div class="card-body">
                        <ImagenesPropiedad :propiedad="propiedad" :errors="errors" />
                    </div>
                </div>
                <!--Estado Propiedad-->
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="text-white mb-0">Estado Propiedad</h4>
                    </div>
                    <div class="card-body">
                        <select class="form-select"
                            :class="{ 'is-invalid': errors?.estado_propiedad ? errors?.estado_propiedad.length > 0 : '' }"
                            id="inputEditarPropiedadEstadoPropiedad" aria-label="Estado Propiedad"
                            v-model="propiedad.estado_propiedad">
                            <option :value="null" disabled selected>Seleccione Estado Propiedad
                            </option>
                            <option value="vendida">Vendida</option>
                            <option value="no_disponible">No Disponible</option>
                            <option value="disponible">Disponible</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col">
                <VistaPreviaPropiedad :propiedad="propiedad" :errors="errors" />
            </div>

            <button type="button" class="btn btn-base-dv btn-lg mt-3 fixed-bottom rounded-0 fw-bold"
                @click="guardarPropiedad" :disabled="loading_crear_propiedad"><i class="bi bi-plus-circle"></i> Guardar
                Propiedad</button>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue';
import VistaPreviaPropiedad from './VistaPreviaPropiedad.vue';
import ImagenesPropiedad from './ImagenesPropiedad.vue';
import draggable from "vuedraggable";
import servicesPropiedadMixin from '../../mixins/propiedad/servicesPropiedadMixin';
import crearPropiedad from '../../mixins/propiedad/crearPropiedad';

export default {
    mixins: [servicesPropiedadMixin, crearPropiedad],
    props: {
        tipos_propiedades: Array,
        formatos_negocios: Array,
        ubicaciones: Array,
        categorias_secundarias: Array,
        atributos_adicionales: Array
    },
    components: {
        LoadingComponent,
        draggable,
        VistaPreviaPropiedad,
        ImagenesPropiedad
    },
    data() {
        return {
            resultado: 0,
            tipoConversion: "UF a Pesos",
            ciudades: [],
            propiedad: {
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
            loading: false
        };
    },
    methods: {
        seleccionarRegion: function (event) {
            const region = event.target.value;
            this.ciudades = this.ubicaciones.find(ubicacion => ubicacion.region == region).ciudades;
        },
        agregarAtributosAdicionales(atributoAdicional) {
            const index = this.propiedad.atributos_adicionales_selected.findIndex(atributo => atributo.id === atributoAdicional.id);
            if (index === -1) {
                if (this.propiedad.atributos_adicionales_selected.length < 5) {
                    this.propiedad.atributos_adicionales_selected.push({
                        id: atributoAdicional.id,
                        nombre: atributoAdicional.nombre,
                        ruta_imagen: atributoAdicional.ruta_imagen,
                        estado: true
                    });
                }
            } else {
                this.propiedad.atributos_adicionales_selected.splice(index, 1);
            }
        },
        deshabilitarAtributosAdicionales(atributoAdicionalId) {
            return this.propiedad.atributos_adicionales_selected.length >= 5 && !this.propiedad.atributos_adicionales_selected.some(atributo => atributo.id === atributoAdicionalId);
        },
        async guardarPropiedad() {
            const formData = new FormData();
            formData.append('titulo', this.propiedad.titulo);
            formData.append('estado_propiedad', this.propiedad.estado_propiedad);
            formData.append('tipo_propiedad_id', this.propiedad.tipo_propiedad_id);
            formData.append('formato_negocio_id', this.propiedad.formato_negocio_id);
            formData.append('cantidad', this.propiedad.cantidad);
            formData.append('valor_uf', this.propiedad.valor_uf);
            formData.append('valor_pesos', this.propiedad.valor_pesos);
            formData.append('tipo_valor', this.propiedad.tipo_valor);
            formData.append('ubicacion_id', this.propiedad.ciudad);
            formData.append('m2_superficie', this.propiedad.m2_superficie);
            formData.append('m2_construido', this.propiedad.m2_construido);
            formData.append('pisos', this.propiedad.pisos);
            formData.append('dormitorios', this.propiedad.dormitorios);
            formData.append('banos', this.propiedad.banos);
            formData.append('categoria_secundaria_id', this.propiedad.categoria_secundaria_id);
            formData.append('descripcion', this.propiedad.descripcion);
            formData.append('direccion', this.propiedad.direccion);
            formData.append('atributos_adicionales', this.propiedad.atributos_adicionales_selected.length > 0
                ? JSON.stringify(this.propiedad.atributos_adicionales_selected)
                : '');

            if (this.propiedad.imagenes.length > 0) {
                this.propiedad.imagenes.forEach((imagen, index) => {
                    formData.append(`imagenes[${index}][url]`, imagen.url);
                    formData.append(`imagenes[${index}][archivo]`, imagen.archivo);
                    formData.append(`imagenes[${index}][principal]`, imagen.principal);
                });
            } else {
                formData.append('imagenes', JSON.stringify([]));
            }

            const response = await this.crearPropiedad(formData);

            if (this.errors === null) {
                this.$notyf.success(response.message);
                this.$emit('crear-propiedad');
                this.limpiarCampos();
            }
        },

        limpiarCampos() {
            this.propiedad = {
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
            };
            this.resultado = 0;
            this.tipoConversion = "UF a Pesos";
            this.ciudades = [];
            this.errors = null;
            this.error_imagen_principal = false;
        }

    },
}
</script>