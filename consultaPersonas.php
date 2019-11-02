<?php 
	//conexion bbdd Personas
	require 'conexionPersonas.php';

	try {
		//montar sentencia sql
		//SELECT 
		//WHERE    
		// ORDER BY
		$sql="SELECT * FROM personas ORDER by pk_personas, nombre, apellidos";
		$resultado=mysqli_query ($con, $sql);
		if (mysqli_errno($con)!=0) {
			throw new Exception('<<error al consultar una persona en la tabla de personas >>',mysqli_errno($con));
		} 
		//print_r($resultado);
		//mientras haya filas se extrae y construye el array asociativo $datosPersonas
		//obtenemos un array asociativo
		$personas = array();
		while ($datosPersona = mysqli_fetch_assoc($resultado)) {
			//añadimos cada fila de la tabla al array
			array_push($personas, $datosPersona);

			//print_r($datosPersona);
			//echo "<br>";
		}
		echo json_encode($personas);
	} catch (Exception $error) { 
		$codigo=$error->getCode();
		//captura de excepciones $error es un objeto de la clase Exception
		$mensaje=$error->getMessage(); //mensaje de error
		$mensaje.=$error->getLine();//nos muestra en que linea de código se ha producido el error
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);
	}
?>