<?php  
//conexion bbdd Personas
	require 'conexionPersonas.php';
	try {
		$pk=$_POST['pk'];
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
		//montar sentencia sql
		$sql="UPDATE personas SET nif='$nif', nombre='$nombre', apellidos='$apellidos', direccion='$direccion', telefono='$telefono', email='$email' WHERE pk_personas='$pk'";
		$resultado=mysqli_query ($bd, $sql);
		if (mysqli_errno($bd)==1062)  {
			throw new Exception("error al modificar", mysqli_errno($bd));
		}
		$codigo='00';
		$numFilas=mysqli_affected_rows($bd);
		$mensaje="modificación realizada con éxito /// $resultado /// $numFilas";
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);				
	} catch (Exception $error){
		$codigo=mysqli_errno($bd);
		//captura de excepciones $error es un objeto de la clase Exception
		$mensaje=$error->getMessage(); //mensaje de error
		$mensaje.=$error->getLine();//nos muestra en que linea de código se ha producido el error
		$respuesta=array('codigo'=>$codigo, 'mensaje'=> $mensaje);
		echo json_encode($respuesta);
	}	 
?>