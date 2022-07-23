<?php
	session_start();
	session_destroy();
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
		<link href="../../css/icons.css" rel="stylesheet" media="screen">
		<link href="../../css/main.css" rel="stylesheet" media="screen">
		<!-- Enlazando el CSS de Bootstrap -->
		
		<!-- Enlazando el JavaScript de Bootstrap -->
		<script src="../../js/jquery-3.5.1.js"></script>
		<script src="../../js/bootstrap.js"></script>
		<script src="../../js/icons.js"></script>
		<script src="../../js/main.js"></script>
		<!-- Enlazando el JavaScript de Bootstrap -->

			<script LANGUAGE="JavaScript">
				var pagina="https://www.onco.cmw.sld.cu"
				function redireccionar() 
				{
					location.href=pagina
				} 
				setTimeout ("redireccionar()", 10000);
			</script>
		<!-- End Plugins JavaScript -->
	</head>
	
	<body>
		<div class="container">
			<div align="center">
				<div align="center" style="width:100%"> 
					<!-- Inicio de Encabezado -->
					<div class="row">
						<div class="col" align="center"><img src="../../img/logo.png" width="345" height="85"></div>
					</div>	
					
					<div align="center" style="color:#666666; font-size:24px">Error al acceder a Gesti&oacute;n de Pacientes o a sus secciones</div>
					<div align="center" style="color:#eeeeee; font-size:4px">&nbsp;</div>
					<!-- Fin de Encabezado -->
					
					<div class="row" align="center">
						<div class="col-md-1" align="center"></div>
						<div class="col-md-10" align="center">
							<div class="card">
								<div class="card-header bg-danger text-white" style="font-size:28px">Las posibles causas pueden ser las siguientes</div>
								<div class="card-body">
									<div class="card-deck">
										<div class="card bg-warning">
											<div class="card-body text-center">
												<br>
												<i class="fas fa-10x fa-user-secret text-white" title="check-square"></i>
												<br><br>
												<div align="center" style="font-size:22px" class="card-text text-white">Usuario no encontrado</div>
												<br>
											</div>
										</div>
									  
										<div class="card bg-success">
											<div class="card-body text-center">
												<br>
												<i class="fas fa-10x fa-key text-white" title="check-square"></i>
												<br><br>
												<div align="center" style="font-size:22px" class="card-text text-white">Acceso restringido</div>
												<br>
											</div>
										</div>
									  
										<div class="card bg-primary">
											<div class="card-body text-center">
												<br>
												<i class="fas fa-10x fa-user-shield text-white" title="check-square"></i>
												<br><br>
												<div align="center" style="font-size:22px" class="card-text text-white">Usuario no autorizado</div>
												<br>
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<div align="center" style="color:#A94442; font-size:22px">Si esto le parece incorrecto contacte al Administrador de la Red</div>
									<div align="center" style="color:#A94442; font-size:18px">En breve ser&aacute; dirigido a la Web ONCO</div>
								</div>
							</div>			
						</div>
						<div class="col-md-1" align="center"></div>
					</div>
				</div>
			</div> 
			<!-- Inicio del Pie de Página -->
				<div id="footer">
					<?php echo $BOTONES_NAVEGACION; ?><br class="quitar_espacios"><div align="center" style="color:#eeeeee; font-size:4px">&nbsp;</div><div align="center" style="color:#999; font-size:12px">Servicios M&eacute;dicos Cubanos, Sucursal Camag&uuml;ey</div>
				</div>
			<!-- Fin del Pie de Página -->
		</div> 
	</body>  
</html>