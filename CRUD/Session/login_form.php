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
    <title>Login</title>
</head>

<body>
    <div class="container my-5 mx-auto col-lg-6 col-md-10">
        <div>
            <h2 class="text-center">PHP + MySQL Login Practice</h2>
            <p class="text-center text-secondary">Sign in to our portal</p>
        </div>
        <div class='container my-4 p-5'>
            <form action="session.php" method="POST" class="py-4 px-5 m-4 bg-light rounded border border-secondary">
                <span class="text-danger"><?php echo isset($_GET['error']) ? $_GET['error'] : ''; ?></span>
                <div class="mb-3">
                    <label for="email" class="form-label">Enter your email</label>
                    <input type="email" id='email' name='email' class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form label">Enter Password</label>
                    <input type="password" id='password' name='password' class="form-control" required>
                </div>
                <div class="text-center mb-3">
                    <input type="submit" name="login" id="login" class="btn btn-primary">
                </div>

                <div class="text-center">
                    <p>Do not have an account. <a href='../Ajax/signup_form.php'>Sign up</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>