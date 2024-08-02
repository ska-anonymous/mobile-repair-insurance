<?php
ob_start();
?>
<?php
if (!isset($_GET['id']) || $_GET['id'] == '') {
    header('location:all_devices_parts.php');
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

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $devicePartId = $_POST['id'];
        $partName = $_POST['partName'];
        $price = $_POST['price'];

        // Define the SQL query to update device part data by ID
        $sql = "UPDATE device_parts SET part_name = :partName, price = :price WHERE id = :id";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':id', $devicePartId, PDO::PARAM_INT);
        $stmt->bindParam(':partName', $partName, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            $success = true;
        } else {
            $success = false;
        }
    }

    ?>


    <?php

    $devicePartId = $_GET['id'];

    // Define the SQL query to select device part data by ID
    $sql = "SELECT * FROM device_parts WHERE id = :id";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Bind the ID parameter
    $stmt->bindParam(':id', $devicePartId, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Fetch the device part data as an associative array
    $devicePartData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Assign the retrieved data to variables for pre-filling the form fields
    $partName = $devicePartData['part_name'];
    $price = $devicePartData['price'];


    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Device Part</h1>
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
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="partName" class="form-label">Part Name</label>
                                <input type="text" class="form-control" id="partName" name="partName" value="<?php echo $partName; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="any" class="form-control" id="price" name="price" value="<?php echo $price; ?>" required>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                            <button type="submit" class="btn btn-primary">Update Device Part</button>
                        </form>
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
                        toastr.success("Part Updated Succesfully");
                        setTimeout(()=>{
                            window.location.href = "all_devices_parts.php";
                        },2000)
                    </script>
                ';
        } else {
            echo '
                    <script>
                        toastr.error("Failed to Update Part");
                    </script>
                ';
        }
    }
    ?>