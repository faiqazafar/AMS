<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$message = "";

$result = mysqli_query($conn, "SELECT id FROM printer ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);

if ($row) {
    $number = $row["id"] + 1;
}
else {
    $number = 1;
}

$tag = "PR-" . str_pad($number, 3, "0", STR_PAD_LEFT);

if (isset($_POST["submit"])) {

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

    $photo = $_FILES["photo"]["name"];

    if ($photo != "") {
        move_uploaded_file($_FILES["photo"]["tmp_name"], "files/" . $photo);
    }

    $sql = "INSERT INTO printer
    (asset_tag, department, lab, brand, printer_class, model, serial_no,
    printer_type, color_printer, toner, status, photo)
    VALUES
    ('$tag', '$department', '$lab', '$brand', '$printer_class', '$model', '$serial_no',
    '$printer_type', '$color_printer', '$toner', '$status', '$photo')";

    if (mysqli_query($conn, $sql)) {
        $message = "Printer $tag added successfully.";
        $result = mysqli_query($conn, "SELECT id FROM printer ORDER BY id DESC LIMIT 1");
        $row = mysqli_fetch_assoc($result);
        $tag = "PR-" . str_pad($row["id"] + 1, 3, "0", STR_PAD_LEFT);
    }
    else {
        $message = "Printer could not be added.";
    }
}

$active = "add_printer";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Printer - ITAMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">Add Items</div>
                <h1>Add Printer</h1>
            </div>

            <a href="view_printer.php" class="btn-ghost">View Printer</a>
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
                            <option value="HP">HP</option>
                            <option value="Canon">Canon</option>
                            <option value="Epson">Epson</option>
                            <option value="Brother">Brother</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Printer Class</label>
                        <select name="printer_class">
                            <option value="Personal">Personal</option>
                            <option value="Workgroup">Workgroup</option>
                            <option value="Enterprise">Enterprise</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Model</label>
                        <input type="text" name="model">
                    </div>
                    <div class="field">
                        <label>Serial No</label>
                        <input type="text" name="serial_no">
                    </div>

                    <div class="field">
                        <label>Printer Type</label>
                        <select name="printer_type">
                            <option value="Laser">Laser</option>
                            <option value="Inkjet">Inkjet</option>
                            <option value="Dot Matrix">Dot Matrix</option>
                            <option value="Thermal">Thermal</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Color Printer</label>
                        <select name="color_printer">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Toner</label>
                        <input type="text" name="toner">
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <option value="Serviceable">Serviceable</option>
                            <!-- <option value="Unserviceable">Unserviceable</option> -->
                        </select>
                    </div>
                </div>

                <br>

                <div class="field" style="margin-top:20px;">
                    <label>Upload Photo</label>
                    <input type="file" name="photo" accept="image/*">
                </div>
                <br>

                <button type="submit" name="submit" class="btn-main">Add Printer</button>

            </form>

        </div>

    </main>

</div>

<script src="js/labs.js"></script>
<script>
document.getElementById('department').addEventListener('change', function () {
    loadLabOptions('department', 'lab', '', false);
});

loadLabOptions('department', 'lab', '', false);
</script>

</body>
</html>
