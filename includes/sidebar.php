<?php
if (!isset($active)) {
    $active = "";
}

$sidebar_photo_message = "";
if (isset($_POST["upload_profile_photo"])) {
    $photo = $_FILES["photo"]["name"] ?? "";
    if ($photo != "") {
        move_uploaded_file($_FILES["photo"]["tmp_name"], "files/" . $photo);
        $photo_escaped = mysqli_real_escape_string($conn, $photo);
        $email_escaped = mysqli_real_escape_string($conn, $_SESSION["user_id"]);
        if (mysqli_query($conn, "UPDATE login SET photo='$photo_escaped' WHERE email='$email_escaped'")) {
            $_SESSION["photo"] = $photo;
            $sidebar_photo_message = "Photo uploaded successfully.";
        }
    }
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

    <div class="sidebar-photo-upload" style="text-align:center; padding:12px 16px 6px;">
        <?php if (!empty($_SESSION["photo"]) && file_exists("files/" . $_SESSION["photo"])) { ?>
            <img src="files/<?php echo htmlspecialchars($_SESSION["photo"]); ?>" class="sidebar-profile-photo" style="width:72px;height:72px;" alt="Profile photo">
        <?php } else { ?>
            <span class="sidebar-profile-initial" style="width:72px;height:72px;font-size:26px;margin:0 auto;"><?php echo strtoupper(substr($_SESSION["fullname"] ?? "A", 0, 1)); ?></span>
        <?php } ?>
        <form method="POST" enctype="multipart/form-data" style="margin-top:10px;">
            <input type="file" name="photo" required style="width:100%; font-size:12px;">
            <button type="submit" name="upload_profile_photo" class="btn-main" style="width:100%; margin-top:8px;">Upload Photo</button>
        </form>
        <?php if ($sidebar_photo_message != "") { ?><small><?php echo $sidebar_photo_message; ?></small><?php } ?>
    </div>

    <nav class="sidebar-nav">

        <span class="nav-label">Dashboard</span>

        <a href="dashboard.php" class="nav-item <?php if ($active == 'dashboard') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            Dashboard
        </a>

        <span class="nav-label">Add Items</span>

        <a href="add_asset.php" class="nav-item <?php if ($active == 'add_desktop') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="12" rx="1"></rect><line x1="8" y1="20" x2="16" y2="20"></line><line x1="12" y1="16" x2="12" y2="20"></line></svg>
            Add Desktop
        </a>

        <a href="laptop.php" class="nav-item <?php if ($active == 'add_laptop') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="10" rx="1"></rect><path d="M2 18h20l-1.5 2.5a1 1 0 01-.86.5H4.36a1 1 0 01-.86-.5L2 18z"></path></svg>
            Add Laptop
        </a>

        <a href="printer.php" class="nav-item <?php if ($active == 'add_printer') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 3 18 3 18 9"></polyline><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"></path><rect x="6" y="14" width="12" height="7"></rect></svg>
            Add Printer
        </a>

        <a href="projector.php" class="nav-item <?php if ($active == 'add_projector') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="14" height="10" rx="2"></rect><polygon points="23 7 16 12 23 17 23 7"></polygon></svg>
            Add Projector
        </a>

        <span class="nav-label">View Items</span>

        <a href="view_assets.php" class="nav-item <?php if ($active == 'desktop') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="12" rx="1"></rect><line x1="8" y1="20" x2="16" y2="20"></line><line x1="12" y1="16" x2="12" y2="20"></line></svg>
            Desktop
        </a>

        <a href="view_laptop.php" class="nav-item <?php if ($active == 'laptop') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="10" rx="1"></rect><path d="M2 18h20l-1.5 2.5a1 1 0 01-.86.5H4.36a1 1 0 01-.86-.5L2 18z"></path></svg>
            Laptop
        </a>

        <a href="view_printer.php" class="nav-item <?php if ($active == 'printer') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 3 18 3 18 9"></polyline><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"></path><rect x="6" y="14" width="12" height="7"></rect></svg>
            Printer
        </a>

        <a href="view_projector.php" class="nav-item <?php if ($active == 'projector') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="14" height="10" rx="2"></rect><polygon points="23 7 16 12 23 17 23 7"></polygon></svg>
            Projector
        </a>

        <span class="nav-label">Status</span>

        <a href="dashboard.php?view=working&status=Serviceable" class="nav-item <?php if ($active == 'serviceable') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="9 12 11 14 15 10"></polyline></svg>
            Serviceable
        </a>

        <a href="dashboard.php?view=working&status=Unserviceable" class="nav-item <?php if ($active == 'unserviceable') echo 'active'; ?>">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><line x1="9.5" y1="9.5" x2="14.5" y2="14.5"></line><line x1="14.5" y1="9.5" x2="9.5" y2="14.5"></line></svg>
            Unserviceable
        </a>

    </nav>

    <div class="sidebar-footer">

        <a href="logout.php" class="nav-item">
            <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            Logout
        </a>
    </div>

</aside>
