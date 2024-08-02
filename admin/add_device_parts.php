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
    require_once("../common/config/db_connect.php");
    ?>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Get the device_id, part_name, and price from the form
        $device_id = $_POST["device_id"];
        $part_name = $_POST["part_name"];
        $price = $_POST["price"];

        // Prepare the SQL insert statement
        $sql = "INSERT INTO device_parts (device_id, part_name, price) VALUES (:device_id, :part_name, :price)";

        // Use a prepared statement to prevent SQL injection
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':device_id', $device_id, PDO::PARAM_INT);
        $stmt->bindParam(':part_name', $part_name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            $success = true;
        } else {
            $success = false;
        }
    }
    ?>

    <?php
    // get device data
    $device_id = $_GET['id'];
    $sql = "SELECT * FROM devices WHERE id='$device_id'";
    $statment = $pdo->prepare($sql);
    $statment->execute();
    $device_data = $statment->fetch(PDO::FETCH_ASSOC);

    ?>
    <?php
    // get device parts data
    $device_id = $_GET['id'];
    $sql = "SELECT * FROM device_parts WHERE device_id='$device_id'";
    $statment = $pdo->prepare($sql);
    $statment->execute();
    $device_parts_data = $statment->fetchAll(PDO::FETCH_ASSOC);

    ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add Device Parts</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Main Content Starts Here -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4><?php echo $device_data['brand'] . ' ' . $device_data['model'] ?></h4>
                            </div>
                            <div class="card-body" style="overflow-x: auto;">
                                <form action="" method="POST">
                                    <input type="hidden" name="device_id" value="<?php echo $_GET['id']; ?>">

                                    <div class="form-group">
                                        <label for="part_name">Part Name:</label>
                                        <input type="text" class="form-control" id="part_name" name="part_name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Price:</label>
                                        <input type="number" class="form-control" id="price" name="price" step="any" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Add Part</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h3>Available parts</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Part Name</th>
                                    <th>Part Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($device_parts_data as $row) {
                                    echo '
                                        <tr>
                                            <td>' . $row['part_name'] . '</td>
                                            <td>' . $row['price'] . '</td>
                                        </tr>
                                        ';
                                }
                                ?>
                            </tbody>
                        </table>
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
                        toastr.success("Device part Added Succesfully.");
                    </script>
                ';
        } else {
            echo '
                    <script>
                        toastr.error("Failed to Add Device part.");
                    </script>
                ';
        }
    }
    ?>