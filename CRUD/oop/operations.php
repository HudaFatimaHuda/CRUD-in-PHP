<?php 
    include 'db.php';
    include 'validation.php';

    class Operation{
            
    private $Crud;

    function __construct(){
        $this->Crud = new userCrud();
    }

    function getAllRecords($UpdateNameError, $UpdateScoreError){
        $data = $this->Crud->read();
        mapRecords($data,$UpdateNameError, $UpdateScoreError);
    }

    function addRecord($postData){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['submit'])) {
                if (isset($_POST['name']) && isset($_POST['score'])) {
                    $name  = $_POST['name'];//$this->Crud->getConnection()->real_escape_string($_POST['name']);
                    $score  = $_POST['score'];//$this->Crud->getConnection()->real_escape_string($_POST['score']);
                    [$isValidated, $nameError, $scoreError] = validation($name, $score);
                    if($isValidated){
                        $result = $this->Crud->create($name,$score);
                        if($result === true){
                            // cross checking the result because even if the data is invalid
                            // the page was refreshing
                            // making sure result is always true before refreshing the page 

                            $_POST = array(); //To unset the $_POST variable, redeclare it as an empty array
                            // otherwise loop through each entry and unset it unset($_POST['value']);

                            return [$isValidated, $nameError, $scoreError, true];
                        }else{
                            return [$isValidated, $nameError, $scoreError, "Error adding record: $result"];
                        }
                    }
                    return [$isValidated, $nameError, $scoreError, "Data Enter is invalid"];
                }
            }
        }
    }

    function deleteRecord($getData){
        $opt  = $_GET['opt']; //$this->Crud->getConnection()->real_escape_string($_GET['opt']);
        if($opt == 'delete'){
            $id  = $_GET['id']; //$this->Crud->getConnection()->real_escape_string($_GET['id']);
            $result = $this->Crud->delete($id);
            return $result === true ? true : "Error in deleting the data" . $result;
            // cross checking the result because even if the data is invalid
            // the page was refreshing
            // making sure result is always true before refreshing the page 
        }
    }

    function updateRecord($postData){
        $id  = $_POST['id']; //$this->Crud->getConnection()->real_escape_string($_POST['id']);
        $name  = $_POST['name']; //$this->Crud->getConnection()->real_escape_string($_POST['name']);
        $score  = $_POST['score']; //$this->Crud->getConnection()->real_escape_string($_POST['score']);
        [$isUpdateValidated, $UpdateNameError, $UpdateScoreError] = validation($name, $score);
        if($isUpdateValidated){
            $result = $this->Crud->update($id,$name,$score);
            if($result === true){
                // cross checking the result because even if the data is invalid
                // the page was refreshing
                // making sure result is always true before refreshing the page 

                $_POST = array(); //To unset the $_POST variable, redeclare it as an empty array
                // otherwise loop through each entry and unset it like this: unset($_POST['value']);

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
                        echo "<td><input type='text' class='form-control' name='name' value = '$row[name]' required><p class='text-danger'>$UpdateNameError</p></td>";
                        echo "<td><input type='number' class='form-control' name='score' value = '$row[score]' required min=0 max=100>
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
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['score'] . "</td>";
                    echo "<td><a class='btn btn-primary' role='button' href='index.php?id=" . $row['id'] . "&opt=update'>Update</a></td>";
                }
                echo "<td><a class='btn btn-danger' role='button' name='delete' data-bs-toggle='modal' data-bs-target='#staticBackdrop2' onClick='deleteConformation($row[id])'>Delete</a></td>";
            echo "</tr>";
            }
        }
    }

    function validation($name, $score){
        $nameError = Validation::nameValidation($name);
        $scoreError = Validation::scoreValidation($score);
        return [$nameError == '' && $scoreError == '', $nameError, $scoreError];
    }
?>