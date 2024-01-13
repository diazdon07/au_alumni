<?php
include '../db/dbcon.php';
$sql = "SELECT * FROM `test`";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array( 
            'id' => $row['id'],
            'imgData' => base64_encode($row['imgData']),
            'imgType' => $row['imgType']
        );
    }
    $result->free();
}

// Output alumni data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>