<template>
    <div>
        <div id="map" style="width: 100%; height: 400px;"></div>
    </div>
</template>

<script>
import obtenerMapaGoogleMixin from '../../mixins/obtener_mapa_google/obtenerMapaGoogleMixin';

export default {
    mixins: [obtenerMapaGoogleMixin],
    props: {
        value: String, // Dirección que viene desde el v-model
    },
    data() {
        return {
            ubicacion: this.value,
            coordenadas: null, // Ya no se usa valor por defecto
            geocoder: null,
            map: null,
            marker: null,
        };
    },
    watch: {
        value(newVal) {
            this.ubicacion = newVal;
            this.buscarUbicacionEnMapa(newVal);
        },
    },
    mounted() {
        if (!window.google || !window.google.maps) {
            this.loadGoogleMaps();
        } else {
            this.initGeocoder();
            this.buscarUbicacionEnMapa(this.ubicacion);
        }
    },
    methods: {
        initMap() {
            if (!this.coordenadas) return;

            const mapOptions = {
                center: this.coordenadas,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            };
            this.map = new google.maps.Map(document.getElementById("map"), mapOptions);

            this.marker = new google.maps.Marker({
                position: this.coordenadas,
                map: this.map,
            });
        },

        initGeocoder() {
            if (typeof google !== "undefined" && google.maps) {
                this.geocoder = new google.maps.Geocoder();
            }
        },

        buscarUbicacionEnMapa(direccion) {
            if (!direccion || !this.geocoder) return;

            this.geocoder.geocode({ address: direccion }, (results, status) => {
                if (status === "OK" && results[0]) {
                    const location = results[0].geometry.location;
                    this.coordenadas = {
                        lat: location.lat(),
                        lng: location.lng(),
                    };

                    if (!this.map) {
                        this.initMap();
                    } else {
                        this.map.setCenter(this.coordenadas);
                        if (this.marker) {
                            this.marker.setMap(null);
                        }
                        this.marker = new google.maps.Marker({
                            position: this.coordenadas,
                            map: this.map,
                        });
                    }
                } else {
                    console.warn("No se pudo geocodificar la dirección:", status);
                }
            });
        },
    },
};
</script>