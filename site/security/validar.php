<?php 
	error_reporting(0);		
	
	$PERMISO = "NO";
	
	// ASIGNO VARIABLES PARA ACCESAR AL SERVIDOR LDAP
	$host = "192.168.40.2";
	$userr = $_POST['txtUsername'];
	$user = $_POST['txtUsername'] . "@onco.cmw.sld.cu";
	$pswd = $_POST['txtPassword'];
	$ad = ldap_connect($host) or die("No se ha podido conectar al Controlador de Dominio SMC");
	
	// ESPECIFICO LA VERSIÓN DEL PROTOCOLO LDAP
	ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3) or die ("Imposible asignar el Protocolo LDAP");
	
	// VALIDO LAS CREDENCIALES PARA ACCESAR AL SERVIDOR LDAP
	$bd = ldap_bind($ad, $user, $pswd) or header("Location:../../index.php"); 
	
	// CREO EL DN
	$dn = "OU=USUARIOS,DC=onco,DC=cmw,DC=sld,DC=cu";
	
	// ESPECIFICO LOS PARÁMETROS QUE QUIERO QUE ME REGRESE LA CONSULTA
	$attrs = array("memberOf");
	
	// CREO EL FILTRO PARA LA BUSQUEDA
	$filter = "(samaccountname=$userr)";
	$search = ldap_search($ad, $dn, $filter, $attrs) or die ("");
	$entries = ldap_get_entries($ad, $search);
	
	if ($entries["count"] > 0)
	{
		for ($i=0; $i<$entries["count"]; $i++)
		{			
			$GRUPO0 = "VACIO";
			$GRUPO1 = "VACIO";
			$GRUPO2 = "VACIO";
			$GRUPO3 = "VACIO";
			$GRUPO4 = "VACIO";
			$GRUPO5 = "VACIO";
			$GRUPO6 = "VACIO";
			$GRUPO7 = "VACIO";
			$GRUPO8 = "VACIO";
			$PERMISO = "NO";			
			if (isset($entries[$i]["memberof"][0]))
			{
				$GRUPO0 = substr($entries[$i]["memberof"][0],3, strpos($entries[$i]["memberof"][0], ",") - strlen($entries[$i]["memberof"][0]));				
			}

			if (isset($entries[$i]["memberof"][1]))
			{
				$GRUPO1 = substr($entries[$i]["memberof"][1],3, strpos($entries[$i]["memberof"][1], ",") - strlen($entries[$i]["memberof"][1]));				
			}
			
			if (isset($entries[$i]["memberof"][2]))
			{
				$GRUPO2 = substr($entries[$i]["memberof"][2],3, strpos($entries[$i]["memberof"][2], ",") - strlen($entries[$i]["memberof"][2]));				
			}
			
			if (isset($entries[$i]["memberof"][3]))
			{
				$GRUPO3 = substr($entries[$i]["memberof"][3],3, strpos($entries[$i]["memberof"][3], ",") - strlen($entries[$i]["memberof"][3]));				
			}
			
			if (isset($entries[$i]["memberof"][4]))
			{
				$GRUPO4 = substr($entries[$i]["memberof"][4],3, strpos($entries[$i]["memberof"][4], ",") - strlen($entries[$i]["memberof"][4]));				
			}
			
			if (isset($entries[$i]["memberof"][5]))
			{
				$GRUPO5 = substr($entries[$i]["memberof"][5],3, strpos($entries[$i]["memberof"][5], ",") - strlen($entries[$i]["memberof"][5]));				
			}
			
			if (isset($entries[$i]["memberof"][6]))
			{
				$GRUPO6 = substr($entries[$i]["memberof"][6],3, strpos($entries[$i]["memberof"][6], ",") - strlen($entries[$i]["memberof"][6]));				
			}
			
			if (isset($entries[$i]["memberof"][7]))
			{
				$GRUPO7 = substr($entries[$i]["memberof"][7],3, strpos($entries[$i]["memberof"][7], ",") - strlen($entries[$i]["memberof"][7]));				
			}
			
			if (isset($entries[$i]["memberof"][8]))
			{
				$GRUPO8 = substr($entries[$i]["memberof"][8],3, strpos($entries[$i]["memberof"][8], ",") - strlen($entries[$i]["memberof"][8]));				
			}
		}

		if ($GRUPO0 == "GESTION_PACIENTES" or $GRUPO1 == "GESTION_PACIENTES" or $GRUPO2 == "GESTION_PACIENTES" or $GRUPO3 == "GESTION_PACIENTES"  or $GRUPO4 == "GESTION_PACIENTES" or $GRUPO5 == "GESTION_PACIENTES" or $GRUPO6 == "GESTION_PACIENTES" or $GRUPO7 == "GESTION_PACIENTES" or $GRUPO8 == "GESTION_PACIENTES")
		{
			$PERMISO = "SI";
		}	
		
		if($PERMISO == "NO" || strlen($PERMISO) == 0)
		{
			$_SERVER = array();
			$_SESSION = array();
			$_SESSION["autentica"] = "NO";
			header("Location:../../error.php");
		} else {
			session_start();
			$_SESSION["user"] = $userr;
			$_SESSION["autentica"] = "SI";
			echo"<script>window.location.href='..'; </script>";
		}
	}

	ldap_unbind($ad);

	// EN CASO DE NO TENER USUARIO DEFINIDO DENTRO DE AD
	echo"<script>window.location.href='../../error.php'; </script>";
?>