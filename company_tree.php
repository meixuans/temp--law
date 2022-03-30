<?php header('Access-Control-Allow-Origin: *');
    include 'connect.php';
    $client_id = $_POST['client_id'];
    // $temp_comp_par_id = $_POST['curr_company_id'];
    // $item_title = strval($temp_title);
    // $item_comp_par_id = strval($temp_comp_par_id);
    $comps = pg_query($connection, "SELECT unique_id, client_name FROM client_table WHERE parent_id = " . $client_id . ";");
    $c_rows = array();
    // return empty array if error
    class Children{}
    while ($row = pg_fetch_row($comps))
    {
        // echo $row[2];
        $child = new Children();
        $child->unique_id = $row[0];
        $child->client_name = $row[1];
        //$child->client_name = $row[2];
        $c_rows[] = $child;
    }
    //echo json_encode($c_rows);

    $docs = pg_query($connection, 
        "SELECT dt.document_type, dt.date, ARRAY_AGG('{' || 'ind:' || cl.ind || ', ' || 'title:' || cl.title ||'}')
        FROM document_table as dt, clause_table as cl
        WHERE (dt.unique_id = cl.parent_doc_id and dt.parent_company_id = " . $client_id . ") 
        GROUP BY dt.unique_id
        ORDER BY dt.document_type, dt.date DESC;");
    $rows = array();
    class docs{}
    // return empty array if error
    while ($row = pg_fetch_row($docs))
    {
        $row_val = new docs();
        $row_val->doc_type = $row[0];
        $row_val->doc_date = $row[1];
        $row_val->clauses = $row[2];
        $rows[]= $row_val;
    }

    $fin = array($c_rows, $rows);
    echo json_encode($fin);
?>
