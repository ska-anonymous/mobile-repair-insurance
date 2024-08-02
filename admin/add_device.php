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
    // Include your database connection here
    require("../common/config/db_connect.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Fetch data from the form
        $brand = $_POST["brand"];
        $model = $_POST["model"];
        $category = $_POST["category"];

        // Prepare the SQL statement
        $sql = "INSERT INTO devices (brand, model, category) VALUES (:brand, :model, :category)";

        // Use prepared statements to prevent SQL injection
        $statement = $pdo->prepare($sql);

        // Bind values to placeholders
        $statement->bindParam(":brand", $brand, PDO::PARAM_STR);
        $statement->bindParam(":model", $model, PDO::PARAM_STR);
        $statement->bindParam(":category", $category, PDO::PARAM_STR);

        // Execute the prepared statement
        if ($statement->execute()) {
            // Data insertion was successful
            $success = true;
        } else {
            // Data insertion failed
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
                        <h1 class="m-0">Add New Device</h1>
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
                        <form action="" method="POST">
                            <!-- Brand Input -->
                            <div class="form-group">
                                <label for="brand">Brand:</label>
                                <input type="text" class="form-control" id="brand" name="brand" placeholder="Enter device brand" required>
                            </div>

                            <!-- Model Input -->
                            <div class="form-group">
                                <label for="model">Model:</label>
                                <input type="text" class="form-control" id="model" name="model" placeholder="Enter device model" required>
                            </div>

                            <!-- Category Input -->
                            <div class="form-group">
                                <label for="category">Category:</label>
                                <select class="form-control" id="category" name="category" required>
                                    <option value="" selected disabled>Select category</option>
                                    <option value="mobile">Mobile</option>
                                    <option value="tablet">Tablet</option>
                                    <option value="laptop">Laptop</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Add Device</button>
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
        if(isset($success)){
            if($success){
                echo '
                    <script>
                        toastr.success("Device Added Succesfully");
                    </script>
                ';
            }else{
                echo '
                    <script>
                        toastr.error("Failed to Add Device");
                    </script>
                ';
            }
        }
    ?>