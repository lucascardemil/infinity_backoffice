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

        // Método para cargar Google Maps una vez que tengamos la clave API
        loadGoogleMapsAPI() {

            // Verifica si Google Maps ya está cargado
            if (window.google && window.google.maps) {
                console.log("Google Maps API ya está cargado.");
                this.initMap();
                this.initAutocomplete();
                return; // No cargarlo nuevamente
            }

            // Verifica si el script ya se agregó
            if (document.querySelector("script[src*='maps.googleapis.com']")) {
                console.log("El script de Google Maps ya se ha insertado.");
                return;
            }

            if (this.apiKey) {
                const script = document.createElement("script");
                script.src = `https://maps.googleapis.com/maps/api/js?key=${this.apiKey}&libraries=places`;
                script.async = true;
                script.onload = () => {
                    // Iniciar el mapa y el geocoder después de cargar Google Maps
                    this.geocoder = new google.maps.Geocoder();
                    this.initMap();
                    this.initAutocomplete();
                };
                document.head.appendChild(script);
            }
        },
    }
};
