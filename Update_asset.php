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
$active="SELECT * FROM desktop WHERE id='$id'";
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
    $processor = $_POST["processor"];
    $ram = $_POST["ram"];
    $gpu  = $_POST["gpu"];
    $motherboard = $_POST["motherboard"];
    $power_supply = $_POST["power_supply"];
    $storage = $_POST["storage"];
    $lan_card = $_POST["lan_card"];
    $monitor_model = $_POST["monitor_model"];
    $keyboard_model = $_POST["keyboard_model"];
    $mouse_model = $_POST["mouse_model"];
    $printer_model = $_POST["printer_model"];
    $added_by = $_SESSION["user_id"];
    $added_username = $_SESSION["fullname"];

    $query="UPDATE `desktop` SET `asset_tag`='$asset_tag',
    `lab_number`='$lab_number',`brand_model`='$brand_model',`purchase_date`='$purchase_date'
    ,`status`='$status',`processor`='$processor',`ram`='$ram ',`gpu`='$gpu '
    ,`storage`='$storage',`motherboard`='$motherboard',`power_supply`='$power_supply',`storage`='$storage',`lan_card`='$lan_card',`monitor_model`='$monitor_model',`keyboard_model`='$keyboard_model'
    ,`mouse_model`='$mouse_model',`printer_model`='$printer_model' WHERE id='$id'";

    $run=mysqli_query($conn,$query);
    if($run){
        $success = true;
        $message = "Asset " . htmlspecialchars($asset_tag) . " was added successfully.";
    }
    else{
        $message = "Could not save this asset. Check the fields and try again.";
    }
}

$active = " Update_asset";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" media="all" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <title>Insert Asset - ITAMS</title>
</head>
<body>
<div class="app-shell">
    <?php include "includes/sidebar.php"; ?>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="eyebrow">Manage / Insert Asset</div>
                <h1>Add New Desktop</h1>
            </div>
            <a href="view_assets.php" class="btn-ghost">View all desktops →</a>
        </div>

        <?php if ($message) { ?>
            <div class="panel" style="padding:14px 20px; margin-bottom:18px; <?php echo $success ? 'border-color:#bbf7d0; background:#f0fdf4;' : 'border-color:#fecaca; background:#fef2f2;'; ?>">
                <p style="margin:0; <?php echo $success ? 'color:#15803d; font-weight:600;' : 'color:#dc2626; font-weight:600;'; ?>">
                    <?php echo $message; ?>
                </p>
            </div>
        <?php } ?>

        <div class="panel" style="max-width:720px;">
            <form method="POST" enctype="multipart/form-data">
                <h2 style="font-size:15px; text-transform:uppercase; letter-spacing:.05em; color:#6b7280; margin-bottom:0;">Identification</h2>
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
                </select>

                <h2 style="font-size:15px; text-transform:uppercase; letter-spacing:.05em; color:#6b7280; margin-top:26px; margin-bottom:0;">Specifications</h2>
                <label>Processor</label>
                <input type="text" name="processor" value="<?php echo $array["processor"] ?>">
                <label>RAM</label>
                <input type="text" name="ram" value="<?php echo $array["ram"] ?>">
                <label>Graphic Card</label>
                <input type="text" name="gpu" value="<?php echo $array["gpu"] ?>">
                <label>Motherboard</label>
                <input type="text" name="motherboard" value="<?php echo $array["motherboard"] ?>">
                <label>Power Supply</label>
                <input type="text" name="power_supply" value="<?php echo $array["power_supply"] ?>">
                <label>Storage</label>
                <input type="text" name="storage" value="<?php echo $array["storage"] ?>">
                <label>LAN Card</label>
                <input type="text" name="lan_card" value="<?php echo $array["lan_card"] ?>">

                <h2 style="font-size:15px; text-transform:uppercase; letter-spacing:.05em; color:#6b7280; margin-top:26px; margin-bottom:0;">Peripherals</h2>
                <label>Monitor Model</label>
                <input type="text" name="monitor_model" value="<?php echo $array["monitor_model"] ?>">
                <label>Keyboard Model</label>
                <input type="text" name="keyboard_model" value="<?php echo $array["keyboard_model"] ?>">
                <label>Mouse Model</label>
                <input type="text" name="mouse_model" value="<?php echo $array["mouse_model"] ?>">
                <label>Printer Model (if attached)</label>
                <input type="text" name="printer_model" value="<?php echo $array["printer_model"] ?>">

                <button type="submit" name="submit" class="btn-main" style="margin-top:24px;">Update Asset</button>
            </form>
        </div>
        <?php include "update_file_asset.php" ?>
    </main>
</div>
</body>
</html>
