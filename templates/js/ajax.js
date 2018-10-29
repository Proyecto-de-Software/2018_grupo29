$(document).ready(function(){  
    //traer partidos con ajax
    $('#partidos').change(function () {
        var id = $(this).find(':selected')[0].value;
        //alert(id);
        $.ajax({
            type: 'POST',
            url: 'index.php?action=obtenerCiudades',
            data: {
                'id': id
            },
            success: function (data) {
                // the next thing you want to do 
                //console.log(data);
                var options = '';
                for (ciudad in data) {
                    options += '<option value="' + data[ciudad].id + '">' + data[ciudad].nombre + '</option>';
                }
                $("#localidades").html(options);
            },
            dataType: "json"
        });
    });
});




