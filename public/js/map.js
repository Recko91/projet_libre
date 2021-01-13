    // var locations = {
    //     "Chatelet": { "lat": 48.85810230439387, "lon": 2.34817831850331},
    //     "Gare de Lyon": {"lat":48.84369043264488, "lon": 2.373284500119991}
    // };
    
    // initialisation carte 
    var mymap = L.map('mapid').setView([48.852969, 2.349903] , 13);

    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
    attribution: 'Données &copy; <a href="//osm.org/copyright">OpenStreetMap</a> - rendu© <a href="//openstreetmap.fr">OSM France</a>',
    minZoom:5,
    maxZoom: 20
    }).addTo(mymap);

    var icone = L.icon({
        iconUrl: "images/icon_bleu.png",
        iconSize: [50,50],
        iconAnchor: [25,50],
        popupAnchor: [0, -40]
    })

    // for(location in locations){
    // var marker = L.marker([locations[location].lat, locations[location].lon])
    // .addTo(myapp);
    // }

    // création marqueur + popup
    var marker = L.marker([48.852969, 2.349903],
    {icon: icone})
    .addTo(mymap);
    marker.bindPopup("<p>Paris</p>").openPopup();