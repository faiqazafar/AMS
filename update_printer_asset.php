<?php  
 if (isset($_GET['id'])) {
	$id=$_GET['id'];
}
$active="SELECT * FROM printer WHERE id='$id'";
$result=mysqli_query($conn,$active);
$array=mysqli_fetch_array($result);
if (isset($_POST["update"])) {
$filename=$_FILES['upload']['name'];
    $tempname=$_FILES['upload']['tmp_name'];
    $folder="files/".$filename;
    move_uploaded_file($tempname,$folder);
    $query= "UPDATE printer SET `file`='$filename' WHERE `id`='$id'";
    $run = mysqli_query($conn, $query);

    if ($run) {
        $success = true;
        $message = "printer was added successfully.";
    } else {
        $message = "Could not save this printer. Check the fields and try again.";
    }

}
 
 ?>
 
 
 
 <div class="panel" style="max-width:720px;">
            <form method="POST" enctype="multipart/form-data">
                
                <label>file upload</label>
                <a href="files/<?php echo $array['file']?>"><?php echo $array['file']?></a>
                 <input type="file" name="upload" class="form-control" style="width:300px" required>
                 <br>

                <button type="submit" name="update" class="btn-main" style="margin-top:24px;">Update Asset</button>
            </form>
        </div>