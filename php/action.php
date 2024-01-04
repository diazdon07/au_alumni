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
        $sqlStudent = "UPDATE students SET uid = ?, firstname = ?, middlename = ?, lastname = ?, course = ?, batch = ? WHERE id = ?";
        $sqlAdmin = "INSERT INTO admins (uid, firstname, middlename, lastname) VALUES (?, ?, ?, ?)";

        $stmt_users = $auth->createUser([
            'email' => $email,
            'password' => $password,
            'phoneNumber' => '+63'.$mobile,
            'displayName' => $firstname.' '.$lastname
        ]);
        
        $uuid = $stmt_users->uid;

        if($stmt_users){
            if($userType === 'admin'){
                $stmt = $conn->prepare($sqlAdmin);
                $stmt->bind_param("ssss", $uuid, $firstname, $middlename, $lastname);
            }else{
                $stmt = $conn->prepare($sqlStudent);
                $stmt->bind_param("ssssssi", $uuid, $firstname, $middlename, $lastname, $course, $batch ,$id);
            }
        
            if($stmt->execute()){
                $dataArray = array(
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'contact' => '+63'.$mobile,
                'userType' => $userType
                );
                echo json_encode($dataArray);
                mysqli_stmt_close($stmt);
            }else{
                echo json_encode(array('error' => '2nd statement preparation failed'));
            }
        }else{
            echo json_encode(array('error' => 'User statement preparation failed'));
        }
    }
    mysqli_close($conn);
};
?>