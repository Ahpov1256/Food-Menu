<?php
include 'config.php';

if(isset($_GET['Id']) && is_numeric($_GET['Id'])) {
    $ID = (int)$_GET['Id'];
    
    // Prepare statement to prevent SQL injection
    $stmt = mysqli_prepare($con, "DELETE FROM `tblcard` WHERE Id = ?");
    mysqli_stmt_bind_param($stmt, "i", $ID);
    
    if(mysqli_stmt_execute($stmt)) {
        header('location:index.php?delete=success');
    } else {
        header('location:index.php?delete=error');
    }
    mysqli_stmt_close($stmt);
} else {
    header('location:index.php');
}
?>