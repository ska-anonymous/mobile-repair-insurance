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

    <?php
    // if repaired is clicked then change the status of that case to done
    if (isset($_GET['id']) && $_GET['id'] != '') {
        $repair_case_id = $_GET['id'];

        $sql = "UPDATE repair_cases SET status='done', date_closed= current_timestamp() WHERE id='$repair_case_id'";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        if ($statement->rowCount()) {
            $success = true;

            // now send email to the insurance company and the customer to update them about the device repair
            // first get the detail about the insurance company email, and customer email
            $sql = "SELECT
                rc.repair_registration_id,
                rc.insurance_id,
                r.customer_id,
                i.email AS insurance_email,
                c.email AS customer_email
            FROM
                repair_cases rc
            INNER JOIN
                insurances i ON rc.insurance_id = i.id
            INNER JOIN
                repair_registration r ON rc.repair_registration_id = r.id
            INNER JOIN
                customers c ON r.customer_id = c.id
                WHERE rc.id = '$repair_case_id';
            ";

            $statement = $pdo->prepare($sql);
            $statement->execute();
            if($statement->rowCount()){
                $mail_data = $statement->fetch(PDO::FETCH_ASSOC);
                
                $repair_registration_id = $mail_data['repair_registration_id'];
                $insurance_email = $mail_data['insurance_email'];
                $customer_email = $mail_data['customer_email'];

                $subject = 'Device Repaired';
                $body = 'This is to inform you that the device registered for repair against the repair_registration_id ('.$repair_registration_id.') has been repaired.';

                send_mail($mail, $insurance_email, $subject, $body);
                send_mail($mail, $customer_email, $subject, $body);
            }



        } else {
            $success = false;
        }
    }
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
                                    <th>Damaged Parts</th>
                                    <th>Estimated Price</th>
                                    <th>Actual Price</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $workshop_id = $_SESSION['user']['business_id'];
                                $sql = "SELECT rc.id, rc.description, rc.damaged_parts, rc.estimated_price, rc.actual_price, i.name, i.address, i.country, i.city, i.postal_code, i.email, i.phone
                                FROM
                                    repair_cases rc
                                JOIN
                                    insurances i ON rc.insurance_id = i.id
                                WHERE
                                    rc.workshop_id = '$workshop_id'
                                    AND rc.status = 'working';
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
                                                <td>' . implode(',', explode('_$$_', $row['damaged_parts'])) . '</td>
                                                <td>' . $row['estimated_price'] . '</td>
                                                <td>' . $row['actual_price'] . '</td>
                                                <td>' . $row['description'] . '</td>
                                                <td>
                                                    <a class="btn btn-sm btn-success" href="?id=' . $row['id'] . '">Repaired</a>
                                                </td>
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

    <?php
        if(isset($success)){
            if($success){
                echo '
                    <script>
                        toastr.success("Successfully updated");
                        setTimeout(()=>{
                            window.location.href="?";
                        }, 3000);
                    </script>
                ';
            }else{
                echo '
                    <script>
                        toastr.error("Failed to update");
                    </script>
                ';
            }
        }
    ?>