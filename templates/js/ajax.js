$(document).ready(function(){  
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
                $("#divLocalidades").html(data);
            }
        });
    });
});




