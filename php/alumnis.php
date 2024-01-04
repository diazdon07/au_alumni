<?php
include '../db/dbcon.php';
$sql = "SELECT * FROM `students`";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = array( 
            'id' => $row['id'],
            'student_number' => $row['student_number'],
            'firstname' => $row['firstname'],
            'middlename' => $row['middlename'],
            'lastname' => $row['lastname'],
            'gender' => $row['gender'],
            'address' => $row['address'],
            'city' => $row['city'],
            'course' => $row['course'],
            'batch' => $row['batch'],
            'photo' => $row['photo']
        );
    }
}

// Output alumni data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>