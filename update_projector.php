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
    $result = mysqli_query($conn, "SELECT * FROM projector WHERE id='$id'");
    $asset = mysqli_fetch_assoc($result);
}

if (isset($_POST["update"])) {

    $id = $_POST["id"];
    $asset_tag = $_POST["asset_tag"];
    $department = $_POST["department"];
    $lab = $_POST["lab"];
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $connection_type = $_POST["connection_type"];
    $status = $_POST["status"];

    // $asset_tag = mysqli_real_escape_string($conn, $asset_tag);
    // $department = mysqli_real_escape_string($conn, $department);
    // $lab = mysqli_real_escape_string($conn, $lab);
    // $brand = mysqli_real_escape_string($conn, $brand);
    // $model = mysqli_real_escape_string($conn, $model);
    // $connection_type = mysqli_real_escape_string($conn, $connection_type);
    // $status = mysqli_real_escape_string($conn, $status);

    // $photo_sql = "";

    if (!empty($_FILES["photo"]["name"])) {
        $photo = $_FILES["photo"]["name"];
        move_uploaded_file($_FILES["photo"]["tmp_name"], "files/" . $photo);
        $photo = mysqli_real_escape_string($conn, $photo);
        $photo_sql = ", photo='$photo'";
    }

    $sql = "UPDATE projector SET
        asset_tag='$asset_tag',
        department='$department',
        lab='$lab',
        brand='$brand',
        model='$model',
        connection_type='$connection_type',
        status='$status'
        $photo_sql
        WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        $message = "Projector updated successfully.";
    }
    else {
        $message = "Projector could not be updated.";
    }

    $result = mysqli_query($conn, "SELECT * FROM projector WHERE id='$id'");
    $asset = mysqli_fetch_assoc($result);
}

$active = "projector";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Projector - ITAMS</title>
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
                <h1>Update Projector</h1>
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
                        <label>Model</label>
                        <input type="text" name="model" value="<?php echo htmlspecialchars($asset['model']); ?>">
                    </div>

                    <div class="field">
                        <label>Connection Type</label>
                        <select name="connection_type">
                            <option value="HDMI" <?php echo ($asset['connection_type'] == 'HDMI') ? 'selected' : ''; ?>>HDMI</option>
                            <option value="VGA" <?php echo ($asset['connection_type'] == 'VGA') ? 'selected' : ''; ?>>VGA</option>
                            <option value="USB" <?php echo ($asset['connection_type'] == 'USB') ? 'selected' : ''; ?>>USB</option>
                            <option value="Wireless" <?php echo ($asset['connection_type'] == 'Wireless') ? 'selected' : ''; ?>>Wireless</option>
                            <option value="HDMI + VGA" <?php echo ($asset['connection_type'] == 'HDMI + VGA') ? 'selected' : ''; ?>>HDMI + VGA</option>
                        </select>
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
                    <label>Upload Projector Photo</label>
                    <input type="file" name="photo" accept="image/*">
                </div>
                <br>
                
                <button type="submit" name="update" class="btn-main">Update Projector</button>

            </form>
        </div>

        <?php } else { ?>
            <div class="panel">
                <div class="empty-state">Projector not found.</div>
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
