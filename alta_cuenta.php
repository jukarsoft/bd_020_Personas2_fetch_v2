<?php 
	header('Content-Type: text/html; charset=utf-8');
	//conexion bbdd Personas
	require 'conexionPersonas.php';
	try {
		$pk_personas=$_POST['pk'];
		$entidad=$_POST['entidad'];
		$oficina=$_POST['oficina'];
		$dc=$_POST['dc'];
		$cuenta=$_POST['cuenta'];
		$saldo=$_POST['saldo'];
		if (trim($entidad)=='') {
			throw new Exception('<<Entidad no informada>>',10);
		};
		if (trim($oficina)=='') {
			throw new Exception('<<Oficina no informada>>',10);
		};
		if (trim($dc)=='') {
			throw new Exception('<<DC no informado>>',10);
		};
		if (trim($saldo)=='') {
			throw new Exception('<<Saldo no informado>>',10);
		};
		$cuenta=4009900000 + rand(1,99999);
		mysqli_autocommit($bd,FALSE);
		$sql = "INSERT INTO cuentas VALUES (NULL, '$entidad', '$oficina', '$dc', '$cuenta', '$saldo')";
		if (!mysqli_query($bd, $sql)) {
			if (mysqli_errno($bd) == 1062) {
				throw new Exception('<<cuenta ya existe en la tabla de cuentas>>',mysqli_errno($bd));
				//clave duplicada (nif)
			} else {throw new Exception('<<error al insertar registro en tabla cuentas',mysqli_error($bd));
			  }
		} 
		$idcuentas= mysqli_insert_id($bd);
		$sql = "INSERT INTO personascuentas VALUES ('$pk_personas','$idcuentas')";
		if (!mysqli_query($bd, $sql)) {
			if (mysqli_errno($bd) == 1062) {
				throw new Exception('<<persona/cuenta ya existe en la tabla de personas/cuentas>>',mysqli_errno($bd));
				//clave duplicada (nif)
			} else {throw new Exception('<<error al insertar registro en tabla personas/cuentas',mysqli_error($bd));
			  }
		} 
		mysqli_commit($bd);
		$codigo='00';
		$mensaje="alta realizada con exito";
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);
	} catch (Exception $error){
		//captura de excepciones $error es un objeto de la clase Exception
		$mensaje=$error->getMessage(); //mensaje de error
		$codigo=$error->getCode();//nos muestra el código de error
		//$linea=$error->getLine();//nos muestra en que linea de código se ha producido el error
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);
		
	}	
?>