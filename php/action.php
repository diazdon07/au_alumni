<?php
include '../db/dbcon.php';
session_start();
header('Content-Type: application/json');
if(isset($_GET['action'])){
    $action = $_GET['action'];
    $dataArray = array();
    $maxImg = 300 * 1024 * 1024;
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    extract($_POST);

    //Login
    if($action === 'login'){

            $md5Pass = md5($password);
            $sqlUser = 'SELECT * FROM `user` WHERE email = ? AND password = ?';
            $sqlCheck = $conn->prepare($sqlUser);
            $sqlCheck->bind_param('ss', $email, $md5Pass);

            if($sqlCheck->execute()){
                $result = $sqlCheck->get_result();

                if($result->num_rows > 0){
                    $data = $result->fetch_assoc();
                    $uuid = $data['uid'];
                    $email = $data['email'];
                    $mobile = $data['contact'];
                    $type = $data['type'];
                    $displayName = $data['displayName'];

                    if($data['status']!==0){
                        if($type === 1){
                            if($userType === 'student'){

                                $sql = "SELECT * FROM `students` WHERE uid = '$uuid'";
                                $stmt = mysqli_query($conn, $sql);
                
                                if (mysqli_num_rows($stmt) > 0) {
                                    while($row = mysqli_fetch_assoc($stmt)) {   
                                        if($row['imgType']!==null&&$row['imgData']!==null){
                                            $photo = 'data:'.$row['imgType'].';base64,'.base64_encode($row['imgData']);
                                        }else{
                                            $photo = null;
                                        }
                                        $_SESSION['user_info'] = array(
                                            'id' => $row['id'],
                                            'studentno' => $row['student_number'],
                                            'displayName' => $displayName,
                                            'firstname' => $row['firstname'],
                                            'middlename' => $row['middlename'],
                                            'lastname' => $row['lastname'],
                                            'gender' => $row['gender'],
                                            'address' => $row['address'],
                                            'city' => $row['city'],
                                            'course' => $row['course'],
                                            'batch' => $row['batch'],
                                            'photo' => $photo,
                                            'email' => $email,
                                            'contact' => $mobile,
                                            'employmentStatus' => $row['employment_status'],
                                            'position' => $row['position'],
                                            'company' => $row['company'],
                                            'createJob' => $row['job_create']
                                        );
                                        echo json_encode(array('success' => 'Account successfully login.'));
                                    }
                                }else{
                                    echo json_encode(array('error' => 'Invalid student profile data.'));
                                }
                            }else{
                                echo json_encode(array('error' => 'Login Failed.'));
                            }
                        }else{
                            if($userType === 'admin'){

                                $sql = "SELECT * FROM `admins` WHERE uid = '$uuid'";
                                $stmt = mysqli_query($conn, $sql);
            
                                if (mysqli_num_rows($stmt) > 0) {
                                    while($row = mysqli_fetch_assoc($stmt)) {   

                                        if($row['imgType']!==null&&$row['imgData']!==null){
                                            $photo = 'data:'.$row['imgType'].';base64,'.base64_encode($row['imgData']);
                                        }else{
                                            $photo = null;
                                        }

                                        $dataArray = array(
                                            'id' => $row['id'],
                                            'displayName' => $displayName,
                                            'firstname' => $row['firstname'],
                                            'middlename' => $row['middlename'],
                                            'lastname' => $row['lastname'],
                                            'gender' => $row['gender'],
                                            'photo'=> $photo,
                                            'email' => $email,
                                            'contact' => $mobile,
                                            'userType' => $type
                                        );
                                    echo json_encode($dataArray);
                                    }
                                }else{
                                    echo json_encode(array('error' => 'Invalid admin profile data.'));
                                }
                            }else{
                                echo json_encode(array('error' => 'Invalid Login.'));
                            }
                        }
                    }else{
                        echo json_encode(array('error' => 'Account Disable.'));
                    }
                }else{
                    echo json_encode(array('error' => 'Invalid email or password'));
                }
            }else{
                echo json_encode(array('error' => $sqlCheck->error));
            }

    }
    //Registration
    if($action === 'register'){
        $sqlStudent = 'INSERT INTO students (uid, student_number, firstname, middlename, lastname, course, batch, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $sqlAdmin = 'INSERT INTO admins (uid, firstname, middlename, lastname) VALUES (?, ?, ?, ?)';
        $sqlUser = 'INSERT INTO user (uid, displayName, email, password, contact, status, type) VALUES (?, ?, ?, ?, ?, ?, ?)';

        $uuid =  generateUid($email);

        $displayName = $lastname.', '.$firstname;
        $md5Pass = md5($password);
        $defaultStatus = 1;

        //boolean 0 = false and 1 = true
        $stmt_users = $conn->prepare($sqlUser);
        $stmt_users->bind_param('sssssss', $uuid, $displayName, $email, $md5Pass, $mobile, $defaultStatus, $type);

        if($stmt_users->execute()){
            if($userType === 'admin'){
                $stmt = $conn->prepare($sqlAdmin);
                $stmt->bind_param('ssss', $uuid, $firstname, $middlename, $lastname);
            }else{
                $stmt = $conn->prepare($sqlStudent);
                $stmt->bind_param('ssssssii', $uuid, $stdno, $firstname, $middlename, $lastname, $course, $batch, $gender);
            }
        
            if($stmt->execute()){
                mysqli_stmt_close($stmt);
                mysqli_stmt_close($stmt_users);
                echo json_encode('Your account approval is pending. Please wait for admin confirmation.');
            }else{
                echo json_encode(array('error' => '2nd statement preparation failed'));
            }
        }else{
            echo json_encode(array('error' => 'User statement preparation failed'));
        }
    }
    // create forum 
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
            $imgSize = $_FILES['image']['size'];
        
            if (!in_array($imgType, $allowedTypes)) {
                echo json_encode(array('error' => 'Invalid file type.'));
                exit;
            } elseif ($imgSize > $maxImg){
                echo json_encode(array('error' => 'File size exceeds the maximum allowed.'));
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
    // create comments
    if($action === 'Comments'){
        $stmt = $conn->prepare('INSERT INTO `forum_comments` (forumId, comments, studentId) VALUES (?,?,?)');
        $stmt->bind_param('sss', $topic, $comment, $id);
        if($stmt->execute()){
            echo json_encode('Comment posted.');
            mysqli_stmt_close($stmt);
        }
    }
    // create job
    if($action === 'createJob'){

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
    // update profile
    if($action === 'updateProfile'){

        $imgSet = "";
        $setPass = "";
        
        if(empty($position)){
            $position = null;
        }
        
        if(empty($company)){
            $company = null;
        }

        $values1 = array();
        $values2 = array();
        $dataType1 = "sssssssissss";
        $dataType2 = "ssss";

        $values1['firstname'] = $firstname;
        $values1['middlename'] = $middlename;
        $values1['lastname'] = $lastname;
        $values1['address'] = $address;
        $values1['city'] = $city;
        $values1['course'] = $course;
        $values1['batch'] = $batch;
        $values1['gender'] = $gender;
        $values1['employment_status'] = $employmentStatus;
        $values1['position'] = $position;
        $values1['company'] = $company;

        $values2['displayName'] = $displayName;
        $values2['email'] = $email;
        $values2['contact'] = $contact;

        if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
            $imgData = file_get_contents($_FILES['image']['tmp_name']);
            $imgType = $_FILES['image']['type'];
            $imgSize = $_FILES['image']['size'];
        
            if (!in_array($imgType, $allowedTypes)) {
                echo json_encode(array('error' => 'Invalid file type.'));
                exit;
            } elseif ($imgSize > $maxImg) {
                echo json_encode(array('error' => 'File size exceeds the maximum allowed.'));
                exit;
            }
            
            $imgSet = ",imgType = ?, imgData = ?";
            $dataType1 = "sssssssissssss";
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

        $stdCheck = 'SELECT * FROM `students` WHERE id = ?';
        $userCheck = 'SELECT * FROM `user` WHERE uid = ?';
        $sqlStudent = 'UPDATE `students` SET firstname = ?, middlename = ?, lastname = ?, address = ?, city = ?, course = ?, batch = ?, gender = ?, employment_status = ?, position = ?, company = ? '.$imgSet.' WHERE uid = ?';
        $sqlUser = 'UPDATE `user` SET displayName = ?, email = ?, contact = ? '.$setPass.' WHERE uid = ?';

        $stmtCheck = $conn->prepare($stdCheck);
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
                
                $stmtStudent = $conn->prepare($sqlStudent);
                $stmtStudent->bind_param($dataType1, ...array_values($values1));
                if($stmtStudent->execute()){
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
                                session_unset();
                                $_SESSION['user_info'] = array(
                                    'id' => strval($row['id']),
                                    'studentno' => $row['student_number'],
                                    'displayName' => $rowUser['displayName'],
                                    'firstname' => $row['firstname'],
                                    'middlename' => $row['middlename'],
                                    'lastname' => $row['lastname'],
                                    'gender' => $row['gender'],
                                    'address' => $row['address'],
                                    'city' => $row['city'],
                                    'course' => $row['course'],
                                    'batch' => $row['batch'],
                                    'photo' => $photo,
                                    'email' => $rowUser['email'],
                                    'contact' => $rowUser['contact'],
                                    'employmentStatus' => $row['employment_status'],
                                    'position' => $row['position'],
                                    'company' => $row['company'],
                                    'createJob' => $row['job_create']
                                );
                                echo json_encode('Verified');
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
                    echo json_encode(array('error' => 'Student update failed.'));
                }
            }else{
                echo json_encode(array('error' => 'No Student Data Found.'));
            }
        }else{
            echo json_encode(array('error' => 'Student check failed.'));
        }
        mysqli_stmt_close($stmtCheck);
        mysqli_stmt_close($stmtStudent);
        mysqli_stmt_close($stmntUser);
        mysqli_stmt_close($stmntUserCheck);
    }
    // event commit
    if($action === 'eventCommited'){
        $stmt = $conn->prepare('INSERT INTO `event_commits` (eventId, userId) VALUES (?,?)');
        $stmt->bind_param('ii', $id, $user);
        if($stmt->execute()){
            echo json_encode('Comment posted.');
            mysqli_stmt_close($stmt);
        }
    }
    // logout
    if($action === 'logout'){
        session_destroy();
        echo json_encode('User data Logout');
    }
    //Forget password
    if ($action === 'forgetPass') {
        $sqlUser = 'SELECT * FROM `user` WHERE email = ?';
        $sqlCheck = $conn->prepare($sqlUser);
        $sqlCheck->bind_param('s', $email);
        
        if ($sqlCheck->execute()) {
            $result = $sqlCheck->get_result();
            $sqlSystem = 'SELECT * FROM `system`';
            $getResult = $conn->query($sqlSystem);
            $systemdata = $getResult->fetch_assoc();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $uuid = $row['uid'];
                $nullPassword = md5($systemdata['defaultPassword']);
                $disable = 0;
                $sqlUpdate = 'UPDATE `user` SET password = ?, status = ? WHERE uid = ?';
                $sqlCheckUpdate = $conn->prepare($sqlUpdate);
                $sqlCheckUpdate->bind_param('sis', $nullPassword, $disable, $uuid);
                
                if ($sqlCheckUpdate->execute()) {
                    echo json_encode(array('success' => 'Please wait to acknowledge your request. Your account cannot be logged into for security reasons. You may contact the admin via email.'));
                } else {
                    echo json_encode(array('error' => 'Error executing update query.'));
                }
            } else {
                echo json_encode(array('error' => 'Your email is not registered in the database. Please input your correct email.'));
            }
        } else {
            echo json_encode(array('error' => 'Error executing select query.'));
        }
    }    
    
    mysqli_close($conn);
};

function generateUid($email) {

    $timestamp = time();
    $combinedData = $timestamp . $email;
    $uid = sha1($combinedData);
    $uid = substr($uid, 0, 40);

    return $uid;
}

?>