<?php
ob_start();
?>
<?php
if (!isset($_GET['id']) || $_GET['id'] == '') {
    header('location:total_customers.php');
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

    // update customer if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_edit_customer'])) {
        extract($_POST);

        $customer_id = $_POST['btn_edit_customer'];

        $sql = "UPDATE `customers` SET `name`='$name',`email`='$email',`phone`='$phone',`address`='$address',`city`='$city',`country`='$country',`postal_code`='$postal_code',`claim_number`='$claim_number' WHERE id='$customer_id'";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        if ($statement->rowCount()) {
            $success = true;
        } else {
            $success = false;
        }
    }
    ?>

    <?php
    // get customer data
    $customer_id = $_GET['id'];
    $insurance_id = $_SESSION['user']['business_id'];

    $sql = "SELECT * FROM customers WHERE id='$customer_id' AND insurance_id='$insurance_id'";
    $statement = $pdo->prepare($sql);
    $statement->execute();

    if ($statement->rowCount()) {
        $customer = $statement->fetch(PDO::FETCH_ASSOC);
    } else {
        $customer = false;
    }

    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Customer</h1>
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
                        <?php
                        if (!$customer) {
                        ?>
                            <h3 class="p-5 bg-danger rounded"> You cannot edit this customer</h3>
                        <?php

                        } else {

                        ?>
                            <form action="" method="post">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Name" type="text" name="name" id="" value="<?php echo $customer['name']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Email" type="email" name="email" id="" value="<?php echo $customer['email']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Phone" type="tel" name="phone" id="" value="<?php echo $customer['phone']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Country" type="text" name="country" id="" value="<?php echo $customer['country']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="City" type="text" name="city" id="" value="<?php echo $customer['city']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Postal Code" type="text" name="postal_code" id="" value="<?php echo $customer['postal_code']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Claim Number" type="tel" name="claim_number" id="" value="<?php echo $customer['claim_number']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="address" placeholder="Address" id="" value="<?php echo $customer['address']; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" name="btn_edit_customer" value="<?php echo $customer['id']; ?>" class="btn btn-primary">Update</button>
                                    </div>

                                </div>
                            </form>
                        <?php
                        }
                        ?>
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
                    toastr.success("Successfully updated");
                    setTimeout(()=>{
                        window.location.href = "total_customers.php";
                    },2000)
                </script>';
        } else {
            echo '
                <script>
                    toastr.error("Data not updated");
                </script>';
        }
    }
    ?>