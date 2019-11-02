<?php  
//conexion bbdd Personas
	require 'conexionPersonas.php';
	try {
		$pk=$_POST['pk'];
		//montar sentencia sql
		//SELECT 
			//WHERE    
		// ORDER BY
		$sql="SELECT * FROM personas WHERE pk_personas=$pk";
		$resultado=mysqli_query ($bd, $sql);
		if (mysqli_errno($bd)!=0) {
			throw new Exception('<<error al consultar una persona en la tabla de personas >>',mysqli_errno($bd));
		} 
		$personas = array();
		//mientras haya filas se extrae y construye el array asociativo $datosPersonas
		//obtenemos un array asociativo
		while ($datosPersona = mysqli_fetch_assoc($resultado)) {
			//añadimos cada fila de la tabla al array
			array_push($personas, $datosPersona);
		}
		echo json_encode($personas);				
	} catch (Exception $error){
		$codigo=$error->getCode();
		//captura de excepciones $error es un objeto de la clase Exception
		$mensaje=$error->getMessage(); //mensaje de error
		$mensaje.=$error->getLine();//nos muestra en que linea de código se ha producido el error
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);
	}	 
?>