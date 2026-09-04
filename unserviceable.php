<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$status_param = "Unserviceable";

$desktop = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM desktop WHERE status='$status_param'");
$laptop = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM laptop WHERE status='$status_param'");
$printer = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM printer WHERE status='$status_param'");
$projector = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM projector WHERE status='$status_param'");

$active = "unserviceable";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Unserviceable Items - ITAMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">Status</div>
                <h1>Unserviceable Items</h1>
            </div>
        </div>

        <div class="panel">
            <h2>Unserviceable Desktop</h2>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th>Registration No</th>
                        <th>Department</th>
                        <th>Brand</th>
                        <th>Model</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($desktop)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["asset_tag"]); ?></td>
                            <td><?php echo htmlspecialchars($row["department"]); ?></td>
                            <td><?php echo htmlspecialchars($row["brand"]); ?></td>
                            <td><?php echo htmlspecialchars($row["model"]); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <div class="panel">
            <h2>Unserviceable Laptop</h2>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th>Registration No</th>
                        <th>Department</th>
                        <th>Brand</th>
                        <th>Model</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($laptop)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["asset_tag"]); ?></td>
                            <td><?php echo htmlspecialchars($row["department"]); ?></td>
                            <td><?php echo htmlspecialchars($row["brand"]); ?></td>
                            <td><?php echo htmlspecialchars($row["model"]); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <div class="panel">
            <h2>Unserviceable Printer</h2>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th>Registration No</th>
                        <th>Department</th>
                        <th>Brand</th>
                        <th>Model</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($printer)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["asset_tag"]); ?></td>
                            <td><?php echo htmlspecialchars($row["department"]); ?></td>
                            <td><?php echo htmlspecialchars($row["brand"]); ?></td>
                            <td><?php echo htmlspecialchars($row["model"]); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

        <div class="panel">
            <h2>Unserviceable Projector</h2>
            <div class="table-responsive">
                <table>
                    <tr>
                        <th>Registration No</th>
                        <th>Department</th>
                        <th>Brand</th>
                        <th>Model</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($projector)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["asset_tag"]); ?></td>
                            <td><?php echo htmlspecialchars($row["department"]); ?></td>
                            <td><?php echo htmlspecialchars($row["brand"]); ?></td>
                            <td><?php echo htmlspecialchars($row["model"]); ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>

    </main>

</div>

</body>
</html>
