<?php
include '../db/dbcon.php';
$sql = "SELECT * FROM `jobs`";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $result->free();
}

// Output alumni data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>