<html>
<head>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="src" href="index.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

	<script src="https://cdn.datatables.net/1.10.6/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.6/css/jquery.dataTables.min.css">
</head>
<body>

	<?php

		if (isset($_REQUEST['mess']))
		{
			$mess = $_REQUEST['mess'];

			switch ($mess)
			{
				case 1: echo '<script> alert("La OS ha sido generada."); </script>'; break;
				case 2: echo '<script> alert("La alerta ha sido ignorada."); </script>'; break;
			}
		}

	?>

	<div id="limit">
		<h4>Datos a buscar: </h4>
		<button type="button" class="btn btn-default active" id="50">50</button>
		<button type="button" class="btn btn-default" id="100">100</button>
		<button type="button" class="btn btn-default" id="500">500</button>
		<button type="button" class="btn btn-default" id="1000">1000</button>
	</div>

	<div id="tablespace"><br><br>
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
	$(document).ready(function () 
	{
		var Q = $('button.active').attr('id');

    	$('#datatable').dataTable({
    		"order": [[0, "desc"]],
        	"sAjaxSource": "datafetch.php?lim="+Q
		});
	});

	$('button.btn').click(function(){
		$('button.active').toggleClass('active');
		$(this).addClass('active');

		Q = $(this).attr('id');

		$('#datatable').dataTable({
			"bDestroy": true,
			"order": [[0, "desc"]],
        	"sAjaxSource": "datafetch.php?lim="+Q
		});
	});

</script>

</html>