<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location:../Session/login_form.php");
    }

    include 'Operations.php';

    $operation = new Operation();
    $UpdateNameError = ''; 
    $UpdateScoreError = ''; 

    if(isset($_POST['submit']) && !isset($_GET['id'])) {
        [$isValidated, $nameError, $scoreError, $result] = $operation->addRecord($_POST);
        if($result === true){
            header("Location: index.php");  
        }
        else{
            echo "<div class = 'text-center bg-danger py-3 text-white'>Sorry! Create operation cannot be completed. " . $result .  "</div>";
        }
    }

    
    if(isset($_GET['opt']) && $_GET['opt'] == 'delete'){
        $result = $operation->deleteRecord($_GET);
        if($result === true){
            header("Location: index.php");  
        }
        else{
            echo "<div class = 'text-center bg-danger py-3 text-white'>Sorry! Delete operation cannot be completed. " . $result .  "</div>";
        }
    }
    
    if(!isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['option'] == 'update'){    
        [$UpdateValidated, $UpdateNameError, $UpdateScoreError, $result] = $operation->updateRecord($_POST);
        if($result === true){
            header("Location: index.php");  
        }
        else{
            echo "<div class = 'text-center bg-danger py-3 text-white'>Sorry! Update operation cannot be completed. " . $result .  "</div>";
        }

    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Index</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <div class="container my-5 mx-auto col-lg-6 col-md-10">
        <div>
            <h2 class="text-center">PHP + MySQL CRUD Practice</h2>
            <p class="text-center text-secondary">Create, read, update, and delete records below</p>
        </div>

        <div class="text-end">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add new user
            </button>
            <a role="button" class="btn btn-primary" href="../session/session.php">Logout</a>
        </div>

        <div>
            <table class="table table-stripped table-hover table-responsive">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">name</th>
                        <th scope="col">Score</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $operation->getAllRecords($UpdateNameError, $UpdateScoreError); ?>
                </tbody>
            </table>

        </div>
    </div>

    <!-- Modal for new user form-->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="resetForm()"></button>
                </div>
                <div class="modal-body">
                    <form id='add-user' autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="p-2 my-2">
                        <input autocomplete="false" name="hidden" type="text" style="display:none;">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" name="name" required onkeyup="showNameHint(this.value)">
                            <span class="text-danger" id = "name-hint"></span>
                            <p class="text-danger" id = "name-error"><?php //if(isset($nameError)){echo $nameError;} ?></p>
                        </div>
                        <div class="mb-3">
                            <label for="score" class="form-label">Score</label>
                            <input type="number" id="score" class="form-control" name="score" required onkeyup="showScoreHint(this.value)">
                            <span class="text-danger" id = "score-hint"></span>
                            <p class="text-danger" id = "score-error"><?php //if(isset($scoreError)){echo $scoreError;} ?></p>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="resetForm()">Close</button>
                            <input type="submit" name='submit' class="btn btn-primary" id = "submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for delete conformation-->
    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-danger" id="staticBackdropLabel2">Are you sure you want to delete.</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" onclick="deleteHandler()">Delete</button>
        </div>
        </div>
    </div>
    </div>

    <script>
        function showNameHint(value){
            var hint = document.getElementById('name-hint')
            if(value == ""){
                hint.innerHTML = ""
                return
            }else{
                var xmlHttp = new XMLHttpRequest(); // XMLHttpRequest object
                    xmlHttp.onreadystatechange = function(){ //function to be executed when the server response is ready
                        if (this.readyState == 4 && this.status == 200) {
                            hint.innerHTML = this.responseText;
                            // if(this.responseText){
                            //     document.getElementById("submit").disabled = true;  
                            // }else{
                            //     document.getElementById("submit").disabled = false;  
                            // }
                        }
                    }
                    xmlHttp.open("GET","../Ajax/validate_name.php?q=" + value, true); //Send the request off to a file on the server
                    xmlHttp.send(null);
                    // hint.innerHTML = value;
            }
        }

        function showScoreHint(value){
            var hint = document.getElementById('score-hint')
            if(value == ""){
                hint.innerHTML = ""
                return
            }else{
                var xmlHttp = new XMLHttpRequest(); // XMLHttpRequest object
                    xmlHttp.onreadystatechange = function(){ //function to be executed when the server response is ready
                        if (this.readyState == 4 && this.status == 200) {
                            hint.innerHTML = this.responseText;
                        }
                    }
                    xmlHttp.open("GET","../Ajax/validate_score.php?q=" + value, true); //Send the request off to a file on the server
                    xmlHttp.send(null);
                    // hint.innerHTML = value;
            }
        }




        function resetForm(){
        document.getElementById('add-user').reset(); 
        document.getElementById('name-error').innerHTML = ""
        document.getElementById('score-error').innerHTML = ""
        }
        var id; 
        function deleteConformation(id_input){
        id = id_input;
        }

        function deleteHandler(){
        var href = 'index.php?opt=delete&id=' + id;
        window.location.href = href;
        }

       

    </script>
</body>

</html>