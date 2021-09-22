<?php
require 'dbc.php';

class Sale_Record {
    public $sale_id;
    public $sale_items;
    public $sale_price;
    public $sale_date;
}

$outputArray = array();

$sql = "SELECT * FROM sales_records";
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
        $saleRecord = new Sale_Record();
        $saleRecord->sale_id = $item['sale_id'];
        $saleRecord->sale_items = $item['sold_items'];
        $saleRecord->sale_price = $item['sale_price'];
        $saleRecord->sale_date = $item['date'];
        //push object to output array
        array_push($outputArray, $saleRecord);
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