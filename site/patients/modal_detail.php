<?php
	include ("../conn/conn.php");

	$userid = $_POST['userid'];

	$sql = $mysqli->query("SELECT * from tbl_pacientes where ci='$userid';");

	function ageCalculator($dob){
		if(!empty($dob)){
			$birthdate = new DateTime($dob);
			$today   = new DateTime('today');
			$age = $birthdate->diff($today)->y;
			return $age;
		}else{
			return 0;
		}
	}
	
	$response = "<table border='0' width='100%'>";
	
	while($row = mysqli_fetch_assoc($sql)){
		$id = $row['ci'];
		$nombre_apellidos	= $row['nombre'] . " " . $row['apellido1'] . " " . $row['apellido2'];
		$HistoriaClinica 	= $row['hc'];
		$CarneIdentidad 	= $row['ci'];
		$Edad 				= ageCalculator($row['fechanac']);
	
		if ($row['sexo'] == "M")
		{
			$Sexo = "<i class='fas fa-3x fa-male'></i>";
		} else {
			$Sexo = "<i class='fas fa-3x fa-female'></i>";
		}
// 
		$Calle 			= "Calle:&nbsp;" . $row['calle'] . ",&nbsp;Nro:&nbsp;" . $row['numero'];
		$Entrecalles	= "Entre:&nbsp;" . $row['entrecalles'];
		$Reparto		= "Reparto:&nbsp;" . $row['reparto'];
		$Municipio		= "Municipio:&nbsp;" . $row['municipio'] . ",&nbsp;Provincia:&nbsp;" . $row['provincia'];
		$FechaInscripcion 	= date('d/m/Y', strtotime($row['fechainscripcion']));
		
		$response .= "<tr>";
		$response .= "<div align='center'>". $Sexo."</div>";
		$response .= "<div align='center' style='font-size:26px'>". $nombre_apellidos."</div>";
		$response .= "<div align='center' style='font-size:16px'>FECHA DE INSCRIPCI&Oacute;N:&nbsp;".$FechaInscripcion."</div>";
		$response .= "<hr>";
		$response .= "</tr>";

		$response .= "<tr>";
		$response .= "<div align='center' style='font-size:24px'>CI:&nbsp;".$CarneIdentidad."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HC:&nbsp;".$HistoriaClinica."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edad:&nbsp;".$Edad."&nbsp;AÑOS</div>";
		$response .= "</tr>";

		$response .= "<tr>";
		$response .= "<div align='left' style='font-size:8px'>&nbsp;</div>";
		$response .= "<div align='left' style='font-size:18px'>" .$Calle."</div>";     
		$response .= "<div align='left' style='font-size:18px'>" .$Entrecalles."</div>";    
		$response .= "<div align='left' style='font-size:18px'>" .$Reparto."</div>";    
		$response .= "<div align='left' style='font-size:20px'>" .$Municipio."</div>";    
	}
	$response .= "</table>";

	echo $response;
	exit;
?>