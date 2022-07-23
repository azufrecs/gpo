<?php 
require('config.php');
include ("../security/seguridad.php");
//sleep(1);
if (isset($_POST)) {
    $valor_ci = (string)$_POST['valor_ci'];
    
    $result = $connexion->query(
        'SELECT * FROM tbl_pacientes WHERE ci = "'.strtolower($valor_ci).'"'
    );
    
    if ($result->num_rows > 0) {
		$_SESSION['QUE_BUSCAR'] 		= "ci";
		$_SESSION['CRITERIO_BUSQUEDA']	= $valor_ci; 
						
						
        echo"<script>window.location.href='result.php'; </script>";
    }
}