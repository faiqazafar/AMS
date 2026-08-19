<?php
include "connection.php";
session_start();
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM desktop ORDER BY lab_number, asset_tag");

function status_pill($status) {
    $class = "status-working";
    if ($status === "Faulty") $class = "status-faulty";
    if ($status === "In Repair") $class = "status-repair";
    return '<span class="status-pill ' . $class . '">' . htmlspecialchars($status) . '</span>';
}

$active = "reports";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" media="all" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <title>Reports - ITAMS</title>
</head>
<body>
<div class="app-shell">
    <?php include "includes/sidebar.php"; ?>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="eyebrow">Overview / Reports</div>
                <h1>All Asset Reports</h1>
            </div>
            <a href="add_asset.php" class="btn-main">+ Add Asset</a>
        </div>

        <div class="panel">
            <div class="panel-header">
                <h2 style="font-size:16px; margin:0;">Full Inventory — Every Category</h2>
                <span style="font-size:12.5px; color:#6b7280;">
                    <?php echo $result ? mysqli_num_rows($result) : 0; ?> records
                </span>
            </div>

            <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                <table>
                    <tr>
                        <th>Tag</th><th>Category</th><th>Lab</th><th>Brand/Model</th><th>Status</th>
                        <th>Processor</th><th>RAM</th><th>Storage</th><th>Monitor</th><th>Printer</th><th>Added By</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["asset_tag"]); ?></td>
                            <td>Desktop</td>
                            <td>Lab <?php echo htmlspecialchars($row["lab_number"]); ?></td>
                            <td><?php echo htmlspecialchars($row["brand_model"]); ?></td>
                            <td><?php echo status_pill($row["status"]); ?></td>
                            <td><?php echo htmlspecialchars($row["processor"]); ?></td>
                            <td><?php echo htmlspecialchars($row["ram"]); ?></td>
                            <td><?php echo htmlspecialchars($row["storage"]); ?></td>
                            <td><?php echo htmlspecialchars($row["monitor_model"]); ?></td>
                            <td><?php echo htmlspecialchars($row["printer_model"]); ?></td>
                            <td><?php echo htmlspecialchars($row["user_name"] ?? ''); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <div class="empty-state">
                    <div class="cat-icon-wrap" style="display:flex; margin-left:auto; margin-right:auto;">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M5 3h11l3 3v15H5V3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M9 12h6M9 16h6M9 8h3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <p>No records to report yet.</p>
                    <a href="add_asset.php" class="btn-main">+ Add the first asset</a>
                </div>
            <?php } ?>
        </div>

        <p style="font-size:12px; color:#9aa2b1; margin-top:-6px;">
            Currently only Desktop assets are tracked in the database. Laptop, Printer, and Projector rows will appear here automatically once those tables are added.
        </p>
    </main>
</div>
</body>
</html>
