<?php  
//conexion bbdd Personas
	require 'conexionPersonas.php';
	try {
		$pk=$_POST['pk'];
		//montar sentencia sql
		$sql="DELETE FROM personas WHERE pk_personas='$pk'";
		if (!mysqli_query($bd, $sql)) {
			//se han producido errores
			if (mysqli_errno($bd) == 1451) {
				throw new Exception('<<persona con cuentas relacionadas>>',mysqli_errno($bd));
			} else {
				throw new Exception('<<errores al borrar una persona de la tabla personas>>',mysqli_errno($bd));
			}
		}
		//ha ido todo bien
		$numFilas=mysqli_affected_rows($bd);
		$codigo=mysqli_errno($bd);
		$mensaje="borrado realizado con éxito // num.filas borradas $numFilas";
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);				
	} catch (Exception $error){
		//captura de excepciones $error es un objeto de la clase Exception
		$codigo=$error->getCode();
		$mensaje=$error->getMessage(); //mensaje de error
		$mensaje=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		//$linea=$error->getLine();//nos muestra en que linea de código se ha producido el error
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);
	}	 
?>
