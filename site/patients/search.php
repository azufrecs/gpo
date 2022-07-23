<?php
	include ("../security/seguridad.php");
	include ("../conn/conn.php");
	include ("../class/message.php");
	setlocale (LC_TIME,"spanish");
	header('Content-Type:text/html; charset=UTF-8');
	
	//INICIO DE CONFIGURACION DEL MENU CON BOTONES
		$BOTONES_NAVEGACION = "
		<div class='col-md-12' align='center'>
			<div class='btn-group btn-group-sm'>
				<a class='btn btn-primary' href='..' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para acceder al Men&uacute;'>Men&uacute;</a>
				<a class='btn btn-success' href='../patients/' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para acceder a Captar Paciente'>Captar</a>
				<a class='btn btn-secondary' href='../patients/summary.php' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para acceder al Resumen'>Resumen</a>
				<a type='button' class='btn btn-outline-warning text-dark' href='../security/onco.php' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para Salir y acceder a la Web ONCO'>Web ONCO</a>
				<a class='btn btn-warning' href='../security/login.php' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para cambiar de usuario'>Salir [" . $_SESSION['user'] . "]</a>				
			</div>
		</div>";
	//FIN DE CONFIGURACION DEL MENU CON BOTONES

	$FECHAACTUAL = date('Y-m-d');
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<!-- Etiquetas <meta> obligatorias para Bootstrap -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="../../img/favicon.svg">
		<title>Gesti&oacute;n de Pacientes ONCO</title>

		<!-- Enlazando el CSS de Bootstrap -->
		<link href="../../css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="../../css/main.css" rel="stylesheet" media="screen">
		<link href="../../css/icons.css" rel="stylesheet" media="screen">
		<link href="../../css/signin.css" rel="stylesheet" media="screen">
		<!-- Enlazando el CSS de Bootstrap -->
		
		<!-- Opcional: enlazando el JavaScript de Bootstrap -->
		<script src="../../js/jquery-3.5.1.js"></script>
		<script src="../../js/popper.js"></script>
		<script src="../../js/bootstrap.js"></script>
		<script src="../../js/main.js"></script>
		<script src="../../js/icons.js"></script>
	</head>

	<body>
		<div class="container" align="center">
			<div class="content" align="center">
				<!-- Inicio de Encabezado -->
				<div class="row quitar_espacios">
					<div class="col" align="center"><i class='fas fa-procedures fa-7x text-danger'></i></div>
				</div>	
				
				<div align="center" style="color:#666666; font-size:24px">Buscar Paciente</div>
				<div align="center" style="color:#eeeeee; font-size:10px">&nbsp;</div>	
				<!-- Fin de Encabezado -->
				
				<?php
					if(isset($_POST['search'])){
						$_SESSION['QUE_BUSCAR'] 		= $_POST['cboBusqueda'];
						$_SESSION['CRITERIO_BUSQUEDA']	= $_POST['txtCriterio']; 
						
						header("Location:result.php");
					}
				?>

				<!-- INICIO DEL FORMULARIO DE BUSQUEDA -->
				<form id="frmBuscar" name="frmBuscar" method="post" action="">
					<div align="center" style="color:#eeeeee; font-size:5px">&nbsp;</div>	
					<div class="form-row" align="center">
						<div class="col-sm"></div>
						<div class="col-md-8">
							<div class="card border-info bg-info-10">
								<div style="font-size:6px">&nbsp;</div>
								<div class="form-row ml-0 mr-0">
									<div class="col-md-6 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">Buscar por</div></div>
										<select name="cboBusqueda" id="cboBusqueda" class="custom-select" required>
											<option disabled value="" selected hidden>Realice una selecci&oacute;n...</option>
											<option value="ci">CARNE DE IDENTIDAD</option>
											<option value="hc">HISTORIA CLINICA</option>
											<option value="nombre">NOMBRE(S)</option>
											<option value="apellido1">PRIMER APELLIDO</option>
											<option value="apellido2">SEGUNDO APELLIDO</option>
											<option value="all">TODOS LOS PACIENTES</option>
										</select>
									</div>

									<div class="col-md-6 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">Criterio</div></div>
										<input name="txtCriterio" id="txtCriterio" class="form-control input" placeholder="Escriba el criterio de b&uacute;squeda..." autocomplete="off" required>
									</div>
								</div>
								<div style="font-size:6px">&nbsp;</div>
							</div>
						</div>
						<div class="col-sm"></div>
					</div>
					
					<div style="color:#EEEEEE; font-size:10px" align="center">&nbsp;</div>

					<div class="form-row">
						<div class='col-md'></div>
						<div class='col-md-3' align='center'>
							<button type='submit' name='search' class='btn btn-info btn-block'><i class='fas fa-search'></i>&nbsp;&nbsp;&nbsp;Listar resultados</button>
						</div>
						<div class='col-md'></div>
					</div>
				</form>
				<!-- FINALIZA EL FORMULARIO DE BUSQUEDA -->
				
				<script>
				$("#cboBusqueda").change(function() 
				{
					if($("#cboBusqueda").val() !== "all")
					{
						$('#txtCriterio').prop('disabled', false);
					} else {
						$('#txtCriterio').prop('disabled', 'disabled');
					}
				});
				</script>
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