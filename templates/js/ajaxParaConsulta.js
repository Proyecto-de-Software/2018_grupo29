$(document).ready(function(){  
    $('#pacientes').change(function () {
        var id = $(this).find(':selected')[0].value;
        $.ajax({
            type: 'POST',
            url: 'index.php?action=obtenerConsultas',
            data: {
                'id': id
            },
            success: function (data) {
                var options = '';
                var isAuthenticated = $('.js-user-rating').data('isAuthenticated');
                if (data.length != 0){
                    options += '<div id="mapdiv" class="mapdiv" style="height: 300px; margin-left: 10%; margin-right:10%"></div>';
                    options += '<ul id="lista" class="list-group">'
                    options += '<li class="list-group-item row d-flex text-center">';
                    options += '<div id="consultas" class="row container-fluid">';
                    options += '<div class="col-2 text-info"> Fecha </div>';
                    options += '<div class="col-2 text-info"> Motivo </div>';
                    options += '<div class="col-5 text-info"> Diagnóstico </div>';
                    options += '<div class="col-1 text-info"></div>';
                    options += '<div class="col-1 text-info"></div>';
                    options += '<div class="col-1 text-info"></div>';
                    options += '</div>';
                    options += '</li>';
                    options += '</ul>';
                } else {
                    options += '<p class="alMedio text-center">No hay consultas previas</p>';
                }
                for (consulta in data) {
                	options += '<li class="list-group-item row d-flex text-center">';
                    options += '<div id="consultas" class="row container-fluid">';
                    options += '<div class="col-2">' + data[consulta].fecha + '</div>';
                    options += '<div class="col-2">' + data[consulta].nombre + '</div>';
                    options += '<div class="col-5">' + data[consulta].diagnostico + '</div>';
                    options += '<div class="col-1"> <form method="POST" action="./index.php?action=showConsulta"><input type="hidden" name="id_consulta" value="'+ data[consulta].id +'"> <input type="submit" name="Ver" value="Ver" class="btn btn-success"></form> </div>';
                    options += '<div class="col-1"> <form method="POST" action="./index.php?action=editConsulta"><input type="hidden" name="id_consulta" value="'+ data[consulta].id +'"> <input type="submit" name="Editar" value="Editar" class="btn btn-warning"></form> </div>';                    
                    if (isAuthenticated) {
                        options += '<div class="col-1"><form onsubmit="return confirmacionEliminacion()" method="POST" action="./index.php?action=deleteConsulta"><input type="hidden" name="id_consulta" value="'+ data[consulta].id +'"> <input type="submit" name="Eliminar" value="Eliminar" class="btn btn-danger"></form></div>';
                    }
                    options += '</div>';
                    options += '</li>';
                }
                $("#lista").html(options);
                map = new OpenLayers.Map("mapdiv");
                map.addLayer(new OpenLayers.Layer.OSM());
                //var icon = new OpenLayers.Icon('./templates/img/marker.png');
    
                for (var i = data.length - 1; i >= 0; i--) {
                    var lonLat = new OpenLayers.LonLat( data[i].Y, data[i].X ).transform(
                        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                        map.getProjectionObject() // to Spherical Mercator Projection
                    );
          
                    var zoom=16;

                    var markers = new OpenLayers.Layer.Markers( "Markers" );
                    map.addLayer(markers);
                    var size = new OpenLayers.Size(21,25);
                    var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
                    var icon = new OpenLayers.Icon('./templates/img/marker.png', size, offset);
                    markers.addMarker(new OpenLayers.Marker(lonLat,icon));
    
                    map.setCenter (lonLat, zoom);
                }
                /*var vectorSource = new ol.source.Vector({
                    features: features      //add an array of features
                });
                var vectorLayer = new ol.layer.Vector({
                    source: vectorSource
                });
                map.addLayer(vectorLayer);*/
            },
            dataType: "json"
        });
    });
});

$(document).ready(function(){
    $("#botonConsulta").click(function(){
        $("#lista").toggle();
    });
});