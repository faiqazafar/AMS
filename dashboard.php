<?php
include "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

function get_count($conn, $table) {
    $query = "SELECT COUNT(*) AS total FROM $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["total"];
}

function get_status_count($conn, $table, $status) {
    $query = "SELECT COUNT(*) AS total FROM $table WHERE status='$status'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row["total"];
}

$total_desktop = get_count($conn, "desktop");
$total_laptop = get_count($conn, "laptop");
$total_printer = get_count($conn, "printer");
$total_projector = get_count($conn, "projector");

$total_assets = $total_desktop + $total_laptop + $total_printer + $total_projector;

$total_serviceable =
    get_status_count($conn, "desktop", "Serviceable") +
    get_status_count($conn, "laptop", "Serviceable") +
    get_status_count($conn, "printer", "Serviceable") +
    get_status_count($conn, "projector", "Serviceable");

$total_unserviceable =
    get_status_count($conn, "desktop", "Unserviceable") +
    get_status_count($conn, "laptop", "Unserviceable") +
    get_status_count($conn, "printer", "Unserviceable") +
    get_status_count($conn, "projector", "Unserviceable");

// The "Working" sidebar link points here with ?view=working, which reveals
// the serviceable-items tables below and highlights the Working nav item.
$show_working = (isset($_GET['view']) && $_GET['view'] == 'working');

if ($show_working) {
    $desktop_working = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM desktop WHERE status='Serviceable'");
    $laptop_working = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM laptop WHERE status='Serviceable'");
    $printer_working = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM printer WHERE status='Serviceable'");
    $projector_working = mysqli_query($conn, "SELECT asset_tag, department, brand, model, status FROM projector WHERE status='Serviceable'");
}

$active = $show_working ? "working" : "dashboard";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - ITAMS</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="app-shell">

    <?php include "includes/sidebar.php"; ?>

    <main class="main">

        <div class="topbar">
            <div>
                <div class="eyebrow">IT Management System</div>
                <h1>Dashboard</h1>
            </div>

            <div>
                Welcome, <?php echo htmlspecialchars($_SESSION["fullname"]); ?>
            </div>
        </div>

        <div class="stat-strip">

            <div class="stat-card">
                <div class="stat-num"><?php echo $total_assets; ?></div>
                <div class="stat-label">Total Assets</div>
            </div>

            <div class="stat-card">
                <div class="stat-num"><?php echo $total_serviceable; ?></div>
                <div class="stat-label">Serviceable</div>
            </div>

            <div class="stat-card">
                <div class="stat-num"><?php echo $total_unserviceable; ?></div>
                <div class="stat-label">Unserviceable</div>
            </div>

        </div>

        <div class="stat-strip">

            <div class="stat-card">
                <div class="stat-num"><?php echo $total_desktop; ?></div>
                <div class="stat-label">Desktop</div>
            </div>

            <div class="stat-card">
                <div class="stat-num"><?php echo $total_laptop; ?></div>
                <div class="stat-label">Laptop</div>
            </div>

            <div class="stat-card">
                <div class="stat-num"><?php echo $total_printer; ?></div>
                <div class="stat-label">Printer</div>
            </div>

            <div class="stat-card">
                <div class="stat-num"><?php echo $total_projector; ?></div>
                <div class="stat-label">Projector</div>
            </div>

        </div>
        <div class="section-heading">Browse by Category</div>

        <div class="category-grid">

            <a href="view_assets.php" class="category-card">
                <div class="cat-count"><?php echo $total_desktop; ?></div>
                <div class="cat-name">Desktop</div>
                <div class="cat-meta">View desktop items</div>
            </a>

            <a href="view_laptop.php" class="category-card">
                <div class="cat-count"><?php echo $total_laptop; ?></div>
                <div class="cat-name">Laptop</div>
                <div class="cat-meta">View laptop items</div>
            </a>

            <a href="view_printer.php" class="category-card">
                <div class="cat-count"><?php echo $total_printer; ?></div>
                <div class="cat-name">Printer</div>
                <div class="cat-meta">View printer items</div>
            </a>

            <a href="view_projector.php" class="category-card">
                <div class="cat-count"><?php echo $total_projector; ?></div>
                <div class="cat-name">Projector</div>
                <div class="cat-meta">View projector items</div>
            </a>

        </div>


        <?php if ($show_working) { ?>

        <div class="section-heading">Working Items</div>

        <div class="panel">
            <h2>Working Desktop</h2>
            <table>
                <tr>
                    <th>Registration No</th>
                    <th>Department</th>
                    <th>Brand</th>
                    <th>Model</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($desktop_working)) { ?>
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
                <?php while ($row = mysqli_fetch_assoc($laptop_working)) { ?>
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
                <?php while ($row = mysqli_fetch_assoc($printer_working)) { ?>
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
                <?php while ($row = mysqli_fetch_assoc($projector_working)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["asset_tag"]); ?></td>
                        <td><?php echo htmlspecialchars($row["department"]); ?></td>
                        <td><?php echo htmlspecialchars($row["brand"]); ?></td>
                        <td><?php echo htmlspecialchars($row["model"]); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <?php } ?>

        
    </main>

</div>

</body>
</html>
