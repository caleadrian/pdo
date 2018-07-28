<?php
require_once "../db/action.php";

$fname = $misc->cpv($_REQUEST['fname']);
$lname = $misc->cpv($_REQUEST['lname']);
$age = $misc->cpv($_REQUEST['age']);

$fields  =  array(
    "fname" => $fname,
    "lname" => $lname,
    "age"   => $age
);
$result = $obj->insert_record("tbl_userDetails", $fields);
if($result){
    $misc->notifyContent("Successfully saved", "success");
}else{  
    $misc->notifyContent("Error occured", "danger");

}



?>