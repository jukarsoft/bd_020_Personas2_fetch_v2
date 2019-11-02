<?php  
//conexion bbdd Personas
	require 'conexionPersonas.php';
	try {
		$id=$_POST['idcuenta'];
		//montar sentencia sql
		//SELECT 
			//WHERE    
		// ORDER BY
		$sql="SELECT * FROM cuentas WHERE idcuentas='$id'";
		$resultado=mysqli_query ($bd, $sql);
		if (mysqli_errno($bd)!=0) {
			throw new Exception('<<error al consultar una cuenta en la tabla de cuentas',mysqli_errno($bd));
		} 
		$cuentas = array();
		//mientras haya filas se extrae y construye el array asociativo $datosPersonas
		//obtenemos un array asociativo
		while ($datosCuenta = mysqli_fetch_assoc($resultado)) {
			//añadimos cada fila de la tabla al array
			array_push($cuentas, $datosCuenta);
		}
		echo json_encode($cuentas);				
	} catch (Exception $error){
		$codigo=$error->getCode();
		//captura de excepciones $error es un objeto de la clase Exception
		$mensaje=$error->getMessage(); //mensaje de error
		$mensaje.=$error->getLine();//nos muestra en que linea de código se ha producido el error
		$cuentas=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($cuentas);
	}	 
?>