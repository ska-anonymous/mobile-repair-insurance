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
    // do approve or reject action based on user action
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $action = $_GET['action'];
        $case_id = $_GET['id'];
        $workshop_id = $_SESSION['user']['business_id'];

        if ($action == 'approve') {
            $status = 'approved';
            $sql = "UPDATE repair_cases SET status='$status' WHERE id='$case_id' AND workshop_id='$workshop_id'";
        } elseif ($action == 'reject') {
            $status = 'rejected';
            $sql = "UPDATE repair_cases SET status='$status', date_closed = current_timestamp() WHERE id='$case_id' AND workshop_id='$workshop_id'";
        }

        $statement = $pdo->prepare($sql);
        $statement->execute();
        if ($statement->rowCount()) {
            $success = true;
            // now send email to the insurance to update them about the action
            // get the insurance email and the repair_registration_id
            $sql = "SELECT
                rc.repair_registration_id,
                rc.insurance_id,
                i.email AS insurance_email
            FROM
                repair_cases rc
            INNER JOIN
                insurances i ON rc.insurance_id = i.id
            INNER JOIN
                repair_registration r ON rc.repair_registration_id = r.id
            WHERE rc.id = '$case_id';";

            $statement = $pdo->prepare($sql);
            $statement->execute();
            if ($statement->rowCount()) {
                $data_for_email = $statement->fetch(PDO::FETCH_ASSOC);
                $repair_registration_id = $data_for_email['repair_registration_id'];
                $insurance_email = $data_for_email['insurance_email'];

                if($status == 'approved'){
                    $subject = 'Repair Case Approval By Workshop';
                    $body = 'This is to inform you that your case for device repair against repair_regisration_id (' . $repair_registration_id . ') has been approved by the workshop. You can now send your device to the workshop for repair. For more details please check at the app dashboard.';
                    
                }elseif($status == 'rejected'){
                    $subject = 'Repair Case Rejection By Workshop';
                    $body = 'This is to inform you that your case for device repair against repair_regisration_id (' . $repair_registration_id . ') has been rejected by the workshop. For more details please check at the app dashboard.';
                }

                send_mail($mail, $insurance_email, $subject, $body);
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
                                    <th>Case Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Country</th>
                                    <th>City</th>
                                    <th>Postal Code</th>
                                    <th>Date Opened</th>
                                    <th>Damaged Parts</th>
                                    <th>Estimated Price</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $workshop_id = $_SESSION['user']['business_id'];
                                $sql = "SELECT rc.id, rc.date_opened, rc.description, rc.damaged_parts, rc.estimated_price, i.name, i.address, i.country, i.city, i.postal_code, i.email, i.phone
                                FROM
                                    repair_cases rc
                                JOIN
                                    insurances i ON rc.insurance_id = i.id
                                WHERE
                                    rc.workshop_id = '$workshop_id'
                                    AND rc.status = 'awaiting';
                                ";

                                $statement = $pdo->prepare($sql);
                                $statement->execute();
                                if ($statement->rowCount()) {
                                    $data = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($data as $row) {
                                        echo '
                                            <tr>
                                                <td>' . $row['id'] . '</td>
                                                <td>' . $row['name'] . '</td>
                                                <td>' . $row['email'] . '</td>
                                                <td>' . $row['phone'] . '</td>
                                                <td>' . $row['address'] . '</td>
                                                <td>' . $row['country'] . '</td>
                                                <td>' . $row['city'] . '</td>
                                                <td>' . $row['postal_code'] . '</td>
                                                <td>' . date('d-M-Y h:i:s a', strtotime($row['date_opened'])) . '</td>
                                                <td>' . implode(',', explode('_$$_', $row['damaged_parts'])) . '</td>
                                                <td>' . $row['estimated_price'] . '</td>
                                                <td>' . $row['description'] . '</td>
                                                <td>
                                                    <a class="btn btn-sm btn-success" href="?action=approve&id=' . $row['id'] . '">Approve</a>
                                                    <a class="btn btn-sm btn-danger" href="?action=reject&id=' . $row['id'] . '">Reject</a>
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
    if (isset($success)) {
        if ($success) {
            echo '
                    <script>
                        toastr.success("Updated Successfully");
                        setTimeout(()=>{
                            window.location.href="?";
                        },3000)
                    </script>
                ';
        } else {
            echo '
                    <script>
                        toastr.error("Failed to update");
                    </script>
                ';
        }
    }
    ?>