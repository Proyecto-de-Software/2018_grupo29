function login(){
	nombreUsuario = document.getElementById("nombre").value;
	contraUsuario = document.getElementById("contra").value;
	if(nombreUsuario == "admin"){
		alert("aca se redirige al menu de admin");
	} else {
		if(nombreUsuario == 'Jorge'){
			alert("aca se redirige al menu normal");
		} else {
			alert("equivocado");
		}
	}
}