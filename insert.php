<?php
include 'config.php';

if(isset($_POST['upload'])) {
    // Validate inputs
    $NAME = mysqli_real_escape_string($con, $_POST['name']);
    $PRICE = (float)$_POST['price'];
    
    // Image validation
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['image']['type'];
        
        if(in_array($fileType, $allowedTypes)) {
            $img_loc = $_FILES['image']['tmp_name'];
            $img_name = uniqid() . '_' . basename($_FILES['image']['name']);
            $img_des = "UploadImage/" . $img_name;
            
            // Create directory if it doesn't exist
            if(!is_dir('UploadImage')) {
                mkdir('UploadImage', 0755, true);
            }
            
            if(move_uploaded_file($img_loc, $img_des)) {
                // Prepare statement to prevent SQL injection
                $stmt = mysqli_prepare($con, "INSERT INTO `tblcard`(`Name`, `Price`, `Image`) VALUES (?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sds", $NAME, $PRICE, $img_des);
                
                if(mysqli_stmt_execute($stmt)) {
                    header('location:index.php?add=success');
                } else {
                    header('location:index.php?add=error');
                }
                mysqli_stmt_close($stmt);
            } else {
                header('location:index.php?add=upload_error');
            }
        } else {
            header('location:index.php?add=invalid_image');
        }
    } else {
        header('location:index.php?add=no_image');
    }
}
?>