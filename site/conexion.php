<?php
/*Datos de conexion a la base de datos*/
function connection(){
	$servidor = "localhost";
	$usuario = "gpo";
	$passwords = "gpo2012*/";
	$bd= "gpo";
	
	/* Create connexion*/
	$connection = mysqli_connect($servidor, $usuario, $passwords, $bd);
	return  $connection;
}
	/* Chequeando Conexion*/
	if(connection()){
		echo "Conectado";
	}else{
		echo "No Conectado";
	}
?>