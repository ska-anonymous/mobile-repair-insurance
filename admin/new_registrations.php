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

    // perform the action(approve, reject) when the button is clicked
    require_once('../common/config/db_connect.php');

    if(isset($_GET['action_type']) && isset($_GET['action_id']) && isset($_GET['business_type'])){
        $action_type = $_GET['action_type'];
        $action_id = $_GET['action_id'];
        $business_type = $_GET['business_type'];

        if($business_type == 'insurance'){
            $table_name = 'insurances';
        }elseif($business_type == 'workshop'){
            $table_name = 'workshops';
        }

        if($action_type == 'approve'){
            $status = 'approved';
        }elseif($action_type == 'reject'){
            $status = 'rejected';
        }

        $sql = "UPDATE $table_name SET `status`='$status', `date_modified`= current_timestamp() WHERE id='$action_id'";

        $statment = $pdo->prepare($sql);
        $statment->execute();

        // now send mail to the admin of this business to update him about the above action performed by admin
        if($statment->rowCount()){
            // first get the admin email of this business from database
            $sql = "SELECT email FROM users WHERE role='admin' AND type='$business_type' AND business_id='$action_id'";
            $statment = $pdo->prepare($sql);
            $statment->execute();
            if($statment->rowCount()){
                $result = $statment->fetch(PDO::FETCH_ASSOC);
                $email = $result['email'];
                
                include('../common/phpmailer/send_mail.php');

                // make the url to the website
                $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
                $domain = $_SERVER['HTTP_HOST'];
                $port = $_SERVER['SERVER_PORT'] == '80' ? '' : ':' . $_SERVER['SERVER_PORT'];
                
                $url = $protocol . $domain . $port . '/dashboard/login';

                $subject = 'Updates from SPS';
                if($status == 'approved'){
                    $body = 'This is to inform you that your '.$business_type.' account has been approved by admin. now you can login at the website online. <br></br>
                        <a href="'.$url.'">Login Here</a>
                    ';
                }else{
                    $body = 'This is to inform you that your '.$business_type.' account has been rejected by admin.
                    ';
                }

                send_mail($mail, $email, $subject, $body);
            }

        }
    }
  ?>

  <?php
    // get data for new registerations

    $type = isset($_GET['type']) ? $_GET['type'] : null;
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    $data = [];
    if($type && $id){
        if($type == 'insurance'){
            $table_name = 'insurances';
        }elseif($type == 'workshop'){
            $table_name = 'workshops';
        } 
        $sql = "SELECT * FROM $table_name WHERE id=:id AND status='awaiting'";
        $statment = $pdo->prepare($sql);
        $statment->bindParam(':id', $id);
        $statment->execute();
        if($statment->rowCount()){
            $data[$type] = $statment->fetchAll(PDO::FETCH_ASSOC);
        }
    }else{
        $sql = "SELECT * FROM insurances WHERE status='awaiting'";
        $statment = $pdo->prepare($sql);
        $statment->execute();
        
        $insurances = $statment->fetchAll(PDO::FETCH_ASSOC);
        
        $data['insurance'] = $insurances;

        $sql = "SELECT * FROM workshops WHERE status='awaiting'";
        $statment = $pdo->prepare($sql);
        $statment->execute();
        
        $workshops = $statment->fetchAll(PDO::FETCH_ASSOC);

        $data['workshop'] = $workshops;
        
    }

?>

<style>
    table th, table td{
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
            <h1 class="m-0">New Registrations</h1>
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
                            <th>Type</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Postal Code</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($data['insurance'])){
                                foreach($data['insurance'] as $row){
                                    echo '
                                        <tr>
                                            <td>Insurance</td>
                                            <td>'.$row['name'].'</td>
                                            <td>'.$row['address'].'</td>
                                            <td>'.$row['country'].'</td>
                                            <td>'.$row['city'].'</td>
                                            <td>'.$row['postal_code'].'</td>
                                            <td>'.$row['email'].'</td>
                                            <td>'.$row['phone'].'</td>
                                            <td>'.date('d-M-Y', strtotime($row['date_created'])).'</td>
                                            <td>
                                                <a class="btn btn-sm btn-success" href="?action_type=approve&business_type=insurance&action_id='.$row['id'].'">Approve</a>
                                                <a class="btn btn-sm btn-danger mx-1" href="?action_type=reject&business_type=insurance&action_id='.$row['id'].'">Reject</a>
                                            </td>
                                        </tr>
                                    ';

                                }
                            }
                            if(isset($data['workshop'])){
                                foreach($data['workshop'] as $row){
                                    echo '
                                        <tr>
                                            <td>Workshop</td>
                                            <td>'.$row['name'].'</td>
                                            <td>'.$row['address'].'</td>
                                            <td>'.$row['country'].'</td>
                                            <td>'.$row['city'].'</td>
                                            <td>'.$row['postal_code'].'</td>
                                            <td>'.$row['email'].'</td>
                                            <td>'.$row['phone'].'</td>
                                            <td>'.date('d-M-Y', strtotime($row['date_created'])).'</td>
                                            <td>
                                                <a class="btn btn-sm btn-success" href="?action_type=approve&business_type=workshop&action_id='.$row['id'].'">Approve</a>
                                                <a class="btn btn-sm btn-danger mx-1" href="?action_type=reject&business_type=workshop&action_id='.$row['id'].'">Reject</a>
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