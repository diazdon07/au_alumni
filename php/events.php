<?php
include '../db/dbcon.php';
$sql = "SELECT * FROM `events`";
$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $date = new DateTime($row['schedule']);
        $events[] = array( 
            'date' => $date->format('Y-m-d'),
            'title' => $row['title'],
            'time' => $row['time'],
            'location' => $row['location'],
            'description' => $row['description'],
            'image' => $row['image'],
            'url' => $row['link']
        );
    }
}

// Output events data as JSON
header('Content-Type: application/json');
echo json_encode($events);

$conn->close();
?>