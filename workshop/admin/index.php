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
  $workshop_id = $_SESSION['user']['business_id'];

  // find the total number of pending cases
  $sql = "SELECT COUNT(*) AS row_count FROM repair_cases WHERE workshop_id='$workshop_id' AND status='awaiting'";
  $stment = $pdo->prepare($sql);
  $stment->execute();
  $result = $stment->fetch(PDO::FETCH_ASSOC);
  $pending_cases = $result['row_count'];

  // find the total number of ongoing cases
  $sql = "SELECT COUNT(*) AS row_count FROM repair_cases WHERE workshop_id='$workshop_id' AND status='working'";
  $stment = $pdo->prepare($sql);
  $stment->execute();
  $result = $stment->fetch(PDO::FETCH_ASSOC);
  $ongoing_cases = $result['row_count'];
  
  // find the total number of completed cases
  $sql = "SELECT COUNT(*) AS row_count FROM repair_cases WHERE workshop_id='$workshop_id' AND status='done'";
  $stment = $pdo->prepare($sql);
  $stment->execute();
  $result = $stment->fetch(PDO::FETCH_ASSOC);
  $completed_cases = $result['row_count'];


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
              <div class="col-4">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3><?php echo $pending_cases; ?></h3>

                    <p>Pending Cases</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-mobile-alt"></i>
                  </div>
                  <a href="new_cases.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-4">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3><?php echo $ongoing_cases; ?></h3>

                    <p>Ongoing Cases</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-spinner"></i>
                  </div>
                  <a href="reviewed_devices.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-4">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3><?php echo $completed_cases; ?></h3>

                    <p>Completed Cases</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-check-circle"></i>
                  </div>
                  <a href="completed_cases.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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