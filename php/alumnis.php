<?php
include '../db/dbcon.php';
$sql = "SELECT * FROM `students`";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if($row["imgType"]!==null&&$row["imgData"]!==null){
            $photo = 'data:'.$row["imgType"].';base64,'.base64_encode($row["imgData"]);
        }else{
            $photo = null;
        }
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
            'photo' => $photo,
            'jobC' => $row['job_create'],
            'forumC' => $row['forum_create'],
            'commentC' => $row['comment_create']
        );
    }
}

// Output alumni data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>