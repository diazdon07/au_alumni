<?php
include '../db/dbcon.php';

// Fetch courses from the database
$sql = "SELECT * FROM `courses`";
$result = $conn->query($sql);

$courses = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Store course ID and name in an associative array
        $courses[$row['id']] = $row['course'];
    }
}

// Fetch students' course and batch information
$sql = "SELECT * FROM `students` ORDER BY batch ASC LIMIT 7";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if the course ID exists in the courses array
        if (isset($courses[$row['course']])) {
            $data[] = array(
                'year' => $row['batch'], // Assuming 'batch' represents the year
                'course' => $courses[$row['course']], // Get the course name from the courses array
            );
        }
    }
}

// Aggregate data by year and course
$groupedData = array();
foreach ($data as $entry) {
    $year = $entry['year'];
    $course = $entry['course'];
    if (!isset($groupedData[$year])) {
        $groupedData[$year] = array();
    }
    if (!isset($groupedData[$year][$course])) {
        $groupedData[$year][$course] = 0;
    }
    $groupedData[$year][$course]++;
}

// Output aggregated data as JSON
$jsonData = array();
foreach ($groupedData as $year => $courses) {
    $dataEntry = array('year' => $year);
    foreach ($courses as $course => $count) {
        $dataEntry[$course] = $count;
    }
    $jsonData[] = $dataEntry;
}

header('Content-Type: application/json');
echo json_encode($jsonData);

$conn->close();
?>