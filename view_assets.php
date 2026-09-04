<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$where = "";
$filter_department = isset($_POST['department']) ? $_POST['department'] : "";
$filter_lab = isset($_POST['lab']) ? $_POST['lab'] : "";

if ($filter_department != "") {
    $department_escaped = mysqli_real_escape_string($conn, $filter_department);
    $where = " WHERE department='$department_escaped'";

    if ($filter_lab != "") {
        $lab_escaped = mysqli_real_escape_string($conn, $filter_lab);
        $where .= " AND lab='$lab_escaped'";
    }
}

$result = mysqli_query($conn, "SELECT * FROM desktop" . $where . " ORDER BY id DESC");
$active = "desktop";
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Desktop - ITAMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">View Items</div>
                <h1>Desktop</h1>
            </div>
            <a href="add_asset.php" class="btn-main">Add Desktop</a>
        </div>

        <div class="panel">
            <form method="POST" class="filter-form">
                <div class="field">
                    <label>Department</label>
                    <select name="department" id="department">
                        <option value="">All Departments</option>
                        <option value="Computer Science" <?php echo ($filter_department == 'Computer Science') ? 'selected' : ''; ?>>Computer Science</option>
                        <option value="Electrical Eng" <?php echo ($filter_department == 'Electrical Eng') ? 'selected' : ''; ?>>Electrical Engineering</option>
                    </select>
                </div>
                <div class="field">
                    <label>Lab</label>
                    <select name="lab" id="lab"></select>
                </div>
            </form>
        </div>

        <div class="panel">

            <?php if (mysqli_num_rows($result) > 0) { ?>

                <div class="table-responsive">
                <table>
                    <tr>
                        <th>Registration No</th>
                        <th>Department</th>
                        <th>Lab</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Capacity</th>
                        <th>Ram</th>
                        <th>Serial No</th>
                        <th>Status</th>
                        <th>Photo</th>
                        <th>Update Status</th>
                    </tr>

                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                        <tr>
                            <td><?php echo htmlspecialchars($row["asset_tag"]); ?></td>
                            <td><?php echo htmlspecialchars($row["department"]); ?></td>
                            <td><?php echo htmlspecialchars($row["lab"]); ?></td>
                            <td><?php echo htmlspecialchars($row["brand"]); ?></td>
                            <td><?php echo htmlspecialchars($row["model"]); ?></td>
                            <td><?php echo htmlspecialchars($row["capacity"]); ?></td>
                            <td><?php echo htmlspecialchars($row["ramtype"]); ?></td>
                            <td><?php echo htmlspecialchars($row["serial_no"]); ?></td>
                            <td>
                                <span class="status-pill <?php echo $row["status"] == "Serviceable" ? "status-serviceable" : "status-unserviceable"; ?>">
                                    <?php echo htmlspecialchars($row["status"]); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($row["photo"] != "") { ?>
                                    <a href="files/<?php echo htmlspecialchars($row["photo"]); ?>" target="_blank">View</a>
                                <?php } else { ?>
                                    No photo
                                <?php } ?>
                            </td>
                            <td>
                                <form method="POST" action="update_desktop.php">
                                    <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
                                    <button type="submit" name="open_update" class="btn-main">Update</button>
                                </form>
                            </td>
                        </tr>

                    <?php } ?>

                </table>
                </div>

            <?php } else { ?>
                <div class="empty-state">No desktop added yet.</div>
            <?php } ?>

        </div>

    </main>

</div>

<script src="js/labs.js"></script>
<script>
document.getElementById('department').addEventListener('change', function () {
    loadLabOptions('department', 'lab', '', true);
    this.form.submit();
});

document.getElementById('lab').addEventListener('change', function () {
    this.form.submit();
});

loadLabOptions('department', 'lab', <?php echo json_encode($filter_lab); ?>, true);
</script>

</body>
</html>
