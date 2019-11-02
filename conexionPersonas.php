<?php 
	//host, usuario, password, base de datos
	$con = mysqli_connect('localhost', 'root', '', 'personas2')
	or die("conexion con base de datos fallida");
	mysqli_set_charset($con, "utf8");

	// Check connection
	//if (mysqli_connect_errno())  {
  	//	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	//}
?>