<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$message = "";

$result = mysqli_query($conn, "SELECT id FROM desktop ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);

if ($row) {
    $number = $row["id"] + 1;
}
else {
    $number = 1;
}

$tag = "PC-" . str_pad($number, 3, "0", STR_PAD_LEFT);

if (isset($_POST["submit"])) {

    $department = $_POST["department"];
    $lab = $_POST["lab"];
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $series = $_POST["series"];
    $capacity = $_POST["capacity"]." "."GB";
    $ram = $_POST["ramtype"];
    $serial_no = $_POST["serial_no"];
    $bus_speed = $_POST["bus_speed"];
    $ethernet_card = $_POST["ethernet_card"];
    $ethernet_model = $_POST["ethernet_model"];
    $mac_address = $_POST["mac_address"];
    $wifi = $_POST["wifi"];
    $processor = $_POST["processor"];
    $processor_manufacturer = $_POST["processor_manufacturer"];
    $clock_speed = $_POST["clock_speed"];
    $processor_series = $_POST["processor_series"];
    $motherboard_manufacturer = $_POST["motherboard_manufacturer"];
    $motherboard_model = $_POST["motherboard_model"];
    $motherboard_series = $_POST["motherboard_series"];
    $storage_manufacturer = $_POST["storage_manufacturer"];
    $storage_type = $_POST["storage_type"];
    $Capacity =  $_POST["scapacity"];
    $storage_model = $_POST["storage_model"];
    $status=$_POST["status"];

    $photo = $_FILES["photo"]["name"];

    if ($photo != "") {
        move_uploaded_file($_FILES["photo"]["tmp_name"], "files/" . $photo);
    }

    $sql = "INSERT INTO desktop
    (asset_tag, department, lab, brand, model, series, capacity,ramtype, serial_no,
    bus_speed, ethernet_card, ethernet_model, mac_address, wifi, processor,
    processor_manufacturer,clock_speed,processor_series, motherboard_manufacturer, motherboard_model,
    motherboard_series, storage_manufacturer, storage_type, S_capacity,
    storage_model,status, photo)
    VALUES
    ('$tag', '$department', '$lab', '$brand', '$model', '$series', '$capacity','$ram' , '$serial_no',
    '$bus_speed', '$ethernet_card', '$ethernet_model', '$mac_address', '$wifi', '$processor',
    '$processor_manufacturer', '$clock_speed','$processor_series','$motherboard_manufacturer', '$motherboard_model',
    '$motherboard_series', '$storage_manufacturer', '$storage_type', '$Capacity','$storage_model','$status', '$photo')";

    if (mysqli_query($conn, $sql)) {
        $message = "Desktop $tag added successfully.";
        $result = mysqli_query($conn, "SELECT id FROM desktop ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc($result);
        $tag = "PC-" . str_pad($row["id"] + 1, 3, "0", STR_PAD_LEFT);
    }
    else {
        $message = "Desktop could not be added.";
    }
}

$active = "add_desktop";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Desktop - ITAMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">Add Items</div>
                <h1>Add Desktop</h1>
            </div>

            <a href="view_assets.php" class="btn-ghost">View Desktop</a>
        </div>

        <?php if ($message != "") { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>

        <div class="panel">

            <form method="POST" enctype="multipart/form-data">

                <h2>Identification</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Registration No</label>
                        <input type="text" name="asset_tag" value="<?php echo $tag; ?>" readonly>
                    </div>
                    <div class="field">
                        <label>Department</label>
                        <select name="department" id="department" required>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Electrical Eng">Electrical Engineering</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Lab</label>
                        <select name="lab" id="lab" required></select>
                    </div>
                    <div class="field">
                        <label>Brand</label>
                        <select name="brand">
                            <option value="Unbranded">Unbranded</option>
                            <option value="HP">HP</option>
                            <option value="Dell">Dell</option>
                            <option value="Lenovo">Lenovo</option>
                            <option value="Acer">Acer</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="model">
                    </div>
                    <div class="field">
                        <label>Series</label>
                        <input type="text" name="series">
                    </div>

                    <div class="field">
                        <label>Capacity</label>
                        <select name="capacity">
                            <option value="2 ">2 </option>
                            <option value="4 ">4 </option>
                            <option value="8 ">8 </option>
                            <option value="16 ">16 </option>
                            <option value="32 ">32 </option>
                        </select>
                    </div>
                    <div class="field">
                        <label>RAM Type</label>
                        <input type="text" name="ramtype">
                    </div>

                    <div class="field">
                        <label>Serial No</label>
                        <input type="text" name="serial_no">
                    </div>
                    <div class="field">
                        <label>Bus Speed</label>
                        <input type="text" name="bus_speed">
                    </div>
                </div>

                <h2>Ethernet Card</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Ethernet Card</label>
                        <select name="ethernet_card">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="ethernet_model">
                    </div>

                    <div class="field">
                        <label>MAC Address</label>
                        <input type="text" name="mac_address">
                    </div>
                    <div class="field">
                        <label>WiFi</label>
                        <select name="wifi">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>

                <h2>Processor</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Processor</label>
                        <select name="processor">
                            <option value="Core i3">Core i3</option>
                            <option value="Core i5">Core i5</option>
                            <option value="Core i7">Core i7</option>
                            <option value="Core i9">Core i9</option>
                            <option value="Ryzen 3">Ryzen 3</option>
                            <option value="Ryzen 5">Ryzen 5</option>
                            <option value="Ryzen 7">Ryzen 7</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Manufacturer</label>
                        <select name="processor_manufacturer">
                            <option value="Intel">Intel</option>
                            <option value="AMD">AMD</option>
                        </select>
                    </div>

                    <!-- <div class="field">
                        <label>Processor Type</label>
                        <select name="processor_type">
                            <option value="Desktop">Desktop</option>
                            <option value="Mobile">Mobile</option>
                        </select>
                    </div> -->
                    <!-- <div class="field">
                        <label>Micro Card</label>
                        <input type="text" name="micro_card">
                    </div> -->

                    <div class="field">
                        <label>Clock Speed</label>
                        <input type="text" name="clock_speed">
                    </div>
                    <div class="field">
                        <label>Series</label>
                        <input type="text" name="processor_series">
                    </div>

                    <!-- <div class="field">
                        <label>Status</label>
                        <select name="status">
                             <option value="Serviceable">Serviceable</option> 
                             <option value="Unserviceable">Unserviceable</option> 
                        </select>
                    </div> -->
                </div>

                <h2>Motherboard Information</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Manufacturer</label>
                        <select name="motherboard_manufacturer">
                            <option value="Dell">Dell</option>
                            <option value="HP">HP</option>
                            <option value="Lenovo">Lenovo</option>
                            <option value="ASUS">ASUS</option>
                            <option value="MSI">MSI</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="motherboard_model">
                    </div>

                    <div class="field">
                        <label>Series</label>
                        <input type="text" name="motherboard_series">
                    </div>
                </div>

                <h2>Storage Media</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Manufacturer</label>
                        <select name="storage_manufacturer">
                            <option value="Seagate">Seagate</option>
                            <option value="Western Digital">Western Digital</option>
                            <option value="Samsung">Samsung</option>
                            <option value="Kingston">Kingston</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Type</label>
                        <input type="text" name="storage_type">
                    </div>

                    <div class="field">
                        <label>Capacity</label>
                        <input type="text" name="scapacity">
                    </div>
                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="storage_model">
                    </div>
                    <div>
                        <label>status</label>
                        <select name="status">
                            <option>seviceable</option>
                            
                        </select>
                    </div>
                </div>


                <br>

                <button type="submit" name="submit" class="btn-main">Add Desktop</button>

                <div class="field" style="margin-top:20px;">
                    <label>Upload Photo</label>
                    <input type="file" name="photo">
                </div>

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

updateLabOptions();
</script>

</body>
</html>
