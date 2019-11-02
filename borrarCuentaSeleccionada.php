<?php 
	require 'conexionPersonas.php';
	try {
		$idcuenta=$_POST['idcuenta'];
		//montar sentencia sql
		$sql="DELETE FROM cuentas WHERE idcuentas='$idcuenta'";
		if (!mysqli_query($bd, $sql)) {
			throw new Exception('<<error al borrar la cuenta>>', mysqli_errno($bd));
		}
		//ha ido todo bien
		$numFilas=mysqli_affected_rows($bd);
		$codigo='00';
		$mensaje="borrado realizado con éxito // num.filas borradas $numFilas";
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);				
	} catch (Exception $error){
		//captura de excepciones $error es un objeto de la clase Exception
		$codigo=$error->getCode();
		$mensaje=$error->getMessage(); //mensaje de error
		//$linea=$error->getLine();//nos muestra en que linea de código se ha producido el error
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);
	}	 



 ?>