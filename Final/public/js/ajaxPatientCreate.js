$(document).ready(function(){ 
	$('#partidos').change(function () {
		var id = $(this).find(':selected')[0].value;
		$.ajax({           
            type:'GET',
            url: app_url + '/patient-ajax/partido/'+id,
            data:{'id': id},
            success:function(data) {
            	var options = '';
            	for (localidades in data) {
            		options += '<option value=" ' + data[localidades].id +'"> ' + data[localidades].nombre + ' </option>';
            	}
            	$("#localidades").html(options);
            }
        });
    });
});
