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

    // Projector Specifications
    $projector_type = $_POST["projector_type"];
    $display_technology = $_POST["display_technology"];
    $resolution = $_POST["resolution"];
    $brightness = $_POST["brightness"];
    $contrast_ratio = $_POST["contrast_ratio"];
    $lamp_type = $_POST["lamp_type"];
    $lamp_hours = $_POST["lamp_hours"];
    $projection_size = $_POST["projection_size"];
    $throw_distance = $_POST["throw_distance"];
    $hdmi = $_POST["hdmi"];
    $vga = $_POST["vga"];
    $usb = $_POST["usb"];
    $wireless = $_POST["wireless"];
    $speaker = $_POST["speaker"];
    $remote = $_POST["remote"];

    $added_by = $_SESSION["user_id"];
    $added_username = $_SESSION["fullname"];

    $query = "INSERT INTO `projector`
    (
        `asset_tag`,
        `lab_number`,
        `brand_model`,
        `purchase_date`,
        `status`,
        `projector_type`,
        `display_technology`,
        `resolution`,
        `brightness`,
        `contrast_ratio`,
        `lamp_type`,
        `lamp_hours`,
        `projection_size`,
        `throw_distance`,
        `hdmi`,
        `vga`,
        `usb`,
        `wireless`,
        `speaker`,
        `remote`,
        `user_id`,
        `user_name`
    )
    VALUES
    (
        '$asset_tag',
        '$lab_number',
        '$brand_model',
        '$purchase_date',
        '$status',
        '$projector_type',
        '$display_technology',
        '$resolution',
        '$brightness',
        '$contrast_ratio',
        '$lamp_type',
        '$lamp_hours',
        '$projection_size',
        '$throw_distance',
        '$hdmi',
        '$vga',
        '$usb',
        '$wireless',
        '$speaker',
        '$remote',
        '$added_by',
        '$added_username'
    )";

    $run = mysqli_query($conn, $query);

    if ($run) {
        $success = true;
        $message = "Projector " . htmlspecialchars($asset_tag) .
                   " was added successfully.";
    } else {
        $message = "Could not save this projector. Check the fields and try again.";
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

    <title>Insert Projector - ITAMS</title>

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

                <h1>Add New Projector</h1>

            </div>

            <a href="view_projectors.php"
               class="btn-ghost">

                View all projectors →

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

            <form method="POST">

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
                       placeholder="e.g. Epson EB-X06">


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


                <!-- Projector Specifications -->

                <h2 style="font-size:15px;
                text-transform:uppercase;
                letter-spacing:.05em;
                color:#6b7280;
                margin-top:26px;
                margin-bottom:0;">

                    Projector Specifications

                </h2>


                <label>Projector Type</label>

                <select name="projector_type">

                    <option value="Standard">
                        Standard
                    </option>

                    <option value="Short Throw">
                        Short Throw
                    </option>

                    <option value="Ultra Short Throw">
                        Ultra Short Throw
                    </option>

                    <option value="Portable">
                        Portable
                    </option>

                </select>


                <label>Display Technology</label>

                <select name="display_technology">

                    <option value="LCD">LCD</option>
                    <option value="DLP">DLP</option>
                    <option value="LED">LED</option>
                    <option value="Laser">Laser</option>

                </select>


                <label>Resolution</label>

                <input type="text"
                       name="resolution"
                       placeholder="e.g. 1920 x 1080 Full HD">


                <label>Brightness</label>

                <input type="text"
                       name="brightness"
                       placeholder="e.g. 3600 Lumens">


                <label>Contrast Ratio</label>

                <input type="text"
                       name="contrast_ratio"
                       placeholder="e.g. 15000:1">


                <label>Lamp Type</label>

                <input type="text"
                       name="lamp_type"
                       placeholder="e.g. UHE Lamp / LED / Laser">


                <label>Lamp Hours</label>

                <input type="text"
                       name="lamp_hours"
                       placeholder="e.g. 5000 hours">


                <label>Projection Size</label>

                <input type="text"
                       name="projection_size"
                       placeholder="e.g. 30 - 300 inches">


                <label>Throw Distance</label>

                <input type="text"
                       name="throw_distance"
                       placeholder="e.g. 1.5 - 10 meters">


                <!-- Connectivity -->

                <h2 style="font-size:15px;
                text-transform:uppercase;
                letter-spacing:.05em;
                color:#6b7280;
                margin-top:26px;
                margin-bottom:0;">

                    Connectivity & Features

                </h2>


                <label>HDMI</label>

                <select name="hdmi">

                    <option value="Yes">Yes</option>
                    <option value="No">No</option>

                </select>


                <label>VGA</label>

                <select name="vga">

                    <option value="Yes">Yes</option>
                    <option value="No">No</option>

                </select>


                <label>USB</label>

                <select name="usb">

                    <option value="Yes">Yes</option>
                    <option value="No">No</option>

                </select>


                <label>Wireless Connectivity</label>

                <select name="wireless">

                    <option value="Yes">Yes</option>
                    <option value="No">No</option>

                </select>


                <label>Built-in Speaker</label>

                <select name="speaker">

                    <option value="Yes">Yes</option>
                    <option value="No">No</option>

                </select>


                <label>Remote Control</label>

                <select name="remote">

                    <option value="Available">
                        Available
                    </option>

                    <option value="Missing">
                        Missing
                    </option>

                </select>
                <label>file upload</label>
                <input type="file" name="upload" class="form-control" style="width:300px" required>
                <br>
                <br>
                <textarea name="msgs" placeholder="Enter Some Text" rows="3" style="width: 300px" class="form-control" required></textarea>
                <br>
                <input type="submit" name="btn" class="form-control" style="width:100px" value="submit">
                <br><br>


                <button type="submit"
                        name="submit"
                        class="btn-main"
                        style="margin-top:24px;">

                    Save Projector

                </button>

            </form>

        </div>

    </main>

</div>

</body>

</html>