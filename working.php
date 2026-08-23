<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$desktop = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM desktop WHERE status='Serviceable'");
$laptop = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM laptop WHERE status='Serviceable'");
$printer = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM printer WHERE status='Serviceable'");
$projector = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM projector WHERE status='Serviceable'");

$active = "working";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Working Items - ITAMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">Working</div>
                <h1>Working Items</h1>
            </div>
        </div>

        <div class="panel">
            <h2>Working Desktop</h2>
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

        <div class="panel">
            <h2>Working Laptop</h2>
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

        <div class="panel">
            <h2>Working Printer</h2>
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

        <div class="panel">
            <h2>Working Projector</h2>
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

    </main>

</div>

</body>
</html>
