<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet Copia Coordinate</title>

    <!-- Includi Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    
    <!-- Includi Clipboard.js -->
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>

    <style>
        /* Impostazioni della mappa */
        #map {
            width: 100%;
            height: 100vh;
        }

        /* Stile del messaggio di notifica */
        .notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 128, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 5px;
            display: none;
            z-index: 9999;
        }
    </style>
</head>
<body>

    <div id="map"></div>

    <!-- Messaggio di notifica -->
    <div id="notification" class="notification">
        Lat, Lng è stata copiata, incollala dove vuoi!
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        // Creazione della mappa
        var map = L.map('map').setView([41.88, 12.50], 6); // Imposta la vista iniziale (esempio: Londra)

        // Aggiungi il tile layer (mappa di base)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Crea una nuova istanza di Clipboard.js per copiare il testo
        var clipboard = new ClipboardJS('.copy-btn');

        // Funzione per mostrare il messaggio di notifica
        function showNotification(message) {
            var notification = document.getElementById('notification');
            notification.innerText = message;
            notification.style.display = 'block';

            // Nascondi il messaggio dopo 3 secondi
            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000);
        }

        // Evento di click sulla mappa
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6); // Prendi la latitudine con 6 decimali
            var lng = e.latlng.lng.toFixed(6); // Prendi la longitudine con 6 decimali
            var coordinates = lat + ', ' + lng;

            // Usa Clipboard.js per copiare nelle memoria
            var tempTextArea = document.createElement('textarea');
            tempTextArea.value = coordinates;
            document.body.appendChild(tempTextArea);
            tempTextArea.select();
            document.execCommand('copy');
            document.body.removeChild(tempTextArea);

            // Mostra la notifica
            showNotification(`Le coordinate ${coordinates} sono state copiate, incollale dove vuoi!`);
        });
    </script>

</body>
</html>
