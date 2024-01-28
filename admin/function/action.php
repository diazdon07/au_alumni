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

      $values = array();
      $dataType = "ssss";
      $ss1 = "";
      $ss2 = "";
      $update1 = "";
      $update2 = "";
      $imgIns1 = "";
      $imgIns1 = "";
      $imgSet1 = "";
      $imgSet2 = "";

      $values['systemName'] = $systemName;
      $values['email'] = $email;
      $values['contact'] = $contact;
      $values['aboutcontent'] = $aboutContent;
        
      if(isset($_FILES['logo'])&&is_uploaded_file($_FILES['logo']['tmp_name'])){
        $imgData1 = file_get_contents($_FILES['logo']['tmp_name']);
        $imgType1 = $_FILES['logo']['type'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
          if (!in_array($imgType1, $allowedTypes)) {
            echo json_encode(array('error' => 'Invalid file1 type.'));
            exit;
        }

        $imgSet1 = ',logoData = ?, logoType = ?';
        $imgIns1 = ',logoData ,logoType';
        $values['logoData'] = $imgData1;
        $values['logoType'] = $imgType1;
        $ss1 = "ss";
        $update1 = ",?,?";
      }

      if(isset($_FILES['aboutImage'])&&is_uploaded_file($_FILES['aboutImage']['tmp_name'])){
        $imgData2 = file_get_contents($_FILES['aboutImage']['tmp_name']);
        $imgType2 = $_FILES['aboutImage']['type'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($imgType2, $allowedTypes)) {
          echo json_encode(array('error' => 'Invalid file2 type.'));
          exit;
        }

        $imgSet2 = ',aboutData = ?, aboutType = ?';
        $imgIns2 = ',aboutData ,aboutType';
        $values['aboutData'] = $imgData2;
        $values['aboutType'] = $imgType2;
        $ss2 = "ss";
        $update2 = ",?,?";
      }
        
      $result = mysqli_query($conn,'SELECT * FROM `system`');
      
        if(mysqli_num_rows($result) > 0){
          $values['id'] = $id;
          $stmt = $conn->prepare('UPDATE `system` SET systemname = ?, email = ?, contact = ?, aboutcontent = ? '.$imgSet1.$imgSet2.'  WHERE id = ?');
          $stmt->bind_param($dataType.$ss1.$ss2.'i', ...array_values($values));
        }else{
          $stmt = $conn->prepare('INSERT INTO `system` (systemname, email, contact, aboutcontent '.$imgIns1.$imgIns2.' ) VALUES (?,?,?,?'.$update1.$update2.')');
          $stmt->bind_param($dataType.$ss1.$ss2, ...array_values($values));
        }

        if($stmt->execute()){
          echo json_encode('System settings successfully save.');
        }else{
          echo json_encode(array('error' => 'System settings failed to save.'));
        }
        mysqli_stmt_close($stmt);
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

        $imgSet = "";
        $imgDataType = "";

        $values = array();
        $values['title'] = $title;
        $values['schedule'] = $schedule;
        $values['timeStart'] = $timeStart;
        $values['timeEnd'] = $timeEnd;
        $values['location'] = $location;
        $values['description'] = $description;
        $dataType = "ssssss";

        if(isset($_FILES['image'])&&is_uploaded_file($_FILES['image']['tmp_name'])){
            $imgData = file_get_contents($_FILES['image']['tmp_name']);
            $imgType = $_FILES['image']['type'];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imgType, $allowedTypes)) {
                echo json_encode(array('error' => 'Invalid file type.'));
                exit;
            }
            $imgSet = ', imgData = ?, imgType = ?';
            $values['aboutData'] = $imgData;
            $values['aboutType'] = $imgType;
            $imgDataType = "ss";
        }

        $values['id'] = $id;

        $stmt = $conn->prepare('UPDATE `events` SET title = ?, schedule = ?, timestart = ?, timeend = ?, location = ?, description = ? '.$imgSet.' WHERE id = ?');
        $stmt->bind_param($dataType.$imgDataType.'i', ...array_values($values));

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

        $imgSet = "";
        $imgDataType = "";

        $values = array();
        $values['title'] = $title;
        $values['description'] = $description;
        $dataType = "ss";

        if(isset($_FILES['image'])&&is_uploaded_file($_FILES['image']['tmp_name'])){
            $imgData = file_get_contents($_FILES['image']['tmp_name']);
            $imgType = $_FILES['image']['type'];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imgType, $allowedTypes)) {
                echo json_encode(array('error' => 'Invalid file type.'));
                exit;
            }
            $imgSet = ', imgData = ?, imgType = ?';
            $values['aboutData'] = $imgData;
            $values['aboutType'] = $imgType;
        }

        $values['id'] = $id;
        
        $stmt = $conn->prepare('UPDATE `gallery` SET title = ?, description = ?'.$imgSet.' WHERE id = ?');
        $stmt->bind_param($dataType.$imgDataType.'i', ...array_values($values));

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

        $partisCheck = isset($parttime) ? 1 : 0;
        $fullisCheck = isset($fulltime) ? 1 : 0;
        $contisCheck = isset($contractual) ? 1 : 0;

        $stmt = $conn->prepare('INSERT INTO `jobs` (job_title, company, link, description, shortdesc, parttime, fulltime, contractual) VALUES (?,?,?,?,?,?,?,?)');
        $stmt->bind_param('sssssiii', $job, $company, $link, $description, $shortdesc, $partisCheck, $fullisCheck, $contisCheck);

        if($stmt->execute()){
            echo json_encode('Job successfully save.');
        }else{
            echo json_encode(array('error' => 'Job failed to save.'));
        }
        mysqli_stmt_close($stmt);
    }

    // edit job
    if($action === 'EditJob'){
        $partisCheck = isset($parttime) ? 1 : 0;
        $fullisCheck = isset($fulltime) ? 1 : 0;
        $contisCheck = isset($contractual) ? 1 : 0;

        $stmt = $conn->prepare('UPDATE jobs SET job_title = ?, company = ?, link = ?, description = ?, shortdesc = ?, parttime = ?, fulltime = ?, contractual = ? WHERE id = ?');
        $stmt->bind_param('sssssiiii', $job, $company, $link, $description, $shortdesc, $partisCheck, $fullisCheck, $contisCheck, $id);
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

    // alumni Check
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

    // user account restriction
    if($action === 'statusCheck'){
        $stmt = $conn->prepare('UPDATE `user` SET status = ? WHERE id = ?');
        $stmt->bind_param('ii', $status, $id);
        if($stmt->execute()){
            echo json_encode('Account status successfully change.');
        }else{
            echo json_encode(array('error' => 'Account Status failed to change.'));
        }
    }

    // change Type
    if($action === 'changeType'){
        $stmt = $conn->prepare('UPDATE `user` SET type = ? WHERE id = ?');
        $stmt->bind_param('ii', $type, $id);
        if($stmt->execute()){
            echo json_encode('Account type successfully change.');
        }else{
            echo json_encode(array('error' => 'Account Status failed to change.'));
        }
    }
    
    // update profile
    if($action === 'updateProfile'){

        $imgSet = "";
        $setPass = "";

        $values1 = array();
        $values2 = array();
        $dataType1 = "sssss";
        $dataType2 = "ssss";

        $values1['firstname'] = $firstname;
        $values1['middlename'] = $middlename;
        $values1['lastname'] = $lastname;
        $values1['gender'] = $gender;

        $values2['displayName'] = $displayName;
        $values2['email'] = $email;
        $values2['contact'] = $contact;

        if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $imgData = file_get_contents($_FILES['image']['tmp_name']);
            $imgType = $_FILES['image']['type'];
        
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imgType, $allowedTypes)) {
                echo json_encode(array('error' => 'Invalid file type.'));
                exit;
            }
            
            $imgSet = ",imgType = ?, imgData = ?";
            $dataType1 = "sssssss";
            $values1['imgType'] = $imgType;
            $values1['imgData'] = $imgData;
        }
        // echo json_encode(array('error' => $dataType1.','.$arrayValues1));

        if($password !== null && $password !== '' && strlen($password) > 0){
            $setPass = ", password = ?";
            $dataType2 = "sssss";
            $values2['password'] = md5($password);
        }  

        // echo json_encode(array('error' => $dataType2.','.$arrayValues2));

        $admCheck = 'SELECT * FROM `admins` WHERE id = ?';
        $userCheck = 'SELECT * FROM `user` WHERE uid = ?';
        $sqlAdmin = 'UPDATE `admins` SET firstname = ?, middlename = ?, lastname = ?, gender = ? '.$imgSet.' WHERE uid = ?';
        $sqlUser = 'UPDATE `user` SET displayName = ?, email = ?, contact = ? '.$setPass.' WHERE uid = ?';

        $stmtCheck = $conn->prepare($admCheck);
        $stmtCheck->bind_param('i', $id);
        if($stmtCheck->execute()){
            $result = $stmtCheck->get_result();
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $uuid = $row['uid'];
                $values1['uid'] = $uuid;
                $arrayValues1 = implode((','), array_merge(array_values($values1)));

                $values2['uid'] = $uuid;
                $arrayValues2 = implode((','), array_merge(array_values($values2)));
                
                $stmtAdmin = $conn->prepare($sqlAdmin);
                $stmtAdmin->bind_param($dataType1, ...array_values($values1));
                if($stmtAdmin->execute()){
                    $stmntUser = $conn->prepare($sqlUser);
                    $stmntUser->bind_param($dataType2, ...array_values($values2));
                    if($stmntUser->execute()){
                        $stmntUserCheck = $conn->prepare($userCheck);
                        $stmntUserCheck->bind_param('s', $uuid);
                        if($stmntUserCheck->execute()){
                            $userResult = $stmntUserCheck->get_result();
                            if($userResult->num_rows > 0){
                                $rowUser = $userResult->fetch_assoc();
                                if($row['imgType']!==null&&$row['imgData']!==null){
                                    $photo = 'data:'.$row['imgType'].';base64,'.base64_encode($row['imgData']);
                                }else{
                                    $photo = null;
                                }
                                $dataArray = array(
                                    'id' => $row['id'],
                                    'displayName' => $rowUser['displayName'],
                                    'firstname' => $row['firstname'],
                                    'middlename' => $row['middlename'],
                                    'lastname' => $row['lastname'],
                                    'gender' => $row['gender'],
                                    'photo'=> $photo,
                                    'email' => $rowUser['email'],
                                    'contact' => $rowUser['contact'],
                                    'userType' => $rowUser['type']
                                );
                                echo json_encode($dataArray);
                            }else{
                                echo json_encode(array('error' => 'No User Data Found.'));
                            }
                        }else{
                            echo json_encode(array('error' => 'User check failed.'));
                        }
                    }else{
                        echo json_encode(array('error' => 'User update failed.'));
                    }
                }else{
                    echo json_encode(array('error' => 'Admin update failed.'));
                }
            }else{
                echo json_encode(array('error' => 'No Admin Data Found.'));
            }
        }else{
            echo json_encode(array('error' => 'Admin check failed.'));
        }
        mysqli_stmt_close($stmtCheck);
        mysqli_stmt_close($stmtAdmin);
        mysqli_stmt_close($stmntUser);
        mysqli_stmt_close($stmntUserCheck);
    }

    // Alumni Job Create Restriction
    if($action === 'alumniJobRestriction'){
        $stmt = $conn->prepare('UPDATE `students` SET job_create = ? WHERE id = ?');
        $stmt->bind_param('ii', $status, $id);
        if($stmt->execute()){
            echo json_encode('Account job create status successfully change.');
        }else{
            echo json_encode(array('error' => 'Account job create status failed to change.'));
        }
    }

    // Alumni Forum Create Restriction
    if($action === 'alumniForumRestriction'){
        $stmt = $conn->prepare('UPDATE `students` SET forum_create = ? WHERE id = ?');
        $stmt->bind_param('ii', $status, $id);
        if($stmt->execute()){
            echo json_encode('Account forum create status successfully change.');
        }else{
            echo json_encode(array('error' => 'Account forum create status failed to change.'));
        }
    }

    // Alumni Comment Restriction
    if($action === 'alumniCommentRestriction'){
        $stmt = $conn->prepare('UPDATE `students` SET comment_create = ? WHERE id = ?');
        $stmt->bind_param('ii', $status, $id);
        if($stmt->execute()){
            echo json_encode('Account comment status successfully change.');
        }else{
            echo json_encode(array('error' => 'Account comment status failed to change.'));
        }
    }

    // Job Approval
    if($action === 'jobApproval'){
        $stmt = $conn->prepare('UPDATE `jobs` SET status = ? WHERE id = ?');
        $stmt->bind_param('ii', $status, $id);
        if($stmt->execute()){
            echo json_encode('Job status successfully change.');
        }else{
            echo json_encode(array('error' => 'Job status failed to change.'));
        }
    }

    // Comments
    if($action === 'Comments'){
        $stmt = $conn->prepare('INSERT INTO `forum_comments` (forumId, comments, adminId) VALUES (?,?,?)');
        $stmt->bind_param('sss', $topic, $comment, $id);
        if($stmt->execute()){
            echo json_encode('Comment posted.');
            mysqli_stmt_close($stmt);
        }
    }

    // Create Forum
    if($action === 'Forum'){
        $values = array();
        $imgSet = "";
        $dataType = "sss";
        $stmQus = "?,?,?";
        $values['topic'] = $topic;
        $values['content'] = $content;
        $values['created'] = $created;

        if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $imgData = file_get_contents($_FILES['image']['tmp_name']);
            $imgType = $_FILES['image']['type'];
        
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imgType, $allowedTypes)) {
                echo json_encode(array('error' => 'Invalid file type.'));
                exit;
            }
            $imgSet = ",imgType, imgData";
            $dataType = "sssss";
            $stmQus = "?,?,?,?,?";
            $values['imgType'] = $imgType;
            $values['imgData'] = $imgData;
        }

        $stmt = $conn->prepare('INSERT INTO `forums` (topic, content, created '.$imgSet.') VALUES ('.$stmQus.')');
        $stmt->bind_param($dataType, ...array_values($values));
        if($stmt->execute()){
            echo json_encode('Topic posted.');
            mysqli_stmt_close($stmt);
        }

    }

    // Delete Forum
    if($action === 'DeleteForum'){
        $stmt = $conn->prepare('DELETE FROM `forums` WHERE id = ?');
        $stmt->bind_param('i', $id);
        if($stmt){
            if($stmt->execute()){
                echo json_encode('Forum successfully deleted.');
            }else{
                echo json_encode(array('error' => 'Statement error: ' . $stmt->error));
            }
            mysqli_stmt_close($stmt);
        }else{
            echo json_encode(array('error' => 'Database error: ' . $conn->error));
        }
    }

    // Delete User
    if($action === 'DeleteUser'){
        $stmtCheck = $conn->prepare('SELECT * FROM `user` WHERE id = ?');
        $stmtCheck->bind_param('i', $id);
        if($stmtCheck->execute()){
            $result = $stmtCheck->get_result();
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $uid = $row['uid'];

                if($type === '1'){
                    $sqlDelete = 'DELETE FROM `students` WHERE uid = ?';
                }else{
                    $sqlDelete = 'DELETE FROM `admins` WHERE uid = ?';
                }

                $stmtDelete = $conn->prepare($sqlDelete);
                $stmtDelete->bind_param('s', $uid);
                if($stmtDelete){
                    if($stmtDelete->execute()){
                        $stmtUser = $conn->prepare('DELETE FROM `user` WHERE uid = ?');
                        $stmtUser->bind_param('s', $uid);
                        if($stmtUser){
                            if($stmtUser->execute()){
                                echo json_encode('Account successfully deleted.');
                            }else{
                                echo json_encode(array('error' => 'Statement error: ' . $stmtUser->error));
                            }
                        }else{
                            echo json_encode(array('error' => 'Database error: ' . $conn->error));
                        }
                    }else{
                        echo json_encode(array('error' => 'Statement error: ' . $stmtDelete->error));
                    }
                }else{
                    echo json_encode(array('error' => 'Database error: ' . $conn->error));
                }
            }
        }
        mysqli_stmt_close($stmtCheck);
        mysqli_stmt_close($stmtDelete);
        mysqli_stmt_close($stmtUser);
    }
}
mysqli_close($conn);
?>