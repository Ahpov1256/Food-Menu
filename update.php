<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Menu Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0">Update Menu Item</h3>
                    </div>
                    <div class="card-body">
                        <?php
                        include 'config.php';
                        
                        if(isset($_GET['Id']) && is_numeric($_GET['Id'])) {
                            $ID = (int)$_GET['Id'];
                            $stmt = mysqli_prepare($con, "SELECT * FROM `tblcard` WHERE Id = ?");
                            mysqli_stmt_bind_param($stmt, "i", $ID);
                            mysqli_stmt_execute($stmt);
                            $result = mysqli_stmt_get_result($stmt);
                            
                            if($data = mysqli_fetch_array($result)) {
                        ?>
                        <form action="update_process.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $data['Id']; ?>">
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($data['Name']); ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $data['Price']; ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="current_image" class="form-label">Current Image</label>
                                <div>
                                    <img src="<?php echo $data['Image']; ?>" class="img-thumbnail mb-2" style="max-width: 200px;">
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="image" class="form-label">Update Image (Leave blank to keep current)</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="index.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" name="update" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                        <?php
                            } else {
                                echo "<div class='alert alert-danger'>Item not found!</div>";
                                echo "<a href='index.php' class='btn btn-primary mt-3'>Back to Menu</a>";
                            }
                            mysqli_stmt_close($stmt);
                        } else {
                            echo "<div class='alert alert-danger'>Invalid request!</div>";
                            echo "<a href='index.php' class='btn btn-primary mt-3'>Back to Menu</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>