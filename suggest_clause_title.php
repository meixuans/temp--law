<?php header('Access-Control-Allow-Origin: *');
    include 'connect.php';
    // echo 'fish_tacos';
    $temp_title = $_POST['clause_title'];
    //echo $temp_title;
    $temp_doc_par_id = $_POST['curr_company_id'];
    //echo $temp_doc_par_id;
    $item_title = strval($temp_title);
    $item_doc_par_id = strval($temp_doc_par_id);
    $comp_name = pg_query($connection, "SELECT DISTINCT title from public.clause_table WHERE (UPPER(title) = UPPER('" . $item_title . "%')" ); // .  " AND title = " . $item_title);
    $rows = array();
    while ($row = pg_fetch_row($comp_name))
    {
        $rows[]= $row;
        // echo $row[10];
    }

    echo json_encode($rows);

    // $result_clause = pg_query($connection, "Select * from public.\"Clause_Table\" WHERE (title =". $item_title .")) ORDER BY date DESC;");

    // if (!$result_clause){
    //     echo "Unable to find clauses titled " . $item_title . "for the client " . $comp_name;
    //     exit; 
    // }
    // echo json_encode($result_clause)
?>
