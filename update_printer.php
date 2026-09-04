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
    $result = mysqli_query($conn, "SELECT * FROM printer WHERE id='$id'");
    $asset = mysqli_fetch_assoc($result);
}

if (isset($_POST["update"])) {

    $id = $_POST["id"];
    $asset_tag = $_POST["asset_tag"];
    $department = $_POST["department"];
    $lab = $_POST["lab"];
    $brand = $_POST["brand"];
    $printer_class = $_POST["printer_class"];
    $model = $_POST["model"];
    $serial_no = $_POST["serial_no"];
    $printer_type = $_POST["printer_type"];
    $color_printer = $_POST["color_printer"];
    $toner = $_POST["toner"];
    $status = $_POST["status"];

    // $asset_tag = mysqli_real_escape_string($conn, $asset_tag);
    // $department = mysqli_real_escape_string($conn, $department);
    // $lab = mysqli_real_escape_string($conn, $lab);
    // $brand = mysqli_real_escape_string($conn, $brand);
    // $printer_class = mysqli_real_escape_string($conn, $printer_class);
    // $model = mysqli_real_escape_string($conn, $model);
    // $serial_no = mysqli_real_escape_string($conn, $serial_no);
    // $printer_type = mysqli_real_escape_string($conn, $printer_type);
    // $color_printer = mysqli_real_escape_string($conn, $color_printer);
    // $toner = mysqli_real_escape_string($conn, $toner);
    // $status = mysqli_real_escape_string($conn, $status);

    // $photo_sql = "";

    if (!empty($_FILES["photo"]["name"])) {
        $photo = $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "files/" . $photo);
        $photo = mysqli_real_escape_string($conn, $photo);
        $photo_sql = ", photo='$photo'";
    }

    $sql = "UPDATE printer SET
        asset_tag='$asset_tag',
        department='$department',
        lab='$lab',
        brand='$brand',
        printer_class='$printer_class',
        model='$model',
        serial_no='$serial_no',
        printer_type='$printer_type',
        color_printer='$color_printer',
        toner='$toner',
        status='$status'
        $photo_sql
        WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        $message = "Printer updated successfully.";
    }
    else {
        $message = "Printer could not be updated.";
    }

    $result = mysqli_query($conn, "SELECT * FROM printer WHERE id='$id'");
    $asset = mysqli_fetch_assoc($result);
}

$active = "printer";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Printer - ITAMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">Update Item</div>
                <h1>Update Printer</h1>
            </div>
        </div>

        <?php if ($message != "") { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>

        <?php if (!empty($asset)) { ?>

        <div class="panel">
            <form method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?php echo $asset['id']; ?>">

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
                        <input type="text" name="brand" value="<?php echo htmlspecialchars($asset['brand']); ?>">
                    </div>

                    <div class="field">
                        <label>Printer Class</label>
                        <select name="printer_class">
                            <option value="Personal" <?php echo ($asset['printer_class'] == 'Personal') ? 'selected' : ''; ?>>Personal</option>
                            <option value="Workgroup" <?php echo ($asset['printer_class'] == 'Workgroup') ? 'selected' : ''; ?>>Workgroup</option>
                            <option value="Enterprise" <?php echo ($asset['printer_class'] == 'Enterprise') ? 'selected' : ''; ?>>Enterprise</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="model" value="<?php echo htmlspecialchars($asset['model']); ?>">
                    </div>

                    <div class="field">
                        <label>Serial No</label>
                        <input type="text" name="serial_no" value="<?php echo htmlspecialchars($asset['serial_no']); ?>">
                    </div>

                    <div class="field">
                        <label>Printer Type</label>
                        <select name="printer_type">
                            <option value="Laser" <?php echo ($asset['printer_type'] == 'Laser') ? 'selected' : ''; ?>>Laser</option>
                            <option value="Inkjet" <?php echo ($asset['printer_type'] == 'Inkjet') ? 'selected' : ''; ?>>Inkjet</option>
                            <option value="Dot Matrix" <?php echo ($asset['printer_type'] == 'Dot Matrix') ? 'selected' : ''; ?>>Dot Matrix</option>
                            <option value="Thermal" <?php echo ($asset['printer_type'] == 'Thermal') ? 'selected' : ''; ?>>Thermal</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Color Printer</label>
                        <select name="color_printer">
                            <option value="Yes" <?php echo ($asset['color_printer'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                            <option value="No" <?php echo ($asset['color_printer'] == 'No') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Toner</label>
                        <input type="text" name="toner" value="<?php echo htmlspecialchars($asset['toner']); ?>">
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

                <div class="field" style="margin-top:20px;">
                    <label>Upload Printer Photo</label>
                    <input type="file" name="photo" accept="image/*">
                </div>
                <br>

                <button type="submit" name="update" class="btn-main">Update Printer</button>

            </form>
        </div>

        <?php } else { ?>
            <div class="panel">
                <div class="empty-state">Printer not found.</div>
            </div>
        <?php } ?>

    </main>

</div>

<script src="js/labs.js"></script>
<script>
if (document.getElementById('department')) {
    document.getElementById('department').addEventListener('change', function () {
        loadLabOptions('department', 'lab', '', false);
    });

    loadLabOptions('department', 'lab', <?php echo !empty($asset) ? json_encode($asset['lab']) : '""'; ?>, false);
}
</script>

</body>
</html>
