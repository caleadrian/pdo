<?php
require_once "../db/action.php";

$content = '';
$limit = $misc->cpv($_REQUEST['limit']);

$result = $obj->fetch_record("tbl_userDetails " . ($limit ? "limit $limit" : ''));
foreach($result as $d){
    $content .= "
   <tr>
       <td>". $d['id'] ."</td>
       <td>". $d['fname'] ."</td>
       <td>". $d['lname'] ."</td>
       <td>". $d['age'] ."</td>
       <td>". $d['date'] ."</td>
       <td><button id='".$d['id']."' class='btn btn-danger btn-sm'  data-toggle='modal' data-target='#exampleModalCenter'>Delete</button>
   </tr>
   ";
}

echo ($content ? $content : $misc->noRecordFound());

?>