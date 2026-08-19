<?php
include "connection.php";
session_start();
if (!isset($_SESSION["user_id"])) {
    header("location: login.php");
    exit();
}

$filter = isset($_GET["lab"]) ? $_GET["lab"] : "all";

if ($filter === "all") {
    $result = mysqli_query($conn, "SELECT * FROM desktop ORDER BY lab_number, asset_tag");
} else {
    $result = mysqli_query($conn, "SELECT * FROM desktop WHERE lab_number = $filter ORDER BY asset_tag");
   
}

function status_pill($status) {
    $class = "status-working";
    if ($status === "Faulty") $class = "status-faulty";
    if ($status === "In Repair") $class = "status-repair";
    return '<span class="status-pill ' . $class . '">' . htmlspecialchars($status) . '</span>';
}

$active = "desktop";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" media="all" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <title>Desktop Specifications - ITAMS</title>
</head>
<body>
<div class="app-shell">
    <?php include "includes/sidebar.php"; ?>

    <main class="main">
        <div class="topbar">
            <div>
                <div class="eyebrow">Category / Desktop</div>
                <h1>Desktop Specifications</h1>
            </div>
            <a href="add_asset.php" class="btn-main">+ Add Asset</a>
        </div>

        <div class="panel">
            <div class="panel-header">
                <form method="GET" style="display:flex; align-items:center; gap:10px;">
                    <label style="margin:0;">Filter by Lab</label>
                    <select name="lab" onchange="this.form.submit()" style="width:auto;">
                        <option value="all" <?php if ($filter === "all") echo "selected"; ?>>All Labs</option>
                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                            <option value="<?php echo $i; ?>" <?php if ($filter == $i) echo "selected"; ?>>Lab <?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                </form>
            </div>

            <?php if ($result && mysqli_num_rows($result) > 0) { ?>
                <table>
                    <tr>
                        <th>Tag</th><th>Lab</th><th>Brand/Model</th><th>Status</th>
                        <th>Processor</th><th>RAM</th><th>Monitor</th><th>Printer</th>
                        <th>Update</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row["asset_tag"]); ?></td>
                            <td>Lab <?php echo htmlspecialchars($row["lab_number"]); ?></td>
                            <td><?php echo htmlspecialchars($row["brand_model"]); ?></td>
                            <td><?php echo status_pill($row["status"]); ?></td>
                            <td><?php echo htmlspecialchars($row["processor"]); ?></td>
                            <td><?php echo htmlspecialchars($row["ram"]); ?></td>
                            <td><?php echo htmlspecialchars($row["monitor_model"]); ?></td>
                            <td><?php echo htmlspecialchars($row["printer_model"]); ?></td>
                            <td><a href="Update_asset.php?id=<?php echo $row["id"]; ?>"><button>Update</button></a></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <div class="empty-state">
                    <div class="cat-icon-wrap" style="display:flex; margin-left:auto; margin-right:auto;">
                        <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="12" rx="1.5" stroke="currentColor" stroke-width="2"/><path d="M8 20h8M12 16v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <p>No desktops recorded <?php echo $filter !== 'all' ? 'for Lab ' . htmlspecialchars($filter) : 'yet'; ?>.</p>
                    <a href="add_asset.php" class="btn-main">+ Add the first one</a>
                </div>
            <?php } ?>
        </div>
    </main>
</div>
</body>
</html>
