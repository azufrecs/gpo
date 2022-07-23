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
				<a class='btn btn-info' href='../patients/search.php' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para Buscar Paciente'>Buscar</a>
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

	<script>
		var municipios_1=new Array("Selecciona un municipio...","CONSOLACION DEL SUR","LA PALMA","LOS PALACIOS","MANTUA","MINAS DE MATAHAMBRE","PINAR DEL RIO","PINAR DEL RIO","SAN JUAN Y MARTINEZ","SAN LUIS","SANDINO","VIÑALES","GUANE");
		var municipios_2=new Array("Selecciona un municipio...","ALQUIZAR","ARTEMISA","BAHIA HONDA","BAUTA","CAIMITO","CANDELARIA","GUANAJAY","GUIRA DE MELENA","MARIEL","SAN ANTONIO","SAN CRISTOBAL");
		var municipios_3=new Array("Selecciona un municipio...","BATABANO","BEJUCAL","GUINES","JARUCO","MADRUGA","MELENA DEL SUR","NUEVA PAZ","QUIVICAN","SAN JOSE DE LAS LAJAS","SAN NICOLAS","SANTA CRUZ DEL NORTE");
		var municipios_4=new Array("Selecciona un municipio...","ARROYO NARANJO","BOYEROS","CENTRO HABANA","CERRO","COTORRO","DIEZ DE OCTUBRE","GUANABACOA","HABANA DEL ESTE","HABANA VIEJA","LA LISA","MARIANAO","PLAYA","PLAZA DE LA REVOLUCION","REGLA","SAN MIGUEL DEL PADRON");
		var municipios_5=new Array("Selecciona un municipio...","CALIMETE","CARDENAS","CIENAGA DE ZAPATA","COLON","JAGUEY GRANDE","JOVELLANOS","LIMONAR","LOS ARABOS","MARTI","MATANZAS","PEDRO BETANCOURT","PERICO","UNION DE REYES");
		var municipios_6=new Array("Selecciona un municipio...","CAIBARIEN","CAMAJUANI","CIFUENTES","CORRALILLO","ENCRUCIJADA","MANICARAGUA","PLACETAS","QUEMADO DE GUINES","RANCHUELO","REMEDIOS","SAGUA LA GRANDE","SANTA CLARA","SANTO DOMINGO");
		var municipios_7=new Array("Selecciona un municipio...","ABREUS","AGUADA DE PASAJEROS","CIENFUEGOS","CRUCES","CUMANAYAGUA","LAJAS","PALMIRA","RODAS");
		var municipios_8=new Array("Selecciona un municipio...","CABAIGUAN","FOMENTO","JATIBONICO","LA SIERPE","SANCTI SPIRITUS","TAGUASCO","TRINIDAD","YAGUAJAY");
		var municipios_9=new Array("Selecciona un municipio...","BARAGUA","BOLIVIA","CHAMBAS","CIEGO DE AVILA","CIRO REDONDO","FLORENCIA","MAJAGUA","MORON","PRIMERO DE ENERO","VENEZUELA");
		var municipios_10=new Array("Selecciona un municipio...","CAMAGUEY","CARLOS MANUEL DE CESPEDES","ESMERALDA","FLORIDA","GUAIMARO","JIMAGUAYU","MINAS","NAJASA","NUEVITAS","SANTA CRUZ DEL SUR","SIBANICU","SIERRA DE CUBITAS","VERTIENTES");
		var municipios_11=new Array("Selecciona un municipio...","AMANCIO","COLOMBIA","JESUS MENENDEZ","JOBABO","LAS TUNAS","MAJIBACOA","MANATI","PUERTO PADRE");
		var municipios_12=new Array("Selecciona un municipio...","ANTILLA","BAGUANOS","BANES","CACOCUM","CALIXTO GARCIA","CUETO","FRANK PAIS","GIBARA","HOLGUIN","MAYARI","MOA","RAFAEL FREYRE","SAGUA DE TANAMO","URBANO NORIS");
		var municipios_13=new Array("Selecciona un municipio...","BARTOLOME MASO","BAYAMO","BUEY ARRIBA","CAMPECHUELA","CAUTO CRISTO","GUISA","JIGUANI","MANZANILLO","MEDIA LUNA","NIQUERO","PILON","RIO CAUTO","YARA");
		var municipios_14=new Array("Selecciona un municipio...","CONTRAMAESTRE","GUAMA","MELLA","PALMA SORIANO","SAN LUIS","SANTIAGO DE CUBA","SEGUNDO FRENTE","SONGO - LA MAYA","TERCER FRENTE");
		var municipios_15=new Array("Selecciona un municipio...","BARACOA","CAIMANERA","EL SALVADOR","GUANTANAMO","IMIAS","MAISI","MANUEL TAMES","NICETO PEREZ","SAN ANTONIO DEL SUR","YATERAS");
		var municipios_16=new Array("Selecciona un municipio...","ISLA DE LA JUVENTUD");
	
		var TodosMunicipios = [
			[],
			municipios_1,
			municipios_2,
			municipios_3,
			municipios_4,
			municipios_5,
			municipios_6,
			municipios_7,
			municipios_8,
			municipios_9,
			municipios_10,
			municipios_11,
			municipios_12,
			municipios_13,
			municipios_14,
			municipios_15,
			municipios_16,
		];

		function cambia_provincia(){ 
			var Provincia 
			Provincia = document.frmUpdate.cboProvincia[document.frmUpdate.cboProvincia.selectedIndex].value 
			if (Provincia != 0) { 													//miro a ver si el pais está definido 
				mis_municipios=TodosMunicipios[Provincia]							//si estaba definido, entonces coloco las opciones de la provincia correspondiente.  //selecciono el array de provincia adecuado 
				num_municipios = mis_municipios.length 								//calculo el numero de municipios 
				document.frmUpdate.cboMunicipio.length = num_municipios 			//marco el número de municipios en el select 
				for(i=0;i<num_municipios;i++){ 										//para cada provincia del array, la introduzco en el select 
					document.frmUpdate.cboMunicipio.options[i].value=mis_municipios[i] 
					document.frmUpdate.cboMunicipio.options[i].text=mis_municipios[i] 
				}	
			}else{ 
				document.frmUpdate.cboMunicipio.length = 1 						//si no había provincia seleccionada, elimino las municipios del select 
				document.frmUpdate.cboMunicipio.options[0].value = "-" 			//coloco un guión en la única opción que he dejado 
				document.frmUpdate.cboMunicipio.options[0].text = "-" 
			} 
			document.frmUpdate.cboMunicipio.options[0].selected = true 			//marco como seleccionada la opción primera de provincia 
		}
	</script>
		
	<body>
		<div class="container" align="center">
			<div class="content" align="center">
				<!-- Inicio de Encabezado -->
				<div class="row quitar_espacios">
					<div class="col" align="center"><i class='fas fa-procedures fa-7x text-danger'></i></div>
				</div>	
				
				<div align="center" style="color:#666666; font-size:24px">Editar Paciente</div>
				<div align="center" style="color:#eeeeee; font-size:10px">&nbsp;</div>	
				<!-- Fin de Encabezado -->
				
				<?php
					$CI =  mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_GET["ci"]),ENT_QUOTES)));
					$PACIENTE_EDITAR = $mysqli->query("SELECT * FROM tbl_pacientes WHERE ci = '$CI'");
					$totalRows_PACIENTE_EDITAR = mysqli_num_rows($PACIENTE_EDITAR);
					
					if ($totalRows_PACIENTE_EDITAR == 0)
					{
						header("Location:..");
					} else {
						$rowPaciente = mysqli_fetch_assoc($PACIENTE_EDITAR);
					}
					
					if ($rowPaciente['sexo'] == 'F')
					{
						$SEXO_COMBO = "FEMENINO";
					} else {
						$SEXO_COMBO = "MASCULINO";
					}
					
					switch ($rowPaciente['provincia'])
					{
						case "PINAR DEL RIO":
							$CODIGO_PROVINCIA	= "1";
							break;
						case "ARTEMISA":
							$CODIGO_PROVINCIA	= "2";
							break;
						case "MAYABEQUE":
							$CODIGO_PROVINCIA	= "3";
							break;
						case "LA HABANA":
							$CODIGO_PROVINCIA	= "4";
							break;
						case "MATANZAS":
							$CODIGO_PROVINCIA	= "5";
							break;
						case "VILLA CLARA":
							$CODIGO_PROVINCIA	= "6";
							break;
						case "CIENFUEGOS":
							$CODIGO_PROVINCIA	= "7";
							break;
						case "SANCTI SPIRITUS":
							$CODIGO_PROVINCIA	= "8";
							break;
						case "CIEGO DE AVILA":
							$CODIGO_PROVINCIA	= "9";
							break;
						case "CAMAGUEY":
							$CODIGO_PROVINCIA	= "10";
							break;
						case "LAS TUNAS":
							$CODIGO_PROVINCIA	= "11";
							break;
						case "HOLGUIN":
							$CODIGO_PROVINCIA	= "12";
							break;
						case "GRANMA":
							$CODIGO_PROVINCIA	= "13";
							break;
						case "SANTIAGO DE CUBA":
							$CODIGO_PROVINCIA	= "14";
							break;
						case "GUANTANAMO":
							$CODIGO_PROVINCIA	= "15";
							break;
						case "ISLA DE LA JUVENTUD":
							$CODIGO_PROVINCIA	= "16";
							break;
					}
							
					if(isset($_POST['update']))
					{
						$NOMBRE 		= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtNombre"]),ENT_QUOTES)));
						$APELLIDO1 		= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtApellido1"]),ENT_QUOTES)));
						$APELLIDO2 		= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtApellido2"]),ENT_QUOTES)));
						$HC 			= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtHC"]),ENT_QUOTES)));
						//$CI 			= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtCI"]),ENT_QUOTES)));
						//$FECHANAC		= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtFechaNac"]),ENT_QUOTES)));
						//$SEXO			= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["cboSexo"]),ENT_QUOTES)));
						$CALLE			= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtCalle"]),ENT_QUOTES)));
						$NRO			= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtNro"]),ENT_QUOTES)));
						$ENTRE			= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtEntre"]),ENT_QUOTES)));
						$REPARTO		= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtReparto"]),ENT_QUOTES)));
						
						switch (mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["cboProvincia"]),ENT_QUOTES))))
							{
								case "1":
									$PROVINCIA = "PINAR DEL RIO";
									break;
								case "2":
									$PROVINCIA = "ARTEMISA";
									break;
								case "3":
									$PROVINCIA = "MAYABEQUE";
									break;
								case "4":
									$PROVINCIA = "LA HABANA";
									break;
								case "5":
									$PROVINCIA = "MATANZAS";
									break;
								case "6":
									$PROVINCIA = "VILLA CLARA";
									break;
								case "7":
									$PROVINCIA = "CIENFUEGOS";
									break;
								case "8":
									$PROVINCIA = "SANCTI SPIRITUS";
									break;
								case "9":
									$PROVINCIA = "CIEGO DE AVILA";
									break;
								case "10":
									$PROVINCIA = "CAMAGUEY";
									break;
								case "11":
									$PROVINCIA = "LAS TUNAS";
									break;
								case "12":
									$PROVINCIA = "HOLGUIN";
									break;
								case "13":
									$PROVINCIA = "GRANMA";
									break;
								case "14":
									$PROVINCIA = "SANTIAGO DE CUBA";
									break;
								case "15":
									$PROVINCIA = "GUANTANAMO";
									break;
								case "16":
									$PROVINCIA = "ISLA DE LA JUVENTUD";
									break;
							}

						$MUNICIPIO		= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["cboMunicipio"]),ENT_QUOTES)));
						$FECHAINS 		= mysqli_real_escape_string($mysqli,(strip_tags(strtoupper($_POST["txtFechaIns"]),ENT_QUOTES))); 
						
						$updatePaciente = $mysqli->query("UPDATE tbl_pacientes SET nombre = '$NOMBRE', apellido1 = '$APELLIDO1', apellido2 = '$APELLIDO2', hc = '$HC', calle = '$CALLE', numero = '$NRO', entrecalles = '$ENTRE', reparto = '$REPARTO', provincia = '$PROVINCIA', municipio = '$MUNICIPIO' WHERE ci = '$CI'") or die(mysqli_error());
											
						if($updatePaciente){
							$_SESSION['QUE_BUSCAR'] 		= "ci";
							$_SESSION['CRITERIO_BUSQUEDA']	= $CI;
							echo"<script>window.location.href='result.php'; </script>";
						}else{
							echo $MESSAGE_ERROR;
						}
					}
				?>
				
				<form id="frmUpdate" name="frmUpdate" method="post" action="">
					
					<!-- COMIENZA LA EDICION DE LA INFORMACION -->
					<div class="form-row" align="center">
						<div class="col-sm"></div>
						<div class="col-md-12">
							<div class="card border-info bg-info-10">
								<div style="font-size:6px">&nbsp;</div>
								
								<div class="form-row ml-0 mr-0">
									<div class="col-md-2 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">HC</div></div>
										<input name="txtHC" onchange="MASK(this,this.value,'0',1)" class="form-control input" style="text-align:right" placeholder="HC" autocomplete="off" pattern="[0-9]{5,8}" value="<?php echo $rowPaciente['hc']; ?>" maxlength="8" required autofocus>
									</div>

									<div class="col-md-2 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">CI</div></div>
										<input name="txtCI" onchange="MASK(this,this.value,'0',1)" class="form-control input" style="text-align:right" placeholder="CI" autocomplete="off" pattern="[0-9]{11}" value="<?php echo $rowPaciente['ci']; ?>" maxlength="11" disabled>
									</div>

									<div class="col-md-4 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">Fecha de Nacimiento</div></div>
										<input type="date" name="txtFechaNac" class="form-control" value="<?php echo $rowPaciente['fechanac']; ?>" maxlength="10" disabled>
									</div>

									<div class="col-md-4 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">Seleccione el Sexo</div></div>
										<select name="cboSexo" class="custom-select" maxlength="1" disabled>
											<option value="<?php echo $rowUnidad['sexo']; ?>" selected hidden><?php echo $SEXO_COMBO; ?></option>
											<option value="F">FEMENINO</option>
											<option value="M">MASCULINO</option>
										</select>
									</div>
								</div>

								<div style="font-size:6px">&nbsp;</div>
								
								<div class="form-row ml-0 mr-0">
									<div class="col-md-4 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">Nombres(s)</div></div>
										<input name="txtNombre" class="form-control input" placeholder="Nombre(s)" autocomplete="off" value="<?php echo $rowPaciente['nombre']; ?>" maxlength="25" required>
									</div>

									<div class="col-md-4 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">1er Apellido</div></div>
										<input name="txtApellido1" class="form-control input" placeholder="1er Apellido" autocomplete="off" value="<?php echo $rowPaciente['apellido1']; ?>" maxlength="25" required>
									</div>

									<div class="col-md-4 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">2do Apellido</div></div>
										<input name="txtApellido2" class="form-control input" placeholder="2do Apellido" autocomplete="off" value="<?php echo $rowPaciente['apellido2']; ?>" maxlength="25" required>
									</div>	
								</div>

								<div style="font-size:6px">&nbsp;</div>

								<div class="form-row ml-0 mr-0">
									<div class="col-md-3 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">Calle</div></div>
										<input name="txtCalle" class="form-control input" placeholder="Calle" autocomplete="off" value="<?php echo $rowPaciente['calle']; ?>" maxlength="50" required>
									</div>

									<div class="col-md-2 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">Nro</div></div>
										<input name="txtNro" class="form-control input" placeholder="Nro" autocomplete="off" value="<?php echo $rowPaciente['numero']; ?>" maxlength="4" required>
									</div>

									<div class="col-md-3 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">E/</div></div>
										<input name="txtEntre" class="form-control input" placeholder="Entre..." autocomplete="off" value="<?php echo $rowPaciente['entrecalles']; ?>" maxlength="45" required>
									</div>
									

									<div class="col-md-4 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">Reparto</div></div>
										<input name="txtReparto" class="form-control input" placeholder="Reparto..." autocomplete="off" value="<?php echo $rowPaciente['reparto']; ?>" maxlength="40" required>
									</div>
								</div>

								<div style="font-size:6px">&nbsp;</div>

								<div class="form-row ml-0 mr-0">
									<div class="col-md-4 input-group input-group">
										<div class="input-group-prepend"><label class="input-group-text text-info" for="cboProvincia">Provincia</label></div>
										<select name=cboProvincia onchange="cambia_provincia()" id="responsive_text" class="custom-select" required> 
											<option value="<?php echo $CODIGO_PROVINCIA; ?>" selected hidden><?php echo $rowPaciente['provincia']; ?></option>
											<option value="1">PINAR DEL RIO</option>
											<option value="2">ARTEMISA</option>
											<option value="3">MAYABEQUE</option>
											<option value="4">LA HABANA</option>
											<option value="5">MATANZAS</option>
											<option value="6">VILLA CLARA</option>
											<option value="7">CIENFUEGOS</option>
											<option value="8">SANCTI SPIRITUS</option>
											<option value="9">CIEGO DE AVILA</option>
											<option value="10">CAMAGUEY</option>
											<option value="11">LAS TUNAS</option>
											<option value="12">HOLGUIN</option>
											<option value="13">GRANMA</option>
											<option value="14">SANTIAGO DE CUBA</option>
											<option value="15">GUANTANAMO</option>
											<option value="16">ISLA DE LA JUVENTUD</option>
										</select>	
									</div>

									<div class="col-md-4 input-group input-group">
									<div class="input-group-prepend"><label class="input-group-text text-info" for="cboMunicipio">Municipio</label></div>
										<select name=cboMunicipio id="responsive_text" class="custom-select" required> 	
											<option value="<?php echo $rowPaciente['municipio']; ?>" selected hidden><?php echo $rowPaciente['municipio']; ?></option>
										</select> 
									</div>

									<div class="col-md-4 input-group input-group">
										<div class="input-group-prepend"><div class="input-group-text text-info">Fecha de Inscripci&oacute;n</div></div>
										<input type="date" name="txtFechaIns" class="form-control" value="<?php echo $rowPaciente['fechainscripcion']; ?>" maxlength="10" disabled required>
									</div>
								</div>

								<div style="font-size:6px">&nbsp;</div>
							</div>
						</div>
						<div class="col-sm"></div>
					</div>
					<script>
						//EVITAR SUBMIT AL HACER ENTER
						//$(document).ready(function() {
						//	$("form").keypress(function(e) {
						//		if (e.which == 13) {
						//			return false;
						//		}
						//	});
						//});
						
						//PASAR ENTRE OPCIONES AL PULSAR ENTER
						$('input').on("keypress", function(e) {
							/* ENTER PRESSED*/
							if (e.keyCode == 13) {
								/* FOCUS ELEMENT */
								var inputs = $(this).parents("form").eq(0).find(":input");
								var idx = inputs.index(this);

								if (idx == inputs.length - 1) {
									inputs[0].select()
								} else {
									inputs[idx + 1].focus(); //  handles submit buttons
									inputs[idx + 1].select();
								}
								return false;
							}
						});   
					</script>
					<!-- FINALIZA LA EDICION DE LA INFORMACION -->
					
					<div style="color:#EEEEEE; font-size:10px" align="center">&nbsp;</div>

					<div class="form-row">
						<div class='col-md'></div>
						<div class='col-md-3' align='center'>
							<button type='submit' name='update' class='btn btn-info btn-block'><i class='fas fa-save'></i>&nbsp;&nbsp;&nbsp;Actualizar datos del Paciente</button>
						</div>
						<div class='col-md'></div>
					</div>
				</form>
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