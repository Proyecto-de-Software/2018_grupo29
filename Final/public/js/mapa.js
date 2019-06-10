var mymap = L.map('mapDiv').setView([-34.9, -57.95], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(mymap);

function addMarker(x_coord,y_coord){
	L.marker([x_coord, y_coord]).addTo(mymap);
}

