<?php 
	//INICIO DE CONFIGURACION DEL MENU CON BOTONES
	$BOTONES_NAVEGACION = "
	<div class='col-md-12' align='center'>
		<div class='btn-group btn-group-sm'>
			<a class='btn btn-warning' href='https://www.onco.cmw.sld.cu' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para acceder a la Web ONCO'>Web ONCO</a>
		</div>
	</div>";
?>

<!doctype html>
<html lang="es">
	<head>
		<!-- Etiquetas <meta> obligatorias para Bootstrap -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="img/favicon.svg">
		<title>Gesti&oacute;n de Pacientes ONCO</title>

		<!-- Enlazando el CSS de Bootstrap -->
		<link href="css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="css/main.css" rel="stylesheet" media="screen">
		<link href="css/icons.css" rel="stylesheet" media="screen">
		<link href="css/signin.css" rel="stylesheet" media="screen">
		<!-- Enlazando el CSS de Bootstrap -->
		
		<!-- Opcional: enlazando el JavaScript de Bootstrap -->
		<script src="js/jquery-3.5.1.js"></script>
		<script src="js/popper.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/main.js"></script>
		<script src="js/icons.js"></script>
		<!-- Opcional: enlazando el JavaScript de Bootstrap -->
	</head>
  
	<body>
		<div class="container">
			<div class="content">
				<div align="center">
					<div align="center" style="width:100%"> 
						<!-- Inicio de Encabezado -->
						<div class="row quitar_espacios">
							<div class="col" align="center"><i class='fas fa-procedures fa-8x text-danger'></i></div>
						</div>
						
						<div align="center" style="color:#666666; font-size:24px">Gesti&oacute;n de Pacientes ONCO, autent&iacute;quese</div>
						<div align="center" style="color:#eeeeee; font-size:10px">&nbsp;</div>	
						<!-- Fin de Encabezado -->
						
						<form id="frmInicio" name="frmInicio" method="post" action="site/security/validar.php" class="form-signin">
							<label class="sr-only">Email address</label><input name="txtUsername" type="text" class="form-control" placeholder="Usuario" autocomplete="on" required autofocus>
							<div style="color:#eeeeee; font-size:5px">.</div>
							<label class="sr-only">Email address</label><input name="txtPassword" type="password" class="form-control" placeholder="Contraseña" autocomplete="off" required autofocus>
							<input name="submit" type="submit" value="Acceder" id="loginbutton" onClick="handleClick()" class="btn btn-lg btn-primary btn-block">
							<input name="js_autodetect_results" value="0" type="hidden">
							<input name="just_logged_in" value="1" type="hidden"></label>
						</form>
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