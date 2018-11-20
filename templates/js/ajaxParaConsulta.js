$(document).ready(function(){  
    //traer partidos con ajax
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
                console.log(data);
                options += '<li class="list-group-item row d-flex text-center">';
                options += '<div class="col-1 text-info"> Fecha </div>';
                options += '<div class="col-1 text-info"> Motivo </div>';
                options += '<div class="col-1 text-info"> Acompañantes </div>';
                options += '<div class="col-1 text-info"> Trat. farmacológico </div>';
                options += '<div class="col-3 text-info"> Diagnóstico </div>';
                options += '<div class="col-2 text-info"> Observaciones </div>';
                options += '<div class="col-1 text-info"> ¿Fue internado?</div>';
                options += '<div class="col-2 text-info"> Articulación con otras instituciones </div>';
                for (consulta in data) {
                	if (data[consulta].internacion == 1) {
                    	var internacion = 'Sí';
                    }
                    else {
                    	var internacion = 'No';
                    }
                	options += '<li class="list-group-item row d-flex text-center">';
                    options += '<div class="col-1">' + data[consulta].fecha + '</div>';
                    options += '<div class="col-1">' + data[consulta].nombre + '</div>';
                    options += '<div class="col-1">' + data[consulta].nombre_acompanamiento + '</div>';
                    options += '<div class="col-1">' + data[consulta].nombre_tratamiento + '</div>';
                    options += '<div class="col-3">' + data[consulta].diagnostico + '</div>';
                    options += '<div class="col-2">' + data[consulta].observaciones + '</div>';
                    options += '<div class="col-1">' + internacion + '</div>';
                    options += '<div class="col-2">' + data[consulta].articulacion_con_instituciones + '</div>';    
                    options += '</li>';
                }
                $("#lista").html(options);
            },
            dataType: "json"
        });
    });
});

$(document).ready(function(){
    $("#botonConsulta").click(function(){
        $("#consultas").toggle();
    });
});