<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$message = "";

$result = mysqli_query($conn, "SELECT id FROM laptop ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);

if ($row) {
    $number = $row["id"] + 1;
}
else {
    $number = 1;
}

$tag = "LP-" . str_pad($number, 3, "0", STR_PAD_LEFT);

if (isset($_POST["submit"])) {

    $department = $_POST["department"];
    $lab = $_POST["lab"];
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $series = $_POST["series"];
    $ram = $_POST["ram"]." "."GB";
    $capacity = $_POST["capacity"];
    $serial_no = $_POST["serial_no"];
    $bus_speed = $_POST["bus_speed"];
    $wifi = $_POST["wifi"];
    $camera = $_POST["camera"];
    $processor = $_POST["processor"];
    $processor_manufacturer = $_POST["processor_manufacturer"];
    $micro_card = $_POST["micro_card"];
    $clock_speed = $_POST["clock_speed"];
    $processor_series = $_POST["processor_series"];
    $status = $_POST["status"];
    $motherboard_manufacturer = $_POST["motherboard_manufacturer"];
    $motherboard_model = $_POST["motherboard_model"];
    $motherboard_series = $_POST["motherboard_series"];
    $storage_manufacturer = $_POST["storage_manufacturer"];
    $storage_type = $_POST["storage_type"];
    $form_factor = $_POST["form_factor"];
    $storage_model = $_POST["storage_model"];

    $photo = $_FILES["photo"]["name"];

    if ($photo != "") {
        move_uploaded_file($_FILES["photo"]["tmp_name"], "files/" . $photo);
    }

    $sql = "INSERT INTO laptop
    (asset_tag, department, lab, brand, model, series, ram, capacity, serial_no,
    bus_speed, wifi, camera, processor, processor_manufacturer, 
    micro_card, clock_speed, processor_series, status, motherboard_manufacturer,
    motherboard_model, motherboard_series, storage_manufacturer, storage_type,
    form_factor, storage_model, photo)
    VALUES
    ('$tag', '$department', '$lab', '$brand', '$model', '$series', '$ram', '$capacity', '$serial_no',
    '$bus_speed', '$wifi', '$camera', '$processor', '$processor_manufacturer', 
    '$micro_card', '$clock_speed', '$processor_series', '$status', '$motherboard_manufacturer',
    '$motherboard_model', '$motherboard_series', '$storage_manufacturer', '$storage_type',
    '$form_factor', '$storage_model', '$photo')";

    if (mysqli_query($conn, $sql)) {
        $message = "Laptop $tag added successfully.";
        $result = mysqli_query($conn, "SELECT id FROM laptop ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc($result);
        $tag = "LP-" . str_pad($row["id"] + 1, 3, "0", STR_PAD_LEFT);
    }
    else {
        $message = "Laptop could not be added.";
    }
}

$active = "add_laptop";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Laptop - ITAMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">Add Items</div>
                <h1>Add Laptop</h1>
            </div>

            <a href="view_laptop.php" class="btn-ghost">View Laptop</a>
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
                        <label>RAM</label>
                        <select name="ram">
                            <option value="2 ">2 </option>
                            <option value="4 ">4 </option>
                            <option value="8 ">8 </option>
                            <option value="16 ">16 </option>
                            <option value="32 ">32 </option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Capacity</label>
                        <input type="number" name="capacity">
                    </div>

                    <div class="field">
                        <label>Serial No</label>
                        <input type="text" name="serial_no">
                    </div>
                    <div class="field">
                        <label>Bus Speed</label>
                        <input type="text" name="bus_speed">
                    </div>

                    <div class="field">
                        <label>WiFi</label>
                        <select name="wifi">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Camera</label>
                        <select name="camera">
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
                            <option value="Mobile">Mobile</option>
                            <option value="Desktop">Desktop</option>
                        </select>
                    </div> -->
                    <div class="field">
                        <label>Micro Card</label>
                        <input type="text" name="micro_card">
                    </div>

                    <div class="field">
                        <label>Clock Speed</label>
                        <input type="text" name="clock_speed">
                    </div>
                    <div class="field">
                        <label>Series</label>
                        <input type="text" name="processor_series">
                    </div>

                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <!-- <option value="Serviceable">Serviceable</option> -->
                            <option value="Unserviceable">Unserviceable</option>
                        </select>
                    </div>
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
                        <label>Form Factor</label>
                        <select name="form_factor">
                            <option value="2.5 inch">2.5 inch</option>
                            <option value="3.5 inch">3.5 inch</option>
                            <option value="M.2">M.2</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="storage_model">
                    </div>
                </div>

                <br>

                <button type="submit" name="submit" class="btn-main">Add Laptop</button>

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
