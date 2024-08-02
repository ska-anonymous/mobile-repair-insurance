<?php
ob_start();
?>
<?php
if (!isset($_GET['id']) || $_GET['id'] == '') {
    header('location:all_devices.php');
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>SPS | Dashboard</title>

    <!-- include Header here -->
    <?php
    require_once("header.php");
    ?>
    <!-- Header Ends here -->
    <?php
    require('../common/config/db_connect.php');
    ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form data
        $device_id = $_POST["device_id"];
        $brand = $_POST["brand"];
        $model = $_POST["model"];
        $category = $_POST["category"];

        // Query to update device information
        $sql = "UPDATE devices SET brand = :brand, model = :model, category = :category WHERE id = :device_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':model', $model, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':device_id', $device_id, PDO::PARAM_INT);

        // Execute the update query
        if ($stmt->execute()) {
            $success = true;
        } else {
            $success = false;
        }
    }
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Device</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Main Content Starts Here -->
                <div class="card">
                    <div class="card-body">
                        <?php
                        // Check if 'id' is provided in the URL
                        $device_id = $_GET['id'];

                        // Query to fetch device data by ID
                        $sql = "SELECT * FROM devices WHERE id = :device_id";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':device_id', $device_id, PDO::PARAM_INT);
                        $stmt->execute();

                        // Fetch the device data
                        $device = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($device) {
                            // Device data found, pre-fill the form fields
                        ?>
                            <form action="" method="POST">
                                <input type="hidden" name="device_id" value="<?php echo $device['id']; ?>">

                                <div class="form-group">
                                    <label for="brand">Brand:</label>
                                    <input type="text" class="form-control" id="brand" name="brand" value="<?php echo $device['brand']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="model">Model:</label>
                                    <input type="text" class="form-control" id="model" name="model" value="<?php echo $device['model']; ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="category">Category:</label>
                                    <select class="form-control" value="<?php echo $device['category']; ?>" id="category" name="category" required>
                                        <option value="mobile" <?php echo $device['category'] == 'mobile' ? 'selected' : '';  ?>>Mobile</option>
                                        <option value="tablet" <?php echo $device['category'] == 'tablet' ? 'selected' : '';  ?>>Tablet</option>
                                        <option value="laptop" <?php echo $device['category'] == 'laptop' ? 'selected' : '';  ?>>Laptop</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Device</button>
                            </form>
                        <?php
                        } else {
                            echo "<p>Device not found.</p>";
                        }

                        ?>
                    </div>
                </div>
                <!-- Main Content Ends Here -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Include Footer Here -->
    <?php
    require_once("footer.php");
    ?>
    <?php
    if (isset($success)) {
        if ($success) {
            echo '
                    <script>
                        toastr.success("Device Updated Succesfully");
                    </script>
                ';
        } else {
            echo '
                    <script>
                        toastr.error("Failed to Update Device");
                    </script>
                ';
        }
    }
    ?>