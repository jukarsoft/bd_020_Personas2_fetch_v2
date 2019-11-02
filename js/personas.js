//VARIABLES
var arrayRespuesta= Array();
var notas='';
var valor=null;

window.onload=function(){
	//detectar la pulsación del boton enviar
	//activar listener	
	document.getElementById('enviar').addEventListener('click', enviarFormulario);
	document.getElementById('borrar').addEventListener('click', borrarPersona);
	document.getElementById('modificar').addEventListener('click', modificarPersona);
	document.getElementById('cuentas').addEventListener('click', consultaCuentas);
	document.getElementById('texto').value="";
	document.getElementById('modificar').style.display='none'; 
	document.getElementById('borrar').style.display='none'; 
	document.getElementById('cuentas').style.display='none'; 
	//consulta a la bbdd para mostrar en el formulario la relación de personas
	consultaPersonas();
}

function consultaCuentas() {
	//alert ('consultaCuentas');
	//recuperar el id de la persona
	var id=document.getElementById('pk').value;
	//var id=this.firstChild;
	//alert (id);
	//validar que el id que esta informado
	if (id=='') {
		alert ('falta seleccionar una persona');
		return
	}
	window.location.href='cuentas.html?pk='+id;

}

//consulta de todo el contenido sobre la tabla personas // SELECT 
function consultaPersonas() {
	document.getElementById('listapersonas').innerHTML="";
	fetch ('consultaPersonas.php', {
		method: 'POST'
	})
	.then(function(respuesta) {
		if (respuesta.ok) {
			//cambiar el json a text, si queremos ver el error
			return respuesta.json();
		} else {
			throw "error en la llamada AJAX",88;
		}
	})
	.then(function(datos) {
		//datos es un array js
		//alert (datos);
		var tabla="<tr><th>id</th><th>nif</th><th>nombre</th><th>apellidos</th></tr>";
		for (i in datos) {
			tabla+="<tr class='tr'>";
				tabla+=`<td class='pk'>${datos[i]['pk_personas']}</td>`;
				tabla+=`<td>${datos[i]['nif']}</td>`;
				//tabla+=`<td>${datos[i].nif}</td>`; //otra manera de recoger el objeto
				tabla+=`<td>${datos[i]['nombre']}</td>`;
				tabla+=`<td>${datos[i]['apellidos']}</td>`;
			tabla+="</tr>";
			
		}
		document.getElementById('listapersonas').innerHTML+=tabla;
		//se activa por cada linea de registro ('tr') class='tr' un listener
		 var fila=document.querySelectorAll('.tr');
		for (i=0;i<fila.length;i++) {
			fila[i].addEventListener('click', consultaPersona);
			fila[i].style.cursor="pointer";
		}

		console.log(datos);
	})
	.catch(function (error) {
		if (error.codigo!='00') {
			alert ('error:' + error.codigo + ' ' + error.mensaje);
		} 
		notas="error en la consulta sobrd la tabla personas"
		document.getElementById('texto').value=notas;
	})
}

//select sobre la primary key de la tabla de personas
function consultaPersona() {
	//alert ("consultaPersona");
	document.getElementById('nif').classList.remove('error');
	document.getElementById('nombre').classList.remove('error');
	document.getElementById('apellidos').classList.remove('error');
	var id=this.firstChild;
	//alert (id.innerText);
	var datos = new FormData();
	datos.append('pk',id.innerText);
	fetch('consultaPersonaSeleccionada.php',{
		method: 'POST',
		body: datos
	})
	.then(function(respuesta) {
		//primera respuesta del servidor como que ha recibido la petición
		if (respuesta.ok) {
			return respuesta.json();
		} else {
			throw "error en la llamada AJAX",88;
		}
	})
	. then (function(datos) {
		//servidor a procesado los datos y nos lo devuelve
		//alert (datos);
			for (i in datos) {
				document.getElementById('pk').value=datos[i]['pk_personas'];
				document.getElementById('nif').value=datos[i]['nif'];
				document.getElementById('nombre').value=datos[i]['nombre'];
				document.getElementById('apellidos').value=datos[i]['apellidos'];
				document.getElementById('direccion').value=datos[i]['direccion'];
				document.getElementById('telefono').value=datos[i]['telefono'];
				document.getElementById('email').value=datos[i]['email'];
			}
		document.getElementById('texto').value="consulta realizada con éxito";
		document.getElementById('modificar').style.display='initial'; 
		document.getElementById('borrar').style.display='initial'; 
		document.getElementById('cuentas').style.display='initial'; 
		//document.getElementById('enviar').style.display='initial'; 
		
	})
	.catch(function(error) {
		//captura de los errores
		if (error.codigo!='00') {
			alert ('error:' + error.codigo + ' ' + error.mensaje);
			notas = error.codigo + ' ' + error.mensaje;
			document.getElementById('texto').value=notas;
		} 
		
		 
	})
}

//envia formulario para dar de alta una nueva persona
function enviarFormulario() {
	//alert ('enviarFormulario');
	document.getElementById('nif').classList.remove('error');
	document.getElementById('nombre').classList.remove('error');
	document.getElementById('apellidos').classList.remove('error');
	document.getElementById('texto').value="";
	
	var nif = document.getElementById('nif').value;
	var nombre = document.getElementById('nombre').value;
	var apellidos = document.getElementById('apellidos').value;
	var direccion = document.getElementById('direccion').value;
	var telefono = document.getElementById('telefono').value;
	var email = document.getElementById('email').value;
	//validar formulario
	if (nif.trim()=='' || nif.length<9) {
		document.getElementById('nif').classList.add('error');
	}
	if (nombre.trim()=='') {
		document.getElementById('nombre').classList.add('error');
	}
	if (apellidos.trim()=='') {
		document.getElementById('apellidos').classList.add('error');
	}
	
	if (nombre.trim()=='' || apellidos.trim()=='' || nif.trim()=='') {
		alert ('nif, nombre, y apellidos, son datos obligatorios');
		document.getElementById('texto').value="nif, nombre, y apellidos, son datos obligatorios";
		return;
	}
	if (nif.length<9) {
		alert ('formato del nif no correcto');
		document.getElementById('texto').value="formato del nif no correcto";
		return;
	}
	valor=validarNIF(nif);
	if (!valor) {
		alert ('nif no válido');
		document.getElementById('texto').value="nif no válido";
		return;
	}
	
	//formateo datos o encapsulado de datos al servidor 
	//para enviar al servidor clave:pareja:valor
	//creamos un objeto
	var datos = new FormData();
	datos.append('nif',nif);
	datos.append('nombre',nombre);
	datos.append('apellidos',apellidos);
	datos.append('direccion',direccion);
	datos.append('telefono',telefono);
	datos.append('email',email);

	//llamada AJAX al servidor
	fetch('bd_020_altaPersona.php',{
		method: 'POST',
		body: datos
	})
	.then(function(respuesta) {
		//primera respuesta del servidor como que ha recibido la petición
		if (respuesta.ok) {
			return respuesta.json();
		} else {
			throw "error en la llamada AJAX",88;
		}
	})
	. then (function(datos) {
		//servidor a procesado los datos y nos lo devuelve
		//alert (datos);
		if (datos.codigo=='00') {
			notas =datos.mensaje;
			notas+='\n';
			notas+='fin proceso - complete function'
			document.getElementById('texto').value=notas;
			document.getElementById('nif').value="";
			document.getElementById('nombre').value="";
			document.getElementById('apellidos').value="";
			document.getElementById('direccion').value="";
			document.getElementById('telefono').value="";
			document.getElementById('email').value="";
			document.getElementById('texto').value=notas;
			alert ('codigo respuesta ok, se ha dado de alta la persona');
			//alert ('complete');
		} else {
			notas = datos.codigo + ' ' + datos.mensaje;
			document.getElementById('texto').value=notas;
		}
		consultaPersonas();
	})
	.catch(function(error) {
		//captura de los errores
		//alert (error);
		if (error.codigo!='00') {
			alert ('error:' + error.codigo + ' ' + error.mensaje);
			notas = error.codigo + ' ' + error.mensaje;
			document.getElementById('texto').value=notas;
		} 
		
		 
	})
}

//borra los datos de la persona
function borrarPersona() {
	//alert ('borradoPersona');
	var datos = new FormData();
	var pk=document.getElementById('pk').value
	//validar si hay seleccionado una persona
	if (pk=='') { 
		return
	}
	datos.append('pk',pk);
	fetch('borrarPersonaSeleccionada.php',{
		method: 'POST',
		body: datos
	})
	.then(function(respuesta) {
		//primera respuesta del servidor como que ha recibido la petición
		if (respuesta.ok) {
			return respuesta.json();
		} else {
			throw "error en la llamada AJAX";
		}
	})
	. then (function(datos) {
		//servidor a procesado los datos y nos lo devuelve
		//alert (datos);
		if (datos.codigo == '1451') {
			document.getElementById('texto').value="persona con cuentas asociadas, no puede borrarse";
			return
		}
		else if (!datos.codigo=='00'){
			document.getElementById('texto').value=datos.codigo + ' ' + datos.mensaje;
			return
		}
		document.getElementById('formulario').reset();
/*		document.getElementById('pk').value="";
		document.getElementById('nif').value="";
		document.getElementById('nombre').value="";
		document.getElementById('apellidos').value="";
		document.getElementById('direccion').value="";
		document.getElementById('telefono').value="";
		document.getElementById('email').value="";
*/	
		document.getElementById('texto').value="borrado registro persona realizado con éxito";
/*		var tr=document.getElementsByClassName('tr');
		for (i=0; i<tr.length;i++) {
			tr[i].parentNode.removeChild(tr[i]);
		}
*/		
		consultaPersonas();
		document.getElementById('modificar').style.display='none'; 
		document.getElementById('borrar').style.display='none'; 
		document.getElementById('enviar').style.display='initial'; 
		document.getElementById('cuentas').style.display='none'; 
		//document.getElementById('modificar').disabled=true;
		//document.getElementById('borrar').disabled=true;
		//document.getElementById('enviar').disabled=false;
		
	})
	.catch(function(error) {
		//captura de los errores
		//alert (error);
		if (error.codigo!='00') {
			alert ('error:' + error.codigo + ' ' + error.mensaje);
			notas = error.codigo + ' ' + error.mensaje;
			document.getElementById('texto').value=notas;
		} 
	})
}

//modificación de los datos de la persona
function modificarPersona() {
	//alert ('modificarPersona');

	//recuperar los datos del formulario
	var pk = document.getElementById('pk').value;
	var nif = document.getElementById('nif').value;
	var nombre = document.getElementById('nombre').value;
	var apellidos = document.getElementById('apellidos').value;
	var direccion = document.getElementById('direccion').value;
	var telefono = document.getElementById('telefono').value;
	var email = document.getElementById('email').value;

	//validar si hay seleccionado una persona
	if (pk=='') { 
		return
	}
	//petición al servidor
	//formateo datos o encapsulado de datos al servidor 
	//para enviar al servidor clave:pareja:valor
	//creamos un objeto
	var datos = new FormData();
	datos.append('pk',pk);
	datos.append('nif',nif);
	datos.append('nombre',nombre);
	datos.append('apellidos',apellidos);
	datos.append('direccion',direccion);
	datos.append('telefono',telefono);
	datos.append('email',email);
	
	//llamada AJAX al servidor
	fetch('modificarPersonas.php',{
		method: 'POST',
		body: datos
	})
	.then(function(respuesta) {
		//primera respuesta del servidor como que ha recibido la petición
		if (respuesta.ok) {
			return respuesta.json();
		} else {
			throw "error en la llamada AJAX",88;
		}
	})
	. then (function(datos) {
		//servidor a procesado los datos y nos lo devuelve
		//alert (datos);
		if (datos.codigo=='00') {
			alert ('codigo respuesta ok, modificación persona realizada');
			notas =datos.mensaje;
			notas+='\n';
			notas+='fin proceso - complete function'
			document.getElementById('texto').value=notas;
			document.getElementById('formulario').reset();
/*			document.getElementById('nif').value="";
			document.getElementById('nombre').value="";
			document.getElementById('apellidos').value="";
			document.getElementById('direccion').value="";
			document.getElementById('telefono').value="";
			document.getElementById('email').value="";
*/			
			document.getElementById('texto').value=notas;
			document.getElementById('modificar').style.display='none'; 
			document.getElementById('borrar').style.display='none'; 
			document.getElementById('enviar').style.display='initial'; 
			document.getElementById('cuentas').style.display='none'; 
			//alert ('complete');
		} else {
			notas = datos.codigo + ' ' + datos.mensaje;
			document.getElementById('texto').value=notas;
		}
		consultaPersonas();
	})
	
	.catch(function(error) {
		//captura de los errores
		//alert (error);
		if (error.codigo!='00') {
			alert ('error:' + error.codigo + ' ' + error.mensaje);
			notas = error.codigo + ' ' + error.mensaje;
			document.getElementById('texto').value=notas;
		} 
	})

}

//valida el NIF
function validarNIF(nif) {
var lockup = 'TRWAGMYFPDXBNJZSQVHLCKE';
	var valueNif=nif.substr(0,nif.length-1);
	var letra=nif.substr(nif.length-1,1).toUpperCase();
 
	if(lockup.charAt(valueNif % 23)==letra)
		return true;
	return false;
}