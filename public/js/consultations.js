function changeButton(){
	if ($("#toggle").html() == "Mostrar consultas") {
		$("#toggle").html("Ocultar consultas");
	} else {
		$("#toggle").html("Mostrar consultas");
	}
	$("#consultations").toggle();
}

function modifyText(){
	$("#newConsultation").html("Crear una consulta para: ");
	$("#newConsultation").append($("#patients option:selected").html());
	$("#newConsultation").attr("href",app_url + '/consultations/create/' + $("#patients option:selected").val());
	$("#map_button").attr("href",app_url + '/consultations/map/' + $("#patients option:selected").val());
	$("#toggle").show();
	$("#newConsultation").show();
}