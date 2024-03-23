<?php
include '../db/dbcon.php';
$sql = "SELECT * FROM `user`";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            'id' => $row['id'],
            'displayName' => $row['displayName'],
            'email' => $row['email'],
            'password' => $row['password'],
            'contact' => $row['contact'],
            'status' => $row['status'],
            'type' => $row['type'],
        );
    }
    $result->free();
}

// Output alumni data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>