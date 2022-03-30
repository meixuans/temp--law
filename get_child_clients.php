<?php header('Access-Control-Allow-Origin: *');
    include 'connect.php';
    $temp_cid = $_POST['parent_ind'];
    //$temp_doc_par_id = $_POST['curr_company_id'];
    $item_cid = strval($temp_cid);
    //$item_doc_par_id = strval($temp_doc_par_id);
    $comp_name = pg_query($connection, "select client_name, unique_id from public.client_table WHERE (parent_id = ". $item_cid . ")" ); // .  " AND title = " . $item_title);
    if ($comp_name == false){
        echo "no_such_children";
        return;
    }
    
    $rows = array();
    class CLI {

    }
    while ($row = pg_fetch_row($comp_name))
    {
        //$cli = new CLI();
        $cliname = $row[0];
        $indi = $row[1];
        //$cli->client_id = $row[1];
        $rows[$cliname] = $indi;
    }

    echo json_encode($rows);
?>
