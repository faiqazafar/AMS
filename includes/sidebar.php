<?php
if (!isset($active)) {
    $active = "";
}
?>

<aside class="sidebar">

    <div class="sidebar-brand">
        <span class="brand-mark">IT</span>
        <div class="brand-text">
            <strong>ITAMS</strong>
            <small>IT Management System</small>
        </div>
    </div>

    <nav class="sidebar-nav">

        <span class="nav-label">Dashboard</span>

        <a href="dashboard.php" class="nav-item <?php if ($active == 'dashboard') echo 'active'; ?>">
            Dashboard
        </a>

        <span class="nav-label">Add Items</span>

        <a href="add_asset.php" class="nav-item <?php if ($active == 'add_desktop') echo 'active'; ?>">
            Add Desktop
        </a>

        <a href="laptop.php" class="nav-item <?php if ($active == 'add_laptop') echo 'active'; ?>">
            Add Laptop
        </a>

        <a href="printer.php" class="nav-item <?php if ($active == 'add_printer') echo 'active'; ?>">
            Add Printer
        </a>

        <a href="projector.php" class="nav-item <?php if ($active == 'add_projector') echo 'active'; ?>">
            Add Projector
        </a>

        <span class="nav-label">View Items</span>

        <a href="view_assets.php" class="nav-item <?php if ($active == 'desktop') echo 'active'; ?>">
            Desktop
        </a>

        <a href="view_laptop.php" class="nav-item <?php if ($active == 'laptop') echo 'active'; ?>">
            Laptop
        </a>

        <a href="view_printer.php" class="nav-item <?php if ($active == 'printer') echo 'active'; ?>">
            Printer
        </a>

        <a href="view_projector.php" class="nav-item <?php if ($active == 'projector') echo 'active'; ?>">
            Projector
        </a>

        <span class="nav-label">Working</span>

        <a href="dashboard.php?view=working" class="nav-item <?php if ($active == 'working') echo 'active'; ?>">
            Working Items
        </a>

    </nav>

    <div class="sidebar-footer">
        <a href="logout.php" class="nav-item">
            Logout
        </a>
    </div>

</aside>
