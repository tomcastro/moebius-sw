<?php

    if (isset($_REQUEST['lim']))
    {
        $lim = (int) $_REQUEST['lim'];
    } else {

        die ("Error");
    }

    $db_connection = pg_connect("host=192.168.40.129 port=5432 dbname=AlertCentral user=postgres password=postgres");

    if (!$db_connection)
    {
        die('Error: Could not connect: ' . pg_last_error());
    }

    $query = "SELECT * FROM alerts ORDER BY id DESC LIMIT $lim";
    $result = pg_query($query);

    $object = new stdClass();
    $array = array();

    while ($alert = pg_fetch_object($result))
    {
        $data = array();

        if ($alert->moebiusos_status == 1 or $alert->moebiusos_status == 4){$b1 = "<a class='btn btn-block btn-success' href=create.php?a=".$alert->id.">Generar</a>";}
            else{$b1 = "";}

        if ($alert->moebiusos_status == 1){$b2 = "<a class='btn btn-block btn-warning' href=ignore.php?a=".$alert->id.">Ignorar</a>";}
            else{$b2 = "";}

        array_push(
            $data, 
            $alert->id,
            getNodeName($alert),
            $alert->message,
            "<a class='btn btn-link' href=history.php?a=".$alert->id.">Historia</a>",
            $alert->object,
            $alert->timeraised,
            ucfirst(strtolower($alert->severity)),
            moebiusStatus($alert->moebiusos_status),
            $alert->moebiusos_id,
            $b1,
            $b2
        );

        array_push($array, $data);
    }

    $object->data = $array;

    echo json_encode($object);

    function moebiusStatus($status)
    {
        switch ($status)
        {
            case 1: return "Orden no generada"; break;
            case 2: return "Orden generada"; break;
            case 3: return "Orden completada"; break;
            case 4: return "Alerta ignorada"; break;
        }
    }

    function getNodeName($alert)
    {
        $id = $alert->id;
        $query = "SELECT value FROM alertdata WHERE name = 'objectName' AND alert_id = $id";
        $result = pg_query($query);
        while ($alert = pg_fetch_object($result))
        {
            if ($alert->value)
            {
                return $alert->value;
            }
        }
    }

    function getHistory($alert)
    {

    }
?>