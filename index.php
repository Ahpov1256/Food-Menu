<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menu Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
 <td>   <div class="nav-buttons">
        <button class="nav-btn" id="menuBtn" title="Navigation Menu">
            <i class="fas fa-bars"></i>
        </button>
        <button class="nav-btn" id="aboutBtn" title="About Me">
            <i class="fas fa-user"></i>
        </button>
    </div>
    </td>
    <!-- About Me Modal -->
    <div id="aboutModal" class="about-modal">
        <div class="about-content">
            <span class="close-about">&times;</span>
            <h2>About Me</h2>
                    <h3>Sorn Sreypov</h3>
                    <p class="text-muted">Food Menu System Developer</p>
                    <p>Hello! I'm the developer of this Food Menu Management System. This application allows restaurant owners to:</p>
            <ul>
                <li>Add new menu items with images</li>
                <li>Update existing items</li>
                <li>Remove items from the menu</li>
                <li>Manage prices and descriptions</li>
            </ul>
                </div>
            </div> 
            <div class="mt-4">
            </div>          
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <div class="container py-5">
            <h1 class="text-center mb-5">Food Menu Management</h1>
            
            <!-- Add Item Card -->
            <div class="card shadow mb-5">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Add New Menu Item</h3>
                </div>
                <div class="card-body">
                    <form action="insert.php" method="POST" enctype="multipart/form-data" class="row g-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-3">
                            <label for="price" class="form-label">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" class="form-control" name="price" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" accept="image/*" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" name="upload" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Add Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Menu Items Table -->
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Current Menu Items</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Update</th>
                                
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'config.php';
                                $pic = mysqli_query($con, "SELECT * FROM `tblcard` ORDER BY Id DESC");
                                while($row = mysqli_fetch_array($pic)) {
                                    echo "
                                    <tr>
                                        <td>{$row['Id']}</td>
                                        <td>{$row['Name']}</td>
                                        
                                        <td><img src='{$row['Image']}' class='img-thumbnail' style='width: 200px; height: 150px;'></td>
                                        <td>
                                           
                                                <a href='update.php?Id={$row['Id']}' class='btn btn-sm btn-warning'>
                                                    <i class='fas fa-edit'></i>
                                                </a>
                                                <a href='delete.php?Id={$row['Id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this item?\")'>
                                                    <i class='fas fa-trash'></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    ";
                                }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Navigation
        const menuBtn = document.getElementById('menuBtn');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            mainContent.classList.toggle('menu-open');
        });

        // Close sidebar when clicking outside
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && e.target !== menuBtn) {
                sidebar.classList.remove('open');
                mainContent.classList.remove('menu-open');
            }
        });

        // About Me Modal
        const aboutBtn = document.getElementById('aboutBtn');
        const aboutModal = document.getElementById('aboutModal');
        const closeAbout = document.querySelector('.close-about');

        aboutBtn.addEventListener('click', () => {
            aboutModal.style.display = 'flex';
            sidebar.classList.remove('open');
            mainContent.classList.remove('menu-open');
        });

        closeAbout.addEventListener('click', () => {
            aboutModal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === aboutModal) {
                aboutModal.style.display = 'none';
            }
        });

        // Alert notifications
        <?php
        if(isset($_GET['delete'])) {
            $message = ($_GET['delete'] == 'success') ? 'Item deleted successfully!' : 'Error deleting item!';
            $alertType = ($_GET['delete'] == 'success') ? 'success' : 'danger';
            echo "showAlert('{$message}', '{$alertType}');";
        }
        if(isset($_GET['add'])) {
            $message = ($_GET['add'] == 'success') ? 'Item added successfully!' : 'Error adding item!';
            $alertType = ($_GET['add'] == 'success') ? 'success' : 'danger';
            echo "showAlert('{$message}', '{$alertType}');";
        }
        if(isset($_GET['update'])) {
            $message = ($_GET['update'] == 'success') ? 'Item updated successfully!' : 'Error updating item!';
            $alertType = ($_GET['update'] == 'success') ? 'success' : 'danger';
            echo "showAlert('{$message}', '{$alertType}');";
        }
        ?>

        function showAlert(message, type) {
            let alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
            alertDiv.innerHTML = `${message}<button type='button' class='btn-close' data-bs-dismiss='alert'></button>`;
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 5000);
        }
    </script>
</body>
</html>