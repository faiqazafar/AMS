<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}
if (isset($_GET['id'])) {
	$id=$_GET['id'];
}
$active="SELECT * FROM laptop WHERE id='$id'";
$result=mysqli_query($conn,$active);
$array=mysqli_fetch_array($result);

$message = "";
$success = false;

if (isset($_POST["submit"])) {

    $asset_tag = $_POST["asset_tag"];
    $lab_number = $_POST["lab_number"];
    $brand_model = $_POST["brand_model"];
    $purchase_date = $_POST["purchase_date"];
    $status = $_POST["status"];

    // Laptop Hardware
    $processor = $_POST["processor"];
    $ram = $_POST["ram"];
    $gpu = $_POST["gpu"];
    $storage = $_POST["storage"];
    $display = $_POST["display"];
    $battery = $_POST["battery"];
    $wifi = $_POST["wifi"];
    $webcam = $_POST["webcam"];
    $bluetooth = $_POST["bluetooth"];
    $operating_system = $_POST["operating_system"];
    $charger = $_POST["charger"];

    $added_by = $_SESSION["user_id"];
    $added_username = $_SESSION["fullname"];

    $query = "UPDATE `laptop` SET
        `asset_tag`= '$asset_tag',
        `lab_number`= '$lab_number',
        `brand_model`='$brand_model',
        `purchase_date` = '$purchase_date' ,
        `status` = '$status' ,
        `processor` =  '$processor',
        `ram` = '$ram',
        `gpu` = '$gpu',
        `storage` =  '$storage',
        `display` = '$display',
        `battery` = '$battery',
        `wifi`= '$wifi',
        `webcam` = '$webcam',
        `bluetooth`= '$bluetooth',
        `operating_system` = '$operating_system' ,
        `charger`='$charger' ,
        `user_id` ='$added_by',
        `user_name`= '$added_username'";
    $run = mysqli_query($conn, $query);

    if ($run) {
        $success = true;
        $message = "Laptop " . htmlspecialchars($asset_tag) . " was added successfully.";
    } else {
        $message = "Could not save this laptop. Check the fields and try again.";
    }
}

$active = "Update_laptop";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css" media="all" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link href="css/style.css" rel="stylesheet">

    <title>Insert Laptop - ITAMS</title>
</head>

<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">

            <div>
                <div class="eyebrow">Manage / Insert Asset</div>
                <h1>Add New Laptop</h1>
            </div>

            <a href="view_laptops.php" class="btn-ghost">
                View all laptops →
            </a>

        </div>


        <?php if ($message) { ?>

            <div class="panel"
                style="padding:14px 20px; margin-bottom:18px;
                <?php echo $success
                    ? 'border-color:#bbf7d0; background:#f0fdf4;'
                    : 'border-color:#fecaca; background:#fef2f2;'; ?>">

                <p style="margin:0;
                    <?php echo $success
                        ? 'color:#15803d; font-weight:600;'
                        : 'color:#dc2626; font-weight:600;'; ?>">

                    <?php echo $message; ?>

                </p>

            </div>

        <?php } ?>


        <div class="panel" style="max-width:720px;">

            <form method="POST">

                <!-- Identification -->

                <h2 style="font-size:15px; text-transform:uppercase;
                    letter-spacing:.05em; color:#6b7280;
                    margin-bottom:0;">

                    Identification

                </h2>

                <label>Asset Tag (unique)</label>
                <input type="text" name="asset_tag" value="<?php echo $array["asset_tag"] ?> ">


                <label>Lab Number</label>

                <select name="lab_number" >

                    <option value="1">Lab 1</option>
                    <option value="2">Lab 2</option>
                    <option value="3">Lab 3</option>
                    <option value="4">Lab 4</option>
                    <option value="5">Lab 5</option>

                </select>


                <label>Brand / Model</label>
                <input type="text" name="brand_model" value="<?php echo $array["brand_model"] ?>">


                <label>Purchase Date</label>
                <input type="date" name="purchase_date" value="<?php echo $array["purchase_date"] ?>">


                <label>Status</label>

                <select name="status" value="<?php echo $array["status"] ?>">

                    <option value="Working">Working</option>
                    <option value="Faulty">Faulty</option>
                    <option value="In Repair">In Repair</option>
                    <option value="Lost">Lost</option>

                </select>


                <!-- Laptop Hardware -->

                <h2 style="font-size:15px; text-transform:uppercase;
                    letter-spacing:.05em; color:#6b7280;
                    margin-top:26px; margin-bottom:0;">

                    Laptop Hardware

                </h2>


                <label>Processor / CPU</label>
                <input type="text" name="processor" value="<?php echo $array["processor"] ?>"
                    placeholder="e.g. Intel Core i5 12th Gen">


                <label>RAM</label>
                <input type="text" name="ram" value="<?php echo $array["ram"] ?>"
                    placeholder="e.g. 8GB DDR4">


                <label>Graphic Card / GPU</label>
                <input type="text" name="gpu" value="<?php echo $array["gpu"] ?>"
                    placeholder="e.g. NVIDIA MX450 / Integrated">


                <label>Storage</label>
                <input type="text" name="storage" value="<?php echo $array["storage"] ?>"
                    placeholder="e.g. 512GB SSD">


                <label>Display / Screen</label>
                <input type="text" name="display" value="<?php echo $array["display"] ?>"
                    placeholder="e.g. 15.6 inch Full HD">


                <label>Battery</label>
                <input type="text" name="battery" value="<?php echo $array["battery"] ?>"
                    placeholder="e.g. 45Wh">


                <label>Wi-Fi</label>
                <input type="text" name="wifi" value="<?php echo $array["wifi"] ?>"
                    placeholder="e.g. Wi-Fi 6">


                <label>Webcam</label>
                <input type="text" name="webcam" value="<?php echo $array["webcam"] ?>"
                    placeholder="e.g. HD 720p">


                <label>Bluetooth</label>
                <input type="text" name="bluetooth" value="<?php echo $array["bluetooth"] ?>"
                    placeholder="e.g. Bluetooth 5.2">


                <label>Operating System</label>

                <select name="operating_system"  value="<?php echo $array["operating_system"] ?>">

                    <option value="Windows 11">Windows 11</option>
                    <option value="Windows 10">Windows 10</option>
                    <option value="Ubuntu">Ubuntu</option>
                    <option value="Other">Other</option>

                </select>


                <label>Charger / Adapter</label>
                <input type="text" name="charger" value="<?php echo $array["charger"] ?>"
                    placeholder="e.g. 65W Original Adapter">


                <!-- Submit -->

                <button type="submit"
                    name="submit"
                    class="btn-main"
                    style="margin-top:24px;">

                    Save Laptop

                </button>

            </form>

        </div>
        <?php include "update_laptop_asset.php" ?>

    </main>

</div>

</body>
</html>