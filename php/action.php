<?php
include '../db/dbcon.php';
header('Content-Type: application/json');
if(isset($_GET['action'])){
    $action = $_GET['action'];
    $dataArray = array();
    extract($_POST);

    //Login
    if($action === 'login'){

            $md5Pass = md5($password);
            $sqlUser = "SELECT * FROM `user` WHERE email = ? AND password = ?";
            $sqlCheck = $conn->prepare($sqlUser);
            $sqlCheck->bind_param("ss", $email, $md5Pass);

            if($sqlCheck->execute()){
                $result = $sqlCheck->get_result();

                if($result->num_rows > 0){
                    $data = $result->fetch_assoc();
                    $uuid = $data['uid'];
                    $email = $data['email'];
                    $mobile = $data['contact'];
                    $type = $data['type'];

                    if($type === '0'){
                        if($userType === 'student'){

                            $sql = "SELECT * FROM `students` WHERE uid = '$uuid'";
                            $stmt = mysqli_query($conn, $sql);
            
                            if (mysqli_num_rows($stmt) > 0) {
                                while($row = mysqli_fetch_assoc($stmt)) {   
                                    if($row["gender"] === '0'){
                                        $gender = 'Male';
                                    }else{
                                        $gender = 'Female';
                                    }
                                    $dataArray = array(
                                        'id' => $row["id"],
                                        'studentno' => $row["student_number"],
                                        'firstname' => $row["firstname"],
                                        'middlename' => $row["middlename"],
                                        'lastname' => $row["lastname"],
                                        'gender' => $gender,
                                        'address' => $row["address"],
                                        'city' => $row["city"],
                                        'course' => $row["course"],
                                        'batch' => $row["batch"],
                                        'photo' => $row["photo"],
                                        'email' => $email,
                                        'contact' => $mobile
                                    );
                                    echo json_encode($dataArray);
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

                                    if($row["gender"] === '0'){
                                        $gender = 'Male';
                                    }else{
                                        $gender = 'Female';
                                    }

                                    if($row["imgType"]!==null&&$row["imgData"]!==null){
                                        $photo = 'data:'.$row["imgType"].';base64,'.base64_encode($row["imgData"]);
                                    }else{
                                        $photo = null;
                                    }

                                    $dataArray = array(
                                        'id' => $row["id"],
                                        'firstname' => $row["firstname"],
                                        'middlename' => $row["middlename"],
                                        'lastname' => $row["lastname"],
                                        'gender' => $gender,
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
                    echo json_encode(array('error' => 'Invalid email or password'));
                }
            }else{
                echo json_encode(array('error' => $sqlCheck->error));
            }

    }
    //Registration
    if($action === 'register'){
        $sqlStudent = "INSERT INTO students (uid, student_number, firstname, middlename, lastname, course, batch) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $sqlAdmin = "INSERT INTO admins (uid, firstname, middlename, lastname) VALUES (?, ?, ?, ?)";
        $sqlUser = "INSERT INTO user (uid, displayName, email, password, contact, status) VALUES (?, ?, ?, ?, ?, ?)";

        $uuid =  generateUid($email);

        $displayName = $lastname.", ".$firstname;
        $md5Pass = md5($password);
        $phone = "+63".$mobile;
        $defaultStatus = "False";

        //boolean 0 = false and 1 = true
        $stmt_users = $conn->prepare($sqlUser);
        $stmt_users->bind_param("ssssss", $uuid, $displayName, $email, $md5Pass, $phone, $defaultStatus);

        if($stmt_users->execute()){
            if($userType === 'admin'){
                $stmt = $conn->prepare($sqlAdmin);
                $stmt->bind_param("ssss", $uuid, $firstname, $middlename, $lastname);
            }else{
                $stmt = $conn->prepare($sqlStudent);
                $stmt->bind_param("ssssssi", $uuid, $stdno, $firstname, $middlename, $lastname, $course, $batch);
            }
        
            if($stmt->execute()){
                $dataArray = array(
                'email' => $email,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'contact' => $phone,
                'userType' => $userType
                );
                echo json_encode($dataArray);
                mysqli_stmt_close($stmt);
                mysqli_stmt_close($stmt_users);
            }else{
                echo json_encode(array('error' => '2nd statement preparation failed'));
            }
        }else{
            echo json_encode(array('error' => 'User statement preparation failed'));
        }
    }
    // create forum
    if($action === 'Forum'){
        $fileData1 = fileUpload($_FILES['file1'],'image');
        if($fileData1 === 0){
            echo json_encode(array('error'=>'error image'));
        }else{
            $stmt = $conn->prepare('INSERT INTO `forums` (topic, img, content, created) VALUES (?,?,?,?)');
            $stmt->bind_param('ssss', $topic, $fileData1, $content, $create);
            if($stmt->execute()){
                echo json_encode('Topic posted.');
                mysqli_stmt_close($stmt);
            }
        }
    }
    // create comments
    if($action === 'Comments'){
        echo json_encode(array('error'=> $create ));
        // $stmt = $conn->prepare('INSERT INTO `forum_comments` (forumId, comments, userId) VALUES (?,?,?)');
        // $stmt->bind_param('sss', $topic, $content, $create);
        // if($stmt->execute()){
        //     echo json_encode('Comment posted.');
        //     mysqli_stmt_close($stmt);
        // }
    }
    if($action === 'test'){
        if(isset($_FILES['userImage'])&&is_uploaded_file($_FILES['userImage']['tmp_name'])){
            $imgData = file_get_contents($_FILES['userImage']['tmp_name']);
            $imgType = $_FILES['userImage']['type'];

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($imgType, $allowedTypes)) {
                echo json_encode(array('error' => 'Invalid file type.'));
                exit;
            }

            $sql = "INSERT INTO `test` (imgType, imgData) VALUES(?, ?)";
            $statement = $conn->prepare($sql);

            if ($statement) {
                $statement->bind_param('ss', $imgType, $imgData);
                if ($statement->execute()) {
                    echo json_encode('Successful Upload.');
                } else {
                    echo json_encode(array('error' => 'Statement error: ' . $statement->error));
                }
                $statement->close();
            } else {
                echo json_encode(array('error' => 'Database error: ' . $conn->error));
            }
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