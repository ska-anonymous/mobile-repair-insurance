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
  // get data from customers
  require('../common/config/db_connect.php');

  $sql = "SELECT * FROM customers";
  $statement = $pdo->prepare($sql);
  $statement->execute();

  $customers = [];
  if ($statement->rowCount()) {
    $customers = $statement->fetchAll(PDO::FETCH_ASSOC);
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
            <h1 class="m-0">Total Customers</h1>
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
                  <th>City</th>
                  <th>Country</th>
                  <th>Postal Code</th>
                  <th>Claim Number</th>
                  <th>Deductible</th>
                  <th>Registration Date</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($customers as $row) {
                  echo '
                      <tr>
                        <td>'.$row['name'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['phone'].'</td>
                        <td>'.$row['address'].'</td>
                        <td>'.$row['city'].'</td>
                        <td>'.$row['country'].'</td>
                        <td>'.$row['postal_code'].'</td>
                        <td>'.$row['claim_number'].'</td>
                        <td>'.$row['deductible'].'</td>
                        <td>'.date('d-M-Y', strtotime($row['date_registered'])).'</td>
                      </tr>
                    ';
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