<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$message = "";

$result = mysqli_query($conn, "SELECT id FROM projector ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);

if ($row) {
    $number = $row["id"] + 1;
}
else {
    $number = 1;
}

$tag = "PJ-" . str_pad($number, 3, "0", STR_PAD_LEFT);

if (isset($_POST["submit"])) {

    $department = $_POST["department"];
    $lab = $_POST["lab"];
    $brand = $_POST["brand"];
    $model = $_POST["model"];
    $connection_type = $_POST["connection_type"];
    $status = $_POST["status"];

    $photo = $_FILES["photo"]["name"];

    if ($photo != "") {
        move_uploaded_file($_FILES["photo"]["tmp_name"], "files/" . $photo);
    }

    $sql = "INSERT INTO projector
    (asset_tag, department, lab, brand, model, connection_type, status, photo)
    VALUES
    ('$tag', '$department', '$lab', '$brand', '$model', '$connection_type', '$status', '$photo')";

    if (mysqli_query($conn, $sql)) {
        $message = "Projector $tag added successfully.";
        $result = mysqli_query($conn, "SELECT id FROM projector ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc($result);
        $tag = "PJ-" . str_pad($row["id"] + 1, 3, "0", STR_PAD_LEFT);
    }
    else {
        $message = "Projector could not be added.";
    }
}

$active = "add_projector";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Projector - ITAMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">Add Items</div>
                <h1>Add Projector</h1>
            </div>

            <a href="view_projector.php" class="btn-ghost">View Projector</a>
        </div>

        <?php if ($message != "") { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>

        <div class="panel">

            <form method="POST" enctype="multipart/form-data">

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
                            <option value="Epson">Epson</option>
                            <option value="BenQ">BenQ</option>
                            <option value="ViewSonic">ViewSonic</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="model">
                    </div>
                    <div class="field">
                        <label>Connection Type</label>
                        <select name="connection_type">
                            <option value="HDMI">HDMI</option>
                            <option value="VGA">VGA</option>
                            <option value="USB">USB</option>
                            <option value="Wireless">Wireless</option>
                            <option value="HDMI + VGA">HDMI + VGA</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <!-- <option value="Serviceable">Serviceable</option> -->
                            <option value="Unserviceable">Unserviceable</option>
                        </select>
                    </div>
                </div>

                <br>

                <button type="submit" name="submit" class="btn-main">Add Projector</button>

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
