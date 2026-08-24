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

    $query = "SELECT * FROM login WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        $_SESSION["user_id"] = $email;
        $_SESSION["fullname"] = $row["fullname"];
        $_SESSION["photo"] = isset($row["photo"]) ? $row["photo"] : "";

        header("location: dashboard.php");
        exit();
    }
    else {
        $message = "Wrong email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - IT Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="auth-shell">

    <div class="auth-visual">
        <div class="brand-mark">IT</div>

        <h2>IT Management System</h2>

        <p>
            Manage university desktops, laptops, printers and projectors in one place.
        </p>
    </div>

    <div class="auth-form-side">

        <div class="container">

            <h1>IT Management System</h1>
            <h4>Comsats University Islamabad</h4>

            <p>Login to your account</p>

            <?php if ($message != "") { ?>
                <p class="error"><?php echo $message; ?></p>
            <?php } ?>

            <form method="POST">

                <label>Email</label>
                <input type="email" name="email" required>

                <label>Password</label>
                <input type="password" name="password" required>

                <button type="submit" name="submit" class="btn-main">
                    Login
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>
