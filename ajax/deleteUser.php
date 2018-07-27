<?php
require_once "../db/action.php";

$id = $misc->cpv($_REQUEST['id']);
$result = $obj->delete_record("id=$id");

if($result){
    echo $misc->alert("Successfully Deleted", "success");
}else{
    echo $misc->alert("Error occured, Try again", "danger");
}





?>