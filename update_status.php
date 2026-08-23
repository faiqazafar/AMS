<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

// Which table are we editing? Comes from the link on each view page
// e.g. update_status.php?type=laptop&id=5
$allowed_types = array("desktop", "laptop", "printer", "projector");
$type = (isset($_GET['type']) && in_array($_GET['type'], $allowed_types)) ? $_GET['type'] : "desktop";
$table = $type;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$message = "";

$active_row = "SELECT * FROM $table WHERE id='$id'";
$result = mysqli_query($conn, $active_row);
$array = mysqli_fetch_array($result);
if (!$array) {
    $array = array();
}

if (isset($_POST["update"])) {

    $asset_tag = mysqli_real_escape_string($conn, $_POST["asset_tag"]);
    $department = mysqli_real_escape_string($conn, $_POST["department"]);
    $lab = mysqli_real_escape_string($conn, $_POST["lab"]);
    $brand = mysqli_real_escape_string($conn, $_POST["brand"]);
    $model = mysqli_real_escape_string($conn, $_POST["model"]);
    $status = mysqli_real_escape_string($conn, $_POST["status"]);

    $photo_sql = "";
    if (!empty($_FILES["photo"]["name"])) {
        $photo = $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "files/" . $photo);
        $photo = mysqli_real_escape_string($conn, $photo);
        $photo_sql = ", photo='$photo'";
    }

    if ($type == "desktop" || $type == "laptop") {

        $series = mysqli_real_escape_string($conn, $_POST["series"]);
        $ram = mysqli_real_escape_string($conn, $_POST["ram"]);
        $capacity = mysqli_real_escape_string($conn, $_POST["capacity"]);
        $serial_no = mysqli_real_escape_string($conn, $_POST["serial_no"]);
        $bus_speed = mysqli_real_escape_string($conn, $_POST["bus_speed"]);
        $wifi = mysqli_real_escape_string($conn, $_POST["wifi"]);
        $processor = mysqli_real_escape_string($conn, $_POST["processor"]);
        $processor_manufacturer = mysqli_real_escape_string($conn, $_POST["processor_manufacturer"]);
        $micro_card = mysqli_real_escape_string($conn, $_POST["micro_card"]);
        $clock_speed = mysqli_real_escape_string($conn, $_POST["clock_speed"]);
        $processor_series = mysqli_real_escape_string($conn, $_POST["processor_series"]);
        $motherboard_manufacturer = mysqli_real_escape_string($conn, $_POST["motherboard_manufacturer"]);
        $motherboard_model = mysqli_real_escape_string($conn, $_POST["motherboard_model"]);
        $motherboard_series = mysqli_real_escape_string($conn, $_POST["motherboard_series"]);
        $storage_manufacturer = mysqli_real_escape_string($conn, $_POST["storage_manufacturer"]);
        $storage_type = mysqli_real_escape_string($conn, $_POST["storage_type"]);
        $form_factor = mysqli_real_escape_string($conn, $_POST["form_factor"]);
        $storage_model = mysqli_real_escape_string($conn, $_POST["storage_model"]);

        if ($type == "desktop") {

            $ethernet_card = mysqli_real_escape_string($conn, $_POST["ethernet_card"]);
            $ethernet_model = mysqli_real_escape_string($conn, $_POST["ethernet_model"]);
            $mac_address = mysqli_real_escape_string($conn, $_POST["mac_address"]);

            $sql = "UPDATE desktop SET
                asset_tag='$asset_tag', department='$department', lab='$lab', brand='$brand', model='$model',
                series='$series', ram='$ram', capacity='$capacity', serial_no='$serial_no',
                bus_speed='$bus_speed', ethernet_card='$ethernet_card', ethernet_model='$ethernet_model',
                mac_address='$mac_address', wifi='$wifi', processor='$processor',
                processor_manufacturer='$processor_manufacturer', micro_card='$micro_card',
                 clock_speed='$clock_speed', processor_series='$processor_series',
                status='$status', motherboard_manufacturer='$motherboard_manufacturer',
                motherboard_model='$motherboard_model', motherboard_series='$motherboard_series',
                storage_manufacturer='$storage_manufacturer', storage_type='$storage_type',
                form_factor='$form_factor', storage_model='$storage_model' $photo_sql
                WHERE id='$id'";

        } else {

            $camera = mysqli_real_escape_string($conn, $_POST["camera"]);

            $sql = "UPDATE laptop SET
                asset_tag='$asset_tag', department='$department', lab='$lab', brand='$brand', model='$model',
                series='$series', ram='$ram', capacity='$capacity', serial_no='$serial_no',
                bus_speed='$bus_speed', wifi='$wifi', camera='$camera', processor='$processor',
                processor_manufacturer='$processor_manufacturer', 
                micro_card='$micro_card', clock_speed='$clock_speed', processor_series='$processor_series',
                status='$status', motherboard_manufacturer='$motherboard_manufacturer',
                motherboard_model='$motherboard_model', motherboard_series='$motherboard_series',
                storage_manufacturer='$storage_manufacturer', storage_type='$storage_type',
                form_factor='$form_factor', storage_model='$storage_model' $photo_sql
                WHERE id='$id'";
        }

    } elseif ($type == "printer") {

        $printer_class = mysqli_real_escape_string($conn, $_POST["printer_class"]);
        $serial_no = mysqli_real_escape_string($conn, $_POST["serial_no"]);
        $printer_type = mysqli_real_escape_string($conn, $_POST["printer_type"]);
        $color_printer = mysqli_real_escape_string($conn, $_POST["color_printer"]);
        $toner = mysqli_real_escape_string($conn, $_POST["toner"]);

        $sql = "UPDATE printer SET
            asset_tag='$asset_tag', department='$department', lab='$lab', brand='$brand',
            printer_class='$printer_class', model='$model', serial_no='$serial_no',
            printer_type='$printer_type', color_printer='$color_printer', toner='$toner',
            status='$status' $photo_sql
            WHERE id='$id'";

    } else { // projector

        $connection_type = mysqli_real_escape_string($conn, $_POST["connection_type"]);

        $sql = "UPDATE projector SET
            asset_tag='$asset_tag', department='$department', lab='$lab', brand='$brand', model='$model',
            connection_type='$connection_type', status='$status' $photo_sql
            WHERE id='$id'";
    }

    if (mysqli_query($conn, $sql)) {
        $message = "Status updated successfully.";
    }
    else {
        $message = "Status could not be updated.";
    }

    // refresh the row so the form shows what was just saved
    $result = mysqli_query($conn, "SELECT * FROM $table WHERE id='$id'");
    $array = mysqli_fetch_array($result);
}

$active = "update_status";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Status - ITAMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">Update</div>
                <h1>Update <?php echo ucfirst($type); ?> Status</h1>
            </div>

            <a href="<?php echo ($type == "desktop") ? "view_assets.php" : "view_" . $type . ".php"; ?>" class="btn-ghost">Back to List</a>
        </div>

        <div class="panel">

            <?php if ($message != "") { ?>
                <div class="message"><?php echo $message; ?></div>
            <?php } ?>

            <form method="POST" enctype="multipart/form-data">

                <h2>Identification</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Registration No</label>
                        <input type="text" name="asset_tag" value="<?php echo val($array,'asset_tag'); ?>">
                    </div>
                    <div class="field">
                        <label>Department</label>
                        <select name="department" id="department">
                            <option value="Computer Science" <?php echo sel($array['department'],'Computer Science'); ?>>Computer Science</option>
                            <option value="Electrical Eng" <?php echo sel($array['department'],'Electrical Eng'); ?>>Electrical Engineering</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Lab</label>
                        <select name="lab" id="lab"></select>
                    </div>

                    <div class="field">
                        <label>Brand</label>
                        <?php if ($type == "printer") { ?>
                        <select name="brand">
                            <option value="Unbranded" <?php echo sel($array['brand'],'Unbranded'); ?>>Unbranded</option>
                            <option value="HP" <?php echo sel($array['brand'],'HP'); ?>>HP</option>
                            <option value="Canon" <?php echo sel($array['brand'],'Canon'); ?>>Canon</option>
                            <option value="Epson" <?php echo sel($array['brand'],'Epson'); ?>>Epson</option>
                            <option value="Brother" <?php echo sel($array['brand'],'Brother'); ?>>Brother</option>
                            <option value="Other" <?php echo sel($array['brand'],'Other'); ?>>Other</option>
                        </select>
                        <?php } elseif ($type == "projector") { ?>
                        <select name="brand">
                            <option value="Unbranded" <?php echo sel($array['brand'],'Unbranded'); ?>>Unbranded</option>
                            <option value="Epson" <?php echo sel($array['brand'],'Epson'); ?>>Epson</option>
                            <option value="BenQ" <?php echo sel($array['brand'],'BenQ'); ?>>BenQ</option>
                            <option value="ViewSonic" <?php echo sel($array['brand'],'ViewSonic'); ?>>ViewSonic</option>
                            <option value="Other" <?php echo sel($array['brand'],'Other'); ?>>Other</option>
                        </select>
                        <?php } else { ?>
                        <select name="brand">
                            <option value="Unbranded" <?php echo sel($array['brand'],'Unbranded'); ?>>Unbranded</option>
                            <option value="HP" <?php echo sel($array['brand'],'HP'); ?>>HP</option>
                            <option value="Dell" <?php echo sel($array['brand'],'Dell'); ?>>Dell</option>
                            <option value="Lenovo" <?php echo sel($array['brand'],'Lenovo'); ?>>Lenovo</option>
                            <option value="Acer" <?php echo sel($array['brand'],'Acer'); ?>>Acer</option>
                            <option value="Other" <?php echo sel($array['brand'],'Other'); ?>>Other</option>
                        </select>
                        <?php } ?>
                    </div>

                    <?php if ($type == "printer") { ?>
                    <div class="field">
                        <label>Printer Class</label>
                        <select name="printer_class">
                            <option value="Personal" <?php echo sel($array['printer_class'],'Personal'); ?>>Personal</option>
                            <option value="Workgroup" <?php echo sel($array['printer_class'],'Workgroup'); ?>>Workgroup</option>
                            <option value="Enterprise" <?php echo sel($array['printer_class'],'Enterprise'); ?>>Enterprise</option>
                        </select>
                    </div>
                    <?php } ?>

                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="model" value="<?php echo val($array,'model'); ?>">
                    </div>

                    <?php if ($type == "desktop" || $type == "laptop") { ?>
                    <div class="field">
                        <label>Series</label>
                        <input type="text" name="series" value="<?php echo val($array,'series'); ?>">
                    </div>

                    <div class="field">
                        <label>RAM</label>
                        <select name="ram">
                            <option value="2 GB" <?php echo sel($array['ram'],'2 GB'); ?>>2 GB</option>
                            <option value="4 GB" <?php echo sel($array['ram'],'4 GB'); ?>>4 GB</option>
                            <option value="8 GB" <?php echo sel($array['ram'],'8 GB'); ?>>8 GB</option>
                            <option value="16 GB" <?php echo sel($array['ram'],'16 GB'); ?>>16 GB</option>
                            <option value="32 GB" <?php echo sel($array['ram'],'32 GB'); ?>>32 GB</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Capacity</label>
                        <input type="number" name="capacity" value="<?php echo val($array,'capacity'); ?>">
                    </div>
                    <div class="field">
                        <label>Serial No</label>
                        <input type="text" name="serial_no" value="<?php echo val($array,'serial_no'); ?>">
                    </div>

                    <div class="field">
                        <label>Bus Speed</label>
                        <input type="text" name="bus_speed" value="<?php echo val($array,'bus_speed'); ?>">
                    </div>
                    <?php } ?>

                    <?php if ($type == "printer") { ?>
                    <div class="field">
                        <label>Serial No</label>
                        <input type="text" name="serial_no" value="<?php echo val($array,'serial_no'); ?>">
                    </div>
                    <div class="field">
                        <label>Printer Type</label>
                        <select name="printer_type">
                            <option value="Laser" <?php echo sel($array['printer_type'],'Laser'); ?>>Laser</option>
                            <option value="Inkjet" <?php echo sel($array['printer_type'],'Inkjet'); ?>>Inkjet</option>
                            <option value="Dot Matrix" <?php echo sel($array['printer_type'],'Dot Matrix'); ?>>Dot Matrix</option>
                            <option value="Thermal" <?php echo sel($array['printer_type'],'Thermal'); ?>>Thermal</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Color Printer</label>
                        <select name="color_printer">
                            <option value="Yes" <?php echo sel($array['color_printer'],'Yes'); ?>>Yes</option>
                            <option value="No" <?php echo sel($array['color_printer'],'No'); ?>>No</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Toner</label>
                        <input type="text" name="toner" value="<?php echo val($array,'toner'); ?>">
                    </div>
                    <?php } ?>

                    <?php if ($type == "projector") { ?>
                    <div class="field">
                        <label>Connection Type</label>
                        <select name="connection_type">
                            <option value="HDMI" <?php echo sel($array['connection_type'],'HDMI'); ?>>HDMI</option>
                            <option value="VGA" <?php echo sel($array['connection_type'],'VGA'); ?>>VGA</option>
                            <option value="USB" <?php echo sel($array['connection_type'],'USB'); ?>>USB</option>
                            <option value="Wireless" <?php echo sel($array['connection_type'],'Wireless'); ?>>Wireless</option>
                            <option value="HDMI + VGA" <?php echo sel($array['connection_type'],'HDMI + VGA'); ?>>HDMI + VGA</option>
                        </select>
                    </div>
                    <?php } ?>

                </div>

                <?php if ($type == "desktop") { ?>

                <h2>Ethernet Card</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Ethernet Card</label>
                        <select name="ethernet_card">
                            <option value="Yes" <?php echo sel($array['ethernet_card'],'Yes'); ?>>Yes</option>
                            <option value="No" <?php echo sel($array['ethernet_card'],'No'); ?>>No</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="ethernet_model" value="<?php echo val($array,'ethernet_model'); ?>">
                    </div>

                    <div class="field">
                        <label>MAC Address</label>
                        <input type="text" name="mac_address" value="<?php echo val($array,'mac_address'); ?>">
                    </div>
                    <div class="field">
                        <label>WiFi</label>
                        <select name="wifi">
                            <option value="Yes" <?php echo sel($array['wifi'],'Yes'); ?>>Yes</option>
                            <option value="No" <?php echo sel($array['wifi'],'No'); ?>>No</option>
                        </select>
                    </div>
                </div>

                <?php } elseif ($type == "laptop") { ?>

                <h2>Connectivity</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>WiFi</label>
                        <select name="wifi">
                            <option value="Yes" <?php echo sel($array['wifi'],'Yes'); ?>>Yes</option>
                            <option value="No" <?php echo sel($array['wifi'],'No'); ?>>No</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Camera</label>
                        <select name="camera">
                            <option value="Yes" <?php echo sel($array['camera'],'Yes'); ?>>Yes</option>
                            <option value="No" <?php echo sel($array['camera'],'No'); ?>>No</option>
                        </select>
                    </div>
                </div>

                <?php } ?>

                <?php if ($type == "desktop" || $type == "laptop") { ?>

                <h2>Processor</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Processor</label>
                        <select name="processor">
                            <option value="Core i3" <?php echo sel($array['processor'],'Core i3'); ?>>Core i3</option>
                            <option value="Core i5" <?php echo sel($array['processor'],'Core i5'); ?>>Core i5</option>
                            <option value="Core i7" <?php echo sel($array['processor'],'Core i7'); ?>>Core i7</option>
                            <option value="Core i9" <?php echo sel($array['processor'],'Core i9'); ?>>Core i9</option>
                            <option value="Ryzen 3" <?php echo sel($array['processor'],'Ryzen 3'); ?>>Ryzen 3</option>
                            <option value="Ryzen 5" <?php echo sel($array['processor'],'Ryzen 5'); ?>>Ryzen 5</option>
                            <option value="Ryzen 7" <?php echo sel($array['processor'],'Ryzen 7'); ?>>Ryzen 7</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Manufacturer</label>
                        <select name="processor_manufacturer">
                            <option value="Intel" <?php echo sel($array['processor_manufacturer'],'Intel'); ?>>Intel</option>
                            <option value="AMD" <?php echo sel($array['processor_manufacturer'],'AMD'); ?>>AMD</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Processor Type</label>
                        <select name="processor_type">
                            <option value="Desktop" <?php echo sel($array['processor_type'],'Desktop'); ?>>Desktop</option>
                            <option value="Mobile" <?php echo sel($array['processor_type'],'Mobile'); ?>>Mobile</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Micro Card</label>
                        <input type="text" name="micro_card" value="<?php echo val($array,'micro_card'); ?>">
                    </div>

                    <div class="field">
                        <label>Clock Speed</label>
                        <input type="text" name="clock_speed" value="<?php echo val($array,'clock_speed'); ?>">
                    </div>
                    <div class="field">
                        <label>Series</label>
                        <input type="text" name="processor_series" value="<?php echo val($array,'processor_series'); ?>">
                    </div>
                </div>

                <h2>Motherboard Information</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Manufacturer</label>
                        <select name="motherboard_manufacturer">
                            <option value="Dell" <?php echo sel($array['motherboard_manufacturer'],'Dell'); ?>>Dell</option>
                            <option value="HP" <?php echo sel($array['motherboard_manufacturer'],'HP'); ?>>HP</option>
                            <option value="Lenovo" <?php echo sel($array['motherboard_manufacturer'],'Lenovo'); ?>>Lenovo</option>
                            <option value="ASUS" <?php echo sel($array['motherboard_manufacturer'],'ASUS'); ?>>ASUS</option>
                            <option value="MSI" <?php echo sel($array['motherboard_manufacturer'],'MSI'); ?>>MSI</option>
                            <option value="Other" <?php echo sel($array['motherboard_manufacturer'],'Other'); ?>>Other</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="motherboard_model" value="<?php echo val($array,'motherboard_model'); ?>">
                    </div>

                    <div class="field">
                        <label>Series</label>
                        <input type="text" name="motherboard_series" value="<?php echo val($array,'motherboard_series'); ?>">
                    </div>
                </div>

                <h2>Storage Media</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Manufacturer</label>
                        <select name="storage_manufacturer">
                            <option value="Seagate" <?php echo sel($array['storage_manufacturer'],'Seagate'); ?>>Seagate</option>
                            <option value="Western Digital" <?php echo sel($array['storage_manufacturer'],'Western Digital'); ?>>Western Digital</option>
                            <option value="Samsung" <?php echo sel($array['storage_manufacturer'],'Samsung'); ?>>Samsung</option>
                            <option value="Kingston" <?php echo sel($array['storage_manufacturer'],'Kingston'); ?>>Kingston</option>
                            <option value="Other" <?php echo sel($array['storage_manufacturer'],'Other'); ?>>Other</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Type</label>
                        <input type="text" name="storage_type" value="<?php echo val($array,'storage_type'); ?>">
                    </div>

                    <div class="field">
                        <label>Form Factor</label>
                        <select name="form_factor">
                            <option value="2.5 inch" <?php echo sel($array['form_factor'],'2.5 inch'); ?>>2.5 inch</option>
                            <option value="3.5 inch" <?php echo sel($array['form_factor'],'3.5 inch'); ?>>3.5 inch</option>
                            <option value="M.2" <?php echo sel($array['form_factor'],'M.2'); ?>>M.2</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="storage_model" value="<?php echo val($array,'storage_model'); ?>">
                    </div>
                </div>

                <?php } ?>

                <h2>Status</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <option value="Serviceable" <?php echo sel($array['status'],'Serviceable'); ?>>Serviceable</option>
                            <option value="Unserviceable" <?php echo sel($array['status'],'Unserviceable'); ?>>Unserviceable</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label>Update Photo</label>
                    <input type="file" name="photo">
                </div>

                <br>

                <button type="submit" name="update" class="btn-main">Update Status</button>

            </form>

        </div>

    </main>

</div>

<script>
function updateLabOptions(preselect) {
    var dept = document.getElementById('department').value;
    var labSelect = document.getElementById('lab');
    var max = (dept === 'Electrical Eng') ? 2 : 6;

    labSelect.innerHTML = '';
    for (var i = 1; i <= max; i++) {
        var opt = document.createElement('option');
        opt.value = 'Lab ' + i;
        opt.textContent = 'Lab ' + i;
        labSelect.appendChild(opt);
    }
    if (preselect) {
        labSelect.value = preselect;
    }
}

document.getElementById('department').addEventListener('change', function () {
    updateLabOptions();
});

updateLabOptions(<?php echo json_encode(val($array, 'lab')); ?>);
</script>

</body>
</html>
