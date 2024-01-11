<?php
include '../db/dbcon.php';
header('Content-Type: application/json');
if(isset($_GET['action'])){
    $action = $_GET['action'];
    $dataArray = array();
    extract($_POST);

    //Login
    if($action === 'login'){
        try{
            $signInResult = $auth->signInWithEmailAndPassword($email, $password);
            $data = $signInResult->data();
            
            $uuid = $data['localId'];
            $user = $auth->getUser($uuid);

            if($userType === 'student'){
        
                if($signInResult){
                    $email = $user->email;
                    $mobile = $user->phoneNumber;
                    $sql = "SELECT * FROM students WHERE uid = '$uuid'";
                    $stmt = mysqli_query($conn, $sql);
    
                    if (mysqli_num_rows($stmt) > 0) {
                        while($row = mysqli_fetch_assoc($stmt)) {   
                        $dataArray = array(
                            'id' => $row["id"],
                            'studentno' => $row["student_number"],
                            'firstname' => $row["firstname"],
                            'middlename' => $row["middlename"],
                            'lastname' => $row["lastname"],
                            'gender' => $row["gender"],
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
                        echo json_encode(array('error' => 'not functioning'));
                    }
                }
            }else if($userType === 'admin'){
                if($signInResult){
                    $email = $user->email;
                    $mobile = $user->phoneNumber;
                    $sql = "SELECT * FROM admins WHERE uid = '$uuid'";
                    $stmt = mysqli_query($conn, $sql);

                    if($stmt){
                        if (mysqli_num_rows($stmt) > 0) {
                        while($row = mysqli_fetch_assoc($stmt)) {   
                        $dataArray = array(
                            'id' => $row["id"],
                            'firstname' => $row["firstname"],
                            'middlename' => $row["middlename"],
                            'lastname' => $row["lastname"],
                            'gender' => $row["gender"],
                            'photo'=> $row["photo"],
                            'email' => $email,
                            'contact' => $mobile,
                            'userType' => $userType
                        );
                        echo json_encode($dataArray);
                        }
                        }else{
                            echo json_encode(array('error' => 'not functioning'));
                        }
                    }else{
                        echo json_encode(array('error' => 'Data Not Found.'));
                    }
                }
            }

        }catch(InvalidPassword $e){
            echo json_encode(array('error' => $e->getMessage()));
        }catch(UserNotFound $e){
            echo json_encode(array('error' => $e->getMessage()));
        }catch(AuthError $e){
            echo json_encode(array('error' => $e->getMessage()));
        }catch(\Exception $e){
            echo json_encode(array('error' => $e->getMessage()));
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
    mysqli_close($conn);
};

function fileUpload($file,$path){

    $uploadDir = $path.'/';
    $allowTypes = array('jpg','png','jpeg');
    $uploadedFile = '';

    if(!empty($file)){
        $fileName = basename($file['name']);
        $targetPath = $uploadDir . $fileName;
        $fileType = pathinfo($targetPath, PATHINFO_EXTENSION);

        if(in_array($fileType, $allowTypes)){
            if(move_uploaded_file($file["tmp_name"], '../'.$path.'/'.$fileName)){
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

function generateUid($email) {

    $timestamp = time();
    $combinedData = $timestamp . $email;
    $uid = sha1($combinedData);
    $uid = substr($uid, 0, 40);

    return $uid;
}

?>