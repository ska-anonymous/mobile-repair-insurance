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
  // register customer if the form is submmited
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_register_customer'])) {
    extract($_POST);
    // insert data to customers table
    require('../../common/config/db_connect.php');

    $insurance_id = $_SESSION['user']['business_id'];

    $sql = "INSERT INTO `customers`(`name`, `email`, `phone`, `address`, `city`, `country`, `postal_code`, `status`, `claim_number`, `deductible`, `insurance_id`) VALUES ('$name','$email','$phone','$address','$city','$country','$postal_code','approved','$claim_number','$deductible','$insurance_id')";

    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount()) {
      $success = true;
    } else {
      $success = false;
    }
  }
  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Customer Registration</h1>
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
              <div class="row">

                <div class="col-md-6">
                  <div class="form-group">
                    <input class="form-control" placeholder="Name" type="text" name="name" id="" required>
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="Email" type="email" name="email" id="" required>
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="Phone" type="tel" name="phone" id="" required>
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="Country" type="text" name="country" id="" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <input class="form-control" placeholder="City" type="text" name="city" id="" required>
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="Postal Code" type="text" name="postal_code" id="" required>
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="Claim Number" type="tel" name="claim_number" id="" required>
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="Deductible" type="number" step="any" min="0" name="deductible" id="" required>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <input class="form-control" type="text" name="address" placeholder="Address" id="" required>
                  </div>
                </div>

                <div class="col-12">
                  <button type="submit" name="btn_register_customer" class="btn btn-primary">Register</button>
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
            setTimeout(()=>{
              window.location.href = "total_customers.php";
            }, 2000)
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