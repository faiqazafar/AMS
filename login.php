<?php

session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit();
}

$message = "";

if (isset($_POST["submit"])) {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $message = "Please enter email and password.";
    } else {

        $pimsUrl = "https://ums-production-34b4.up.railway.app/api/login.php";
        $pimsToken = getenv("123456789");

        if (!$pimsToken) {

            $message = "PIMS API configuration error.";

        } else {

            $requestData = [
                "email" => $email,
                "password" => $password
            ];

            $ch = curl_init($pimsUrl);

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                json_encode($requestData)
            );

            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer " . $pimsToken,
                "Content-Type: application/json"
            ]);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($response === false) {

                $message = "Unable to connect to PIMS.";

            } else {

                $result = json_decode($response, true);

                if (
                    $httpCode >= 200 &&
                    $httpCode < 300 &&
                    isset($result["success"]) &&
                    $result["success"] === true
                ) {

                    /*
                     * PIMS authentication successful.
                     */

                    $user = $result["data"]["user"] ?? [];

                    $_SESSION["user_id"] = $user["id"] ?? $email;
                    $_SESSION["fullname"] = $user["name"] ?? "Admin";
                    $_SESSION["email"] = $user["email"] ?? $email;
                    $_SESSION["role"] = $user["role"] ?? "admin";

                    header("Location: dashboard.php");
                    exit();

                } else {

                    $message = $result["message"] ?? "Invalid email or password.";
                }
            }

            curl_close($ch);
        }
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
