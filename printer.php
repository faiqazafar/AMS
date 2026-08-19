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

    // Printer Hardware / Specifications
    $printer_type = $_POST["printer_type"];
    $printing_technology = $_POST["printing_technology"];
    $connectivity = $_POST["connectivity"];
    $paper_size = $_POST["paper_size"];
    $print_speed = $_POST["print_speed"];
    $resolution = $_POST["resolution"];
    $duplex_printing = $_POST["duplex_printing"];
    $color_printing = $_POST["color_printing"];
    $scanner = $_POST["scanner"];
    $copy_function = $_POST["copy_function"];
    $network_support = $_POST["network_support"];
    $toner_ink = $_POST["toner_ink"];
    $added_by = $_SESSION["user_id"];
    $added_username = $_SESSION["fullname"];
    $filename=$_FILES['file']['name'];
    $tempname=$_FILES['file']['tmp_name'];
    $folder="files/".$filename;
    move_uploaded_file($tempname,$folder);

    $query = "INSERT INTO `printer`
    (
        `asset_tag`,
        `lab_number`,
        `brand_model`,
        `purchase_date`,
        `status`,
        `printer_type`,
        `printing_technology`,
        `connectivity`,
        `paper_size`,
        `print_speed`,
        `resolution`,
        `duplex_printing`,
        `color_printing`,
        `scanner`,
        `copy_function`,
        `network_support`,
        `toner_ink`,
        `user_id`,
        `user_name`,
        `file`
    )
    VALUES
    (
        '$asset_tag',
        '$lab_number',
        '$brand_model',
        '$purchase_date',
        '$status',
        '$printer_type',
        '$printing_technology',
        '$connectivity',
        '$paper_size',
        '$print_speed',
        '$resolution',
        '$duplex_printing',
        '$color_printing',
        '$scanner',
        '$copy_function',
        '$network_support',
        '$toner_ink',
        '$added_by',
        '$added_username',
        '$filename'
    )";

    $run = mysqli_query($conn, $query);

    if ($run) {
        $success = true;
        $message = "Printer " . htmlspecialchars($asset_tag) . " was added successfully.";
    } else {
        $message = "Could not save this printer. Check the fields and try again.";
    }
}

$active = "add_asset";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.min.css"
          media="all"
          rel="stylesheet">

    <script src="js/bootstrap.min.js"></script>

    <link href="css/style.css"
          rel="stylesheet">

    <title>Insert Printer - ITAMS</title>

</head>

<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">

            <div>

                <div class="eyebrow">
                    Manage / Insert Asset
                </div>

                <h1>Add New Printer</h1>

            </div>

            <a href="view_printers.php"
               class="btn-ghost">

                View all printers →

            </a>

        </div>


        <?php if ($message) { ?>

            <div class="panel"
                 style="padding:14px 20px;
                 margin-bottom:18px;
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


        <div class="panel"
             style="max-width:720px;">

            <form method="POST" enctype="multipart/form-data">

                <!-- Identification -->

                <h2 style="font-size:15px;
                text-transform:uppercase;
                letter-spacing:.05em;
                color:#6b7280;
                margin-bottom:0;">

                    Identification

                </h2>


                <label>Asset Tag (unique)</label>

                <input type="text"
                       name="asset_tag"
                       required>


                <label>Lab Number</label>

                <select name="lab_number"
                        required>

                    <option value="1">Lab 1</option>
                    <option value="2">Lab 2</option>
                    <option value="3">Lab 3</option>
                    <option value="4">Lab 4</option>
                    <option value="5">Lab 5</option>

                </select>


                <label>Brand / Model</label>

                <input type="text"
                       name="brand_model"
                       placeholder="e.g. HP LaserJet Pro M404">


                <label>Purchase Date</label>

                <input type="date"
                       name="purchase_date">


                <label>Status</label>

                <select name="status">

                    <option value="Working">
                        Working
                    </option>

                    <option value="Faulty">
                        Faulty
                    </option>

                    <option value="In Repair">
                        In Repair
                    </option>

                    <option value="Lost">
                        Lost
                    </option>

                </select>


                <!-- Printer Specifications -->

                <h2 style="font-size:15px;
                text-transform:uppercase;
                letter-spacing:.05em;
                color:#6b7280;
                margin-top:26px;
                margin-bottom:0;">

                    Printer Specifications

                </h2>


                <label>Printer Type</label>

                <select name="printer_type">

                    <option value="Laser">
                        Laser Printer
                    </option>

                    <option value="Inkjet">
                        Inkjet Printer
                    </option>

                    <option value="Dot Matrix">
                        Dot Matrix Printer
                    </option>

                    <option value="Thermal">
                        Thermal Printer
                    </option>

                    <option value="Multifunction">
                        Multifunction Printer
                    </option>

                </select>


                <label>Printing Technology</label>

                <select name="printing_technology">

                    <option value="Laser">
                        Laser
                    </option>

                    <option value="Inkjet">
                        Inkjet
                    </option>

                    <option value="Dot Matrix">
                        Dot Matrix
                    </option>

                    <option value="Thermal">
                        Thermal
                    </option>

                </select>


                <label>Connectivity</label>

                <select name="connectivity">

                    <option value="USB">
                        USB
                    </option>

                    <option value="Wi-Fi">
                        Wi-Fi
                    </option>

                    <option value="Ethernet">
                        Ethernet
                    </option>

                    <option value="USB + Wi-Fi">
                        USB + Wi-Fi
                    </option>

                    <option value="USB + Ethernet">
                        USB + Ethernet
                    </option>

                </select>


                <label>Paper Size</label>

                <select name="paper_size">

                    <option value="A4">A4</option>
                    <option value="A3">A3</option>
                    <option value="A5">A5</option>
                    <option value="Letter">Letter</option>
                    <option value="Legal">Legal</option>

                </select>


                <label>Print Speed</label>

                <input type="text"
                       name="print_speed"
                       placeholder="e.g. 30 pages per minute">


                <label>Print Resolution</label>

                <input type="text"
                       name="resolution"
                       placeholder="e.g. 1200 x 1200 DPI">


                <label>Duplex Printing</label>

                <select name="duplex_printing">

                    <option value="Yes">Yes</option>
                    <option value="No">No</option>

                </select>


                <label>Color Printing</label>

                <select name="color_printing">

                    <option value="Color">Color</option>
                    <option value="Black & White">
                        Black & White
                    </option>

                </select>


                <!-- Additional Features -->

                <h2 style="font-size:15px;
                text-transform:uppercase;
                letter-spacing:.05em;
                color:#6b7280;
                margin-top:26px;
                margin-bottom:0;">

                    Additional Features

                </h2>


                <label>Scanner</label>

                <select name="scanner">

                    <option value="Yes">Yes</option>
                    <option value="No">No</option>

                </select>


                <label>Copy Function</label>

                <select name="copy_function">

                    <option value="Yes">Yes</option>
                    <option value="No">No</option>

                </select>


                <label>Network Support</label>

                <select name="network_support">

                    <option value="Yes">Yes</option>
                    <option value="No">No</option>

                </select>


                <label>Toner / Ink Type</label>

                <input type="text"
                       name="toner_ink"
                       placeholder="e.g. HP 76A Toner">

                <label>file upload</label>
                 <input type="file" name="file" class="form-control" style="width:300px" required>
                 


                <button type="submit"
                        name="submit"
                        class="btn-main"
                        style="margin-top:24px;">

                    Save Printer

                </button>

            </form>

        </div>

    </main>

</div>

</body>

</html>