<?php
	include ("../security/seguridad.php");
	include ("../conn/conn.php");
	include ("../class/message.php");
	setlocale (LC_TIME,"spanish");
	header('Content-Type:text/html; charset=UTF-8');
	//error_reporting(0);					// No mostrar los errores de PHP
	error_reporting(-1); 				// Motrar todos los errores de PHP
	error_reporting(E_ALL);				// Motrar todos los errores de PHP
	ini_set('error_reporting', E_ALL);	// Motrar todos los errores de PHP
	
	//PRIMERA_FECHA_REGISTRADA
	$PRIMERA_FECHA_REGISTRADA = $mysqli->query("SELECT MIN(fechainscripcion) AS primera_fecha FROM tbl_pacientes");
	$totalRows_PRIMERA_FECHA_REGISTRADA = mysqli_num_rows($PRIMERA_FECHA_REGISTRADA);
	if ($totalRows_PRIMERA_FECHA_REGISTRADA > 0) 
	{
		while($row = $PRIMERA_FECHA_REGISTRADA->fetch_assoc()) 
		{
			$PRIMERAFECHA = date("d/m/Y",strtotime($row['primera_fecha']));
		}
	} else {
		$PRIMERAFECHA = "";
	}
	
	//error_reporting(0);
	$LINK_REPORTE = "<button type='submit' name='generar_reporte' class='btn btn-success btn-block'>Preparar Reporte</button>";
	
	//INICIO DE CONFIGURACION DEL MENU CON BOTONES
		$BOTONES_NAVEGACION = "
		<div class='col-md-12' align='center'>
			<div class='btn-group btn-group-sm'>
				<a class='btn btn-primary' href='..' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para acceder al Men&uacute;'>Men&uacute;</a>
				<a class='btn btn-success' href='../patients/' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para acceder a Captar Paciente'>Captar</a>
				<a class='btn btn-info' href='../patients/search.php' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para Buscar Paciente'>Buscar</a>
				<a type='button' class='btn btn-outline-warning text-dark' href='../security/onco.php' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para Salir y acceder a la Web ONCO'>Web ONCO</a>
				<a class='btn btn-warning' href='../security/login.php' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para cambiar de usuario'>Salir [" . $_SESSION['user'] . "]</a>				
			</div>
		</div>";
	//FIN DE CONFIGURACION DEL MENU CON BOTONES
	
	$FECHAACTUAL = date('Y-m-d');
	$YEARACTUAL = date('Y');
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// COMIENZO EL PROCESO DE GENERACION DEL PARTE DIARIO ///////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////
    if (isset($_POST['generar_reporte'])) {	
		include ("report.php");
	}
	
	//INICIO DE CONSULTAS PARA TOTALES DE PACIENTES Y PORCIENTES ACUMULADOS Y ANUALES
	$PACIENTES_TOTAL = $mysqli->query("SELECT * FROM tbl_pacientes");
	$totalRows_PACIENTES_TOTAL = mysqli_num_rows($PACIENTES_TOTAL);

	$PACIENTES_TOTAL_YEAR = $mysqli->query("SELECT * FROM tbl_pacientes WHERE YEAR(fechainscripcion)=YEAR(CURDATE())");
	$totalRows_PACIENTES_TOTAL_YEAR = mysqli_num_rows($PACIENTES_TOTAL_YEAR);

	$PACIENTES_FEMENINOS_YEAR = $mysqli->query("SELECT * FROM tbl_pacientes WHERE sexo = 'F' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$totalRows_PACIENTES_FEMENINOS_YEAR = mysqli_num_rows($PACIENTES_FEMENINOS_YEAR);
	if ($totalRows_PACIENTES_FEMENINOS_YEAR > 0)
	{
		$PORCIENTO_FEMENINO_YEAR = round(($totalRows_PACIENTES_FEMENINOS_YEAR / $totalRows_PACIENTES_TOTAL_YEAR) * 100, 0) . "%";
	} else {
		$PORCIENTO_FEMENINO_YEAR = "0%";
	}
	
	$PACIENTES_FEMENINOS = $mysqli->query("SELECT * FROM tbl_pacientes WHERE sexo = 'F'");
	$totalRows_PACIENTES_FEMENINOS = mysqli_num_rows($PACIENTES_FEMENINOS);	
	if ($totalRows_PACIENTES_FEMENINOS > 0)
	{
		$PORCIENTO_FEMENINO = round(($totalRows_PACIENTES_FEMENINOS / $totalRows_PACIENTES_TOTAL) * 100, 0) . "%";
	} else {
		$PORCIENTO_FEMENINO = "0%";
	}
	
	$totalRows_PACIENTES_MASCULINOS_YEAR = $totalRows_PACIENTES_TOTAL_YEAR - $totalRows_PACIENTES_FEMENINOS_YEAR;	
	if ($totalRows_PACIENTES_MASCULINOS_YEAR > 0)
	{
		$PORCIENTO_MASCULINO_YEAR = round(($totalRows_PACIENTES_MASCULINOS_YEAR / $totalRows_PACIENTES_TOTAL_YEAR) * 100, 0) . "%";
	} else {
		$PORCIENTO_MASCULINO_YEAR = "0%";
	}
	
	$totalRows_PACIENTES_MASCULINOS = $totalRows_PACIENTES_TOTAL - $totalRows_PACIENTES_FEMENINOS;	
	if ($totalRows_PACIENTES_MASCULINOS > 0)
	{
		$PORCIENTO_MASCULINO = round(($totalRows_PACIENTES_MASCULINOS / $totalRows_PACIENTES_TOTAL) * 100, 0) . "%";
	} else {
		$PORCIENTO_MASCULINO = "0%";
	}
	//FIN DE CONSULTAS PARA TOTALES DE PACIENTES Y PORCIENTES ACUMULADOS Y ANUALES
	
	//////////////////////////////////////////////////////////////////////////
	
	//INICIO DE CONSULTAS PARA TOTALES DE PACIENTES Y PORCIENTOS ACUMULADOS HASTA LA FECHA POR PROVINCIA Y MUNICIPIOS	
	$PRI_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'PINAR DEL RIO'");
	$TotalPRI_ACUM = mysqli_num_rows($PRI_ACUM);
	if ($TotalPRI_ACUM > 0)
	{
		$EstadoPRI_ACUM = "";
		$TitlePRI_ACUM = "Provincia Pinar del R&iacute;o, clic para ver pacientes por municipios";
		$ColorPRI_ACUM = "btn-dark";
	} else {	
		$EstadoPRI_ACUM = "disabled";
		$TitlePRI_ACUM = "Provincia Pinar del R&iacute;o, sin pacientes este año";
		$ColorPRI_ACUM = "btn-secondary";
	}
	
	$ART_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'ARTEMISA'");
	$TotalART_ACUM = mysqli_num_rows($ART_ACUM);
	if ($TotalART_ACUM > 0)
	{
		$EstadoART_ACUM = "";
		$TitleART_ACUM = "Provincia Artemisa, clic para ver pacientes por municipios";
		$ColorART_ACUM = "btn-dark";
	} else {	
		$EstadoART_ACUM = "disabled";
		$TitleART_ACUM = "Provincia Artemisa, sin pacientes este año";
		$ColorART_ACUM = "btn-secondary";
	}
	
	$MAY_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'MAYABEQUE'");
	$TotalMAY_ACUM = mysqli_num_rows($MAY_ACUM);
	if ($TotalMAY_ACUM > 0)
	{
		$EstadoMAY_ACUM = "";
		$TitleMAY_ACUM = "Provincia Mayabeque, clic para ver pacientes por municipios";
		$ColorMAY_ACUM = "btn-dark";
	} else {	
		$EstadoMAY_ACUM = "disabled";
		$TitleMAY_ACUM = "Provincia Mayabeque, sin pacientes este año";
		$ColorMAY_ACUM = "btn-secondary";
	}
	
	$LHA_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'LA HABANA'");
	$TotalLHA_ACUM = mysqli_num_rows($LHA_ACUM);
	if ($TotalLHA_ACUM > 0)
	{
		$EstadoLHA_ACUM = "";
		$TitleLHA_ACUM = "Provincia La Habana, clic para ver pacientes por municipios";
		$ColorLHA_ACUM = "btn-dark";
	} else {	
		$EstadoLHA_ACUM = "disabled";
		$TitleLHA_ACUM = "Provincia La Habana, sin pacientes este año";
		$ColorLHA_ACUM = "btn-secondary";
	}
	
	$MTZ_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'MATANZAS'");
	$TotalMTZ_ACUM = mysqli_num_rows($MTZ_ACUM);
	if ($TotalMTZ_ACUM > 0)
	{
		$EstadoMTZ_ACUM = "";
		$TitleMTZ_ACUM = "Provincia Matanzas, clic para ver pacientes por municipios";
		$ColorMTZ_ACUM = "btn-dark";
	} else {	
		$EstadoMTZ_ACUM = "disabled";
		$TitleMTZ_ACUM = "Provincia Matanzas, sin pacientes este año";
		$ColorMTZ_ACUM = "btn-secondary";
	}
	
	$VLC_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'VILLA CLARA'");
	$TotalVLC_ACUM = mysqli_num_rows($VLC_ACUM);
	if ($TotalVLC_ACUM > 0)
	{
		$EstadoVLC_ACUM = "";
		$TitleVLC_ACUM = "Provincia Villa Clara, clic para ver pacientes por municipios";
		$ColorVLC_ACUM = "btn-dark";
	} else {	
		$EstadoVLC_ACUM = "disabled";
		$TitleVLC_ACUM = "Provincia Villa Clara, sin pacientes este año";
		$ColorVLC_ACUM = "btn-secondary";
	}
	
	$CFG_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CIENFUEGOS'");
	$TotalCFG_ACUM = mysqli_num_rows($CFG_ACUM);
	if ($TotalCFG_ACUM > 0)
	{
		$EstadoCFG_ACUM = "";
		$TitleCFG_ACUM = "Provincia Cienfuegos, clic para ver pacientes por municipios";
		$ColorCFG_ACUM = "btn-dark";
	} else {	
		$EstadoCFG_ACUM = "disabled";
		$TitleCFG_ACUM = "Provincia Cienfuegos, sin pacientes este año";
		$ColorCFG_ACUM = "btn-secondary";
	}
	
	$SSP_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'SANCTI SPIRITUS'");
	$TotalSSP_ACUM = mysqli_num_rows($SSP_ACUM);
	if ($TotalSSP_ACUM > 0)
	{
		$EstadoSSP_ACUM = "";
		$TitleSSP_ACUM = "Provincia Sancti Sp&iacute;ritus, clic para ver pacientes por municipios";
		$ColorSSP_ACUM = "btn-dark";
	} else {	
		$EstadoSSP_ACUM = "disabled";
		$TitleSSP_ACUM = "Provincia Sancti Sp&iacute;ritus, sin pacientes este año";
		$ColorSSP_ACUM = "btn-secondary";
	}
	
	$CAV_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CIEGO DE AVILA'");
	$TotalCAV_ACUM = mysqli_num_rows($CAV_ACUM);
	if ($TotalCAV_ACUM > 0)
	{
		$EstadoCAV_ACUM = "";
		$TitleCAV_ACUM = "Provincia Ciego de &Aacute;vila, clic para ver pacientes por municipios";
		$ColorCAV_ACUM = "btn-dark";
	} else {	
		$EstadoCAV_ACUM = "disabled";
		$TitleCAV_ACUM = "Provincia Ciego de &Aacute;vila, sin pacientes este año";
		$ColorCAV_ACUM = "btn-secondary";
	}
	
	$CMW_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CAMAGUEY'");
	$TotalCMW_ACUM = mysqli_num_rows($CMW_ACUM);
	if ($TotalCMW_ACUM > 0)
	{
		$EstadoCMW_ACUM = "";
		$TitleCMW_ACUM = "Provincia Camag&uuml;ey, clic para ver pacientes por municipios";
		$ColorCMW_ACUM = "btn-dark";
	} else {	
		$EstadoCMW_ACUM = "disabled";
		$TitleCMW_ACUM = "Provincia Camag&uuml;ey, sin pacientes este año";
		$ColorCMW_ACUM = "btn-secondary";
	}
	
	$LTU_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'LAS TUNAS'");
	$TotalLTU_ACUM = mysqli_num_rows($LTU_ACUM);
	if ($TotalLTU_ACUM > 0)
	{
		$EstadoLTU_ACUM = "";
		$TitleLTU_ACUM = "Provincia Las Tunas, clic para ver pacientes por municipios";
		$ColorLTU_ACUM = "btn-dark";
	} else {	
		$EstadoLTU_ACUM = "disabled";
		$TitleLTU_ACUM = "Provincia Las Tunas, sin pacientes este año";
		$ColorLTU_ACUM = "btn-secondary";
	}
	
	$HOL_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'HOLGUIN'");
	$TotalHOL_ACUM = mysqli_num_rows($HOL_ACUM);
	if ($TotalHOL_ACUM > 0)
	{
		$EstadoHOL_ACUM = "";
		$TitleHOL_ACUM = "Provincia Holgu&iacute;n, clic para ver pacientes por municipios";
		$ColorHOL_ACUM = "btn-dark";
	} else {	
		$EstadoHOL_ACUM = "disabled";
		$TitleHOL_ACUM = "Provincia Holgu&iacute;n, sin pacientes este año";
		$ColorHOL_ACUM = "btn-secondary";
	}
	
	$GRA_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'GRANMA'");
	$TotalGRA_ACUM = mysqli_num_rows($GRA_ACUM);
	if ($TotalGRA_ACUM > 0)
	{
		$EstadoGRA_ACUM = "";
		$TitleGRA_ACUM = "Provincia Granma, clic para ver pacientes por municipios";
		$ColorGRA_ACUM = "btn-dark";
	} else {	
		$EstadoGRA_ACUM = "disabled";
		$TitleGRA_ACUM = "Provincia Granma, sin pacientes este año";
		$ColorGRA_ACUM = "btn-secondary";
	}
	
	$STG_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'SANTIAGO DE CUBA'");
	$TotalSTG_ACUM = mysqli_num_rows($STG_ACUM);
	if ($TotalSTG_ACUM > 0)
	{
		$EstadoSTG_ACUM = "";
		$TitleSTG_ACUM = "Provincia Santiago de Cuba, clic para ver pacientes por municipios";
		$ColorSTG_ACUM = "btn-dark";
	} else {	
		$EstadoSTG_ACUM = "disabled";
		$TitleSTG_ACUM = "Provincia Santiago de Cuba, sin pacientes este año";
		$ColorSTG_ACUM = "btn-secondary";
	}
	
	$GTM_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'GUANTANAMO'");
	$TotalGTM_ACUM = mysqli_num_rows($GTM_ACUM);
	if ($TotalGTM_ACUM > 0)
	{
		$EstadoGTM_ACUM = "";
		$TitleGTM_ACUM = "Provincia Guant&aacute;namo, clic para ver pacientes por municipios";
		$ColorGTM_ACUM = "btn-dark";
	} else {	
		$EstadoGTM_ACUM = "disabled";
		$TitleGTM_ACUM = "Provincia Guant&aacute;namo, sin pacientes este año";
		$ColorGTM_ACUM = "btn-secondary";
	}
	
	$ILJ_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'ISLA DE LA JUVENTUD'");
	$TotalILJ_ACUM = mysqli_num_rows($ILJ_ACUM);
	if ($TotalILJ_ACUM > 0)
	{
		$EstadoILJ_ACUM = "";
		$TitleILJ_ACUM = "Municipio Especial Isla de la Juventud, clic para ver pacientes por municipios";
		$ColorILJ_ACUM = "btn-dark";
	} else {	
		$EstadoILJ_ACUM = "disabled";
		$TitleILJ_ACUM = "Municipio Especial Isla de la Juventud, sin pacientes este año";
		$ColorILJ_ACUM = "btn-secondary";
	}
	//FIN DE CONSULTAS PARA TOTALES DE PACIENTES Y PORCIENTOS ACUMULADOS HASTA LA FECHA POR PROVINCIA Y MUNICIPIOS	

	//INICIO DE CONSULTAS PARA TOTALES DE PACIENTES Y PORCIENTOS DEL AÑO ACTUAL POR PROVINCIA Y MUNICIPIOS	
	$PRI = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'PINAR DEL RIO' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalPRI = mysqli_num_rows($PRI);
	if ($TotalPRI > 0)
	{
		$EstadoPRI = "";
		$TitlePRI = "Provincia Pinar del R&iacute;o, clic para ver pacientes por municipios";
		$ColorPRI = "btn-info";
	} else {	
		$EstadoPRI = "disabled";
		$TitlePRI = "Provincia Pinar del R&iacute;o, sin pacientes este año";
		$ColorPRI = "btn-secondary";
	}
	
	$ART = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'ARTEMISA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalART = mysqli_num_rows($ART);
	if ($TotalART > 0)
	{
		$EstadoART = "";
		$TitleART = "Provincia Artemisa, clic para ver pacientes por municipios";
		$ColorART = "btn-info";
	} else {	
		$EstadoART = "disabled";
		$TitleART = "Provincia Artemisa, sin pacientes este año";
		$ColorART = "btn-secondary";
	}
	
	$MAY = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'MAYABEQUE' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalMAY = mysqli_num_rows($MAY);
	if ($TotalMAY > 0)
	{
		$EstadoMAY = "";
		$TitleMAY = "Provincia Mayabeque, clic para ver pacientes por municipios";
		$ColorMAY = "btn-info";
	} else {	
		$EstadoMAY = "disabled";
		$TitleMAY = "Provincia Mayabeque, sin pacientes este año";
		$ColorMAY = "btn-secondary";
	}
	
	$LHA = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'LA HABANA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalLHA = mysqli_num_rows($LHA);
	if ($TotalLHA > 0)
	{
		$EstadoLHA = "";
		$TitleLHA = "Provincia La Habana, clic para ver pacientes por municipios";
		$ColorLHA = "btn-info";
	} else {	
		$EstadoLHA = "disabled";
		$TitleLHA = "Provincia La Habana, sin pacientes este año";
		$ColorLHA = "btn-secondary";
	}
	
	$MTZ = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'MATANZAS' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalMTZ = mysqli_num_rows($MTZ);
	if ($TotalMTZ > 0)
	{
		$EstadoMTZ = "";
		$TitleMTZ = "Provincia Matanzas, clic para ver pacientes por municipios";
		$ColorMTZ = "btn-info";
	} else {	
		$EstadoMTZ = "disabled";
		$TitleMTZ = "Provincia Matanzas, sin pacientes este año";
		$ColorMTZ = "btn-secondary";
	}
	
	$VLC = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'VILLA CLARA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalVLC = mysqli_num_rows($VLC);
	if ($TotalVLC > 0)
	{
		$EstadoVLC = "";
		$TitleVLC = "Provincia Villa Clara, clic para ver pacientes por municipios";
		$ColorVLC = "btn-info";
	} else {	
		$EstadoVLC = "disabled";
		$TitleVLC = "Provincia Villa Clara, sin pacientes este año";
		$ColorVLC = "btn-secondary";
	}
	
	$CFG = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CIENFUEGOS' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalCFG = mysqli_num_rows($CFG);
	if ($TotalCFG > 0)
	{
		$EstadoCFG = "";
		$TitleCFG = "Provincia Cienfuegos, clic para ver pacientes por municipios";
		$ColorCFG = "btn-info";
	} else {	
		$EstadoCFG = "disabled";
		$TitleCFG = "Provincia Cienfuegos, sin pacientes este año";
		$ColorCFG = "btn-secondary";
	}
	
	$SSP = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'SANCTI SPIRITUS' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalSSP = mysqli_num_rows($SSP);
	if ($TotalSSP > 0)
	{
		$EstadoSSP = "";
		$TitleSSP = "Provincia Sancti Sp&iacute;ritus, clic para ver pacientes por municipios";
		$ColorSSP = "btn-info";
	} else {	
		$EstadoSSP = "disabled";
		$TitleSSP = "Provincia Sancti Sp&iacute;ritus, sin pacientes este año";
		$ColorSSP = "btn-secondary";
	}
	
	$CAV = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CIEGO DE AVILA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalCAV = mysqli_num_rows($CAV);
	if ($TotalCAV > 0)
	{
		$EstadoCAV = "";
		$TitleCAV = "Provincia Ciego de &Aacute;vila, clic para ver pacientes por municipios";
		$ColorCAV = "btn-info";
	} else {	
		$EstadoCAV = "disabled";
		$TitleCAV = "Provincia Ciego de &Aacute;vila, sin pacientes este año";
		$ColorCAV = "btn-secondary";
	}
	
	$CMW = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CAMAGUEY' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalCMW = mysqli_num_rows($CMW);
	if ($TotalCMW > 0)
	{
		$EstadoCMW = "";
		$TitleCMW = "Provincia Camag&uuml;ey, clic para ver pacientes por municipios";
		$ColorCMW = "btn-info";
	} else {	
		$EstadoCMW = "disabled";
		$TitleCMW = "Provincia Camag&uuml;ey, sin pacientes este año";
		$ColorCMW = "btn-secondary";
	}
	
	$LTU = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'LAS TUNAS' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalLTU = mysqli_num_rows($LTU);
	if ($TotalLTU > 0)
	{
		$EstadoLTU = "";
		$TitleLTU = "Provincia Las Tunas, clic para ver pacientes por municipios";
		$ColorLTU = "btn-info";
	} else {	
		$EstadoLTU = "disabled";
		$TitleLTU = "Provincia Las Tunas, sin pacientes este año";
		$ColorLTU = "btn-secondary";
	}
	
	$HOL = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'HOLGUIN' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalHOL = mysqli_num_rows($HOL);
	if ($TotalHOL > 0)
	{
		$EstadoHOL = "";
		$TitleHOL = "Provincia Holgu&iacute;n, clic para ver pacientes por municipios";
		$ColorHOL = "btn-info";
	} else {	
		$EstadoHOL = "disabled";
		$TitleHOL = "Provincia Holgu&iacute;n, sin pacientes este año";
		$ColorHOL = "btn-secondary";
	}
	
	$GRA = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'GRANMA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalGRA = mysqli_num_rows($GRA);
	if ($TotalGRA > 0)
	{
		$EstadoGRA = "";
		$TitleGRA = "Provincia Granma, clic para ver pacientes por municipios";
		$ColorGRA = "btn-info";
	} else {	
		$EstadoGRA = "disabled";
		$TitleGRA = "Provincia Granma, sin pacientes este año";
		$ColorGRA = "btn-secondary";
	}
	
	$STG = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'SANTIAGO DE CUBA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalSTG = mysqli_num_rows($STG);
	if ($TotalSTG > 0)
	{
		$EstadoSTG = "";
		$TitleSTG = "Provincia Santiago de Cuba, clic para ver pacientes por municipios";
		$ColorSTG = "btn-info";
	} else {	
		$EstadoSTG = "disabled";
		$TitleSTG = "Provincia Santiago de Cuba, sin pacientes este año";
		$ColorSTG = "btn-secondary";
	}
	
	$GTM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'GUANTANAMO' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalGTM = mysqli_num_rows($GTM);
	if ($TotalGTM > 0)
	{
		$EstadoGTM = "";
		$TitleGTM = "Provincia Guant&aacute;namo, clic para ver pacientes por municipios";
		$ColorGTM = "btn-info";
	} else {	
		$EstadoGTM = "disabled";
		$TitleGTM = "Provincia Guant&aacute;namo, sin pacientes este año";
		$ColorGTM = "btn-secondary";
	}
	
	$ILJ = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'ISLA DE LA JUVENTUD' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalILJ = mysqli_num_rows($ILJ);
	if ($TotalILJ > 0)
	{
		$EstadoILJ = "";
		$TitleILJ = "Municipio Especial Isla de la Juventud, clic para ver pacientes por municipios";
		$ColorILJ = "btn-info";
	} else {	
		$EstadoILJ = "disabled";
		$TitleILJ = "Municipio Especial Isla de la Juventud, sin pacientes este año";
		$ColorILJ = "btn-secondary";
	}
	//FIN DE CONSULTAS PARA TOTALES DE PACIENTES Y PORCIENTOS DEL AÑO ACTUAL POR PROVINCIA Y MUNICIPIOS	
	
	//////////////////////////////////////////////////////////////////////////
	
	//INICIO DE CONSULTAS PARA RANGOS DE EDADES DE PACIENTES ACUMULADO
	$MENOR20_ACUM = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad < '20'");
	$TotalMENOR20_ACUM = mysqli_num_rows($MENOR20_ACUM);
	if ($TotalMENOR20_ACUM > 0)
	{
		$EstadoMENOR20_ACUM = "";
		$TitleMENOR20_ACUM = "Pacientes menores de 20 años de edad, clic para verlos por Provincias";
		$ColorMENOR20_ACUM = "btn-dark";
	} else {	
		$EstadoMENOR20_ACUM = "disabled";
		$TitleMENOR20_ACUM = "No existen pacientes menores de 20 años de edad este año";
		$ColorMENOR20_ACUM = "btn-secondary";
	}
	
	$ENTRE20y29_ACUM = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '20' AND '29'");
	$TotalENTRE20y29_ACUM = mysqli_num_rows($ENTRE20y29_ACUM);
	if ($TotalENTRE20y29_ACUM > 0)
	{
		$EstadoENTRE20y29_ACUM = "";
		$TitleENTRE20y29_ACUM = "Pacientes entre 20 y 29 años de edad, clic para verlos por Provincias";
		$ColorENTRE20y29_ACUM = "btn-dark";
	} else {	
		$EstadoENTRE20y29_ACUM = "disabled";
		$TitleENTRE20y29_ACUM = "No existen pacientes entre 20 y 29 años de edad este año";
		$ColorENTRE20y29_ACUM = "btn-secondary";
	}
	
	$ENTRE30y45_ACUM = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '30' AND '45'");
	$TotalENTRE30y45_ACUM = mysqli_num_rows($ENTRE30y45_ACUM);
	if ($TotalENTRE30y45_ACUM > 0)
	{
		$EstadoENTRE30y45_ACUM = "";
		$TitleENTRE30y45_ACUM = "Pacientes entre 30 y 45 años de edad, clic para verlos por Provincias";
		$ColorENTRE30y45_ACUM = "btn-dark";
	} else {	
		$EstadoENTRE30y45_ACUM = "disabled";
		$TitleENTRE30y45_ACUM = "No existen pacientes entre 30 y 45 años de edad este año";
		$ColorENTRE30y45_ACUM = "btn-secondary";
	}
	
	$ENTRE46y60_ACUM = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '46' AND '60'");
	$TotalENTRE46y60_ACUM = mysqli_num_rows($ENTRE46y60_ACUM);
	if ($TotalENTRE46y60_ACUM > 0)
	{
		$EstadoENTRE46y60_ACUM = "";
		$TitleENTRE46y60_ACUM = "Pacientes entre 46 y 60 años de edad, clic para verlos por Provincias";
		$ColorENTRE46y60_ACUM = "btn-dark";
	} else {	
		$EstadoENTRE46y60_ACUM = "disabled";
		$TitleENTRE46y60_ACUM = "No existen pacientes entre 46 y 60 años de edad este año";
		$ColorENTRE46y60_ACUM = "btn-secondary";
	}
	
	$MAYOR60_ACUM = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad > '60'");
	$TotalMAYOR60_ACUM = mysqli_num_rows($MAYOR60_ACUM);
	if ($TotalMAYOR60_ACUM > 0)
	{
		$EstadoMAYOR60_ACUM = "";
		$TitleMAYOR60_ACUM = "Pacientes mayores de 60 años de edad, clic para verlos por Provincias";
		$ColorMAYOR60_ACUM = "btn-dark";
	} else {	
		$EstadoMAYOR60_ACUM = "disabled";
		$TitleMAYOR60_ACUM = "No existen pacientes mayores de 60 años de edad este año";
		$ColorMAYOR60_ACUM = "btn-secondary";
	}
	//FIN DE CONSULTAS PARA RANGOS DE EDADES DE PACIENTES ACUMULADO


	//INICIO DE CONSULTAS PARA RANGOS DE EDADES DE PACIENTES EN EL AÑO
	$MENOR20 = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_actual WHERE edad < '20'");
	$TotalMENOR20 = mysqli_num_rows($MENOR20);
	if ($TotalMENOR20 > 0)
	{
		$EstadoMENOR20 = "";
		$TitleMENOR20 = "Pacientes menores de 20 años de edad, clic para verlos por Provincias";
		$ColorMENOR20 = "btn-primary";
	} else {	
		$EstadoMENOR20 = "disabled";
		$TitleMENOR20 = "No existen pacientes menores de 20 años de edad este año";
		$ColorMENOR20 = "btn-secondary";
	}
	
	$ENTRE20y29 = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_actual WHERE edad BETWEEN '20' AND '29'");
	$TotalENTRE20y29 = mysqli_num_rows($ENTRE20y29);
	if ($TotalENTRE20y29 > 0)
	{
		$EstadoENTRE20y29 = "";
		$TitleENTRE20y29 = "Pacientes entre 20 y 29 años de edad, clic para verlos por Provincias";
		$ColorENTRE20y29 = "btn-primary";
	} else {	
		$EstadoENTRE20y29 = "disabled";
		$TitleENTRE20y29 = "No existen pacientes entre 20 y 29 años de edad este año";
		$ColorENTRE20y29 = "btn-secondary";
	}
	
	$ENTRE30y45 = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_actual WHERE edad BETWEEN '30' AND '45'");
	$TotalENTRE30y45 = mysqli_num_rows($ENTRE30y45);
	if ($TotalENTRE30y45 > 0)
	{
		$EstadoENTRE30y45 = "";
		$TitleENTRE30y45 = "Pacientes entre 30 y 45 años de edad, clic para verlos por Provincias";
		$ColorENTRE30y45 = "btn-primary";
	} else {	
		$EstadoENTRE30y45 = "disabled";
		$TitleENTRE30y45 = "No existen pacientes entre 30 y 45 años de edad este año";
		$ColorENTRE30y45 = "btn-secondary";
	}
	
	$ENTRE46y60 = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_actual WHERE edad BETWEEN '46' AND '60'");
	$TotalENTRE46y60 = mysqli_num_rows($ENTRE46y60);
	if ($TotalENTRE46y60 > 0)
	{
		$EstadoENTRE46y60 = "";
		$TitleENTRE46y60 = "Pacientes entre 46 y 60 años de edad, clic para verlos por Provincias";
		$ColorENTRE46y60 = "btn-primary";
	} else {	
		$EstadoENTRE46y60 = "disabled";
		$TitleENTRE46y60 = "No existen pacientes entre 46 y 60 años de edad este año";
		$ColorENTRE46y60 = "btn-secondary";
	}
	
	$MAYOR60 = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_actual WHERE edad > '60'");
	$TotalMAYOR60 = mysqli_num_rows($MAYOR60);
	if ($TotalMAYOR60 > 0)
	{
		$EstadoMAYOR60 = "";
		$TitleMAYOR60 = "Pacientes mayores de 60 años de edad, clic para verlos por Provincias";
		$ColorMAYOR60 = "btn-primary";
	} else {	
		$EstadoMAYOR60 = "disabled";
		$TitleMAYOR60 = "No existen pacientes mayores de 60 años de edad este año";
		$ColorMAYOR60 = "btn-secondary";
	}
	//FIN DE CONSULTAS PARA RANGOS DE EDADES DE PACIENTES EN EL AÑO
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
		
				<div align="center" style="color:#666666; font-size:24px">Resumen de Pacientes</div>
				<div align="center" style="color:#eeeeee; font-size:10px">&nbsp;</div>	
				<!-- Fin de Encabezado -->
				
				<!-- Modal Provincias-->
				<div class="modal fade" id="ProvModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-info">
								<div align="left">
									<span class="text-white" style="font-size:36px">Pacientes por Municipios</span>
								</div>
							</div>
							<div class="modal-body text-info" style="font-size:22px"></div>
							<div class="modal-footer">
								<button class="btn btn-info" data-dismiss="modal" aria-hidden="true">Cerrar</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal Provincias Acum-->
				<div class="modal fade" id="ProvModalAcum" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-dark">
								<div align="left">
									<span class="text-white" style="font-size:36px">Pacientes por Municipios</span>
								</div>
							</div>
							<div class="modal-body text-dark" style="font-size:22px"></div>
							<div class="modal-footer">
								<button class="btn btn-dark" data-dismiss="modal" aria-hidden="true">Cerrar</button>
							</div>
						</div>
					</div>
				</div>
				
				<!-- Modal Grupos Edades-->
				<div class="modal fade" id="EdadModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-primary">
								<div align="left">
									<span class="text-white" style="font-size:36px">Pacientes por grupos de edades</span>
								</div>
							</div>
							<div class="modal-body text-primary" style="font-size:22px"></div>
							<div class="modal-footer">
								<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cerrar</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal Grupos Edades Acum-->
				<div class="modal fade" id="EdadModalAcum" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-dark">
								<div align="left">
									<span class="text-white" style="font-size:36px">Pacientes por grupos de edades</span>
								</div>
							</div>
							<div class="modal-body text-dark" style="font-size:22px"></div>
							<div class="modal-footer">
								<button class="btn btn-dark" data-dismiss="modal" aria-hidden="true">Cerrar</button>
							</div>
						</div>
					</div>
				</div>
				
				<!-- COMIENZA LA FILA DE LAS CELDAS -->
				<div class="form-row" align="center">
					<!-- INICIA LA COLUMNA DE VALORES ACUMULADOS -->
					<div class="col-md-6">
						<div class="card border-secondary bg-secondary-10">

							<div align="center" style="font-size:20px">Acumulado desde <?php echo $PRIMERAFECHA; ?><br>Pacientes registrados</div><div style="font-size:2px">&nbsp;</div>
							<div class="form-row ml-0 mr-0">
								<div class="col-md-6 input-group input-group-sm">
									<div class="input-group-prepend"><div class="input-group-text text-dark"><i class='fas fa-restroom fa-flip-horizontal fa-6x'></i>&nbsp;&nbsp;<div align="center" style="font-size:50px"><?php echo $totalRows_PACIENTES_TOTAL; ?></div></div></div>
								</div>

								<div class="col-sm input-group input-group-sm">
									<div class="input-group-prepend"><div class="input-group-text text-dark"><i class='fas fa-female fa-6x'></i>&nbsp;&nbsp;<div align="center" style="font-size:30px"><?php echo $totalRows_PACIENTES_FEMENINOS . "<br>" . $PORCIENTO_FEMENINO ; ?></div></div></div>
								</div>

								<div class="col-sm input-group input-group-sm" align="right">
									<div class="input-group-prepend"><div class="input-group-text text-dark"><i class='fas fa-male fa-6x'></i>&nbsp;&nbsp;<div align="center" style="font-size:30px"><?php echo $totalRows_PACIENTES_MASCULINOS . "<br>" . $PORCIENTO_MASCULINO ; ?></div></div></div>
								</div>
							</div>

							<div style="font-size:6px">&nbsp;</div>
							
							<div align="center" style="font-size:19px">Pacientes por provincia y municipio</div><div style="font-size:1px">&nbsp;</div>
							<!-- INICIA LA COLUMNA DE PACIENTES POR PROVINCIA ACUMULADO -->
							<div class="col-md-12">
								<div class="form-row ml-0 mr-0">
									<div class="col-sm input-group input-group-sm">
										<button type="button" data-id="PINAR DEL RIO" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorPRI_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitlePRI_ACUM; ?>' <?php echo $EstadoPRI_ACUM; ?>>PRI&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalPRI_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-sm input-group input-group-sm">
										<button type="button" data-id="ARTEMISA" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorART_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleART_ACUM; ?>' <?php echo $EstadoART_ACUM; ?>>ART&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalART_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-sm input-group input-group-sm">
										<button type="button" data-id="MAYABEQUE" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorMAY_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleMAY_ACUM; ?>' <?php echo $EstadoMAY_ACUM; ?>>MAY&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalMAY_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-sm input-group input-group-sm">
										<button type="button" data-id="LA HABANA" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorLHA_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleLHA_ACUM; ?>' <?php echo $EstadoLHA_ACUM; ?>>LHA&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalLHA_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
								</div>

								<div style="font-size:2px">&nbsp;</div>

								<div class="form-row ml-0 mr-0">
									<div class="col-md">
										<button type="button" data-id="MATANZAS" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorMTZ_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleMTZ_ACUM; ?>' <?php echo $EstadoMTZ_ACUM; ?>>MTZ&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalMTZ_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="VILLA CLARA" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorVLC_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleVLC_ACUM; ?>' <?php echo $EstadoVLC_ACUM; ?>>VLC&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalVLC_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="CIENFUEGOS" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorCFG_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleCFG_ACUM; ?>' <?php echo $EstadoCFG_ACUM; ?>>CFG&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalCFG_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="SANCTI SPIRITUS" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorSSP_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleSSP_ACUM; ?>' <?php echo $EstadoSSP_ACUM; ?>>SSP&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalSSP_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
								</div>

								<div style="font-size:2px">&nbsp;</div>

								<div class="form-row ml-0 mr-0" >
									<div class="col-md">
										<button type="button" data-id="CIEGO DE AVILA" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorCAV_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleCAV_ACUM; ?>' <?php echo $EstadoCAV_ACUM; ?>>CAV&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalCAV_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="CAMAGUEY" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorCMW_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleCMW_ACUM; ?>' <?php echo $EstadoCMW_ACUM; ?>>CMG&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalCMW_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="LAS TUNAS" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorLTU_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleLTU_ACUM; ?>' <?php echo $EstadoLTU_ACUM; ?>>LTU&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalLTU_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="HOLGUIN" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorHOL_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleHOL_ACUM; ?>' <?php echo $EstadoHOL_ACUM; ?>>HOL&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalHOL_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
								</div>

								<div style="font-size:4px">&nbsp;</div>

								<div class="form-row ml-0 mr-0" >
									<div class="col-md">
										<button type="button" data-id="GRANMA" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorGRA_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleGRA_ACUM; ?>' <?php echo $EstadoGRA_ACUM; ?>>GRA&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalGRA_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="SANTIAGO DE CUBA" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorSTG_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleSTG_ACUM; ?>' <?php echo $EstadoSTG_ACUM; ?>>STG&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalSTG_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="GUANTANAMO" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorGTM_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleGTM_ACUM; ?>' <?php echo $EstadoGTM_ACUM; ?>>GTM&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalGTM_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="ISLA DE LA JUVENTUD" class="provinciainfo_acum btn btn-block btn-xs <?php echo $ColorILJ_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleILJ_ACUM; ?>' <?php echo $EstadoILJ_ACUM; ?>>ILJ&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalILJ_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
								</div>
							</div>
							<!-- INICIA LA COLUMNA DE PACIENTES POR PROVINCIA ACUMULADO -->

							<div style="font-size:6px">&nbsp;</div>

							<!-- INICIA LA COLUMNA DE GRUPOS DE PACIENTES POR EDADES Y PROVINCIAS EN EL AÑO -->
							<div class="col-md-12">
								<div align="center" style="font-size:19px">Pacientes por grupos de edades y provincias</div><div style="font-size:1px">&nbsp;</div>
								<div class="form-row ml-0 mr-0">
									<div class="col-md">
										<button type="button" data-id="MENORES DE 20 AÑOS" class="grupoesedades_acum btn btn-block btn-xs <?php echo $ColorMENOR20_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleMENOR20_ACUM; ?>' <?php echo $EstadoMENOR20_ACUM; ?>>< 20&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalMENOR20_ACUM; ?></span><span class="sr-only"></span></button>
									</div>

									<div class="col-md">
										<button type="button" data-id="ENTRE 20 Y 29 AÑOS" class="grupoesedades_acum btn btn-block btn-xs <?php echo $ColorENTRE20y29_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleENTRE20y29_ACUM; ?>' <?php echo $EstadoENTRE20y29_ACUM; ?>>20 - 29&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalENTRE20y29_ACUM; ?></span><span class="sr-only"></span></button>
									</div>

									<div class="col-md">
										<button type="button" data-id="ENTRE 30 Y 45 AÑOS" class="grupoesedades_acum btn btn-block btn-xs <?php echo $ColorENTRE30y45_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleENTRE30y45_ACUM; ?>' <?php echo $EstadoENTRE30y45_ACUM; ?>>30 - 45&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalENTRE30y45_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
									
									<div class="col-md">
										<button type="button" data-id="ENTRE 46 Y 60 AÑOS" class="grupoesedades_acum btn btn-block btn-xs <?php echo $ColorENTRE46y60_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleENTRE46y60_ACUM; ?>' <?php echo $EstadoENTRE46y60_ACUM; ?>>46 y 60&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalENTRE46y60_ACUM; ?></span><span class="sr-only"></span></button>
									</div>

									<div class="col-md">
										<button type="button" data-id="MAYORES DE 60 AÑOS" class="grupoesedades_acum btn btn-block btn-xs <?php echo $ColorMAYOR60_ACUM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleMAYOR60_ACUM; ?>' <?php echo $EstadoMAYOR60_ACUM; ?>>> 60&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalMAYOR60_ACUM; ?></span><span class="sr-only"></span></button>
									</div>
								</div>
							</div>
							<!-- FINALIZA LA COLUMNA DE GRUPOS DE PACIENTES POR EDADES Y PROVINCIAS EN EL AÑO-->
							<div style="font-size:4px">&nbsp;</div>
						</div>
					</div>
					<!-- FINALIZA LA COLUMNA DE VALORES ACUMULADOS -->
					
					<!-- INICIA LA COLUMNA DE VALORES ANUALES -->
					<div class="col-md-6">
						<div class="card border-secondary bg-secondary-10">
							<div align="center" style="font-size:20px">Año&nbsp;<?php echo $YEARACTUAL; ?><br>Pacientes registrados</div><div style="font-size:1px">&nbsp;</div>
							<div class="form-row ml-0 mr-0">
								<div class="col-md-6 input-group input-group-sm">
									<div class="input-group-prepend"><div class="input-group-text text-primary"><i class='fas fa-restroom fa-flip-horizontal fa-6x'></i>&nbsp;&nbsp;<div align="center" style="font-size:50px"><?php echo $totalRows_PACIENTES_TOTAL_YEAR; ?></div></div></div>
								</div>

								<div class="col-sm input-group input-group-sm">
									<div class="input-group-prepend"><div class="input-group-text text-danger"><i class='fas fa-female fa-6x'></i>&nbsp;&nbsp;<div align="center" style="font-size:30px"><?php echo $totalRows_PACIENTES_FEMENINOS_YEAR . "<br>" . $PORCIENTO_FEMENINO_YEAR ; ?></div></div></div>
								</div>

								<div class="col-sm input-group input-group-sm" align="right">
									<div class="input-group-prepend"><div class="input-group-text text-success"><i class='fas fa-male fa-6x'></i>&nbsp;&nbsp;<div align="center" style="font-size:30px"><?php echo $totalRows_PACIENTES_MASCULINOS_YEAR . "<br>" . $PORCIENTO_MASCULINO_YEAR ; ?></div></div></div>
								</div>
							</div>

							<div style="font-size:6px">&nbsp;</div>

							<!-- INICIA LA COLUMNA DE PACIENTES POR PROVINCIA EN EL AÑO -->
							<div class="col-md-12">
								<div align="center" style="font-size:19px">Pacientes por provincia y municipio</div><div style="font-size:1px">&nbsp;</div>
								<div class="form-row ml-0 mr-0">
									<div class="col-md">
										<button type="button" data-id="PINAR DEL RIO" class="provinciainfo btn btn-block btn-xs <?php echo $ColorPRI; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitlePRI; ?>' <?php echo $EstadoPRI; ?>>PRI&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalPRI; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="ARTEMISA" class="provinciainfo btn btn-block btn-xs <?php echo $ColorART; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleART; ?>' <?php echo $EstadoART; ?>>ART&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalART; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="MAYABEQUE" class="provinciainfo btn btn-block btn-xs <?php echo $ColorMAY; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleMAY; ?>' <?php echo $EstadoMAY; ?>>MAY&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalMAY; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="LA HABANA" class="provinciainfo btn btn-block btn-xs <?php echo $ColorLHA; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleLHA; ?>' <?php echo $EstadoLHA; ?>>LHA&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalLHA; ?></span><span class="sr-only"></span></button>
									</div>
								</div>

								<div style="font-size:2px">&nbsp;</div>

								<div class="form-row ml-0 mr-0">
									<div class="col-md">
										<button type="button" data-id="MATANZAS" class="provinciainfo btn btn-block btn-xs <?php echo $ColorMTZ; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleMTZ; ?>' <?php echo $EstadoMTZ; ?>>MTZ&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalMTZ; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="VILLA CLARA" class="provinciainfo btn btn-block btn-xs <?php echo $ColorVLC; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleVLC; ?>' <?php echo $EstadoVLC; ?>>VLC&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalVLC; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="CIENFUEGOS" class="provinciainfo btn btn-block btn-xs <?php echo $ColorCFG; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleCFG; ?>' <?php echo $EstadoCFG; ?>>CFG&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalCFG; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="SANCTI SPIRITUS" class="provinciainfo btn btn-block btn-xs <?php echo $ColorSSP; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleSSP; ?>' <?php echo $EstadoSSP; ?>>SSP&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalSSP; ?></span><span class="sr-only"></span></button>
									</div>
								</div>

								<div style="font-size:2px">&nbsp;</div>

								<div class="form-row ml-0 mr-0" >
									<div class="col-md">
										<button type="button" data-id="CIEGO DE AVILA" class="provinciainfo btn btn-block btn-xs <?php echo $ColorCAV; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleCAV; ?>' <?php echo $EstadoCAV; ?>>CAV&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalCAV; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="CAMAGUEY" class="provinciainfo btn btn-block btn-xs <?php echo $ColorCMW; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleCMW; ?>' <?php echo $EstadoCMW; ?>>CMG&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalCMW; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="LAS TUNAS" class="provinciainfo btn btn-block btn-xs <?php echo $ColorLTU; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleLTU; ?>' <?php echo $EstadoLTU; ?>>LTU&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalLTU; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="HOLGUIN" class="provinciainfo btn btn-block btn-xs <?php echo $ColorHOL; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleHOL; ?>' <?php echo $EstadoHOL; ?>>HOL&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalHOL; ?></span><span class="sr-only"></span></button>
									</div>
								</div>

								<div style="font-size:4px">&nbsp;</div>

								<div class="form-row ml-0 mr-0" >
									<div class="col-md">
										<button type="button" data-id="GRANMA" class="provinciainfo btn btn-block btn-xs <?php echo $ColorGRA; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleGRA; ?>' <?php echo $EstadoGRA; ?>>GRA&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalGRA; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="SANTIAGO DE CUBA" class="provinciainfo btn btn-block btn-xs <?php echo $ColorSTG; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleSTG; ?>' <?php echo $EstadoSTG; ?>>STG&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalSTG; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="GUANTANAMO" class="provinciainfo btn btn-block btn-xs <?php echo $ColorGTM; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleGTM; ?>' <?php echo $EstadoGTM; ?>>GTM&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalGTM; ?></span><span class="sr-only"></span></button>
									</div>
									<div class="col-md">
										<button type="button" data-id="ISLA DE LA JUVENTUD" class="provinciainfo btn btn-block btn-xs <?php echo $ColorILJ; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleILJ; ?>' <?php echo $EstadoILJ; ?>>ILJ&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalILJ; ?></span><span class="sr-only"></span></button>
									</div>
								</div>
								<div style="font-size:6px">&nbsp;</div>
							</div>
							<!-- INICIA LA COLUMNA DE PACIENTES POR PROVINCIA EN EL AÑO -->

							<!-- INICIA LA COLUMNA DE GRUPOS DE PACIENTES POR EDADES Y PROVINCIAS EN EL AÑO -->
							<div class="col-md-12">
								<div align="center" style="font-size:19px">Pacientes por grupos de edades y provincias</div><div style="font-size:2px">&nbsp;</div>
								<div class="form-row ml-0 mr-0">
									<div class="col-md">
										<button type="button" data-id="MENORES DE 20 AÑOS" class="grupoesedades btn btn-block btn-xs <?php echo $ColorMENOR20; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleMENOR20; ?>' <?php echo $EstadoMENOR20; ?>>< 20&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalMENOR20; ?></span><span class="sr-only"></span></button>
									</div>

									<div class="col-md">
										<button type="button" data-id="ENTRE 20 Y 29 AÑOS" class="grupoesedades btn btn-block btn-xs <?php echo $ColorENTRE20y29; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleENTRE20y29; ?>' <?php echo $EstadoENTRE20y29; ?>>20 - 29&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalENTRE20y29; ?></span><span class="sr-only"></span></button>
									</div>

									<div class="col-md">
										<button type="button" data-id="ENTRE 30 Y 45 AÑOS" class="grupoesedades btn btn-block btn-xs <?php echo $ColorENTRE30y45; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleENTRE30y45; ?>' <?php echo $EstadoENTRE30y45; ?>>30 - 45&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalENTRE30y45; ?></span><span class="sr-only"></span></button>
									</div>
									
									<div class="col-md">
										<button type="button" data-id="ENTRE 46 Y 60 AÑOS" class="grupoesedades btn btn-block btn-xs <?php echo $ColorENTRE46y60; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleENTRE46y60; ?>' <?php echo $EstadoENTRE46y60; ?>>46 - 60&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalENTRE46y60; ?></span><span class="sr-only"></span></button>
									</div>

									<div class="col-md">
										<button type="button" data-id="MAYORES DE 60 AÑOS" class="grupoesedades btn btn-block btn-xs <?php echo $ColorMAYOR60; ?>" data-toggle='tooltip' data-placement='top' title='<?php echo $TitleMAYOR60; ?>' <?php echo $EstadoMAYOR60; ?>>> 60&nbsp;&nbsp;&nbsp;<span class="badge badge-light"><?php echo $TotalMAYOR60; ?></span><span class="sr-only"></span></button>
									</div>
								</div>
							</div>
							<!-- FINALIZA LA COLUMNA DE GRUPOS DE PACIENTES POR EDADES Y PROVINCIAS EN EL AÑO-->
							<div style="font-size:4px">&nbsp;</div>	
							</div>
						</div>
					</div>

					<!-- SCRIPRS NECESARIOS -->
					<script type='text/javascript'>
						//LLAMADA AL MODAL PROVINCIAS
						$(document).ready(function(){
							$('.provinciainfo').click(function(){
								var userid = $(this).data('id');
								// AJAX request
								$.ajax({
									url: 'modal_prov.php',
									type: 'post',
									data: {userid: userid},
									success: function(response){ 
										// Add response in Modal body
										$('.modal-body').html(response); 
										// Display Modal
										$('#ProvModal').modal('show'); 
									}
								});
							});
						});

						//LLAMADA AL MODAL PROVINCIAS ACUM
						$(document).ready(function(){
							$('.provinciainfo_acum').click(function(){
								var userid = $(this).data('id');
								// AJAX request
								$.ajax({
									url: 'modal_prov_acum.php',
									type: 'post',
									data: {userid: userid},
									success: function(response){ 
										// Add response in Modal body
										$('.modal-body').html(response); 
										// Display Modal
										$('#ProvModalAcum').modal('show'); 
									}
								});
							});
						});
						
						// OCULTAR TOOLTIP AL HACER CLIC
						$('[data-toggle="tooltip"]').on('click', function () {
						$(this).tooltip('hide')
						});
						
						//LLAMADA AL MODAL GRUPOS DE EDADES
						$(document).ready(function(){
							$('.grupoesedades').click(function(){
								var userid = $(this).data('id');
								// AJAX request
								$.ajax({
									url: 'modal_edad.php',
									type: 'post',
									data: {userid: userid},
									success: function(response){ 
										// Add response in Modal body
										$('.modal-body').html(response); 
										// Display Modal
										$('#EdadModal').modal('show'); 
									}
								});
							});
						});

						//LLAMADA AL MODAL GRUPOS DE EDADES
						$(document).ready(function(){
							$('.grupoesedades_acum').click(function(){
								var userid = $(this).data('id');
								// AJAX request
								$.ajax({
									url: 'modal_edad_acum.php',
									type: 'post',
									data: {userid: userid},
									success: function(response){ 
										// Add response in Modal body
										$('.modal-body').html(response); 
										// Display Modal
										$('#EdadModalAcum').modal('show'); 
									}
								});
							});
						});
						
						// OCULTAR TOOLTIP AL HACER CLIC
						$('[data-toggle="tooltip"]').on('click', function () {
						$(this).tooltip('hide')
						});
					</script>	
					
					<div style="color:#EEEEEE; font-size:10px" align="center">&nbsp;</div>
				
					<form id="frmReport" name="frmReport" method="post" action="">			
						<div class="form-row" align="center">
							<div class='col-md'></div>			
							<div class='col-md-3' align='center'>
								<?php echo $LINK_REPORTE; ?>
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