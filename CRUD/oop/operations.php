<?php 
    include 'db.php';
    include 'validation.php';

    class Operation{
            
    private $Crud;

    function __construct(){
        $this->Crud = new userCrud();
    }

    function getAllRecords($UpdateNameError, $UpdateScoreError){
        $id = $_SESSION['id']; 
        $data = $this->Crud->read($id);
        mapRecords($data,$UpdateNameError, $UpdateScoreError);
    }

    function addRecord($postData){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['submit'])) {
                if (isset($_POST['name']) && isset($_POST['score'])) {
                    $name  = $_POST['name'];
                    $score  = $_POST['score'];

                    $img = $_FILES['img']['name']; //This is the name of the file to be uploaded originally.
                    $temp_name = $_FILES['img']['tmp_name']; //This will include the temporary filename of the file in which the uploaded file was stored on the server.
                    $folder = "image/".$img;  

                    [$isValidated] = validation($name, $score);
                    if($isValidated){
                        $id = $_SESSION['id'];
                        $isUploaded = move_uploaded_file($temp_name, $folder);
                        if($isUploaded){
                            $result = $this->Crud->create($name, $score, $id, $img);
                            if($result === true){
                                $_POST = array(); 
                                return true;
                            }else{
                                return "Error adding record: $result";
                            }
                        }
                    }
                    return "Data Enter is invalid"; 
                }
            }
        }
    }

    function deleteRecord($getData){
        $opt  = $_GET['opt']; 
        if($opt == 'delete'){
            $id  = $_GET['id']; 
            $result = $this->Crud->delete($id);
            return $result === true ? true : "Error in deleting the data" . $result;
        }
    }

    function updateRecord($postData){
        $id  = $_POST['id']; 
        $name  = $_POST['name']; 
        $score  = $_POST['score']; 

        [$isUpdateValidated, $UpdateNameError, $UpdateScoreError] = validation($name, $score);
        echo $isUpdateValidated;
        
        if($isUpdateValidated){
            $result = $this->Crud->update($id,$name,$score);
            if($result === true){
                $_POST = array(); 

                return [$isUpdateValidated, $UpdateNameError, $UpdateScoreError, true];
            }else{
                return [$isUpdateValidated, $UpdateNameError, $UpdateScoreError, "Error in updating record: $result"];
            }
        }
        return [$isUpdateValidated, $UpdateNameError, $UpdateScoreError, "Data Enter is invalid"];
    }
    
    } //operations class ends here

    function mapRecords($data, $UpdateNameError, $UpdateScoreError){
       
        if(sizeof($data) > 0){
            foreach($data as $row){
                echo "<tr>";
                if(isset($_GET['id']) && $_GET['id'] == $row['id'] && $_GET['opt'] == 'update'){
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<form class = 'form-inline' method='post' action= 'index.php?id=" . $row['id'] . "&opt=update'>";
                        echo "<td></td>";
                        echo "<td><input type='text' class='form-control' name='name' value = '$row[name]' required><p class='text-danger'>$UpdateNameError</p></td>";
                        echo "<td><input type='number' class='form-control' name='score' value = '$row[score]' required>
                        <p class='text-danger'>$UpdateScoreError</p>
                        </td>";
                        echo "<td><button type='submit' class='btn btn-primary' name = 'update'>Save</button>
                        </td>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] ."'>";
                        echo "<input type='hidden' name='option' value='update'>";
                    echo "</form>";
                }
                else{
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td><a href = 'image/" . $row['img'] . "' target = 'blank'><img class='rounded-circle' width='35' height='35' src='image/" . $row['img'] . "'></a></td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['score'] . "</td>";
                    echo "<td><a class='btn btn-primary' role='button' href='index.php?id=" . $row['id'] . "&opt=update'>Update</a></td>";
                }
                echo "<td><a class='btn btn-danger' role='button' name='delete' data-bs-toggle='modal' data-bs-target='#staticBackdrop2' onClick='deleteConformation($row[id])'>Delete</a></td>";
            echo "</tr>";
            }
        }else{
            echo "<tr class = 'text-center pt-1'><td colspan='5' class='text-danger'>No data found</td></tr>"; 
        }
    }

    function validation($name, $score){
        $nameError = Validation::nameValidation($name);
        $scoreError = Validation::scoreValidation($score);
        return [$nameError == '' && $scoreError == '', $nameError, $scoreError];
    }
?>