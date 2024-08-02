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
    require('../../common/config/db_connect.php');
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
                        <h1 class="m-0">New Repair Cases</h1>
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
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Postal Code</th>
                                    <th>Date Opened</th>
                                    <th>Date Closed</th>
                                    <th>Damaged Parts</th>
                                    <th>Estimated Price</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $workshop_id = $_SESSION['user']['business_id'];
                                $sql = "SELECT rc.id, rc.date_opened, rc.date_closed, rc.description, rc.damaged_parts, rc.estimated_price, i.name, i.address, i.country, i.city, i.postal_code, i.email, i.phone
                                FROM
                                    repair_cases rc
                                JOIN
                                    insurances i ON rc.insurance_id = i.id
                                WHERE
                                    rc.workshop_id = '$workshop_id'
                                    AND rc.status = 'rejected';
                                ";

                                $statement = $pdo->prepare($sql);
                                $statement->execute();
                                if ($statement->rowCount()) {
                                    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($data as $row) {
                                        echo '
                                            <tr>
                                                <td>' . $row['name'] . '</td>
                                                <td>' . $row['email'] . '</td>
                                                <td>' . $row['phone'] . '</td>
                                                <td>' . $row['address'] . '</td>
                                                <td>' . $row['country'] . '</td>
                                                <td>' . $row['city'] . '</td>
                                                <td>' . $row['postal_code'] . '</td>
                                                <td>' . date('d-M-Y h:i:s a', strtotime($row['date_opened'])) . '</td>
                                                <td>' . date('d-M-Y h:i:s a', strtotime($row['date_closed'])) . '</td>
                                                <td>' . implode(',', explode('_$$_', $row['damaged_parts'])) . '</td>
                                                <td>' . $row['estimated_price'] . '</td>
                                                <td>' . $row['description'] . '</td>
                                            </tr>
                                        
                                        ';
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