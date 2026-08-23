<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$where = "";
$filter_department = isset($_GET['department']) ? $_GET['department'] : "";
$filter_lab = isset($_GET['lab']) ? $_GET['lab'] : "";

if ($filter_department != "") {
    $department_escaped = mysqli_real_escape_string($conn, $filter_department);
    $where = " WHERE department='$department_escaped'";

    if ($filter_lab != "") {
        $lab_escaped = mysqli_real_escape_string($conn, $filter_lab);
        $where .= " AND lab='$lab_escaped'";
    }
}

$result = mysqli_query($conn, "SELECT * FROM laptop" . $where . " ORDER BY id DESC");
$active = "laptop";
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Laptop - ITAMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">View Items</div>
                <h1>Laptop</h1>
            </div>
            <a href="laptop.php" class="btn-main">Add Laptop</a>
        </div>

        <div class="panel">
            <form method="GET" class="filter-form">
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
                <button type="submit" class="btn-main">View</button>
            </form>
        </div>

        <div class="panel">

            <?php if (mysqli_num_rows($result) > 0) { ?>

                <table>
                    <tr>
                        <th>Registration No</th>
                        <th>Department</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>RAM</th>
                        <th>Capacity</th>
                        <th>Camera</th>
                        <th>Status</th>
                        <th>Photo</th>
                        <th>Update Status</th>
                    </tr>

                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["asset_tag"]); ?></td>
                            <td><?php echo htmlspecialchars($row["department"]); ?></td>
                            <td><?php echo htmlspecialchars($row["brand"]); ?></td>
                            <td><?php echo htmlspecialchars($row["model"]); ?></td>
                            <td><?php echo htmlspecialchars($row["ram"]); ?></td>
                            <td><?php echo htmlspecialchars($row["capacity"]); ?></td>
                            <td><?php echo htmlspecialchars($row["camera"]); ?></td>
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
                                <a href="update_status.php?type=laptop&id=<?php echo $row["id"]; ?>">Update</a>
                            </td>
                        </tr>
                    <?php } ?>

                </table>

            <?php } else { ?>
                <div class="empty-state">No laptop added yet.</div>
            <?php } ?>

        </div>

    </main>

</div>

<script>
function updateLabOptions(preselect) {
    var dept = document.getElementById('department').value;
    var labSelect = document.getElementById('lab');

    labSelect.innerHTML = '';

    var allOpt = document.createElement('option');
    allOpt.value = '';
    allOpt.textContent = 'All Labs';
    labSelect.appendChild(allOpt);

    if (dept === '') {
        return;
    }

    var max = (dept === 'Electrical Eng') ? 2 : 6;
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

updateLabOptions(<?php echo json_encode($filter_lab); ?>);
</script>

</body>
</html>
