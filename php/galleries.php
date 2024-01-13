<?php
include '../db/dbcon.php';
$sql = "SELECT * FROM `gallery`";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if($row["imgType"]!==null&&$row["imgData"]!==null){
            $photo = 'data:'.$row["imgType"].';base64,'.base64_encode($row["imgData"]);
        }else{
            $photo = null;
        }
        $data[] = array(
            'id' => $row['id'],
            'photo' => $photo,
            'description' => $row['description'],
            'title' => $row['title']
        );
    }
    $result->free();
}

// Output alumni data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>