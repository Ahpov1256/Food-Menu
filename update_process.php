<?php
include 'config.php'; // Make sure your DB connection file is correctly named

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $ID = (int)$_POST['id'];
    $NAME = trim($_POST['name']);
    $PRICE = (float)$_POST['price'];

    // Get current image from DB in case no new image is uploaded
    $stmt = mysqli_prepare($con, "SELECT Image FROM tblcard WHERE Id = ?");
    mysqli_stmt_bind_param($stmt, "i", $ID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $currentImage = $row['Image'];
    mysqli_stmt_close($stmt);

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $image_path = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
            // Optionally delete the old image if desired:
            if (!empty($currentImage) && file_exists($currentImage)) {
                unlink($currentImage);
            }
        } else {
            // Upload failed, fallback to current image
            $image_path = $currentImage;
        }
    } else {
        // No new image uploaded
        $image_path = $currentImage;
    }

    // Update the database record
    $stmt = mysqli_prepare($con, "UPDATE tblcard SET Name = ?, Price = ?, Image = ? WHERE Id = ?");
    mysqli_stmt_bind_param($stmt, "sdsi", $NAME, $PRICE, $image_path, $ID);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?update=success");
        exit();
    } else {
        header("Location: index.php?update=error");
        exit();
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: index.php?update=invalid");
    exit();
}
?>
