<?php 
    include "../oop/db.php";
    include "../oop/validation.php";

    class Login extends DatabaseConnection{
        private $conn;

        function __construct(){
            parent::__construct();
            $this->conn = $this->getConnection(); 
            if($this->conn->connect_error){
                echo "Login connection failed" . $this->conn->connect_error;
            }
        }

        function logout(){
            session_start();
            session_unset();
            session_destroy();
            header("Location: login_form.php");
        }

        function login(){
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = $_POST["email"];
                $password = $_POST["password"];
                [$is_user_exist, $result] = $this->checkLoginUser($email, $password);
                if($is_user_exist){
                    session_start();
                    //If the number of rows is equal to 1, let them login
                    while ($row = $result->fetch_assoc()) {
                        //Here we retrieve values from database and initiate SESSION Variables  
                        $_SESSION["email"] = $row["email"];
                        $_SESSION["username"] = $row["name"];
                        $_SESSION["is_login"] = true;
                        header("location: ../oop/index.php"); //redirect to members page... information correct.
                    }
                }else {
                    $loginError = "Incorrect Email or Password.";
                    header("Location: login_form.php?error=$loginError");
                }
            }
        }

        function checkLoginUser($email,$password){
            $sql = "SELECT * FROM login WHERE email='$email' AND password='$password'";
            $result = $this->conn->query($sql);
            return [$result->num_rows == 1, $result];
        }

        function checkSignupUser($email){
            $sql = "SELECT * FROM login WHERE email='$email'";
            $result = $this->conn->query($sql);
            return $result->num_rows == 0;
        }

        function signup(){
            if(isset($_POST['email']) && isset($_POST['name']) && isset($_POST['password']) && isset($_POST['c-password'])){
                $email = $_POST['email'];
                $name = $_POST['name'];
                $password = $_POST['password'];
                $conform = $_POST['c-password'];
                $contact = $_POST['contact'];

                // validate the data
                // here
                $nameError = Validation::nameValidation($name);
                $emailError = Validation::emailValidation($email);
                $passwordError = Validation::passwordValidation($password);

                if($nameError == "" && $emailError == "" && $passwordError == ""){
                    // if validation pass 
                    if($this->checkSignupUser($email)){
                        if($password == $conform){
                            $sql = "INSERT INTO login (name, email, password, mobile) VALUES ('$name', '$email', '$password', '$contact')";
                            $result = $this->conn->query($sql);
                            if($result == true){
                                session_start();
                                $_SESSION["email"] = $email;
                                $_SESSION["username"] = $name;
                                $_SESSION["is_login"] = true;
                                header("location: ../oop/index.php"); 
                            }else{
                                header("Location: ../Ajax/signup_form.php?error=Sorry the sign up request failed" . $this->conn->error);
                                // return "Sorry the sign up request failed" . $this->conn->error;
                            }
                        }else{
                            header("Location: ../Ajax/signup_form.php?error=The password did not match.");
                            // return "The password did not match.";
                        }
                    }else{
                        header("Location: ../Ajax/signup_form.php?error=The email address is already registered.");
                        // return "The email address is already registered.";
                    }
                }else{
                    header("Location: ../Ajax/signup_form.php?name_error=" . $nameError . "&email_error=" . $emailError . "&password_error=" . $passwordError);
                    // return [$nameError , $emailError , $passwordError];
                }

                
            }
        }

    }
?>