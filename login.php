<?php
include "connection.php";
session_start();

if (isset($_SESSION["user_id"])) {
    header("location: dashboard.php");
    exit();
}

$message = "";

if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query="SELECT * FROM login WHERE email='$email' AND password='$password'";
    $run=mysqli_query($conn,$query);
    $total=mysqli_num_rows($run);
    $row=mysqli_fetch_array($run);
    $fullname=$row['fullname'];
    if($total>0){
        $_SESSION['user_id']=$email ;
        $_SESSION['fullname']=$fullname;
        header("location:dashboard.php");
        exit();
    }
    else{
         header("location:login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" media="all" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <title>Login - ITAMS</title>
</head>
<body>
    <div class="auth-shell">
        <div class="auth-visual">
            <div class="brand-mark">IT</div>
            <h2>Track every desktop, laptop, printer and projector in one place.</h2>
            <p>ITAMS gives your department a single, live view of lab hardware — status, location, and history — without the spreadsheet chaos.</p>
            <div class="auth-points">
                <span>Real-time status across every lab</span>
                <span>Centralized records, zero duplicate entries</span>
                <span>Built for department IT teams</span>
            </div>
        </div>
        <div class="auth-form-side">
            <div class="container">
                <h1>Welcome back</h1>
                <hr>
                <?php if ($message) echo "<p class='error'>$message</p>"; ?>
                <form method="POST">

                    <label>Email address</label>
                    <input type="email" name="email" required>

                    <label>Password</label>
                    <input type="password" name="password" required>

                    <button type="submit" name="submit" class="btn-main">Log in</button>
                </form>
                <p class="mt-3">No account? <a href="signup.php">Sign up</a></p>
            </div>
        </div>
    </div>
</body>
</html>
