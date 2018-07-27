<?php
require_once "../db/action.php";

$content = '';
$result = $obj->fetch_record("tbl_userDetails");
foreach($result as $d){
    $content .= "
   <tr>
       <td>". $d['id'] ."</td>
       <td>". $d['fname'] ."</td>
       <td>". $d['lname'] ."</td>
       <td>". $d['age'] ."</td>
       <td>". $d['date'] ."</td>
       <td><button id='".$d['id']."' class='btn btn-danger btn-sm'>Delete</button>
   </tr>
   ";
}

echo ($content ? $content : $misc->noRecordFound());

?>