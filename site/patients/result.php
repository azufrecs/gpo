<?php
	include ("../security/seguridad.php");
	include ("../conn/conn.php");
	include ("../class/message.php");
	setlocale (LC_TIME,"spanish");
	header('Content-Type:text/html; charset=UTF-8');
	
	$FECHAACTUAL = date('Y-m-d');
	$QUE_BUSCAR			=  $_SESSION['QUE_BUSCAR'] ;
	$CRITERIO_BUSQUEDA 	= $_SESSION['CRITERIO_BUSQUEDA'];

	/*How many records you want to show in a single page.*/
	$limit = 10;
	/*How may adjacent page links should be shown on each side of the current page link.*/
	$adjacents = 3;
	/*Get total number of records */

	if(isset($_GET['page']) && $_GET['page'] != "") {
		$page = $_GET['page'];
		$offset = $limit * ($page-1);
	} else {
		$page = 1;
		$offset = 0;
	}

	if ($QUE_BUSCAR == "all")
	{
		$CONSULTA_MYSQL0 = "SELECT * FROM tbl_pacientes ORDER BY apellido1, apellido2, nombre LIMIT $offset, $limit;";
		$CONSULTA_MYSQL1 = "SELECT * FROM tbl_pacientes;";
		$CONSULTA_MYSQL2 = "SELECT COUNT(*) 'total_rows' FROM tbl_pacientes;";
	} else {
		$CONSULTA_MYSQL0 = "SELECT * FROM tbl_pacientes WHERE $QUE_BUSCAR LIKE '$CRITERIO_BUSQUEDA%' ORDER BY apellido1, apellido2, nombre LIMIT $offset, $limit;";
		$CONSULTA_MYSQL1 = "SELECT * FROM tbl_pacientes WHERE $QUE_BUSCAR LIKE '$CRITERIO_BUSQUEDA%';";
		$CONSULTA_MYSQL2 = "SELECT COUNT(*) 'total_rows' FROM tbl_pacientes WHERE $QUE_BUSCAR LIKE '$CRITERIO_BUSQUEDA%';";
	}
		
	$sql = $CONSULTA_MYSQL2;
	$res = mysqli_fetch_object(mysqli_query($mysqli, $sql));
	$total_rows = $res->total_rows;
	//Get the total number of pages.
	$total_pages = ceil($total_rows / $limit);

	///////////////////////////////////////////////

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

	$MostrarPacientes = $mysqli->query($CONSULTA_MYSQL0);
	$MostrarPacientes1 = $mysqli->query($CONSULTA_MYSQL1);

	if (mysqli_num_rows($MostrarPacientes1)>0)
	{	
		$totalRows_rstMostrarPacientes=mysqli_num_rows($MostrarPacientes1);
		if (mysqli_num_rows($MostrarPacientes1)==1)
		{
			$TITULO="Resultado de la b&uacute;squeda&nbsp;(" . $totalRows_rstMostrarPacientes . "&nbsp;Paciente)";
		} else {
			$TITULO="Resultado de la b&uacute;squeda&nbsp;(" . $totalRows_rstMostrarPacientes . "&nbsp;Pacientes)";
		}	
				
	} else {
		$totalRows_rstMostrarPacientes=0;
		$TITULO="Resultado de la b&uacute;squeda";
    }	

	//INICIO DE CONFIGURACION DEL MENU CON BOTONES
		$BOTONES_NAVEGACION = "
		<div class='col-md-12' align='center'>
			<div class='btn-group btn-group-sm'>
				<a class='btn btn-primary' href='..' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para acceder al Men&uacute;'>Men&uacute;</a>
				<a class='btn btn-success' href='../patients/' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para acceder a Captar Paciente'>Captar</a>
				<a class='btn btn-info' href='../patients/search.php' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para realizar otra b&uacute;squeda'>Otra B&uacute;squeda</a>
				<a class='btn btn-secondary' href='../patients/summary.php' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para acceder al Resumen'>Resumen</a>
				<a type='button' class='btn btn-outline-warning text-dark' href='../security/onco.php' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para Salir y acceder a la Web ONCO'>Web ONCO</a>
				<a class='btn btn-warning' href='../security/login.php' role='button' data-toggle='tooltip' data-placement='top' title='Clic aqu&iacute; para cambiar de usuario'>Salir [" . $_SESSION['user'] . "]</a>				
			</div>
		</div>";
	//FIN DE CONFIGURACION DEL MENU CON BOTONES
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
				
				<div align="center" style="color:#666666; font-size:24px"><?php echo $TITULO; ?></div>
				<div align="center" style="color:#eeeeee; font-size:10px">&nbsp;</div>	
				<!-- Fin de Encabezado -->
				
				<!-- Modal -->
				<div class="modal fade" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header bg-secondary">
								<div align="left">
									<span class="text-white" style="font-size:36px">Detalles Paciente</span>
								</div>
							</div>
							<div class="modal-body text-secondary h4"></div>
							<div class="modal-footer">
								<button class="btn btn-secondary" data-dismiss="modal" aria-hidden="true">Cerrar</button>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm" align="center"></div>
					<div class="col-md-11" align="center">
						<table class='table table-bordered-primary table-hover table-sm'>
							<tr class="table-primary">
								<td class="pt-0" align='left'><strong>&nbsp;NOMBRE(S) Y APELLIDOS</strong></td>
								<td class="pt-0 ajustar" align='right'><strong>&nbsp;CARNE IDENTIDAD&nbsp;</strong></td>
								<td class="pt-0 ajustar" align='right'><strong>&nbsp;HISTORIA CLINICA&nbsp;</strong></td>
								<td class="pt-0" align='right'><strong>ACCION&nbsp;</strong></td>
							</tr>
							
							<?php
								if(isset($_GET['aksi']) == 'delete')
								{
									$CI = $_GET['ci'];
									$BorrarPaciente = $mysqli->query("DELETE FROM tbl_pacientes WHERE ci='$CI'");
									header("Location:result.php");
								}

								if($totalRows_rstMostrarPacientes == 0)
								{
									echo '<tr><td colspan="8">&nbsp;No se encontraron resultados.</td></tr>';
								} else {
									while($row = mysqli_fetch_assoc($MostrarPacientes))
									{
										$CI = $row['ci'];
										echo "<tr>";
											echo "<td class='pt-0 pb-0 align-middle' align='left'>" . $row['nombre'] . " " . $row['apellido1'] .  " " . $row['apellido2'] . "</td>";
											echo "<td class='pt-0 pb-0 align-middle' align='right'>" . $row['ci'] . "</td>";
											echo "<td class='pt-0 pb-0 align-middle' align='right'>" . $row['hc'] . "</td>";
											echo '<td class="pt-0 pb-0 align-middle ajustar" align="right">
															<button data-id="'. $CI .'" type="button" class="pacienteinfo btn btn-secondary btn-xs" data-toggle="tooltip" data-placement="right" title="Detalles de '  . $row['nombre'] . " " . $row['apellido1'] .  " " . $row['apellido2'] . '">Detalles <i class="fas fa-user"></i></button>
															<a href=edit.php?ci=' . $row['ci'] . ' data-toggle="tooltip" data-placement="right" title="Editar datos de '  . $row['nombre'] . " " . $row['apellido1'] .  " " . $row['apellido2'] .  '" class="btn btn-info btn-xs">Editar <i class="fas fa-eye"></i></a>
															<a href="result.php?aksi=delete&ci=' . $row['ci'] . '" data-confirm-delete="Confirme la acci&oacute;n sobre&nbsp;'  . $row['nombre'] . " " . $row['apellido1'] .  " " . $row['apellido2'] .  '"><button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="right" title="Eliminar a '  . $row['nombre'] . " " . $row['apellido1'] .  " " . $row['apellido2'] .  '">Eliminar <i class="fas fa-trash"></i></button></a></td>';
										echo "</tr>";
									}
								}
							?>
						</table>
						<?php
							//Checking if the adjacent plus current page number is less than the total page number.
							//If small then page link start showing from page 1 to upto last page.
							if($total_pages <= (1+($adjacents * 2))) {
								$start = 1;
								$end   = $total_pages;
							} else {
								if(($page - $adjacents) > 1) {				   //Checking if the current page minus adjacent is greateer than one.
									if(($page + $adjacents) < $total_pages) {  //Checking if current page plus adjacents is less than total pages.
										$start = ($page - $adjacents);         //If true, then we will substract and add adjacent from and to the current page number  
										$end   = ($page + $adjacents);         //to get the range of the page numbers which will be display in the pagination.
									} else {								   //If current page plus adjacents is greater than total pages.
										$start = ($total_pages - (1+($adjacents*2)));  //then the page range will start from total pages minus 1+($adjacents*2)
										$end   = $total_pages;						   //and the end will be the last page number that is total pages number.
									}
								} else {									   //If the current page minus adjacent is less than one.
									$start = 1;                                //then start will be start from page number 1
									$end   = (1+($adjacents * 2));             //and end will be the (1+($adjacents * 2)).
								}
							}
						?>
						<script type='text/javascript'>
							$(document).ready(function(){
								$('.pacienteinfo').click(function(){
									var userid = $(this).data('id');
									// AJAX request
									$.ajax({
										url: 'modal_detail.php',
										type: 'post',
										data: {userid: userid},
										success: function(response){ 
											// Add response in Modal body
											$('.modal-body').html(response); 
											// Display Modal
											$('#DetailModal').modal('show'); 
										}
									});
								});
							});
							
							// OCULTAR TOOLTIP AL HACER CLIC
							$('[data-toggle="tooltip"]').on('click', function () {
							$(this).tooltip('hide')
							});
						</script>

					</div>	
					<div class="col-sm" align="center"></div>
				</div>
				<?php if($total_pages > 1) { ?>
					<ul class="pagination pagination-sm justify-content-center">
						<!-- Link of the first page -->
						<li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
							<a class='page-link' href='?page=1'><i class='fas fa-fast-backward'></i></a>
						</li>
						<!-- Link of the previous page -->
						<li class='page-item <?php ($page <= 1 ? print 'disabled' : '')?>'>
							<a class='page-link' href='?page=<?php ($page>1 ? print($page-1) : print 1)?>'><i class='fas fa-step-backward'></i></a>
						</li>
						<!-- Links of the pages with page number -->
						<?php for($i=$start; $i<=$end; $i++) { ?>
						<li class='page-item <?php ($i == $page ? print 'active' : '')?>'>
							<a class='page-link' href='?page=<?php echo $i;?>'><?php echo $i;?></a>
						</li>
						<?php } ?>
						<!-- Link of the next page -->
						<li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
							<a class='page-link' href='?page=<?php ($page < $total_pages ? print($page+1) : print $total_pages)?>'><i class='fas fa-step-forward'></i></a>
						</li>
						<!-- Link of the last page -->
						<li class='page-item <?php ($page >= $total_pages ? print 'disabled' : '')?>'>
							<a class='page-link' href='?page=<?php echo $total_pages;?>'><i class='fas fa-fast-forward'></i></a>
						</li>
					</ul>
				<?php } ?>
				<div style="color:#eeeeee; font-size:10px">.</div>
			</div>
			
			
			<!-- Inicio del Pie de Página -->
			<footer>
				<?php echo $BOTONES_NAVEGACION; ?><br class="quitar_espacios"><div align="center" style="color:#eeeeee; font-size:4px">&nbsp;</div><div align="center" style="color:#999; font-size:12px">Hospital Provincial Docente de Oncolog&iacute;a "Mar&iacute;a Curie"</div>
			</footer>
			<!-- Fin del Pie de Página -->
		</div>	
	</body>
</html>