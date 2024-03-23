<?php
include '../db/dbcon.php';
$sql = "SELECT * FROM `system`";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if($row["logoType"]!==null&&$row["logoData"]!==null){
            $logo = 'data:'.$row["logoType"].';base64,'.base64_encode($row["logoData"]);
        }else{
            $logo = null;
        }
        if($row["aboutType"]!==null&&$row["aboutData"]!==null){
            $aboutPhoto = 'data:'.$row["aboutType"].';base64,'.base64_encode($row["aboutData"]);
        }else{
            $aboutPhoto = null;
        }
        $data[] = array(
            'id' => $row['id'],
            'systemname' => $row['systemname'],
            'email' => $row['email'],
            'contact' => $row['contact'],
            'logo' => $logo,
            'aboutimage' => $aboutPhoto,
            'aboutcontent' => $row['aboutcontent'],
            'systemDefaultPass' => $row['defaultPassword']
        );
    }
    $result->free();
}

// Output alumni data as JSON
header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>