<?php
ob_start();
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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">All Devices</h1>
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
                    <div class="card-body" style="overflow-x: auto;">
                        <table class="table table-striped data-table">
                            <thead>
                                <tr>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Prepare and execute the SQL query to select data from the devices table
                                $sql = "SELECT * FROM devices";
                                $statement = $pdo->query($sql);

                                if ($statement) {
                                    $devices_data = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($devices_data as $row) {
                                        echo '<tr>
                                            <td>' . $row['brand'] . '</td>
                                            <td>' . $row['model'] . '</td>
                                            <td>' . $row['category'] . '</td>
                                            <td>
                                                 <a href="edit_device.php?id=' . $row['id'] . '" class="btn btn-info btn-sm">Edit Device</a>
                                                <a href="add_device_parts.php?id=' . $row['id'] . '" class="btn btn-primary btn-sm mx-2">Add Parts</a>
                                            </td>
                                        </tr>';
                                    }
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