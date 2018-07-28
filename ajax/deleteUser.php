<?php
require_once "../db/action.php";

$id = $misc->cpv($_REQUEST['id']);
$result = $obj->delete_record("id=$id");

if($result){
    $misc->notifyContent("Successfully deleted", "success");
}else{
    $misc->notifyContent("Error occured", "danger");   
}





?>