$(document).ready(function(){ 
	$('#patients').change(function () {
		var id = $(this).find(':selected')[0].value;
		$.ajax({
            
            type:'GET',
            url:'/patient-ajax/'+id,
            data:{'id': id},
            success:function(data) {
                var createButton = '"><button class="btn btn-success">Ver</button></a>';
                var updateButton = '"><button class="btn btn-warning">Modificar</button></a>';                
                var deleteButton = '"><button class="btn btn-danger" onclick="return confirm('+"'¿Está seguro?'"+')">Borrar</button>';
                var table = $('#table_id').DataTable();
                var consultations_button = '<a href="'+ app_url + '/consultations/'
                var dataToAdd = []
                for (var i = data.length - 1; i >= 0; i--) {
                    dataToAdd[data.length-i-1] = {
                        Fecha: data[i].date,
                        Motivo: data[i].reason.name,
                        Diagnóstico: data[i].diagnostic,
                        Detalle:  consultations_button + data[i].id + createButton,
                        Modificar: consultations_button + data[i].id + '/edit' +  updateButton,
                        Eliminar: consultations_button + + data[i].id + '/destroy' + deleteButton,
                    }
                }
                table.clear();
                table.rows.add(dataToAdd).draw();
            }
        });
    });
});

