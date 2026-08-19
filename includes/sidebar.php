<?php
// Expects $active to be set by the including page, e.g. "dashboard", "add_asset", "desktop", "laptop", "printer", "projector", "reports"
if (!isset($active)) { $active = ""; }
?>
<aside class="sidebar">
    <div class="sidebar-brand">
        <span class="brand-mark">IT</span>
        <div class="brand-text">
            <strong>ITAMS</strong>
            <small>Lab Asset Registry</small>
        </div>
    </div>

    <nav class="sidebar-nav">
        <span class="nav-label">Manage</span>
        <a href="dashboard.php" class="nav-item <?php echo $active === 'add_asset' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" class="nav-icon"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
           dashboard
        </a>

        <a href="add_asset.php" class="nav-item <?php echo $active === 'add_asset' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" class="nav-icon"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Insert Desktop
        </a>

        <a href="laptop.php" class="nav-item <?php echo $active === 'add_asset' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" class="nav-icon"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Insert laptop
        </a>

        <a href="printer.php" class="nav-item <?php echo $active === 'add_asset' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" class="nav-icon"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Insert printer
        </a>

        <a href="projector.php" class="nav-item <?php echo $active === 'add_asset' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" class="nav-icon"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Insert projector
        </a>

        <span class="nav-label">Categories</span>
        <a href="view_assets.php" class="nav-item <?php echo $active === 'desktop' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" class="nav-icon"><rect x="3" y="4" width="18" height="12" rx="1.5" stroke="currentColor" stroke-width="2"/><path d="M8 20h8M12 16v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Desktop
        </a>
        <a href="view_laptop.php" class="nav-item <?php echo $active === 'laptop' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" class="nav-icon"><path d="M4 5.5A1.5 1.5 0 0 1 5.5 4h13A1.5 1.5 0 0 1 20 5.5V16H4V5.5Z" stroke="currentColor" stroke-width="2"/><path d="M2 16h20l-1.6 3.2a1 1 0 0 1-.9.8H4.5a1 1 0 0 1-.9-.8L2 16Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
            Laptop
        </a>
        <a href="view_printer.php" class="nav-item <?php echo $active === 'printer' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" class="nav-icon"><path d="M6 9V4h12v5" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><rect x="3" y="9" width="18" height="8" rx="1.5" stroke="currentColor" stroke-width="2"/><rect x="7" y="14" width="10" height="6" stroke="currentColor" stroke-width="2"/></svg>
            Printer
        </a>
        <a href="view_projector.php" class="nav-item <?php echo $active === 'projector' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" class="nav-icon"><rect x="2" y="7" width="14" height="10" rx="2" stroke="currentColor" stroke-width="2"/><circle cx="9" cy="12" r="2.6" stroke="currentColor" stroke-width="2"/><path d="M16 11l5-2.5v7L16 13" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
            Projector
        </a>

        <span class="nav-label">Overview</span>
        <a href="reports.php" class="nav-item <?php echo $active === 'reports' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" class="nav-icon"><path d="M5 3h11l3 3v15H5V3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M9 12h6M9 16h6M9 8h3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
            Reports
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="logout.php" class="nav-item logout-link">
            <svg viewBox="0 0 24 24" class="nav-icon"><path d="M9 21H5a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Logout
        </a>
    </div>
</aside>
