<?php 
require_once "./db/action.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        th{
            cursor: pointer; 
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="col-lg-6">
        
            <div class="container-fluid">
            <form>
                <div class="container-fluid" id="alertContainer"></div>
                <div class="form-group">
                    <label for="fnae">First Name</label>
                    <input type="text" class="form-control" id="fname" placeholder="Enter Firstname">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" id="lname" placeholder="Enter Lastname">
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" id="age" placeholder="Age">
                </div>
                
                <button type="button" id="savebtn" class="btn btn-primary">Submit</button>
            </form>
            </div>

        </div>
        <div class="col-lg-6">
        <!-- table -->
            <div class="form-group">
                <label for="exampleFormControlSelect1">Example select</label>
                <select class="form-control form-control-sm" id="exampleFormControlSelect1">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                    <option>100</option>
                    <option>All</option>
                </select>
            </div>
            <table id="mytable" class="table table-stripped tablesorter">
                <thead>
                    <th>ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Age</th>
                    <th>Date</th>
                    <th>Action</th>
                </thead>
                <tbody id="tableContent">

                </tbody>
            </table>

        <!-- table -->
        
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script
    src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
    integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
    crossorigin="anonymous"></script>
    <script src="./js/jquery.tablesorter.min.js"></script>


    <script>
    $(function(){
        loadTable();

       // $("#tableContent").sortable(); drag n drop


        function loadTable(){
            $("#tableContent").html("<p>Loading</p>"); //set loading stuff 
            $.ajax({
                type:'POST',
                url: './ajax/loadTable.php',
                success: function(result){
                $("#tableContent").html(result); //result var is from the echo of loadTable
                $("#mytable").tablesorter(); //enable sorter if tbody is not empty ps. it needs the table sorter css to see the arrow stuff

                }
            });

        }

        $("#savebtn").click(function(){
            $("div#alertContainer").html("<p>Sending</p>");
            var lname = $("#lname").val();
            var fname = $("#fname").val();
            var age = $("#age").val();
            $.ajax({
                type:'POST',
                url: './ajax/saveUserDetails.php',
                data: {fname : fname, lname : lname, age : age},
                success: function(result){
                    $("div#alertContainer").html(result);
                    loadTable();
                }
            });
        });


        //delegate event !!!!!!!!!!! call me master lol
        $( "#tableContent" ).on( "click", "button", function( event ) {
            event.preventDefault();
            deleteUser($(this).attr('id'));
        });

        function deleteUser(id){
            $("div#alertContainer").html("<p>Deleting</p>");
            $.ajax({
                type:'POST',
                url: './ajax/deleteUser.php',
                data: {id:id},
                success: function(result){
                    $("div#alertContainer").html(result);
                    loadTable();
                }
            });
        }

       

    });
  
    
    </script>
</body>
</html>
