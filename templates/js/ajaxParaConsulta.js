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
                var isAuthenticated = $('.js-user-rating').data('isAuthenticated');
                console.log(data);
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
                
                console.log()
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