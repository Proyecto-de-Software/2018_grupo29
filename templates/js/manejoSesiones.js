function validarLogin() {
	var a = document.forms["login"]["nombre"].value;
    var b = document.forms["login"]["contra"].value;
   
    if (b.length < 6) {
    	 document.getElementById("campo_error").innerHTML = "La contraseña tiene menos de 6 caracteres";
        return false;
    }
    if (a.length < 6) {
       document.getElementById("campo_error").innerHTML = "El nombre de usuario tiene menos de 6 caracteres";
        return false;
    }
}


function confirmacion($msj) {
  if (confirm($msj)){
       document.tuformulario.submit()
    }
  else {
        return false;
    }
}

function confirmacionEliminacion(){
  if (confirm('¿Está seguro que quiere eliminar esta consulta?')){
       document.tuformulario.submit()
    }
  else {
        return false;
    }
}

function tieneSoloLetras(string) {
  return /[a-zA-Z]+$/g.test(string);
}

function tieneSoloNumeros(parametro) {
  return /[0-9]+$/g.test(parametro);
}

function validarAltaUsuario() {
  var contra1 = document.forms["formularioAltaUsuario"]["password"].value;
  var contra2 = document.forms["formularioAltaUsuario"]["password2"].value;
  var first_name = document.forms["formularioAltaUsuario"]["first_name"].value;
  var last_name = document.forms["formularioAltaUsuario"]["last_name"].value;
  var email = document.forms["formularioAltaUsuario"]["email"].value;
  var username = document.forms["formularioAltaUsuario"]["username"].value;

  if (! tieneSoloLetras(first_name)) {
    document.getElementById("campo_error").innerHTML = "El nombre debe tener solo letras";
    return false;
  }

  if (! tieneSoloLetras(last_name)) {
    document.getElementById("campo_error").innerHTML = "El apellido debe tener solo letras";
    return false;
  }

  if (contra1.length < 6) {
    document.getElementById("campo_error").innerHTML = "La contraseña debe tener 6 caracteres como mínimo";
    return false;
  }

  if (contra1 != contra2) {
    document.getElementById("campo_error").innerHTML = "Las contraseñas no coinciden";
    return false;
  }
  
  if (username.length < 6) {
    document.getElementById("campo_error").innerHTML = "El nombre de usuario debe tener 6 caracteres como mínimo";
    return false;
  }

  return true;
}


function validarAltaPaciente() {
  var nombre = document.forms["formularioAltaPaciente"]["nombre"].value;
  var apellido = document.forms["formularioAltaPaciente"]["apellido"].value;
  var nro_historia_clinica = document.forms["formularioAltaPaciente"]["nro_historia_clinica"].value;
  var nro_carpeta = document.forms["formularioAltaPaciente"]["nro_carpeta"].value;
  var tel = document.forms["formularioAltaPaciente"]["tel"].value;
  var numeroDocumento = document.forms["formularioAltaPaciente"]["numero"].value;
  
   if (! tieneSoloLetras(nombre)) {
    document.getElementById("campo_error").innerHTML = "El nombre debe tener solo letras";
    return false;
  }

  if (! tieneSoloLetras(apellido)) {
    document.getElementById("campo_error").innerHTML = "El apellido debe tener solo letras";
    return false;
  }

  if (! tieneSoloNumeros(numeroDocumento)) {
     document.getElementById("campo_error").innerHTML = "El número de documento debe tener solo números";
    return false;
  }

  if (nro_historia_clinica != '')  {
    if ((! tieneSoloNumeros(nro_historia_clinica)) || (nro_historia_clinica.length > 6)) {
      document.getElementById("campo_error").innerHTML = "El número de historia clínica debe tener solo números y 6 dígitos como máximo";
      return false;
    }
  }

  if (nro_carpeta != '') {
    if ((! tieneSoloNumeros(nro_carpeta)) || (nro_carpeta.length > 5)) {
      document.getElementById("campo_error").innerHTML = "El número de carpeta debe tener solo números y 5 dígitos como máximo";
      return false;
    }
  }

  if (tel != '') {
    if ((! tieneSoloNumeros(tel)) || (tel.length < 8)) {
      document.getElementById("campo_error").innerHTML = "El número de teléfono debe tener sólo números y al menos 8 dígitos";
      return false;
    }
  }

  return true;

}
