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

// numbers for the serviceable / unserviceable chart on the dashboard
$chart_total = $total_serviceable + $total_unserviceable;
$service_pct = $chart_total > 0 ? round(($total_serviceable / $chart_total) * 100) : 0;
$unservice_pct = $chart_total > 0 ? (100 - $service_pct) : 0;

$active = "dashboard";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - ITAMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div class="section-heading">Serviceable vs Unserviceable</div>

        <div class="panel health-panel">
            <div class="topbar" style="margin-bottom:14px;">
                <div class="eyebrow">Fleet Health</div>
                <span class="health-summary"><?php echo $service_pct; ?>% Serviceable</span>
            </div>

            <div class="health-bar">
                <div class="health-seg health-seg-ok" style="width: <?php echo $service_pct; ?>%;"></div>
                <div class="health-seg health-seg-bad" style="width: <?php echo $unservice_pct; ?>%;"></div>
            </div>

            <div class="health-legend">
                <span><span class="dot dot-ok"></span> Serviceable — <?php echo $total_serviceable; ?></span>
                <span><span class="dot dot-bad"></span> Unserviceable — <?php echo $total_unserviceable; ?></span>
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


    </main>

</div>

</body>
</html>
