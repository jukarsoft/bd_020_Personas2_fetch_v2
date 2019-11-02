<?php 
	header('Content-Type: text/html; charset=utf-8');
	$contador=0;
	//cookie - contador peticiones
	if (isset($_COOKIE['bd_020_altaPersonas'])) {
		$contador= $_COOKIE['bd_020_altaPersonas'];
	} else {
		//crear cookie
		setcookie('bd_020_altaPersonas', $contador, time()+3600*24*365);
	}

	//conexion bbdd Personas
	require 'conexionPersonas.php';

	//variables
	$codigo='00';
	$mensaje="";
	$respuesta=null;
	$nif=$nombre=$apellidos=$direccion=$telefono=$email=null;

	//validación datos del formulario
	//obtención de las variables recibidas
	$nif=$_POST['nif'];
	$nombre=$_POST['nombre'];
	$apellidos=$_POST['apellidos'];
	$direccion=$_POST['direccion'];
	$telefono=$_POST['telefono'];
	$email=$_POST['email'];
	$nif = addslashes($nif);
	$nombre = addslashes($nombre);
	$apellidos = addslashes($apellidos);
	$direccion = addslashes($direccion);
	$telefono = addslashes($telefono);
	$email = addslashes($email);

	try {
		if (trim($nif)=='') {
			throw new Exception('<<NIF, es un dato obligatorio>>',10);
		};
		if (trim($nombre)=='') {
			throw new Exception('<<Nombre, es un dato obligatorio>>',10);
		};
		if (trim($apellidos)=='') {
			throw new Exception('<<Apellidos, es un dato obligatorio>>',10);
		};
				
		//ALTA -- en bbdd personas tabla personas
		//construir la sentencia SQL BBDD personas tabla personas
		$sql = "INSERT INTO personas VALUES (NULL, '$nif', '$nombre', '$apellidos', '$direccion', '$telefono', '$email')";
		//ejecutar la sentencia SQL
		if (!mysqli_query($bd, $sql)) {
			if (mysqli_errno($bd) == 1062) {
				throw new Exception('<<persona ya existe en la tabla de personas>>',mysqli_errno($bd));
				//clave duplicada (nif)
			} else {echo (mysqli_error($bd));
				throw new Exception('<<error al insertar registro en tabla personas',mysqli_errno($bd));
			}
		} else {
			$mensaje="Registro alta efectuado en tabla personas";
			$idPersona=mysqli_insert_id($bd);
			$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
			$mensaje=json_encode($respuesta);
			echo $mensaje;
			//recuperar el id que el sistema gestor le ha asignado a la persona
			
		}
	} catch (Exception $error){
		//captura de excepciones $error es un objeto de la clase Exception
		$mensaje=$error->getMessage(); //mensaje de error
		$codigo=$error->getCode();//nos muestra el código de error
		//$linea=$error->getLine();//nos muestra en que linea de código se ha producido el error
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		$mensaje=json_encode($respuesta);
		echo $mensaje;
	};
?>