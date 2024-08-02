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
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Delete Customer</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Main Content Starts Here -->
                <?php
                // check if this user can delete this customer

                $customer_id = $_GET['id'];
                $insurance_id = $_SESSION['user']['business_id'];

                $sql = "SELECT * FROM customers WHERE id='$customer_id' AND insurance_id='$insurance_id'";
                $statement = $pdo->prepare($sql);
                $statement->execute();

                if (!$statement->rowCount()) {

                ?>
                <div class="card">
                    <div class="card-body">
                        <h3 class="p-5 rounded bg-danger">You cannot delete this customer.</h3>
                    </div>
                </div>
                <?php
                }else{
                    //now delete customer
                    $sql = "DELETE FROM customers WHERE id='$customer_id'";
                    $statement = $pdo->prepare($sql);
                    $statement->execute();

                    if($statement->rowCount()){
                        $success = true;
                    }else{
                        $success = false;
                    }
                }
                ?>
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
                        toastr.success("Successfully Deleted");
                        setTimeout(()=>{
                            window.location.href = "total_customers.php";
                        },2000)
                        </script>';
                    } else {
                        echo '
                        <script>
                        toastr.error("Failed to Delete");
                        setTimeout(()=>{
                            window.location.href = "total_customers.php";
                        },4000)
                    </script>';
            }
        }
    ?>