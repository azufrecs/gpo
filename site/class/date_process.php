<?php
    $FECHAACTUAL = "";
	$DATE_PROCESS = $mysqli->query("SELECT * FROM tbl_global_date_process");
	if (mysqli_num_rows($DATE_PROCESS) > 0) {
        while ($row_DATE_PROCESS = mysqli_fetch_assoc($DATE_PROCESS)) {
            $FECHAACTUAL = $row_DATE_PROCESS['fecha_proceso'];
            if (strlen($FECHAACTUAL) <> 10) {
                header("Location:https://gpo.onco.cmw.sld.cu/site/");
			}
        }
	} else {
        header("Location:https://gpo.onco.cmw.sld.cu/site/");
    }		
?>
