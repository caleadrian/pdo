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
    <link rel="stylesheet" href="./css/animate.css">
    <style>
        th{
            cursor: pointer; 
        }
        .alert{
            max-width: 20rem;
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
                <label for="filter">Example select</label>
                <select class="form-control form-control-sm" id="filter">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="">All</option>
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


    <!-- modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Please confirm your action.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-confirm"  data-dismiss="modal" name="modalConfirmBtn">Confirm</button>
            </div>
            </div>
        </div>
    </div>
    <!-- modal -->


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
    <script src="./js/bootstrap-notify.js"></script>
    <script>
    $(function(){

        function notify(msg, style){
            return $.notify( // snackbar notification
                {
                message : msg
                },
                {
                animate: {
                    enter: "animated fadeInUp",
                    exit: "animated fadeOutDown"
                },
                delay : 2000,
                type: style
            });
        }


        var limit = $("select#filter").val();
        loadTable(limit);

       // $("#tableContent").sortable(); drag n drop
        $("select#filter").change(function(){
            limit = $(this).val();
            loadTable(limit);
        });

        function loadTable(limit){
            var noti = notify('Loading the data ...', 'info');
            $.ajax({
                type:'POST',
                url: './ajax/loadTable.php',
                data: {limit:limit},
                success: function(result){
                    noti.close();
                    $("#tableContent").html(result); //result var is from the echo of loadTable
                    $("#mytable").trigger('update');
                    $("#mytable").tablesorter(); //enable sorter if tbody is not empty ps. it needs the table sorter css to see the arrow stuff
                }
            });
        }

        $("#savebtn").click(function(){
            var noti = notify('Saving your inputs ...', 'info');
            var lname = $("#lname").val();
            var fname = $("#fname").val();
            var age = $("#age").val();
            $.ajax({
                type:'POST',
                url: './ajax/saveUserDetails.php',
                data: {fname : fname, lname : lname, age : age},
                dataType:"json",
                success: function(result){
                    // $("div#alertContainer").html(result);
                    noti.close();
                    notify(result.msg, result.type);
                    loadTable(limit);
                }
            });
        });

        function deleteUser(id){
            var noti = notify('Deleting ...', 'info');
            $.ajax({
                type:'POST',
                url: './ajax/deleteUser.php',
                data: {id:id},
                dataType:"json",
                success: function(result){
                    noti.close();
                    notify(result.msg, result.type);
                    loadTable(limit);
                }
            });
        }

        $("button[name='modalConfirmBtn']").click(function(){
            deleteUser($(this).attr('id'));
        });

        //delegate event !!!!!!!!!!! call me master lol
        $("#tableContent").on("click", "button", function(event) {
            event.preventDefault();
            $("button[name='modalConfirmBtn']").attr('id', $(this).attr('id')); //pass the delete btn id to modal btn
        });



    });
  
    
    </script>
</body>
</html>
