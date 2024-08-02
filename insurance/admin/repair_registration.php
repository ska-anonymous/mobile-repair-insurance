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
    require('../../common/config/db_connect.php');
    ?>


    <?php
    // script for inserting data into dabsase repair registration table
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the customer ID and insurance ID directly
        $customer_id = $_POST["customer_id"];
        $insurance_id = $_SESSION['user']['business_id'];

        // Get device name based on the selected option
        if ($_POST["device_name"] == "other") {
            $device_name = $_POST["other_device_name"];
        } else {
            $device_name = $_POST["device_name"];
        }

        // Get category based on the selected option
        if ($_POST["category"] == "other") {
            $category = $_POST["other_category"];
        } else {
            $category = $_POST["category"];
        }

        // Get model based on the selected option
        if ($_POST["model"] == "other") {
            $model = $_POST["other_model"];
        } else {
            $model = $_POST["model"];
        }

        // Get damaged parts as an array if multiple options are selected
        $damaged_parts = isset($_POST["damaged_parts"]) ? $_POST["damaged_parts"] : [];
        $damaged_parts_string = implode('_$$_', $damaged_parts);
        // Get estimated price
        $estimated_price = $_POST["estimated_price"];

        // Now you can use these variables in your PHP logic as needed
        // For example, you can insert this data into your database or perform any other processing.
        // Insert data into the repair_registration table
        $sql = "INSERT INTO repair_registration (customer_id, insurance_id, device_name, category, model, damaged_parts, estimated_price, date_registered) 
        VALUES (:customer_id, :insurance_id, :device_name, :category, :model, :damaged_parts, :estimated_price, NOW())";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(':insurance_id', $insurance_id, PDO::PARAM_INT);
        $stmt->bindParam(':device_name', $device_name, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':model', $model, PDO::PARAM_STR);
        $stmt->bindParam(':damaged_parts', $damaged_parts_string, PDO::PARAM_STR);
        $stmt->bindParam(':estimated_price', $estimated_price, PDO::PARAM_STR);

        $stmt->execute();
        if ($stmt->rowCount()) {
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
                        <h1 class="m-0">Repair Registration</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Main Content Starts Here -->
                <!-- Form start -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Register a Device</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="" method="POST">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="customer_id">Customer:</label>
                                <select class="form-control" id="customer_id" name="customer_id" required>
                                    <!-- Populate this dropdown with customer data -->
                                    <option value="" selected disabled>Select a Customer</option>
                                    <?php
                                    $insurance_id = $_SESSION['user']['business_id'];
                                    $sql = "SELECT * FROM customers WHERE status = 'approved' AND insurance_id='$insurance_id'";
                                    $statement = $pdo->prepare($sql);
                                    $statement->execute();
                                    if ($statement->rowCount()) {
                                        $customers = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($customers as $row) {
                                            echo '<option value="' . $row['id'] . '">' . $row['name'] . ' (' . $row['email'] . ')' . '</option>';
                                        }
                                    }
                                    ?>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category">Category:</label>
                                <select class="form-control" id="category" name="category" required>
                                    <!-- Populate this dropdown with categories -->
                                </select>
                                <div id="otherCategory" style="display: none;">
                                    <input type="text" class="form-control" id="other_category" name="other_category" placeholder="Enter other category">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="device_name">Device Name:</label>
                                <select class="form-control" id="device_name" name="device_name">
                                    <!-- Populate this dropdown with device names -->
                                </select>
                                <div id="otherDeviceName" style="display: none;">
                                    <input type="text" class="form-control" id="other_device_name" name="other_device_name" placeholder="Enter other device name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="model">Model:</label>
                                <select class="form-control" id="model" name="model">
                                    <!-- Populate this dropdown with models -->
                                </select>
                                <div id="otherModel" style="display: none;">
                                    <input type="text" class="form-control" id="other_model" name="other_model" placeholder="Enter other model">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="damaged_parts">Damaged Parts (select multiple):</label>
                                <select multiple class="form-control" id="damaged_parts" name="damaged_parts[]">
                                </select>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="" id="new_damaged_part_input" placeholder="Part Name">
                                    <input class="form-control" type="number" name="" step="any" min="0" id="new_damaged_part_price" placeholder="Part Price">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-info" onclick="handleAddDamagePart()">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="estimated_price">Estimated Price:</label>
                                <input type="number" min="0" step="any" class="form-control" id="estimated_price" name="estimated_price" placeholder="Enter estimated price" required>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
                <!-- Form end -->

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
                echo '<script>
                    toastr.success("Registration Successfull");
                </script>';
            }else{
                echo '<script>
                    toastr.error("Registration Failed");
                </script>';

            }
        }
    ?>

    <!-- JavaScript for show/hide "Other" input fields -->
    <script>
        document.getElementById('device_name').addEventListener('change', function() {
            toggleOtherInput(this.value, 'otherDeviceName');
        });

        document.getElementById('category').addEventListener('change', function() {
            toggleOtherInput(this.value, 'otherCategory');
        });

        document.getElementById('model').addEventListener('change', function() {
            toggleOtherInput(this.value, 'otherModel');
        });

        // Function to toggle the "Other" input fields based on the selected value
        function toggleOtherInput(selectedValue, inputFieldId) {
            const otherInputField = document.getElementById(inputFieldId);
            if (selectedValue === 'other') {
                otherInputField.style.display = 'block';
            } else {
                otherInputField.style.display = 'none';
            }
        }

        document.getElementById('category').addEventListener('change', function() {
            const selectedCategory = this.value;
            populateDeviceNames(selectedCategory);
        });

        document.getElementById('device_name').addEventListener('change', function() {
            const selectedDeviceName = this.value;
            populateModels(selectedDeviceName);
        });

        document.getElementById('model').addEventListener('change', function() {
            const selectedModel = this.value;
            populateDamagedParts(selectedModel);
        });

        // calculate estimated price from parts selected
        document.getElementById('damaged_parts').addEventListener('change', (e) => {
            let optionsSelected = e.currentTarget.selectedOptions;
            let selectedPartsPricesArray = Array.from(optionsSelected).map(option => option.getAttribute('data-price'));

            let estimatePrice = 0;
            selectedPartsPricesArray.forEach(price => estimatePrice = estimatePrice + (price - 0));
            document.getElementById('estimated_price').value = estimatePrice;
        })

        // Define the URL of the PHP script
        const url = 'fetch_devices_data.php';

        // Create variables to store the fetched data
        let devicesData = [];

        // Function to populate device names dropdown based on the selected category
        function populateDeviceNames(selectedCategory) {
            const deviceNameSelect = document.getElementById('device_name');
            deviceNameSelect.innerHTML = ''; // Clear existing options
            deviceNameSelect.options.add(new Option('Select Device Name', '')); // Add a default option

            // Filter data based on the selected category
            const filteredData = devicesData.filter(item => item.category === selectedCategory);

            // Add the "Other" option without removing existing options
            deviceNameSelect.options.add(new Option('Other', 'other'));

            // Populate device names dropdown from the filtered data
            const uniqueDeviceNames = [...new Set(filteredData.map(item => item.brand))];
            uniqueDeviceNames.forEach(deviceName => {
                deviceNameSelect.options.add(new Option(deviceName, deviceName));
            });
        }

        // Function to populate models dropdown based on the selected device name
        function populateModels(selectedDeviceName) {
            const modelSelect = document.getElementById('model');
            modelSelect.innerHTML = ''; // Clear existing options
            modelSelect.options.add(new Option('Select Model', '')); // Add a default option

            // Get the selected category
            const selectedCategory = document.getElementById('category').value;

            // Filter data based on the selected category and device name
            const filteredData = devicesData.filter(item => item.category === selectedCategory && item.brand === selectedDeviceName);

            // Add the "Other" option without removing existing options
            modelSelect.options.add(new Option('Other', 'other'));

            // Populate models dropdown from the filtered data
            const uniqueModels = [...new Set(filteredData.map(item => item.model))];
            uniqueModels.forEach(model => {
                modelSelect.options.add(new Option(model, model));
            });
        }

        // Function to populate damaged parts dropdown based on the selected model
        function populateDamagedParts(selectedModel) {
            const damagedPartsSelect = document.getElementById('damaged_parts');
            damagedPartsSelect.innerHTML = ''; // Clear existing options

            // Get the selected device name
            const selectedDeviceName = document.getElementById('device_name').value;

            // Get the selected category
            const selectedCategory = document.getElementById('category').value;

            // Filter data based on the selected category, device name, and model
            const filteredData = devicesData.filter(item => item.category === selectedCategory && item.brand === selectedDeviceName && item.model === selectedModel);
            // Populate damaged parts checkboxes from the filtered data
            filteredData.forEach(item => {
                let option = new Option(item.part_name + ' (' + item.price + ')', item.part_name);
                option.setAttribute('data-price', item.price);
                damagedPartsSelect.options.add(option);
            });
        }

        const handleAddDamagePart = () => {
            let damagepartInput = document.getElementById('new_damaged_part_input');
            let damagePartPriceInput = document.getElementById('new_damaged_part_price');

            let newPartName = damagepartInput.value.trim();
            let newPartPrice = damagePartPriceInput.value.trim();

            if (newPartName.length == 0 || newPartPrice.length == 0) {
                return;
            }

            const damagedPartsSelect = document.getElementById('damaged_parts');
            let option = new Option(newPartName + '(' + newPartPrice + ')', newPartName);
            option.setAttribute('data-price', newPartPrice);
            option.selected = true;
            damagedPartsSelect.options.add(option);
            damagedPartsSelect.dispatchEvent(new Event('change'));
        }

        // Fetch the data and populate the arrays
        fetch(url)
            .then(response => {
                if (response.status === 200) {
                    return response.json();
                } else {
                    throw new Error('Failed to fetch data');
                }
            })
            .then(data => {
                devicesData = data; // Store the fetched data
                // Populate the initial category dropdown
                populateCategoryDropdown();
            })
            .catch(error => {
                console.error('Error:', error);
            });

        // Function to populate the initial category dropdown
        function populateCategoryDropdown() {
            const categorySelect = document.getElementById('category');
            categorySelect.innerHTML = ''; // Clear existing options
            categorySelect.options.add(new Option('Select Category', '')); // Add a default option

            // Add the "Other" option without removing existing options
            categorySelect.options.add(new Option('Other', 'other'));

            // Populate categories dropdown from the fetched data
            const uniqueCategories = [...new Set(devicesData.map(item => item.category))];
            uniqueCategories.forEach(category => {
                categorySelect.options.add(new Option(category, category));
            });
        }
    </script>