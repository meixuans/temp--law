<?php header('Access-Control-Allow-Origin: *');
    include 'connect.php';
    $unique_title = pg_query($connection, "SELECT DISTINCT title from public.clause_table");
    if (!$unique_title) {
        echo "System Error\n";
        exit;
    }
    $rows = array();
    while ($row = pg_fetch_row($unique_title))
    {
        $rows[]= $row;
    }
    echo json_encode($rows);
?>
