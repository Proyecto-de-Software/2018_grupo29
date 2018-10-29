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

function tieneSoloLetras(string) {
  return /[a-zA-Z]+$/g.test(string);
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