<?php
	@session_start();
	if($_SESSION["autentica"] != "SI"){
		header("Location: https://gpo.onco.cmw.sld.cu");
		exit();
	}
?>
