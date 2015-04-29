<?php

	include ("fakeapi.php");

	$db_connection = pg_connect("host=192.168.40.129 port=5432 dbname=AlertCentral user=postgres password=postgres");

	if (!$db_connection)
	{
		die('Error: Could not connect: ' . pg_last_error());
	}
	
	if(isset($_REQUEST['a']))
	{
		$id = $_REQUEST['a'];
		$query = "SELECT * FROM alerts WHERE id = $id";
		$result = pg_query($query);

		while ($alert = pg_fetch_object($result))
		{
			$res = API($id, $alert->message);
		}

		if (!$res)
		{
			echo "OS no generada";
		}
		else 
		{
			$time = new DateTime('NOW');
			$time = $time->format(DateTime::ISO8601);
			if($res)
			{
				$res = (int) $res;
				$query = "UPDATE alerts SET moebiusos_status=2, moebiusos_timeraised='$time', moebiusos_id=$res WHERE id=$id";
				pg_query($query);

				header('Location: http://localhost:8080/index.php?mess=1');
			}
		}
	}


?>