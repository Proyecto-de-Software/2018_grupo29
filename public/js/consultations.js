function changeButton(){
	if ($("#toggle").html() == "Mostrar consultas") {
		$("#toggle").html("Ocultar consultas");
	} else {
		$("#toggle").html("Mostrar consultas");
	}
	$("#consultations").toggle();
}

function modifyText(){
	$("#newConsultation").show();
	$("#newConsultation").html("Crear una consulta para: ");
	$("#newConsultation").append($("#patients option:selected").html());
}