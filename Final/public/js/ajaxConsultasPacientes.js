$(document).ready(function(){ 
	$('#patients').change(function () {
		var id = $(this).find(':selected')[0].value;
		$.ajax({
            
            type:'GET',
            url: app_url +'/patient-ajax/'+id,
            data:{'id': id},
            success:function(data) {
                var table = $('#table_id').DataTable();
                if(show){
                    var show_button = '<a href="'+ app_url + '/consultations/';
                    var showButton = '"><button class="btn btn-success">Ver</button></a>';
                } else {
                    var show_button = '<p name="';
                    var showButton = '"></p>';
                }
                if(update){
                    var update_button = '<a href="'+ app_url + '/consultations/edit/';
                    var updateButton = '"><button class="btn btn-warning">Modificar</button></a>';
                } else {
                    var update_button = '<p name="';
                    var updateButton = '"></p>';
                }
                if(destroy){
                    var destroy_button = '<a href="'+ app_url + '/consultations/destroy/';
                    var destroyButton = '"><button class="btn btn-danger" onclick="return confirm('+"'¿Está seguro?'"+')">Borrar</button>';
                } else {
                    var destroy_button = '<p name="';
                    var destroyButton = '"></p>';
                }
                var dataToAdd = []
                for (var i = data.length - 1; i >= 0; i--) {
                    dataToAdd[data.length-i-1] = {
                        Fecha: data[i].date,
                        Motivo: data[i].reason.name,
                        Diagnóstico: data[i].diagnostic,
                        Detalle:  show_button + data[i].id + showButton,
                        Modificar: update_button + data[i].id +  updateButton,
                        Eliminar: destroy_button + data[i].id + destroyButton,
                    }
                }
                table.clear();
                table.rows.add(dataToAdd).draw();
            }
        });
    });
});

