function login(){
	nombreUsuario = document.getElementById("nombre").value;
	contraUsuario = document.getElementById("contra").value;
	if(nombreUsuario == "admin"){
		window.location.href = 'administracion.html';
		//console.log(window.location);
		//window.location = '/ProyectoSoftware/administracion.html';
		//window.location.pathname = 'administracion.html'
		//window.location.replace('http://www.google.com');
		//window.location.href = 'D:/ProgrammingPrograms/xampp/htdocs/ProyectoSoftware/administracion.html';
		//window.location = './administracion.html';
	} else {
		if(nombreUsuario == 'Jorge'){
			alert("aca se redirige al menu normal");
		} else {
			alert("Nombre de usuario incorrecto");
		}
	}
}