<template>
    <div>
        <input type="text" ref="autocompleteInput" id="buscarUbicacion" v-model="ubicacion"
            placeholder="Ingrese una dirección" class="form-control mb-3" />
        <div id="map" style="width: 100%; height: 400px;"></div> <!-- Contenedor del mapa -->
    </div>
</template>

<script>
import obtenerMapaGoogleMixin from '../../mixins/obtener_mapa_google/obtenerMapaGoogleMixin';

export default {
    mixins: [obtenerMapaGoogleMixin],
    props: {
        value: String, // Se usa para `v-model`
    },
    data() {
        return {
            ubicacion: this.value, // Inicializa con el valor del prop
            coordenadas: { lat: -33.4489, lng: -70.6693 }, // Coordenadas iniciales (Santiago de Chile)
            geocoder: null,
            autocomplete: null,
        };
    },
    watch: {
        ubicacion(newVal) {
            this.$emit('input', newVal); // Permitir `v-model`
        }
    },
    mounted() {
        if (!window.google || !window.google.maps) {
            this.loadGoogleMaps().then(() => {
                this.initMap();
                this.initAutocomplete();
            });
        } else {
            this.initMap();
            this.initAutocomplete();
        }
    },

    methods: {
        // Inicializa el mapa de Google
        initMap() {
            const mapOptions = {
                center: this.coordenadas,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            };
            const map = new google.maps.Map(document.getElementById("map"), mapOptions);
            new google.maps.Marker({
                position: this.coordenadas,
                map: map,
            });
        },

        // Inicializa el Autocomplete de Google Places
        initAutocomplete() {
            if (typeof google !== "undefined" && google.maps) {
                this.autocomplete = new google.maps.places.Autocomplete(this.$refs.autocompleteInput, {
                    types: ["geocode"], // Solo direcciones
                    componentRestrictions: { country: "CL" } // Restringir a un país específico
                });

                this.autocomplete.addListener("place_changed", () => {
                    const place = this.autocomplete.getPlace();
                    if (place.geometry) {
                        this.coordenadas = {
                            lat: place.geometry.location.lat(),
                            lng: place.geometry.location.lng(),
                        };
                        this.ubicacion = place.formatted_address;
                        this.initMap();
                    }
                });
            }
        },
    },
};
</script>
