function validarFormularioConsulta() {
	var a = document.getElementById("myTextArea").value;
	var b = document.getElementById("pacientes").value;
	if (b == ''){
		document.getElementById("campo_error").innerHTML = "Por favor, seleccione un paciente";
        return false;
	}
    if (a == '') {
    	document.getElementById("campo_error").innerHTML = "El diagnóstico es obligatorio";
        return false;
    }
    return true;
}