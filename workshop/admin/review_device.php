<?php
ob_start();
?>
<?php
// check if the id of the repair case is not set
if (!isset($_GET['id']) || $_GET['id'] == '') {
    header('location:approved_cases.php');
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
    // Include your database connection code here

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the values from POST
        $repair_case_id = $_GET['id'];
        $damaged_parts = implode('_$$_', $_POST['damaged_parts']);
        $actual_price = $_POST['actual_price'];

        // Prepare and execute the SQL UPDATE statement
        $sql = "UPDATE repair_cases SET damaged_parts = :damaged_parts, actual_price = :actual_price, status='working' WHERE id = :repair_case_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':damaged_parts', $damaged_parts, PDO::PARAM_STR);
        $stmt->bindParam(':actual_price', $actual_price, PDO::PARAM_STR);
        $stmt->bindParam(':repair_case_id', $repair_case_id, PDO::PARAM_INT);

        $stmt->execute();
        if ($stmt->rowCount()) {
            $success = true;
            // now send email to the insurance to inform about the device review
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
            WHERE rc.id = '$repair_case_id';";

            $statement = $pdo->prepare($sql);
            $statement->execute();
            if ($statement->rowCount()) {
                $data_for_email = $statement->fetch(PDO::FETCH_ASSOC);
                $repair_registration_id = $data_for_email['repair_registration_id'];
                $insurance_email = $data_for_email['insurance_email'];

                $subject = 'Device Review by Workshop';
                $body = 'This is to inform you that your device repair against repair_regisration_id (' . $repair_registration_id . ') has been reviewed by the workshop. The damaged parts information and the actual price for repair has been updated by the workshop. For details you can check at the app dashboard.';

                send_mail($mail, $insurance_email, $subject, $body);
            }
        } else {
            $success = false;
        }
    }
    ?>


    <?php
    // get data for the device
    require('../../common/config/db_connect.php');

    $repair_case_id = $_GET['id'];

    $sql = "SELECT rc.id, rc.description, rc.damaged_parts, rc.estimated_price, rc.actual_price, rr.device_name, rr.category, rr.model
        FROM repair_cases rc
        INNER JOIN repair_registration rr ON rc.repair_registration_id = rr.id
        WHERE rc.id='$repair_case_id';
        ";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount()) {
        $data = $statement->fetch(PDO::FETCH_ASSOC);
    } else {
        header('location:approved_cases.php');
        exit(0);
    }

    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Review Device</h1>
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
                        Edit Repair Case
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Description:</label>
                                        <input type="text" class="form-control" id="description" name="description" value="<?php echo $data['description']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estimated_price">Estimated Price:</label>
                                        <input type="text" class="form-control" id="estimated_price" name="estimated_price" value="<?php echo $data['estimated_price']; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="device_name">Device Name:</label>
                                        <input type="text" class="form-control" id="device_name" name="device_name" value="<?php echo $data['device_name']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category">Category:</label>
                                        <input type="text" class="form-control" id="category" name="category" value="<?php echo $data['category']; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="model">Model:</label>
                                        <input type="text" class="form-control" id="model" name="model" value="<?php echo $data['model']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="actual_price">Actual Repair Price:</label>
                                        <input type="number" value="<?php echo $data['actual_price']; ?>" step="any" class="form-control" id="actual_price" name="actual_price" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="damaged_parts">Damaged Parts (select multiple):</label>
                                <select multiple class="form-control" id="damaged_parts" name="damaged_parts[]" required>
                                    <?php
                                    // Split the damaged parts string into an array
                                    $damagedPartsArray = explode('_$$_', $data['damaged_parts']);

                                    foreach ($damagedPartsArray as $part) {
                                        echo '<option value="' . $part . '" selected>' . $part . '</option>';
                                    }
                                    ?>
                                </select>
                                <div class="input-group my-2">
                                    <input class="form-control" type="text" name="" id="new_damaged_part_input" placeholder="Part Name">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info" onclick="handleAddDamagePart()">+</button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
                        toastr.success("Updated Successfully");
                        setTimeout(()=>{
                            window.location.href= "";
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

    <script>
        const handleAddDamagePart = () => {
            let damagepartInput = document.getElementById('new_damaged_part_input');

            let newPartName = damagepartInput.value.trim();

            if (newPartName.length == 0) {
                return;
            }

            const damagedPartsSelect = document.getElementById('damaged_parts');
            let option = new Option(newPartName, newPartName);
            option.selected = true;
            damagedPartsSelect.options.add(option);
            damagepartInput.value = '';
        }
    </script>