<?php
	include ("../conn/conn.php");

	$userid = $_POST['userid'];
	$sql = $mysqli->query("SELECT provincia, municipio, Count(municipio) AS pacientes FROM tbl_pacientes WHERE YEAR(fechainscripcion)=YEAR(CURDATE()) GROUP BY provincia, municipio HAVING provincia='$userid' ORDER BY pacientes DESC");
	
	$Consulta = $mysqli->query("SELECT * FROM tbl_pacientes WHERE provincia = '$userid' AND YEAR(fechainscripcion)=YEAR(CURDATE())");
	$Total = mysqli_num_rows($Consulta);
	
	//WHERE YEAR(fechainscripcion)=YEAR(CURDATE()) ORDER BY pacientes DESC
	echo "<div align='center' style='font-size:34px'>" . $userid . "&nbsp;(" . $Total . ")</div>";
	echo "<hr>";
	$num_fila = 0; 
	$izquierda	= "";
	$derecha	= "";
	while($row = mysqli_fetch_assoc($sql)){
		$provincia = $row['provincia'];
		$municipio = $row['municipio'];
		$pacientes = $row['pacientes'];
		
		if ($num_fila%2==0)  
		{
			$izquierda	= $izquierda . $municipio. "&nbsp;(" . $pacientes. ")<br>";
		} else {
			$derecha	= $derecha . $municipio. "&nbsp;(" . $pacientes. ")<br>";	
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