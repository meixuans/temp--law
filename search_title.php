<?php header('Access-Control-Allow-Origin: *');
    include 'connect.php';
    $temp_title = $_POST['clause_title'];
    $temp_comp_par_id = $_POST['curr_company_id'];
    $item_title = strval($temp_title);
    $item_comp_par_id = strval($temp_comp_par_id);
    $comp_name = pg_query($connection, "select * from public.clause_table WHERE (UPPER(title) = UPPER('" . $item_title . "') AND parent_comp_id = "  . $item_comp_par_id . ")" ); // .  " AND title = " . $item_title);
    $rows = array();
    class Clause{

    }

    while ($row = pg_fetch_row($comp_name))
    {
        //echo $row[0];
        $row_val = new Clause();
        $row_val->IND = $row[0];
        $row_val->parent_doc_id = $row[1];
        $row_val->title = $row[2];
        $row_val->tags = $row[3];
        $row_val->author = $row[4];
        $row_val->date = $row[5];
        $row_val->abnormal = $row[6];
        $row_val->chng_rsn = $row[7];
        $row_val->param_dict = $row[8];
        $row_val->clause_string = $row[9];
        $row_val->parent_comp_id = $row[10]; 

        $rows[]= $row_val;
    }

    echo json_encode($rows);
?>
