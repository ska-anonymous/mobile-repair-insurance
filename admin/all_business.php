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
    require_once('../common/config/db_connect.php');

    $sql = "SELECT * FROM insurances";
    $statment = $pdo->prepare($sql);
    $statment->execute();
    $insurances = $statment->fetchAll(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM workshops";
    $statment = $pdo->prepare($sql);
    $statment->execute();
    $workshops = $statment->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <style>
        table th,
        table td {
            white-space: nowrap;
        }
    </style>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">All Businesses</h1>
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
                    <div class="card-header">
                        <div class="card-title">
                            Insurances
                        </div>
                    </div>
                    <div class="card-body" style="overflow-x: auto;">
                        <table class="table table-striped data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Postal Code</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Registration Date</th>
                                    <th>status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($insurances as $row) {
                                    echo '
                                        <tr>
                                            <td>' . $row['name'] . '</td>
                                            <td>' . $row['address'] . '</td>
                                            <td>' . $row['country'] . '</td>
                                            <td>' . $row['city'] . '</td>
                                            <td>' . $row['postal_code'] . '</td>
                                            <td>' . $row['email'] . '</td>
                                            <td>' . $row['phone'] . '</td>
                                            <td>' . date('d-M-Y', strtotime($row['date_created'])) . '</td>
                                            <td>' . $row['status'] . '</td>
                                        </tr>
                                    ';
                                }

                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Workshops
                        </div>
                    </div>
                    <div class="card-body" style="overflow-x: auto;">
                        <table class="table table-striped data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Postal Code</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Registration Date</th>
                                    <th>status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($workshops as $row) {
                                    echo '
                                        <tr>
                                            <td>' . $row['name'] . '</td>
                                            <td>' . $row['address'] . '</td>
                                            <td>' . $row['country'] . '</td>
                                            <td>' . $row['city'] . '</td>
                                            <td>' . $row['postal_code'] . '</td>
                                            <td>' . $row['email'] . '</td>
                                            <td>' . $row['phone'] . '</td>
                                            <td>' . date('d-M-Y', strtotime($row['date_created'])) . '</td>
                                            <td>' . $row['status'] . '</td>
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