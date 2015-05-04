<html>
<head>
	
    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/sweetalert.min.js"></script>

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/index.css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="css/sweetalert.css">

	<link rel="stylesheet" type="text/css" href="themes/google.css">

	<script>
		function confirmAlert(){
			swal("Éxito", "Alerta generada!", "success");
		};

		function ignoreAlert(){
			swal("Éxito", "Alerta ignorada!", "success");
		};
	</script>
</head>
<body>

	<?php

		if (isset($_REQUEST['mess']))
		{
			$mess = $_REQUEST['mess'];

			switch ($mess)
			{
				case 1: echo '<script> confirmAlert(); </script>'; break;
				case 2: echo '<script> ignoreAlert(); </script>'; break;
			}
		}

	?>

	<div id="header" class="clearfix"><br>
		<h4 class="pull-left" style="padding-left: 5px;">Datos a buscar: </h4><br><br>
		<div id="limit" class="pull-left" style="padding-top: 5px; padding-left: 5px;">
			<button type="button" class="btn lim btn-default active" id="50">50</button>
			<button type="button" class="btn lim btn-default" id="100">100</button>
			<button type="button" class="btn lim btn-default" id="500">500</button>
			<button type="button" class="btn lim btn-default" id="1000">1000</button>
		</div>

		<div style="padding-top: 5px; padding-right: 20px">
			<button type="button" class="btn refresh btn-info pull-right">Recargar datos</button>
		</div>
	</div>

	<div id="tablespace" style="padding: 5px;"><br><br>
	<table id='datatable' class="table table-bordered"><thead><tr>
		<th>ID</th>
		<th>Nodo</th>
		<th>Mensaje</th>
		<th>Historia</th>
		<th>Objeto</th>
		<th>Fecha y hora</th>
		<th>Importancia</th>
		<th>Estado de OS</th>
		<th>ID de OS</th>
		<th>Generar OS</th>
		<th>Ignorar alerta</th>
	</tr></thead>
	<tbody></tbody>
	</table></div>

</body>

<script type="text/javascript" charset="utf-8">

	$(document).ready(function (){
		var Q = $('button.active').attr('id');

    	$('#datatable').dataTable({
    		"order": [[0, "desc"]],
    		"language": {
    			"url": "localisation/spanish.json"
    		},
        	"sAjaxSource": "datafetch.php?lim="+Q
		});
	});

	$('button.btn.lim').click(function(){
		$('button.active').toggleClass('active');
		$(this).addClass('active');

		Q = $(this).attr('id');

		$('#datatable').dataTable({
			"bDestroy": true,
			"order": [[0, "desc"]],
			"language": {
    			"url": "localisation/spanish.json"
    		},
        	"sAjaxSource": "datafetch.php?lim="+Q
		});
	});

	$('button.btn.refresh').click(function(){
		Q = $('button.btn.lim.active').attr('id');

		$('#datatable').dataTable({
			"bDestroy": true,
			"order": [[0, "desc"]],
			"language": {
    			"url": "localisation/spanish.json"
    		},
        	"sAjaxSource": "datafetch.php?lim="+Q
		});
	});

	$('body').on('click', '.generar', function(){

		var id = $(this).attr('id');

		swal({
			title: "Confirmación necesaria",
			text: "¿Seguro que quieres generar una OS para esta alerta?",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "Generar",
			cancelButtonText: "Cancelar",
			closeOnConfirm: false,
			closeOnCancel: true
		},
		function(isConfirm){
			if(isConfirm){
				location.href = "create.php?a="+id;
			}
		});
	});

	$('body').on('click', '.ignorar', function(){

		var id = $(this).attr('id');

		swal({
			title: "Confirmación necesaria",
			text: "¿Seguro que quieres ignorar esta alerta?",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "Ignorar",
			cancelButtonText: "Cancelar",
			closeOnConfirm: false,
			closeOnCancel: true
		},
		function(isConfirm){
			if(isConfirm){
				location.href = "ignore.php?a="+id;
			}
		});
	});

</script>

</html>