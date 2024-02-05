<?php 
    session_start();
    if(isset($_SESSION['username'])){
        header("Location:../oop/index.php");
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="../styles.css">
</head>

<body>
    <div class="container my-5 col-lg-6 col-md-12 mx-auto">
        <div>
            <h2 class="text-center">PHP + MySQL Signup Practice</h2>
            <p class="text-center text-secondary">Sign up to our portal</p>
        </div>
        <form action="../Session/session.php" method="post" class="py-4 px-5 m-4 bg-light rounded border border-secondary">

            <span class="text-danger"><?php echo isset($_GET['error']) ? $_GET['error'] : ''; ?></span>

            <div class="mb-3">
                <label for="name" class="form-label">Enter your name</label>
                <input type="text" name="name" id="name" class="form-control">
                <span class="text-danger"><?php echo isset($_GET['name_error']) ? $_GET['name_error'] : ''; ?></span>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Enter your email</label>
                <input type="email" name="email" id="email" class="form-control" onblur="showHint(this.value)">
                <span class="text-danger"><?php echo isset($_GET['email_error']) ? $_GET['email_error'] : ''; ?></span>
                <span class="text-danger" id = "email-hint"></span>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Enter password:</label>
                <input type="password" name="password" id="password" class="form-control">
                <span class="text-danger"><?php echo isset($_GET['password_error']) ? $_GET['password_error'] : ''; ?></span>
            </div>

            <div class="mb-3">
                <label for="c-password" class="form-label">Confirm password:</label>
                <input type="password" name="c-password" id="c-password" class="form-control">
                <div class="form-text">Make sure you enter the same password.</div>
            </div>

            <div class="mb-3">
                <label for="contact" class="form-label">Enter your contact (optional):</label>
                <input type="number" name="contact" id="contact" class="form-control">
            </div>

            <div class="text-center mb-3">
                <input role="button" type="submit" name="submit" id="submit" class="btn btn-primary" >
            </div>

            <div class="text-center">
                <p>Already have an account. <a href ='../Session/login_form.php'>Sign in</a></p>
            </div>
        </form>
    </div>
    <script>
        function showHint(value){
            var hint = document.getElementById("email-hint");
            if(value == ""){
                hint.innerHTML = "";
                return
            }
            else{
                var xmlHttp = new XMLHttpRequest(); // XMLHttpRequest object
                xmlHttp.onreadystatechange = function(){ //function to be executed when the server response is ready
                    if (this.readyState == 4 && this.status == 200) {
                        hint.innerHTML = this.responseText;
                        if(this.responseText){
                            document.getElementById("submit").disabled = true;  
                        }else{
                            document.getElementById("submit").disabled = false;  
                        }
                    }
                }
                xmlHttp.open("GET","getuser.php?q=" + value, true); //Send the request off to a file on the server
                xmlHttp.send(null);
                // hint.innerHTML = value;
            }
        }
    </script>
</body>

</html>