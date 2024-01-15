<?php
include '../../db/dbcon.php';
header('Content-Type: application/json');
if(isset($_GET['action'])){
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
        $stmt = $conn->prepare('DELETE FROM `courses` WHERE id = ?');
        $stmt->bind_param('i', $id);
        if($stmt){
            if($stmt->execute()){
                echo json_encode('Course successfully deleted.');
            }else{
                echo json_encode(array('error' => 'Statement error: ' . $stmt->error));
            }
            mysqli_stmt_close($stmt);
        }else{
            echo json_encode(array('error' => 'Database error: ' . $conn->error));
        }        
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
        if(isset($_FILES['image'])&&is_uploaded_file($_FILES['image']['tmp_name'])){
            $imgData = file_get_contents($_FILES['image']['tmp_name']);
            $imgType = $_FILES['image']['type'];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imgType, $allowedTypes)) {
                echo json_encode(array('error' => 'Invalid file type.'));
                exit;
            }

            $stmt = $conn->prepare('INSERT INTO `events` (title, imgData, imgType, schedule, timestart, timeend, location, description) VALUES (?,?,?,?,?,?,?,?)');
            $stmt->bind_param('ssssssss', $title, $imgData, $imgType, $schedule, $timeStart, $timeEnd, $location, $description);

            if($stmt->execute()){
                echo json_encode('Event successfully save.');
            }else{
                echo json_encode(array('error' => 'Event failed to save.'));
            }
            mysqli_stmt_close($stmt);
        }
    }

    // edit event
    if($action === 'EditEvent'){
        if($_FILES['image'] === null ){

            $stmt = $conn->prepare('UPDATE `events` SET title = ?, schedule = ?, timestart = ?, timeend = ?, location = ?, description = ? WHERE id = ?');
            $stmt->bind_param('ssssssi', $title, $schedule, $timeStart, $timeEnd, $location, $description, $id);

            if($stmt){
                if($stmt->execute()){
                    echo json_encode('Event successfully save.');
                }else{
                    echo json_encode(array('error' => 'Statement error: ' . $stmt->error));
                }
                mysqli_stmt_close($stmt);
            }else{
                echo json_encode(array('error' => 'Database error: ' . $conn->error));
            }
        }else{
            if(isset($_FILES['image'])&&is_uploaded_file($_FILES['image']['tmp_name'])){
                $imgData = file_get_contents($_FILES['image']['tmp_name']);
                $imgType = $_FILES['image']['type'];

                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($imgType, $allowedTypes)) {
                    echo json_encode(array('error' => 'Invalid file type.'));
                    exit;
                }

                $stmt = $conn->prepare('UPDATE `events` SET title = ?, imgData = ?, imgType = ?, schedule = ?, timestart = ?, timeend = ?, location = ?, description = ? WHERE id = ?');
                $stmt->bind_param('ssssssssi', $title, $imgData, $imgType, $schedule, $timeStart, $timeEnd, $location, $description, $id);

                if($stmt){
                    if($stmt->execute()){
                        echo json_encode('Event successfully save.');
                    }else{
                        echo json_encode(array('error' => 'Statement error: ' . $stmt->error));
                    }
                    mysqli_stmt_close($stmt);
                }else{
                    echo json_encode(array('error' => 'Database error: ' . $conn->error));
                }
            }
        }
    }
    
    // add gallery
    if($action === 'AddGallery'){
        if(isset($_FILES['image'])&&is_uploaded_file($_FILES['image']['tmp_name'])){
            $imgData = file_get_contents($_FILES['image']['tmp_name']);
            $imgType = $_FILES['image']['type'];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imgType, $allowedTypes)) {
                echo json_encode(array('error' => 'Invalid file type.'));
                exit;
            }

            $stmt = $conn->prepare('INSERT INTO `gallery` (title, imgData, imgType, description) VALUES (?,?,?,?)');
            $stmt->bind_param('ssss', $title, $imgData, $imgType, $description);

            if($stmt){
                if($stmt->execute()){
                    echo json_encode('Gallery successfully save.');
                }else{
                    echo json_encode(array('error' => 'Statement error: ' . $stmt->error));
                }
                mysqli_stmt_close($stmt);
            }else{
                echo json_encode(array('error' => 'Database error: ' . $conn->error));
            }
        }
    }

    // edit gallery
    if($action === 'EditGallery'){
        if($_FILES['image'] !== null){

            $stmt = $conn->prepare('UPDATE `gallery` SET title = ?, description = ? WHERE id = ?');
            $stmt->bind_param('ssi', $title, $description, $id);

            if($stmt){
                if($stmt->execute()){
                    echo json_encode('Gallery successfully save.');
                }else{
                    echo json_encode(array('error' => 'Statement error: ' . $stmt->error));
                }
                mysqli_stmt_close($stmt);
            }else{
                echo json_encode(array('error' => 'Database error: ' . $conn->error));
            }
        }else{
            if(isset($_FILES['image'])&&is_uploaded_file($_FILES['image']['tmp_name'])){
                $imgData = file_get_contents($_FILES['image']['tmp_name']);
                $imgType = $_FILES['image']['type'];

                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($imgType, $allowedTypes)) {
                    echo json_encode(array('error' => 'Invalid file type.'));
                    exit;
                }

                $stmt = $conn->prepare('UPDATE `gallery` SET title = ?, imgData = ?, imgType = ?, description = ? WHERE id = ?');
                $stmt->bind_param('ssssi', $title, $imgData, $imgType, $description, $id);

                if($stmt){
                    if($stmt->execute()){
                        echo json_encode('Gallery successfully save.');
                    }else{
                        echo json_encode(array('error' => 'Statement error: ' . $stmt->error));
                    }
                    mysqli_stmt_close($stmt);
                }else{
                    echo json_encode(array('error' => 'Database error: ' . $conn->error));
                }
            }
        }
    }

    // delete gallery
    if($action === 'DeleteGallery'){
        $stmt = $conn->prepare('DELETE FROM `gallery` WHERE id = ?');
        $stmt->bind_param('i', $id);
        if($stmt){
            if($stmt->execute()){
                echo json_encode('Gallery successfully deleted.');
            }else{
                echo json_encode(array('error' => 'Statement error: ' . $stmt->error));
            }
            mysqli_stmt_close($stmt);
        }else{
            echo json_encode(array('error' => 'Database error: ' . $conn->error));
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

    // edit job
    if($action === 'EditJob'){
        $stmt = $conn->prepare('UPDATE jobs SET job_title = ?, company = ?, link = ?, description = ? WHERE id = ?');
        $stmt->bind_param('ssssi', $job, $company, $link, $description, $id);
        if($stmt->execute()){
            echo json_encode('Job successfully edit.');
        }else{
            echo json_encode(array('error' => 'Job failed to edit.'));
        }
        mysqli_stmt_close($stmt);
    }
    
    // delete job
    if($action === 'DeleteJob'){
        $stmt = $conn->prepare('DELETE FROM `jobs` WHERE id = ?');
        $stmt->bind_param('i', $id);
        if($stmt){
            if($stmt->execute()){
                echo json_encode('Job successfully deleted.');
            }else{
                echo json_encode(array('error' => 'Statement error: ' . $stmt->error));
            }
            mysqli_stmt_close($stmt);
        }else{
            echo json_encode(array('error' => 'Database error: ' . $conn->error));
        }
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

   //alumni Check
    if($action === 'alumniCheck'){
        $stmt1 = $conn->prepare('SELECT * FROM `students` WHERE id = ?');
        $stmt1->bind_param('i', $id);
        $data = [];
        if($stmt1->execute()){
            $result1 = $stmt1->get_result();
            if($result1->num_rows > 0){
                $row1 = $result1->fetch_assoc();
                $uuid = $row1['uid'];
                $courseId = $row1['course'];
                $stmt2 = $conn->prepare('SELECT * FROM `user` WHERE uid = ?');
                $stmt2->bind_param('i', $uuid);
                if($stmt2->execute()){
                    $result2 = $stmt2->get_result();
                    if($result2->num_rows > 0){
                        $row2 = $result2->fetch_assoc();
                        $stmt3 = $conn->prepare('SELECT * FROM `courses` WHERE id = ?');
                        $stmt3->bind_param('i', $courseId);
                        if($stmt3->execute()){
                            $result3 = $stmt3->get_result();
                            if($result3->num_rows > 0){
                                $row3 = $result3->fetch_assoc();
                                if($row1["imgType"]!==null&&$row1["imgData"]!==null){
                                    $photo = 'data:'.$row1["imgType"].';base64,'.base64_encode($row1["imgData"]);
                                }else{
                                    $photo = null;
                                }
                                if($row1['gender']===0){
                                    $gender = 'Male';
                                }else{
                                    $gender = 'Female';
                                }
                                $dataArray = array(
                                    'userId' => $row2['id'],
                                    'stdNo' => $row1['student_number'],
                                    'firstname' => $row1['firstname'],
                                    'middlename' => $row1['middlename'],
                                    'lastname' => $row1['lastname'],
                                    'gender' => $gender,
                                    'address' => $row1['address'],
                                    'city' => $row1['city'],
                                    'course' => $row3['course'],
                                    'batch' => $row1['batch'],
                                    'photo' => $photo,
                                    'displayName' => $row2['displayName'],
                                    'email' => $row2['email'],
                                    'contact' => $row2['contact'],
                                    'status' => $row2['status']
                                );
                            }
                            echo json_encode($dataArray);
                        }else{
                            echo json_encode(array('error' => 'Course check failed.'));
                        }     
                    }
                }else{
                    echo json_encode(array('error' => 'User check failed.'));
                }
            }
        }else{
            echo json_encode(array('error' => 'Alumni check failed.'));
        }
        mysqli_stmt_close($stmt1);
        mysqli_stmt_close($stmt2);
        mysqli_stmt_close($stmt3);

    }

    //status Check
    if($action === 'statusCheck'){
        $stmt = $conn->prepare('UPDATE `user` SET status = ? WHERE id = ?');
        $stmt->bind_param('ii', $status, $id);
        if($stmt->execute()){
            echo json_encode('Account status successfully change.');
        }else{
            echo json_encode(array('error' => 'Account Status failed to change.'));
        }
    }
}
mysqli_close($conn);
?>