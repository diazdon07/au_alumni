<?php
include '../../db/dbcon.php';
header('Content-Type: application/json');
if(isset($_GET['action']) || isset($_FILES['file1']) || isset($_FILES['file2'])){
    $action = $_GET['action'];
    $dataArray = array();
    extract($_POST);

    // add courses
    if($action === 'AddCourse'){
        $stmt = $conn->prepare('INSERT INTO courses (course) VALUES (?)');
        $stmt->bind_param('s', $course);
        if($stmt->execute()){
            echo json_encode('Course successfully save.');
        }else{
            echo json_encode(array('error' => 'Course failed to save.'));
        }
        mysqli_stmt_close($stmt);
    }
    // edit courses
    if($action === 'EditCourse'){
        $stmt = $conn->prepare('UPDATE courses SET course = ? WHERE id = ?');
        $stmt->bind_param('si', $course, $id);
        if($stmt->execute()){
            echo json_encode('Course successfully edit.');
        }else{
            echo json_encode(array('error' => 'Course failed to edit.'));
        }
        mysqli_stmt_close($stmt);
    }
    // delete courses
    if($action === 'DeleteCourse'){
        
    }
    // save and update system
    if($action === 'System'){
        $fileData1 = fileUpload($_FILES['file1'],'image');
        $fileData2 = fileUpload($_FILES['file2'],'image');
        if($fileData1 === 0 && $fileData2 === 0){
            echo json_encode(array('error'=>'error image'));
        }else{
            $result = mysqli_query($conn,'SELECT * FROM `system`');
            if(mysqli_num_rows($result) > 0){
                $stmt = $conn->prepare('UPDATE `system` SET systemname = ?, email = ?, contact = ?, logo = ?, aboutimage = ?, aboutcontent = ? WHERE id = ?');
                $stmt->bind_param('ssssssi', $systemName, $email, $contact, $fileData1, $fileData2, $aboutContent, $id);
            }else{
                $stmt = $conn->prepare('INSERT INTO `system` (systemname, email, contact, logo, aboutimage, aboutcontent) VALUES (?,?,?,?,?,?)');
                $stmt->bind_param('ssssss', $systemName, $email, $contact, $fileData1, $fileData2, $aboutContent);
            }

            if($stmt->execute()){
                echo json_encode('System settings successfully save.');
            }else{
                echo json_encode(array('error' => 'System settings failed to save.'));
            }
            mysqli_stmt_close($stmt);
        }
    }

    // add event
    if($action === 'AddEvent'){
        $fileData1 = fileUpload($_FILES['file1'],'image');
        if($fileData1 === 0){
            echo json_encode(array('error'=>'error image'));
        }else{
            $stmt = $conn->prepare('INSERT INTO `events` (title, image, schedule, location, description) VALUES (?,?,?,?,?)');
            $stmt->bind_param('sssss', $title, $fileData1, $schedule, $location, $description);

            if($stmt->execute()){
                echo json_encode('Event successfully save.');
            }else{
                echo json_encode(array('error' => 'Event failed to save.'));
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    // add gallery
    if($action === 'AddGallery'){
        $fileData1 = fileUpload($_FILES['file1'],'upload');
        if($fileData1 === 0){
            echo json_encode(array('error'=>'error image'));
        }else{
            $stmt = $conn->prepare('INSERT INTO `gallery` (title, image, description) VALUES (?,?,?)');
            $stmt->bind_param('sss', $title, $fileData1, $description);

            if($stmt->execute()){
                echo json_encode('Gallery successfully save.');
            }else{
                echo json_encode(array('error' => 'Gallery failed to save.'));
            }
            mysqli_stmt_close($stmt);
        }
    }

    // add job
    if($action === 'AddJob'){
        $stmt = $conn->prepare('INSERT INTO `jobs` (job_title, company, link, description) VALUES (?,?,?,?)');
        $stmt->bind_param('ssss', $job, $company, $link, $description);

        if($stmt->execute()){
            echo json_encode('Job successfully save.');
        }else{
            echo json_encode(array('error' => 'Job failed to save.'));
        }
        mysqli_stmt_close($stmt);
    }

    // add forum
    if($action === 'AddForum'){
        $stmt = $conn->prepare('INSERT INTO `forums` (topic, description, created) VALUES (?,?,?)');
        $stmt->bind_param('sss', $topic, $description, $creator);

        if($stmt->execute()){
            echo json_encode('Job successfully save.');
        }else{
            echo json_encode(array('error' => 'Job failed to save.'));
        }
        mysqli_stmt_close($stmt);
    }

    // add alumni
    if($action === 'AddAlumni'){

        $result = mysqli_query($conn,'SELECT * FROM `students` WHERE student_number = '.$stdNo);
        if(mysqli_num_rows($result) > 0){
            echo json_encode(array('error','Student Number: '.$stdNo.' already save.'));
        }else{
            $stmt = $conn->prepare('INSERT INTO `students` (student_number) VALUES (?)');
            $stmt->bind_param('s', $stdNo);

            if($stmt->execute()){
                echo json_encode('Student Number successfully save.');
            }else{
                echo json_encode(array('error' => 'Student Number failed to save.'));
            }
            mysqli_stmt_close($stmt);
        }

        
    }
}
mysqli_close($conn);

function fileUpload($file,$path){

    $uploadDir = $path.'/';
    $allowTypes = array('jpg','png','jpeg');
    $uploadedFile = '';

    if(!empty($file)){
        $fileName = basename($file['name']);
        $targetPath = $uploadDir . $fileName;
        $fileType = pathinfo($targetPath, PATHINFO_EXTENSION);

        if(in_array($fileType, $allowTypes)){
            if(move_uploaded_file($file["tmp_name"], '../../'.$path.'/'.$fileName)){
                $uploadedFile = $fileName;
                return $uploadedFile;
            }else{
                return 0;
            }
        }
    }else{
        return null;
    }
}
?>