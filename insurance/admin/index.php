<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>SPS | HOME</title>

  <!-- include Header here -->
  <?php
  require_once("header.php");
  ?>
  <!-- Header Ends here -->

  <?php
  // get stats data for the dashboard
  require('../../common/config/db_connect.php');
  $insurance_id = $_SESSION['user']['business_id'];

  // find the total number of repair registrations
  $sql = "SELECT COUNT(*) AS row_count FROM repair_registration WHERE insurance_id='$insurance_id'";
  $stment = $pdo->prepare($sql);
  $stment->execute();
  $result = $stment->fetch(PDO::FETCH_ASSOC);
  $total_repair_registrations = $result['row_count'];

  // find the total number of customers registered
  $sql = "SELECT COUNT(*) AS row_count FROM customers WHERE status='approved' AND insurance_id='$insurance_id'";
  $stment = $pdo->prepare($sql);
  $stment->execute();
  $result = $stment->fetch(PDO::FETCH_ASSOC);
  $total_customers = $result['row_count'];



  ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Home</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- Main Content Starts Here -->
        <div class="card card-primary">
          <div class="card-header">Stats</div>
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $total_repair_registrations; ?></h3>

                    <p>Total Repair Registration</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-mobile-alt"></i>
                  </div>
                  <a href="repairs_list.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?php echo $total_customers; ?></h3>

                    <p>Total Customer Registrations</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-user-plus"></i>
                  </div>
                  <a href="total_customers.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
            <!-- /.row -->
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