<?php
include "connection.php";
session_start();
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

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
    $gpu = $_POST["gpu"];
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

    $query="INSERT INTO `desktop`( `asset_tag`, `lab_number`, `brand_model`, `purchase_date`, `status`, `processor`, `ram`, `gpu`, `motherboard`, `power_supply`, `storage`, `lan_card`, `monitor_model`, `keyboard_model`, `mouse_model`, `printer_model`, `user_id`, `user_name`) 
    VALUES ('$asset_tag','$lab_number','$brand_model','$purchase_date','$status','$processor','$ram','$gpu','$motherboard','$power_supply'
    ,'$storage','$lan_card','$monitor_model','$keyboard_model','$mouse_model','$printer_model','$added_by','$added_username')";

    $run=mysqli_query($conn,$query);
    if($run){
        $success = true;
        $message = "Asset " . htmlspecialchars($asset_tag) . " was added successfully.";
    }
    else{
        $message = "Could not save this asset. Check the fields and try again.";
    }
}

$active = "add_asset";
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
                <input type="text" name="asset_tag" required>

                <label>Lab Number</label>
                <select name="lab_number" required>
                    <option value="1">Lab 1</option>
                    <option value="2">Lab 2</option>
                    <option value="3">Lab 3</option>
                    <option value="4">Lab 4</option>
                    <option value="5">Lab 5</option>
                </select>

                <label>Brand / Model</label>
                <input type="text" name="brand_model">

                <label>Purchase Date</label>
                <input type="date" name="purchase_date">

                <label>Status</label>
                <select name="status">
                    <option value="Working">Working</option>
                    <option value="Faulty">Faulty</option>
                    <option value="In Repair">In Repair</option>
                </select>

                <h2 style="font-size:15px; text-transform:uppercase; letter-spacing:.05em; color:#6b7280; margin-top:26px; margin-bottom:0;">Specifications</h2>
                <label>Processor</label>
                <input type="text" name="processor">
                <label>RAM</label>
                <input type="text" name="ram">
                <label>Graphic Card</label>
                <input type="text" name="gpu">
                <label>Motherboard</label>
                <input type="text" name="motherboard">
                <label>Power Supply</label>
                <input type="text" name="power_supply">
                <label>Storage</label>
                <input type="text" name="storage">
                <label>LAN Card</label>
                <input type="text" name="lan_card">

                <h2 style="font-size:15px; text-transform:uppercase; letter-spacing:.05em; color:#6b7280; margin-top:26px; margin-bottom:0;">Peripherals</h2>
                <label>Monitor Model</label>
                <input type="text" name="monitor_model">
                <label>Keyboard Model</label>
                <input type="text" name="keyboard_model">
                <label>Mouse Model</label>
                <input type="text" name="mouse_model">
                <label>Printer Model (if attached)</label>
                <input type="text" name="printer_model">
                <label>file upload</label>
                 <input type="file" name="upload" class="form-control" style="width:300px" required>
                 <br>
                
                <button type="submit" name="submit" class="btn-main" style="margin-top:24px;">Save Asset</button>
            </form>
        </div>
    </main>
</div>
</body>
</html>
