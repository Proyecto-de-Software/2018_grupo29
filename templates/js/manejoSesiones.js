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

function mostrarLocalidades(str) {
    if (str.length == 0) {
        document.getElementById("localidades").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("localidades").innerHTML = this.responseText;
            }
        };
        $_POST['id_partido'] = str;
        xmlhttp.open("POST", "./index.php?action=obtenerLocalidades", true);
        xmlhttp.send();
    }
}
