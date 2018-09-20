function login(){
	nombreUsuario = document.getElementById("nombre").value;
	contraUsuario = document.getElementById("contra").value;
	if(nombreUsuario == "admin"){
		openNewURLInTheSameWindow('administracion.html');
	} else {
		alert("Nombre de usuario incorrecto");
	}
}


function fireClickEvent(element) {
    var evt = new window.MouseEvent('click', {
        view: window,
        bubbles: true,
        cancelable: true
    });

    element.dispatchEvent(evt);
}

function openNewURLInTheSameWindow(targetURL) {
    var a = document.createElement('a');
    a.href = targetURL;
    fireClickEvent(a);
}