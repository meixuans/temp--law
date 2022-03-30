
<?php header('Access-Control-Allow-Origin: *');
    include 'connect.php';
    $unique_doc = pg_query($connection, "SELECT DISTINCT document_type from public.document_table");
    if (!$unique_doc) {
        echo "System Error\n";
        exit;
    }
    $rows = array();
    while ($row = pg_fetch_row($unique_doc))
    {
        $rows[]= $row;
    }
    echo json_encode($rows);
?>