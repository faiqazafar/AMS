<?php
include "connection.php";
session_start();
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

// --- Counts for the stat strip and category cards ---
// Wrapped defensively so the page still renders if a query/table isn't ready yet.
function count_query($conn, $sql) {
    $result = @mysqli_query($conn, $sql);
    if (!$result) return 0;
    $row = mysqli_fetch_row($result);
    return $row ? (int)$row[0] : 0;
}

$totalDesktops = count_query($conn, "SELECT COUNT(*) FROM desktop");
$workingCount  = count_query($conn, "SELECT COUNT(*) FROM desktop WHERE status = 'Working'");
$faultyCount   = count_query($conn, "SELECT COUNT(*) FROM desktop WHERE status = 'Faulty'");
$repairCount   = count_query($conn, "SELECT COUNT(*) FROM desktop WHERE status = 'In Repair'");

$totalLaptops    = count_query($conn, "SELECT COUNT(*) FROM laptop");
$totalPrinters   = count_query($conn, "SELECT COUNT(*) FROM printer");
$totalProjectors = count_query($conn, "SELECT COUNT(*) FROM projector");

$active = "dashboard";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" media="all" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <title>Dashboard - ITAMS</title>
</head>
<body>
<div class="app-shell">
    <?php include "includes/sidebar.php"; ?>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="eyebrow">IT Asset Management System — Department Labs</div>
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION["fullname"]); ?></h1>
            </div>
            <div class="user-chip">
                <span class="avatar"><?php echo strtoupper(substr($_SESSION["fullname"], 0, 1)); ?></span>
                <?php echo htmlspecialchars($_SESSION["fullname"]); ?>
            </div>
        </div>

        <div class="stat-strip">
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon stat-icon-total">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="12" rx="1.5" stroke="currentColor" stroke-width="2"/><path d="M8 20h8M12 16v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                </div>
                <div class="stat-num"><?php echo $totalDesktops; ?></div>
                <div class="stat-label">Total Assets</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon stat-icon-ok">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M5 12.5l4.5 4.5L19 7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <div class="stat-num" style="color:#15803d;"><?php echo $workingCount; ?></div>
                <div class="stat-label">Working</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon stat-icon-warn">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M12 8v5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><circle cx="12" cy="16.3" r="1" fill="currentColor"/><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/></svg>
                    </div>
                </div>
                <div class="stat-num" style="color:#b45309;"><?php echo $repairCount; ?></div>
                <div class="stat-label">In Repair</div>
            </div>
            <div class="stat-card">
                <div class="stat-top">
                    <div class="stat-icon stat-icon-bad">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M7 7l10 10M17 7L7 17" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                    </div>
                </div>
                <div class="stat-num" style="color:#b91c1c;"><?php echo $faultyCount; ?></div>
                <div class="stat-label">Faulty</div>
            </div>
        </div>

        <?php if ($totalDesktops > 0):
            $pctWorking = round($workingCount / $totalDesktops * 100);
            $pctRepair  = round($repairCount  / $totalDesktops * 100);
            $pctFaulty  = max(0, 100 - $pctWorking - $pctRepair);
        ?>
        <div class="panel health-panel">
            <div class="panel-header">
                <h2 style="font-size:16px; margin:0;">Fleet Health</h2>
                <span class="health-summary"><?php echo $pctWorking; ?>% operational</span>
            </div>
            <div class="health-bar">
                <div class="health-seg health-seg-ok" style="width:<?php echo $pctWorking; ?>%" title="Working — <?php echo $pctWorking; ?>%"></div>
                <div class="health-seg health-seg-warn" style="width:<?php echo $pctRepair; ?>%" title="In Repair — <?php echo $pctRepair; ?>%"></div>
                <div class="health-seg health-seg-bad" style="width:<?php echo $pctFaulty; ?>%" title="Faulty — <?php echo $pctFaulty; ?>%"></div>
            </div>
            <div class="health-legend">
                <span><i class="dot dot-ok"></i>Working · <?php echo $workingCount; ?></span>
                <span><i class="dot dot-warn"></i>In Repair · <?php echo $repairCount; ?></span>
                <span><i class="dot dot-bad"></i>Faulty · <?php echo $faultyCount; ?></span>
            </div>
        </div>
        <?php endif; ?>

        <div class="section-heading">Browse by category</div>
        <div class="category-grid">

            <a href="view_assets.php" class="category-card cat-desktop">
                <div class="cat-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="12" rx="1.5" stroke="currentColor" stroke-width="2"/><path d="M8 20h8M12 16v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </div>
                <div class="cat-count"><?php echo $totalDesktops; ?></div>
                <div class="cat-name">Desktops</div>
                <div class="cat-meta">View specifications →</div>
            </a>

            <a href="laptop.php" class="category-card cat-laptop">
                <div class="cat-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M4 5.5A1.5 1.5 0 0 1 5.5 4h13A1.5 1.5 0 0 1 20 5.5V16H4V5.5Z" stroke="currentColor" stroke-width="2"/><path d="M2 16h20l-1.6 3.2a1 1 0 0 1-.9.8H4.5a1 1 0 0 1-.9-.8L2 16Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                </div>
                <div class="cat-count"><?php echo $totalLaptops; ?></div>
                <div class="cat-name">Laptops</div>
                <div class="cat-meta">Add new laptop →</div>
            </a>

            <a href="printer.php" class="category-card cat-printer">
                <div class="cat-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M6 9V4h12v5" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><rect x="3" y="9" width="18" height="8" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="7" y="14" width="10" height="6" stroke="currentColor" stroke-width="2"/></svg>
                </div>
                <div class="cat-count"><?php echo $totalPrinters; ?></div>
                <div class="cat-name">Printers</div>
                <div class="cat-meta">Add new printer →</div>
            </a>

            <a href="projector.php" class="category-card cat-projector">
                <div class="cat-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="7" width="14" height="10" rx="2" stroke="currentColor" stroke-width="2"/><circle cx="9" cy="12" r="2.6" stroke="currentColor" stroke-width="2"/><path d="M16 11l5-2.5v7L16 13" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                </div>
                <div class="cat-count"><?php echo $totalProjectors; ?></div>
                <div class="cat-name">Projectors</div>
                <div class="cat-meta">Add new projector →</div>
            </a>

        </div>

        <div class="panel">
            <div class="panel-header">
                <h2 style="font-size:16px; margin:0;">Assets per Lab</h2>
                <a href="view_assets.php" class="btn-ghost">View all →</a>
            </div>
            <?php
            $labResult = @mysqli_query($conn, "SELECT lab_number, COUNT(*) AS total FROM desktop GROUP BY lab_number ORDER BY lab_number");
            $labRows = [];
            $maxLab = 0;
            if ($labResult && mysqli_num_rows($labResult) > 0) {
                while ($lab = mysqli_fetch_assoc($labResult)) {
                    $labRows[] = $lab;
                    if ((int)$lab['total'] > $maxLab) $maxLab = (int)$lab['total'];
                }
            }
            ?>
            <?php if (count($labRows) > 0): ?>
            <div class="lab-bars">
                <?php foreach ($labRows as $lab):
                    $pct = $maxLab > 0 ? round($lab['total'] / $maxLab * 100) : 0;
                ?>
                <div class="lab-bar-row">
                    <div class="lab-bar-label">Lab <?php echo htmlspecialchars($lab['lab_number']); ?></div>
                    <div class="lab-bar-track">
                        <div class="lab-bar-fill" style="width: <?php echo $pct; ?>%"></div>
                    </div>
                    <div class="lab-bar-count"><?php echo htmlspecialchars($lab['total']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
                <p style="color:#6b7280; margin:8px 0 0 0;">No assets recorded yet. Add one to get started.</p>
            <?php endif; ?>
        </div>
    </main>
</div>
</body>
</html>
