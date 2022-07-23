<?php
	include ("../conn/conn.php");

	$userid = $_POST['userid'];
	
	switch ($userid) 
	{
		case "MENORES DE 20 AÑOS":
			$sql = $mysqli->query("SELECT Count(edad) AS pacientes, provincia FROM view_edad_pacientes_year_acum WHERE edad < '20' GROUP BY provincia");
			$Consulta = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad < '20'");
			$Total = mysqli_num_rows($Consulta);
			break;
		case "ENTRE 20 Y 29 AÑOS":
			$sql = $mysqli->query("SELECT Count(edad) AS pacientes, provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '20' AND '29' GROUP BY provincia");
			$Consulta = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '20' AND '29'");
			$Total = mysqli_num_rows($Consulta);
			break;
		case "ENTRE 30 Y 45 AÑOS":
			$sql = $mysqli->query("SELECT Count(edad) AS pacientes, provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '30' AND '45' GROUP BY provincia");
			$Consulta = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '30' AND '45'");
			$Total = mysqli_num_rows($Consulta);
			break;
		case "ENTRE 46 Y 60 AÑOS":
			$sql = $mysqli->query("SELECT Count(edad) AS pacientes, provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '46' AND '60' GROUP BY provincia");
			$Consulta = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad BETWEEN '46' AND '60'");
			$Total = mysqli_num_rows($Consulta);
			break;
		case "MAYORES DE 60 AÑOS":
			$sql = $mysqli->query("SELECT Count(edad) AS pacientes, provincia FROM view_edad_pacientes_year_acum WHERE edad > '60' GROUP BY provincia");
			$Consulta = $mysqli->query("SELECT provincia FROM view_edad_pacientes_year_acum WHERE edad > '60'");
			$Total = mysqli_num_rows($Consulta);
			break;		
	}
	
	echo "<div align='center' style='font-size:34px'>" . $userid . "&nbsp;(" . $Total . ")</div>";
	echo "<hr>";
	
	$num_fila = 0; 
	$izquierda	= "";
	$derecha	= "";
	while($row = mysqli_fetch_assoc($sql)){
		$provincia = $row['provincia'];
		$pacientes = $row['pacientes'];
		
		if ($num_fila%2==0)  
		{
			$izquierda	= $izquierda . $provincia . "&nbsp;(" . $pacientes. ")<br>";
		} else {
			$derecha	= $derecha . $provincia . "&nbsp;(" . $pacientes. ")<br>";	
		}
		
		$num_fila++; 
	}
	
	$response = "<table border='0' width='100%'>";
		$response .= "<tr>";
			$response .= "<td align='left' valign='middle'>" . $izquierda . "</td>";
			$response .= "<td align='right' valign='middle'>" . $derecha. " </td>";
		$response .= "</tr>";
	$response .= "</table>";

	echo $response;
	exit;
?>