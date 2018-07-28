<?php
include "connection.php";

class Actions extends DatabaseConnection{
    public function checkConnection(){
        $this->openConnection();
        return ($this->pdo ? "Connected" : "Not Connected");
    }

    public function fetch_record($table, $want = "*", $condition = null){
        $this->openConnection();        
        $query = "select $want from $table"; //$want should be seperated by comma : fname,lname,age
        $query .= ($condition ? " where $condition" : ''); //$condition should also seperated by comma : id=2 and foo='f'
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert_record($table, $fields){ //fields should be on array value-key pair format : array("lname" -> $lname,)
        $this->openConnection();
        $query = "";
        $query .= "Insert into $table";
        $query .= " (". implode(",", array_keys($fields)).") VALUES "; 
        $query .= " ('". implode("','", array_values($fields))."')";
        $result = $this->pdo->exec($query);
        return ($result ? true : false); //if data save successfully return true
    }

    public function delete_record($condition){
        if($condition){
            $this->openConnection();
            $query = "Delete from tbl_userDetails where $condition"; //$condition should also seperated by comma : id=2 and foo='f'
            $result = $this->pdo->exec($query);
            return ($result ? true : false); //if data save successfully return true
        }else{
            return false;
        }
    }

    //fetch record by custom query : select * from tbl_foo
    public function fetch_query($query){
        if($query){ //if query is not empty it execute else return false
            $this->openConnection();
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);                       
        }else{
            return false;
        }
    }

}
class Misc{
    public function noRecordFound(){
        $content = "<p>No Record Found</p>";
        return $content;
    }
    public function LoadingTable(){
        $content = "<p>Loading ...</p>";
        return $content;       
    }
    public function cpv($var){
        if(!isset($var) || $var == ''){
            return null;
        }else{
            return $var;
        }
    }

    public function alert($text, $type = "primary"){
        $content = "
        <div class='alert alert-$type alert-dismissible fade show' role='alert'>$text
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span></button></div>";
        return $content;
    }
    public function notifyContent($msg, $type){
        return print json_encode(array('msg' => $msg, 'type' => $type));
    }
}




$obj = new Actions();
$misc = new Misc();





?>