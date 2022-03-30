<?php header('Access-Control-Allow-Origin: *');

include 'connect.php';
$temp_arr = $_POST['params'];
$temp_doc =$_POST['doc_json'];
$author = $_POST['author'];
$company_path = $_POST["company_path"];
$company_path = explode(",", $company_path);
$company_overflowo = $_POST["comp_path_expand"];
//echo "x".$company_overflowo."x";
//if ($company_overflow !=)
$company_overflow = explode (",", $company_overflowo);
echo sizeof($company_overflow);
$doc_type = $_POST["doc_type"];
$last_comp = end($company_path);
//$last_comp = $last_comp[sizeof($last_comp) -1];
//echo $last_comp;

//echo $temp_arr;
$temp_comp_id = strval($_POST['curr_company_id']);
$arr = json_decode($temp_arr);
$doc = json_decode($temp_doc);
/// Here we need to Insert the file into the database

// foreach($company_overflow as $over){
//     echo $over;
// }



if ($company_overflowo != "") {
    foreach ($company_overflow as $row) {
        echo $row;
        $last_comp = pg_query($connection, "INSERT INTO public.client_table (parent_id, client_name) 
                                            VALUES('" . $last_comp . "', '" . $row . "') RETURNING unique_id;");
        $last_comp = pg_fetch_array($last_comp);
        $last_comp = $last_comp[0];
    }
}

$unique_id = pg_query($connection, "INSERT INTO public.document_table (parent_company_id, document_type, author, docx_slices) 
                                    VALUES('" . $last_comp . "', '" . $doc_type . "', '" . $author . "', '" . 
                                    strval($temp_doc) . "') RETURNING unique_id;");

list($new_id) = pg_fetch_array($unique_id);


foreach($arr as $item){
    echo strval($item->title);
    pg_query($connection, "INSERT INTO public.clause_Table (parent_doc_id, title, tags, author, abnormal, change_reason, parameter_dict, clause_string, parent_comp_id) 
                            VALUES('" . $new_id . "', '". strval($item->title) ."', '" . strval($item->tags) ."', '" . strval($item->auth) . "', '" . 
                                    strval($item->abnormal) . "', '" . strval($item->chng) ."', '" . strval($item->param_dict) ."', '" . strval($item->text) . "', '".$last_comp."');" );
    
}
?>