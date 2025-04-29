import axios from 'axios';

export default {
    data() {
        return {
            apiKey: "",
        };
    },
    methods: {
        async loadGoogleMaps() {
            try {
                const response = await axios.get("/configuraciones/all");
                this.apiKey = response.data.api_google_maps;
                this.loadGoogleMapsAPI();
            } catch (error) {
                console.error("Error al obtener la API Key:", error);
            }
        },

        loadGoogleMapsAPI() {
            if (window.google && window.google.maps) {
                console.log("Google Maps API ya está cargado.");
                this.initGeocoder();
                this.buscarUbicacionEnMapa(this.ubicacion); // <-- usar la dirección directamente
                return;
            }

            if (document.querySelector("script[src*='maps.googleapis.com']")) {
                console.log("El script de Google Maps ya se ha insertado.");
                return;
            }

            if (this.apiKey) {
                const script = document.createElement("script");
                script.src = `https://maps.googleapis.com/maps/api/js?key=${this.apiKey}&libraries=places`;
                script.async = true;
                script.onload = () => {
                    this.geocoder = new google.maps.Geocoder();
                    this.initGeocoder();
                    this.buscarUbicacionEnMapa(this.ubicacion); // <-- llamada segura al cargar
                };
                document.head.appendChild(script);
            }
        },
    },
};
