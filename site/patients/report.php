<?php
    include ("../security/seguridad.php");
	include ("../conn/conn.php");
	include ("../class/message.php");
	require_once '../class/PHPExcel/IOFactory.php';
	setlocale (LC_TIME,"spanish");
	header('Content-Type:text/html; charset=UTF-8');
    
	//OBTENIENDO VALORES 
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
	
	//INICIO DE CONSULTAS PARA TOTALES DE PACIENTES Y PORCIENTES ACUMULADOS Y ANUALES POR PROVINCIA Y MUNICIPIOS AÑO ACTUAL	
	$PRI = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'PINAR DEL RIO' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalPRI = mysqli_num_rows($PRI) . " ";
		
	$ART = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'ARTEMISA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalART = mysqli_num_rows($ART) . " ";
		
	$MAY = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'MAYABEQUE' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalMAY = mysqli_num_rows($MAY) . " ";
	
	$LHA = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'LA HABANA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalLHA = mysqli_num_rows($LHA) . " ";

	$MTZ = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'MATANZAS' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalMTZ = mysqli_num_rows($MTZ) . " ";
	
	$VLC = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'VILLA CLARA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalVLC = mysqli_num_rows($VLC) . " ";
	
	$CFG = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CIENFUEGOS' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalCFG = mysqli_num_rows($CFG) . " ";
	
	$SSP = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'SANCTI SPIRITUS' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalSSP = mysqli_num_rows($SSP) . " ";

	$CAV = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CIEGO DE AVILA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalCAV = mysqli_num_rows($CAV) . " ";
	
	$CMW = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CAMAGUEY' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalCMW = mysqli_num_rows($CMW) . " ";
	
	$LTU = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'LAS TUNAS' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalLTU = mysqli_num_rows($LTU) . " ";
	
	$HOL = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'HOLGUIN' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalHOL = mysqli_num_rows($HOL) . " ";
	
	$GRA = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'GRANMA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalGRA = mysqli_num_rows($GRA) . " ";
	
	$STG = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'SANTIAGO DE CUBA' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalSTG = mysqli_num_rows($STG) . " ";
	
	$GTM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'GUANTANAMO' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalGTM = mysqli_num_rows($GTM) . " ";
	
	$ILJ = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'ISLA DE LA JUVENTUD' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$TotalILJ = mysqli_num_rows($ILJ) . " ";
	//FIN DE CONSULTAS PARA TOTALES DE PACIENTES Y PORCIENTES ACUMULADOS Y ANUALES POR PROVINCIA Y MUNICIPIOS AÑO ACTUAL
	
	//////////////////////////////////////////////////////////////////////////

	//INICIO DE CONSULTAS PARA TOTALES DE PACIENTES Y PORCIENTES ACUMULADOS Y ANUALES POR PROVINCIA Y MUNICIPIOS ACUMULADO
	$PRI_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'PINAR DEL RIO'");
	$TotalPRI_ACUM = mysqli_num_rows($PRI_ACUM) . " ";
		
	$ART_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'ARTEMISA'");
	$TotalART_ACUM = mysqli_num_rows($ART_ACUM) . " ";
		
	$MAY_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'MAYABEQUE'");
	$TotalMAY_ACUM = mysqli_num_rows($MAY_ACUM) . " ";
	
	$LHA_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'LA HABANA'");
	$TotalLHA_ACUM = mysqli_num_rows($LHA_ACUM) . " ";

	$MTZ_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'MATANZAS'");
	$TotalMTZ_ACUM = mysqli_num_rows($MTZ_ACUM) . " ";
	
	$VLC_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'VILLA CLARA'");
	$TotalVLC_ACUM = mysqli_num_rows($VLC_ACUM) . " ";
	
	$CFG_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CIENFUEGOS'");
	$TotalCFG_ACUM = mysqli_num_rows($CFG_ACUM) . " ";
	
	$SSP_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'SANCTI SPIRITUS'");
	$TotalSSP_ACUM = mysqli_num_rows($SSP_ACUM) . " ";

	$CAV_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CIEGO DE AVILA'");
	$TotalCAV_ACUM = mysqli_num_rows($CAV_ACUM) . " ";
	
	$CMW_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'CAMAGUEY'");
	$TotalCMW_ACUM = mysqli_num_rows($CMW_ACUM) . " ";
	
	$LTU_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'LAS TUNAS'");
	$TotalLTU_ACUM = mysqli_num_rows($LTU_ACUM) . " ";
	
	$HOL_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'HOLGUIN'");
	$TotalHOL_ACUM = mysqli_num_rows($HOL_ACUM) . " ";
	
	$GRA_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'GRANMA'");
	$TotalGRA_ACUM = mysqli_num_rows($GRA_ACUM) . " ";
	
	$STG_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'SANTIAGO DE CUBA'");
	$TotalSTG_ACUM = mysqli_num_rows($STG_ACUM) . " ";
	
	$GTM_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'GUANTANAMO'");
	$TotalGTM_ACUM = mysqli_num_rows($GTM_ACUM) . " ";
	
	$ILJ_ACUM = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = 'ISLA DE LA JUVENTUD'");
	$TotalILJ_ACUM = mysqli_num_rows($ILJ_ACUM) . " ";
	//FIN DE CONSULTAS PARA TOTALES DE PACIENTES Y PORCIENTES ACUMULADOS Y ANUALES POR PROVINCIA Y MUNICIPIOS ACUMULADO
	
	//////////////////////////////////////////////////////////////////////////
	
	//INICIO DE CONSULTAS PARA RANGOS DE EDADES DE PACIENTES AÑO ACTUAL
	$MENOR20 = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_actual WHERE edad < '20'");
	$TotalMENOR20 = mysqli_num_rows($MENOR20) . " ";
	
	$ENTRE20y29 = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_actual WHERE edad BETWEEN '20' AND '29'");
	$TotalENTRE20y29 = mysqli_num_rows($ENTRE20y29) . " ";
	
	$ENTRE30y45 = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_actual WHERE edad BETWEEN '30' AND '45'");
	$TotalENTRE30y45 = mysqli_num_rows($ENTRE30y45) . " ";
	
	$ENTRE46y60 = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_actual WHERE edad BETWEEN '46' AND '60'");
	$TotalENTRE46y60 = mysqli_num_rows($ENTRE46y60) . " ";
	
	$MAYOR60 = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_actual WHERE edad > '60'");
	$TotalMAYOR60 = mysqli_num_rows($MAYOR60) . " ";
	//FIN DE CONSULTAS PARA RANGOS DE EDADES DE PACIENTES AÑO ACTUAL

	//INICIO DE CONSULTAS PARA RANGOS DE EDADES DE PACIENTES ACUMULADO
	$MENOR20_ACUM = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad < '20'");
	$TotalMENOR20_ACUM = mysqli_num_rows($MENOR20_ACUM) . " ";
	
	$ENTRE20y29_ACUM = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '20' AND '29'");
	$TotalENTRE20y29_ACUM = mysqli_num_rows($ENTRE20y29_ACUM) . " ";
	
	$ENTRE30y45_ACUM = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '30' AND '45'");
	$TotalENTRE30y45_ACUM = mysqli_num_rows($ENTRE30y45_ACUM) . " ";
	
	$ENTRE46y60_ACUM = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '46' AND '60'");
	$TotalENTRE46y60_ACUM = mysqli_num_rows($ENTRE46y60_ACUM) . " ";
	
	$MAYOR60_ACUM = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad > '60'");
	$TotalMAYOR60_ACUM = mysqli_num_rows($MAYOR60_ACUM) . " ";
	//FIN DE CONSULTAS PARA RANGOS DE EDADES DE PACIENTES ACUMULADO
	
    /////////////////////////////////////////////////////////////////////////////////////////////////////
	// COMIENZO EL PROCESO DE GENERACION DEL REPORTE ////////////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////
        // LIMPIANDO DIRECTORIO EXPORTS
        $DIRECTORIO = "exports/";
        $HANDLE = opendir($DIRECTORIO);
        while ($FILE = readdir($HANDLE)) {
            if ($FILE!= "." && $FILE != ".." && $FILE!=".htaccess") {
                unlink($DIRECTORIO . $FILE);
            }
        }

        $NOMBRE_REPORTE = "REPORTE-GPO-" . date('dmY') . ".xls";
    
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load("template/reporte.xls");
		//$objPHPExcel->getActiveSheet()->setCellValue(CELDA, VALOR);

		//PRIMERA FECHA DE PACIENTES
		$objPHPExcel->getActiveSheet()->setCellValue("A1", "RESUMEN DE PACIENTES REGISTRADOS EN ONCO DESDE " . $PRIMERAFECHA);
		
		//PACIENTES REGISTRADOS HASTA LA FECHA
		$objPHPExcel->getActiveSheet()->setCellValue("A5", $totalRows_PACIENTES_TOTAL);
		$objPHPExcel->getActiveSheet()->setCellValue("C5", $totalRows_PACIENTES_FEMENINOS . " (" . $PORCIENTO_FEMENINO . ")");
		$objPHPExcel->getActiveSheet()->setCellValue("D5", $totalRows_PACIENTES_MASCULINOS . " (" . $PORCIENTO_MASCULINO . ")");
		
		//PACIENTES REGISTRADOS ESTE AÑO
		$objPHPExcel->getActiveSheet()->setCellValue("F3", "PACIENTES REGISTRADOS EN " . $YEARACTUAL);
		$objPHPExcel->getActiveSheet()->setCellValue("F5", $totalRows_PACIENTES_TOTAL_YEAR);
		$objPHPExcel->getActiveSheet()->setCellValue("H5", $totalRows_PACIENTES_FEMENINOS_YEAR . " (" . $PORCIENTO_FEMENINO_YEAR . ")");
		$objPHPExcel->getActiveSheet()->setCellValue("I5", $totalRows_PACIENTES_MASCULINOS_YEAR . " (" . $PORCIENTO_MASCULINO_YEAR . ")");
		
		//PACIENTES POR PROVINCIAS ESTE ACUMULADO
		$objPHPExcel->getActiveSheet()->setCellValue("D8", $TotalPRI_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D9", $TotalART_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D10", $TotalMAY_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D11", $TotalLHA_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D12", $TotalMTZ_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D13", $TotalVLC_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D14", $TotalCFG_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D15", $TotalSSP_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D16", $TotalCAV_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D17", $TotalCMW_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D18", $TotalLTU_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D19", $TotalHOL_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D20", $TotalGRA_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D21", $TotalSTG_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D22", $TotalGTM_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D23", $TotalILJ_ACUM);

		//PACIENTES POR PROVINCIAS ESTE AÑO
		$objPHPExcel->getActiveSheet()->setCellValue("F7", "PACIENTES POR PROVINCIAS " . $YEARACTUAL);
		$objPHPExcel->getActiveSheet()->setCellValue("I8", $TotalPRI);
		$objPHPExcel->getActiveSheet()->setCellValue("I9", $TotalART);
		$objPHPExcel->getActiveSheet()->setCellValue("I10", $TotalMAY);
		$objPHPExcel->getActiveSheet()->setCellValue("I11", $TotalLHA);
		$objPHPExcel->getActiveSheet()->setCellValue("I12", $TotalMTZ);
		$objPHPExcel->getActiveSheet()->setCellValue("I13", $TotalVLC);
		$objPHPExcel->getActiveSheet()->setCellValue("I14", $TotalCFG);
		$objPHPExcel->getActiveSheet()->setCellValue("I15", $TotalSSP);
		$objPHPExcel->getActiveSheet()->setCellValue("I16", $TotalCAV);
		$objPHPExcel->getActiveSheet()->setCellValue("I17", $TotalCMW);
		$objPHPExcel->getActiveSheet()->setCellValue("I18", $TotalLTU);
		$objPHPExcel->getActiveSheet()->setCellValue("I19", $TotalHOL);
		$objPHPExcel->getActiveSheet()->setCellValue("I20", $TotalGRA);
		$objPHPExcel->getActiveSheet()->setCellValue("I21", $TotalSTG);
		$objPHPExcel->getActiveSheet()->setCellValue("I22", $TotalGTM);
		$objPHPExcel->getActiveSheet()->setCellValue("I23", $TotalILJ);
		
		//PACIENTES POR GRUPOS DE EDADES ESTE AÑO ACUMULADO
		$objPHPExcel->getActiveSheet()->setCellValue("D26", $TotalMENOR20_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D27", $TotalENTRE20y29_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D28", $TotalENTRE30y45_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D29", $TotalENTRE46y60_ACUM);
		$objPHPExcel->getActiveSheet()->setCellValue("D30", $TotalMAYOR60_ACUM);

		//PACIENTES POR GRUPOS DE EDADES ESTE AÑO
		$objPHPExcel->getActiveSheet()->setCellValue("F25", "PACIENTES POR EDADES " . $YEARACTUAL);
		$objPHPExcel->getActiveSheet()->setCellValue("I26", $TotalMENOR20);
		$objPHPExcel->getActiveSheet()->setCellValue("I27", $TotalENTRE20y29);
		$objPHPExcel->getActiveSheet()->setCellValue("I28", $TotalENTRE30y45);
		$objPHPExcel->getActiveSheet()->setCellValue("I29", $TotalENTRE46y60);
		$objPHPExcel->getActiveSheet()->setCellValue("I30", $TotalMAYOR60);

		// ESCRIBO TODO EN EL EXCEL
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save("exports/" . $NOMBRE_REPORTE);
		//$LINK_REPORTE = "<a class='btn btn-success btn-block' href='exports/" . $NOMBRE_REPORTE . "' role='button'><i class='fas fa-file-excel'></i>&nbsp;&nbsp;&nbsp;Descargar Reporte</a>";

	// EXPORTANDO EL FICHERO CREADO
	if (file_exists("exports/" . $NOMBRE_REPORTE)) {
		header('Content-Description: File Transfer');
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename=' . basename("exports/" . $NOMBRE_REPORTE));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize("exports/" . $NOMBRE_REPORTE));
		ob_clean();
		flush();
		readfile("exports/" . $NOMBRE_REPORTE);
		exit;
	} else {
		echo $MESSAGE_ERROR_ARCHIVO_NO_DISPONIBLE;
	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////
	// FINALIZO EL PROCESO DE GENERACION DEL PARTE DIARIO ///////////////////////////////////////////////
	/////////////////////////////////////////////////////////////////////////////////////////////////////
?>