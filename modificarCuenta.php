<?php 
	//conexion bbdd Personas
	require 'conexionPersonas.php';
	try {
		$idcuenta=$_POST['idcuenta'];
		$entidad=$_POST['entidad'];
		$oficina=$_POST['oficina'];
		$dc=$_POST['dc'];
		$numcuenta=$_POST['cuenta'];
		$saldo=$_POST['saldo'];

		$sql="UPDATE cuentas SET saldo='$saldo' WHERE idcuentas='$idcuenta'";
		if (!mysqli_query ($bd, $sql)) {
			throw new Exception("error al modificar", mysqli_errno($bd));
		} 
		
		$numFilas=mysqli_affected_rows($bd);
		$mensaje="modificación realizada con éxito /// 00 /// $numFilas";
		$respuesta=array('codigo'=>'00', 'mensaje'=> $mensaje);
		echo json_encode($respuesta);				

	} catch (Exception $error) {
		$codigo=$error->getCode();
		//captura de excepciones $error es un objeto de la clase Exception
		$mensaje=$error->getMessage(); //mensaje de error
		$mensaje.=$error->getLine();//nos muestra en que linea de código se ha producido el error
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);
	}
?>