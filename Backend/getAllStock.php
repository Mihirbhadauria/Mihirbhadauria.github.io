<?php
require 'dbc.php';

class Stock_Item {
    public $item_id;
    public $item_name;
    public $item_price;
    public $soh;
}

$outputArray = array();

$sql = "SELECT * FROM stock_items";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    exit();
}else{
    //Execute query 
    mysqli_stmt_execute($stmt);
    //store the query results in an array using get_result
    $result = get_result($stmt);

    //loop through results and store data into php object
    foreach($result as $item){
        $stockItem = new Stock_Item();
        $stockItem->item_id = $item['stock_item_id'];
        $stockItem->item_name = $item['stock_item_name'];
        $stockItem->item_price = $item['stock_item_price'];
        $stockItem->soh = $item['SOH'];
        //push object to output array
        array_push($outputArray, $stockItem);
    }

    //OUTPUT IN STRING FORM.
    //OUTPUT IS READ TO BE RECIEVED IN JAVASCRIPT WITH FETCH OR AJAX CALLS.
    echo json_encode($outputArray);
}

function get_result(\mysqli_stmt $statement)
{
    $result = array();
    $statement->store_result();
    for ($i = 0; $i < $statement->num_rows; $i++)
    {
        $metadata = $statement->result_metadata();
        $params = array();
        while ($field = $metadata->fetch_field())
        {
            $params[] = &$result[$i][$field->name];
        }
        call_user_func_array(array($statement, 'bind_result'), $params);
        $statement->fetch();
    }
    return $result;
}