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
