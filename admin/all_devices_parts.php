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

    <?php
    // get all parts names and their device names etc 
    $sql = "SELECT
        d.brand,
        d.model,
        d.category,
        dp.part_name,
        dp.price,
        dp.id
    FROM
        devices d
    INNER JOIN
        device_parts dp ON d.id = dp.device_id;
    ";
    $statment = $pdo->prepare($sql);
    $statment->execute();
    $data = $statment->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">All Devices Parts</h1>
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
                        <table class="table table-striped data-table">
                            <thead>
                                <tr>
                                    <th>Brand</th>
                                    <th>Model</th>
                                    <th>Category</th>
                                    <th>Part Name</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach($data as $row){
                                        echo '
                                        <tr>
                                            <td>'.$row['brand'].'</td>
                                            <td>'.$row['model'].'</td>
                                            <td>'.$row['category'].'</td>
                                            <td>'.$row['part_name'].'</td>
                                            <td>'.$row['price'].'</td>
                                            <td>
                                                <a href="edit_device_part.php?id='.$row['id'].'" class="btn btn-sm btn-info">Edit</a>
                                            </td>
                                        </tr>';
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