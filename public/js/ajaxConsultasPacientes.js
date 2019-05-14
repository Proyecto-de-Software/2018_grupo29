$(document).ready(function(){ 
	$('#patients').change(function () {
		var id = $(this).find(':selected')[0].value;
		$.ajax({
            
            type:'GET',
            url:'/patient-ajax/'+id,
            data:{'id': id},
            success:function(data) {
            	console.log(data);
            	var options = '';
            	//falta armar el html desde esta funcion, pero los datos estan viniendo bien
            }
        });
    });
});
