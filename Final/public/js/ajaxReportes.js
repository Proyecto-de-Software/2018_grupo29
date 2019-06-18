$(document).ready(function(){ 
	$('#byGender').onclick(function () {
		$.ajax({           
            type:'GET',
            url:'/reports/byGender',
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
