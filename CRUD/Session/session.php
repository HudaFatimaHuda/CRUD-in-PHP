<?php
    include("session_class.php");

    $user = new Login(); 
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $user->login();
    }
    else if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['submit'])){
        $user->signup();
    }
    else{
        $user->logout();
    }






















    // if (isset($_POST['email']) && isset($_POST['password'])) {
    //     $email = $_POST["email"];
    //     $password = $_POST["password"];

    //     $sql = "SELECT * FROM login WHERE email='$email'";
    //     $result = $conn->query($sql);

    //     if ($result->num_rows == 1) {
    //         //If the number of rows is equal to 1, let them login
    //         while ($rows = $result->fetch_assoc()) {
    //             if($rows["password"] == $password){
    //                 //Here we retrieve values from database and initiate SESSION Variables  
    //                 $_SESSION["email"] = $row["email"];
    //                 $_SESSION["username"] = $row["name"];
    //                 $_SESSION["is_login"] = true;
    //                 header("location: ../oop/index.php"); //redirect to members page... information correct.
    //             }else {
    //                 $loginError = "Incorrect Email or Password.";
    //                 header("Location: login_form.php?error=$loginError");
    //             }
    //         }
    //     } 
    //     else {
    //         $loginError = "The email address does not exist.";
    //         header("Location: login_form.php?error=$loginError");
    //     }

        
    // }

