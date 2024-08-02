<?php
ob_start();
?>
<?php
// Include your database connection file here
require('../../common/config/db_connect.php');

// Initialize variable to store data
$deviceData = [];

// Query to join "devices" and "devices_parts" tables
$query = "
SELECT d.id as device_id, d.brand, d.model, d.category, dp.id as part_id, dp.part_name, dp.price
FROM devices d
INNER JOIN device_parts dp ON d.id = dp.device_id;
";

$statement = $pdo->prepare($query);
$statement->execute();
$deviceData = $statement->fetchAll(PDO::FETCH_ASSOC);

// Convert the data to JSON format
$jsonData = json_encode($deviceData);

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the JSON data
echo $jsonData;
?>
