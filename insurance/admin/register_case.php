<?php
ob_start();
?>
<?php
if (!isset($_GET['id']) || $_GET['id'] == '') {
    header('location:repairs_list.php');
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
    require('../../common/config/db_connect.php');
    ?>

    <?php
    // submit case form to the database
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $repair_registration_id = $_POST['repair_registration_id'];
        $insurance_id = $_POST['insurance_id'];
        $workshop_id = $_POST['workshop'];
        $description = $_POST['description'];
        $damaged_parts = implode('_$$_', explode(',', $_POST['damaged_parts']));
        $estimated_price = $_POST['estimated_price'];

        $sql = "INSERT INTO `repair_cases`(`repair_registration_id`, `insurance_id`, `workshop_id`, `status`, `description`, `damaged_parts`, `estimated_price`) VALUES ('$repair_registration_id','$insurance_id','$workshop_id','awaiting','$description','$damaged_parts','$estimated_price')";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $new_repair_case_id = $pdo->lastInsertId();
        if ($statement->rowCount()) {
            $success = true;

            // now send mail to the workshop to update them about the new case registered
            // first get the workshop email using the workshop id
            $sql = "SELECT email FROM workshops WHERE id='$workshop_id'";
            $statement = $pdo->prepare($sql);
            $statement->execute();
            if($statement->rowCount()){
                $workshop_email = $statement->fetch(PDO::FETCH_ASSOC)['email'];
                
                $subject = "New Repair Case Registered";
                $body = '
                    This is to inform you that an insurance registered new repair case with your workshop.
                    The repair case id is '.$new_repair_case_id.'. For details please see app dashboard.
                ';
                send_mail($mail, $workshop_email, $subject, $body);
            }
        } else {
            $success = false;
        }
    }
    ?>

    <?php
    // get the repair registration data
    $repair_registration_id = $_GET['id'];
    $insurance_id = $_SESSION['user']['business_id'];

    $sql = "SELECT * from repair_registration WHERE id = '$repair_registration_id' AND insurance_id='$insurance_id'";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if (!$statement->rowCount()) {
        header('location:repairs_list.php');
        exit(0);
    }

    $data = $statement->fetch(PDO::FETCH_ASSOC);


    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Register Case</h1>
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
                        <form action="" method="post">
                            <input type="hidden" name="repair_registration_id" value="<?php echo $data['id']; ?>">
                            <input type="hidden" name="insurance_id" value="<?php echo $data['insurance_id']; ?>">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select class="form-control" name="workshop" id="" required>
                                            <option value="" selected disabled>Select Workshop</option>
                                            <?php
                                            $sql = "SELECT * FROM workshops WHERE status='approved'";
                                            $statement = $pdo->prepare($sql);
                                            $statement->execute();
                                            if ($statement->rowCount()) {
                                                $workshops = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($workshops as $row) {
                                                    echo '
                                                            <option value="' . $row['id'] . '">' . $row['name'] . '</option>
                                                        ';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Device Category</label>
                                        <input class="form-control" type="text" value="<?php echo $data['category'] ?>" name="category" id="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Device Name</label>
                                        <input class="form-control" type="text" value="<?php echo $data['device_name'] ?>" name="device_name" id="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Device Model</label>
                                        <input class="form-control" type="text" value="<?php echo $data['model'] ?>" name="model" id="" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Damaged Parts</label>
                                        <input class="form-control" type="text" value="<?php echo implode(',', explode('_$$_', $data['damaged_parts'])) ?>" name="damaged_parts" id="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Estimated Price</label>
                                        <input class="form-control" type="text" value="<?php echo $data['estimated_price'] ?>" name="estimated_price" id="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Registration Date</label>
                                        <input class="form-control" type="text" value="<?php echo date('d-M-Y', strtotime($data['date_registered'])) ?>" name="date_registered" id="" readonly>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea class="form-control" name="description" id="" cols="30" rows="4" required></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Submit Case</button>
                                </div>

                            </div>

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
                        toastr.success("Registration Successfull");
                        toastr.warning("Case forwarded to the workshop. Please wait for approval");
                    </script>
                ';
        } else {
            echo '
                    <script>
                        toastr.error("Registration Failed");
                    </script>
                ';
        }
    }
    ?>