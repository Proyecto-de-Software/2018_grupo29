function changeButton(){
	if ($("#toggle").html() == "Mostrar consultas") {
		$("#toggle").html("Ocultar consultas");
	} else {
		$("#toggle").html("Mostrar consultas");
	}
	$("#consultations").toggle();
}