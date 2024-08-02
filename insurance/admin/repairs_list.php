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
        table td,
        table th {
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
                        <h1 class="m-0">Repairs List</h1>
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
                                    <th>Registration Id</th>
                                    <th>Customer Name</th>
                                    <th>Customer Email</th>
                                    <th>Customer Claim Number</th>
                                    <th>Device Category</th>
                                    <th>Device Name</th>
                                    <th>Device Model</th>
                                    <th>Damaged Parts</th>
                                    <th>Estimated Price</th>
                                    <th>Regisration Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $insurance_id = $_SESSION['user']['business_id'];
                                $sql = "SELECT rr.id, rr.customer_id, rr.insurance_id, rr.device_name, rr.category, rr.model, rr.damaged_parts, rr.estimated_price, rr.date_registered, c.name, c.email, c.claim_number 
                                FROM repair_registration rr
                                INNER JOIN customers c ON rr.customer_id = c.id WHERE rr.insurance_id = '$insurance_id';
                                ";
                                $statment = $pdo->prepare($sql);
                                $statment->execute();
                                if($statment->rowCount()){
                                    $data = $statment->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($data as $row){
                                        // check if this particular case is registered with a workshop
                                        $sql = "SELECT * FROM repair_cases WHERE repair_registration_id='{$row['id']}' AND status != 'rejected'";
                                        $stment = $pdo->prepare($sql);
                                        $stment->execute();
                                        if($stment->rowCount()){
                                            $registered_btn = '';
                                        }else{
                                            $registered_btn = '
                                            <a title="Register Case" class="btn btn-sm btn-primary" href="register_case.php?id='.$row['id'].'">
                                                <i class="fa fa-registered"></i>
                                            </a>';
                                        }

                                        echo '<tr>
                                            <td>'.$row['id'].'</td>
                                            <td>'.$row['name'].'</td>
                                            <td>'.$row['email'].'</td>
                                            <td>'.$row['claim_number'].'</td>
                                            <td>'.$row['category'].'</td>
                                            <td>'.$row['device_name'].'</td>
                                            <td>'.$row['model'].'</td>
                                            <td>'.implode(',', explode('_$$_', $row['damaged_parts'])).'</td>
                                            <td>'.$row['estimated_price'].'</td>
                                            <td>'.date('d-M-Y', strtotime($row['date_registered'])).'</td>
                                            <td>
                                                '.$registered_btn.'
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