<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$message = "";
$asset = array();

if (isset($_POST["open_update"])) {
    $id = $_POST["id"];

    $result = mysqli_query($conn, "SELECT * FROM desktop WHERE id='$id'");
    $asset = mysqli_fetch_assoc($result);
}

if (isset($_POST["update"])) {

    $id = $_POST["id"];

    $asset_tag = $_POST["asset_tag"];
    $department = $_POST["department"];
    $lab = $_POST["lab"];
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $series = $_POST["series"];
    $ram = $_POST["ram"];
    $capacity = $_POST["capacity"];
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
    $storage_capacity = $_POST["storage_capacity"];
    $storage_model = $_POST["storage_model"];
    $status = $_POST["status"];

    // $asset_tag = mysqli_real_escape_string($conn, $asset_tag);
    // $department = mysqli_real_escape_string($conn, $department);
    // $lab = mysqli_real_escape_string($conn, $lab);
    // $brand = mysqli_real_escape_string($conn, $brand);
    // $model = mysqli_real_escape_string($conn, $model);
    // $series = mysqli_real_escape_string($conn, $series);
    // $ram = mysqli_real_escape_string($conn, $ram);
    // $capacity = mysqli_real_escape_string($conn, $capacity);
    // $serial_no = mysqli_real_escape_string($conn, $serial_no);
    // $bus_speed = mysqli_real_escape_string($conn, $bus_speed);
    // $ethernet_card = mysqli_real_escape_string($conn, $ethernet_card);
    // $ethernet_model = mysqli_real_escape_string($conn, $ethernet_model);
    // $mac_address = mysqli_real_escape_string($conn, $mac_address);
    // $wifi = mysqli_real_escape_string($conn, $wifi);
    // $processor = mysqli_real_escape_string($conn, $processor);
    // $processor_manufacturer = mysqli_real_escape_string($conn, $processor_manufacturer);
    // $clock_speed = mysqli_real_escape_string($conn, $clock_speed);
    // $processor_series = mysqli_real_escape_string($conn, $processor_series);
    // $motherboard_manufacturer = mysqli_real_escape_string($conn, $motherboard_manufacturer);
    // $motherboard_model = mysqli_real_escape_string($conn, $motherboard_model);
    // $motherboard_series = mysqli_real_escape_string($conn, $motherboard_series);
    // $storage_manufacturer = mysqli_real_escape_string($conn, $storage_manufacturer);
    // $storage_type = mysqli_real_escape_string($conn, $storage_type);
    // $storage_capacity = mysqli_real_escape_string($conn, $storage_capacity);
    // $storage_model = mysqli_real_escape_string($conn, $storage_model);
    // $status = mysqli_real_escape_string($conn, $status);

    // $photo_sql = "";

    if (!empty($_FILES["photo"]["name"])) {
        $photo = $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "files/" . $photo);
        $photo = mysqli_real_escape_string($conn, $photo);
        $photo_sql = ", photo='$photo'";
    }

    $sql = "UPDATE desktop SET
        asset_tag='$asset_tag',
        department='$department',
        lab='$lab',
        brand='$brand',
        model='$model',
        series='$series',
        ram='$ram',
        capacity='$capacity',
        serial_no='$serial_no',
        bus_speed='$bus_speed',
        ethernet_card='$ethernet_card',
        ethernet_model='$ethernet_model',
        mac_address='$mac_address',
        wifi='$wifi',
        processor='$processor',
        processor_manufacturer='$processor_manufacturer',
        clock_speed='$clock_speed',
        processor_series='$processor_series',
        motherboard_manufacturer='$motherboard_manufacturer',
        motherboard_model='$motherboard_model',
        motherboard_series='$motherboard_series',
        storage_manufacturer='$storage_manufacturer',
        storage_type='$storage_type',
        S_capacity='$storage_capacity',
        storage_model='$storage_model',
        status='$status'
        $photo_sql
        WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        $message = "Desktop updated successfully.";
    }
    else {
        $message = "Desktop could not be updated.";
    }

    $result = mysqli_query($conn, "SELECT * FROM desktop WHERE id='$id'");
    $asset = mysqli_fetch_assoc($result);
}

$active = "desktop";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Desktop - ITAMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">Update Item</div>
                <h1>Update Desktop</h1>
            </div>
        </div>

        <?php if ($message != "") { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>

        <?php if (!empty($asset)) { ?>

        <div class="panel">

            <form method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?php echo $asset['id']; ?>">

                <h2>Identification</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Registration No</label>
                        <input type="text" name="asset_tag" value="<?php echo htmlspecialchars($asset['asset_tag']); ?>" readonly>
                    </div>

                    <div class="field">
                        <label>Department</label>
                        <select name="department" id="department" required>
                            <option value="Computer Science" <?php echo ($asset['department'] == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                            <option value="Electrical Eng" <?php echo ($asset['department'] == 'Electrical Eng') ? 'selected' : ''; ?>>Electrical Engineering</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Lab</label>
                        <select name="lab" id="lab" required></select>
                    </div>

                    <div class="field">
                        <label>Brand</label>
                        <select name="brand">
                            <option value="Unbranded" <?php echo ($asset['brand'] == 'Unbranded') ? 'selected' : ''; ?>>Unbranded</option>
                            <option value="HP" <?php echo ($asset['brand'] == 'HP') ? 'selected' : ''; ?>>HP</option>
                            <option value="Dell" <?php echo ($asset['brand'] == 'Dell') ? 'selected' : ''; ?>>Dell</option>
                            <option value="Lenovo" <?php echo ($asset['brand'] == 'Lenovo') ? 'selected' : ''; ?>>Lenovo</option>
                            <option value="Acer" <?php echo ($asset['brand'] == 'Acer') ? 'selected' : ''; ?>>Acer</option>
                            <option value="Other" <?php echo ($asset['brand'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="model" value="<?php echo htmlspecialchars($asset['model']); ?>">
                    </div>

                    <div class="field">
                        <label>Series</label>
                        <input type="text" name="series" value="<?php echo htmlspecialchars($asset['series']); ?>">
                    </div>

                    <div class="field">
                        <label>RAM Type</label>
                        <input type="text" name="ram" value="<?php echo htmlspecialchars($asset['ramtype']); ?>">
                    </div>

                    <div class="field">
                        <label>Capacity</label>
                        <input type="number" name="capacity" value="<?php echo htmlspecialchars($asset['capacity']); ?>">
                    </div>

                    <div class="field">
                        <label>Serial No</label>
                        <input type="text" name="serial_no" value="<?php echo htmlspecialchars($asset['serial_no']); ?>">
                    </div>

                    <div class="field">
                        <label>Bus Speed</label>
                        <input type="text" name="bus_speed" value="<?php echo htmlspecialchars($asset['bus_speed']); ?>">
                    </div>
                </div>

                <h2>Ethernet Card</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Ethernet Card</label>
                        <select name="ethernet_card">
                            <option value="Yes" <?php echo ($asset['ethernet_card'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="No" <?php echo ($asset['ethernet_card'] == 'No') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="ethernet_model" value="<?php echo htmlspecialchars($asset['ethernet_model']); ?>">
                    </div>

                    <div class="field">
                        <label>MAC Address</label>
                        <input type="text" name="mac_address" value="<?php echo htmlspecialchars($asset['mac_address']); ?>">
                    </div>

                    <div class="field">
                        <label>WiFi</label>
                        <select name="wifi">
                            <option value="Yes" <?php echo ($asset['wifi'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="No" <?php echo ($asset['wifi'] == 'No') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                </div>

                <h2>Processor</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Processor</label>
                        <select name="processor">
                            <option value="Core i3" <?php echo ($asset['processor'] == 'Core i3') ? 'selected' : ''; ?>>Core i3</option>
                            <option value="Core i5" <?php echo ($asset['processor'] == 'Core i5') ? 'selected' : ''; ?>>Core i5</option>
                            <option value="Core i7" <?php echo ($asset['processor'] == 'Core i7') ? 'selected' : ''; ?>>Core i7</option>
                            <option value="Core i9" <?php echo ($asset['processor'] == 'Core i9') ? 'selected' : ''; ?>>Core i9</option>
                            <option value="Ryzen 3" <?php echo ($asset['processor'] == 'Ryzen 3') ? 'selected' : ''; ?>>Ryzen 3</option>
                            <option value="Ryzen 5" <?php echo ($asset['processor'] == 'Ryzen 5') ? 'selected' : ''; ?>>Ryzen 5</option>
                            <option value="Ryzen 7" <?php echo ($asset['processor'] == 'Ryzen 7') ? 'selected' : ''; ?>>Ryzen 7</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Manufacturer</label>
                        <select name="processor_manufacturer">
                            <option value="Intel" <?php echo ($asset['processor_manufacturer'] == 'Intel') ? 'selected' : ''; ?>>Intel</option>
                            <option value="AMD" <?php echo ($asset['processor_manufacturer'] == 'AMD') ? 'selected' : ''; ?>>AMD</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Clock Speed</label>
                        <input type="text" name="clock_speed" value="<?php echo htmlspecialchars($asset['clock_speed']); ?>">
                    </div>

                    <div class="field">
                        <label>Series</label>
                        <input type="text" name="processor_series" value="<?php echo htmlspecialchars($asset['processor_series']); ?>">
                    </div>
                </div>

                <h2>Motherboard Information</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Manufacturer</label>
                        <input type="text" name="motherboard_manufacturer" value="<?php echo htmlspecialchars($asset['motherboard_manufacturer']); ?>">
                    </div>

                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="motherboard_model" value="<?php echo htmlspecialchars($asset['motherboard_model']); ?>">
                    </div>

                    <div class="field">
                        <label>Series</label>
                        <input type="text" name="motherboard_series" value="<?php echo htmlspecialchars($asset['motherboard_series']); ?>">
                    </div>
                </div>

                <h2>Storage Media</h2>

                <div class="form-grid">
                    <div class="field">
                        <label>Manufacturer</label>
                        <input type="text" name="storage_manufacturer" value="<?php echo htmlspecialchars($asset['storage_manufacturer']); ?>">
                    </div>

                    <div class="field">
                        <label>Type</label>
                        <input type="text" name="storage_type" value="<?php echo htmlspecialchars($asset['storage_type']); ?>">
                    </div>

                    <div class="field">
                        <label>Capacity</label>
                        <input type="text" name="storage_capacity" value="<?php echo htmlspecialchars($asset['S_capacity']); ?>">
                    </div>

                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="storage_model" value="<?php echo htmlspecialchars($asset['storage_model']); ?>">
                    </div>

                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <option value="Serviceable" <?php echo ($asset['status'] == 'Serviceable') ? 'selected' : ''; ?>>Serviceable</option>
                            <option value="Unserviceable" <?php echo ($asset['status'] == 'Unserviceable') ? 'selected' : ''; ?>>Unserviceable</option>
                        </select>
                    </div>
                </div>

                <br>

                <button type="submit" name="update" class="btn-main">Update Desktop</button>

                <div class="field" style="margin-top:20px;">
                    <label>Upload Desktop Photo</label>
                    <input type="file" name="photo">
                </div>

            </form>

        </div>

        <?php } else { ?>
            <div class="panel">
                <div class="empty-state">Desktop not found.</div>
            </div>
        <?php } ?>

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

if (document.getElementById('department')) {
    document.getElementById('department').addEventListener('change', function () {
        updateLabOptions();
    });

    updateLabOptions(<?php echo !empty($asset) ? json_encode($asset['lab']) : '""'; ?>);
}
</script>

</body>
</html>
