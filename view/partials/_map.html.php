<!-- <div id="suggestions" class="choose-address__suggestions"></div>
<div id="map" style="height: 400px;"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>
    const map = L.map('map', {
        dragging: false,
        touchZoom: false,
        scrollWheelZoom: false,
        doubleClickZoom: false,
        boxZoom: false,
        keyboard: false,
        zoomControl: false,
    }).setView([48.8566, 2.3522], 13);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    let marker = null;
    let routingControl = null;

    function searchAddress() {
        const query = document.getElementById("adresse").value;
        const suggestionsDiv = document.getElementById("suggestions");
        suggestionsDiv.innerHTML = "";

        if (query.length < 3) return;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&addressdetails=1&limit=5`)
            .then(response => response.json())
            .then(results => {
                results.forEach(result => {
                    const suggestion = document.createElement("div");
                    suggestion.className = "suggestion-item";
                    suggestion.textContent = result.display_name;
                    suggestion.onclick = () => {
                        // Affiche l'adresse lisible dans l'input texte
                        document.getElementById("adresse").value = result.display_name;
                        // Place les coordonnées dans l'input hidden
                        document.getElementById("coordonnees").value = result.lat + ',' + result.lon;
                        suggestionsDiv.innerHTML = "";

                        const lat = parseFloat(result.lat);
                        const lon = parseFloat(result.lon);

                        map.setView([lat, lon], 13);

                        if (marker) {
                            map.removeLayer(marker);
                        }
                        marker = L.marker([lat, lon]).addTo(map);

                        afficherItineraire(lat, lon);
                    };
                    suggestionsDiv.appendChild(suggestion);
                });
            })
            .catch(err => {
                console.error("Erreur de géocodage :", err);
            });
    }

    function afficherItineraire(lat, lon) {
        if (routingControl) {
            map.removeControl(routingControl);
        }

        routingControl = L.Routing.control({
            waypoints: [
                // L.latLng(lat, lon),
                L.latLng(48, 2),
                L.latLng(48.8584, 2.2945) // Tour Eiffel
            ],
            createMarker: () => null,
            routeWhileDragging: true,
            draggableWaypoints: false,
            addWaypoints: false,
            show: false,
            lineOptions: {
                styles: [{
                    color: '#105062',
                    opacity: 0.8,
                    weight: 6
                }]
            },
        }).addTo(map);

        routingControl.on('routesfound', function(e) {
            const route = e.routes[0];
            const bounds = L.latLngBounds(route.coordinates);
            map.fitBounds(bounds);
        });
    }
</script> -->
