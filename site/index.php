<?php
	include ("security/seguridad.php");
	include ("class/message.php");
	include ("conn/conn.php");
	setlocale (LC_TIME,"spanish");
	header('Content-Type:text/html; charset=UTF-8');
	
	//CONFIGURACION DE BOTONES
	$BOTONES_NAVEGACION = "
		<div class='col-md-12' align='center'>
			<div class='btn-group btn-group-sm'>
			<a type='button' class='btn btn-outline-warning text-dark' href='security/onco.php' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para Salir y acceder a la Web ONCO'>Web ONCO</a>
				<a type='button' class='btn btn-warning' href='security/login.php' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para cambiar de usuario'>Salir [" . $_SESSION['user'] . "]</a>
			</div>
		</div>";
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<!-- Etiquetas <meta> obligatorias para Bootstrap -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="../img/favicon.svg">
		<title>Gesti&oacute;n de Pacientes ONCO</title>

		<!-- Enlazando el CSS de Bootstrap -->
		<link href="../css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="../css/main.css" rel="stylesheet" media="screen">
		<link href="../css/icons.css" rel="stylesheet" media="screen">
		<!-- Enlazando el CSS de Bootstrap -->
		
		<!-- Opcional: enlazando el JavaScript de Bootstrap -->
		<script src="../js/jquery-3.5.1.js"></script>
		<script src="../js/popper.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/main.js"></script>
		<script src="../js/icons.js"></script>
		<!-- Opcional: enlazando el JavaScript de Bootstrap -->
	</head>
	
	<body>
		<div class="container" align="center">
			<div class="content" align="center">
				<!-- Inicio de Encabezado -->
				<div class="row quitar_espacios">
					<div class="col" align="center"><i class='fas fa-procedures fa-7x text-danger'></i></div>
				</div>	
				
				<div align="center" style="color:#666666; font-size:24px">Men&uacute; inicial, seleccione la acci&oacute;n a realizar</div>
				<div align="center" style="color:#eeeeee; font-size:10px">&nbsp;</div>	
				<!-- Fin de Encabezado -->
				
				<div align="center">	
					<div class='row'>
						<div class='col-sm'></div>
						<div class='col-md-8'>
							<div class='row'>
								<div class='col-md-4'>
									<a href='patients/' data-toggle='tooltip' class='btn btn-lg btn-success btn-block' role='button'><br><i class='fas fa-5x fa-pen'></i><br><br><br>Captar Paciente</a>
								</div>
								
								<div class='col-md-4'>
									<a href='patients/search.php' data-toggle='tooltip' class='btn btn-lg btn-info btn-block' role='button'><br><i class='fas fa-5x fa-search'></i><br><br><br>Buscar Paciente</a>
								</div>

								<div class='col-md-4'>
									<a href='patients/summary.php' data-toggle='tooltip' class='btn btn-lg btn-secondary btn-block' role='button'><br><i class='fas fa-5x fa-file-alt'></i><br><br><br>Resumen</a>
								</div>
							</div>
						</div>
						<div class='col-sm'></div>
					</div>
				</div>	
				<div style="color:#eeeeee; font-size:10px">.</div>				
			</div>			

			<!-- Inicio del Pie de Página -->
			<footer>
				<div align="center">
					<?php echo $BOTONES_NAVEGACION; ?><br class="quitar_espacios"><div align="center" style="color:#eeeeee; font-size:4px">&nbsp;</div><div align="center" style="color:#999; font-size:12px">Hospital Provincial Docente de Oncolog&iacute;a "Mar&iacute;a Curie"</div>
				</div>
			</footer>
			<!-- Fin del Pie de Página -->
		</div>
	</body>
</html>