<?php
    // use Kreait\Firebase\Factory;
    // use Kreait\Firebase\Contract\Auth;
    // use Kreait\Firebase\Auth\SignInResult\SignInResult;
    // $server = "sql104.infinityfree.com";
    // $username = "if0_35651842";
    // $passworddb = "Z8QMebulb1";
    // $dbname = "if0_35651842_au_cite_alumni";

    $server = "localhost";
    $username = "root";
    $passworddb = "";
    $dbname = "au_cite_alumni";
    
    $conn = mysqli_connect($server, $username, $passworddb, $dbname);

    if(!$conn){
        die("Connection Failed:".mysqli_connect_error());
    }
    
    // require __DIR__.'../vendor/autoload.php';

    // $factory = (new Factory)
    // ->withProjectId('capstone-alumni')
    // ->withServiceAccount(__DIR__.'/firebase_service_key.json')
    // ->withDatabaseUri('https://capstone-alumni-default-rtdb.asia-southeast1.firebasedatabase.app');

    // $auth = $factory->createAuth();
    // $users = $auth->listUsers();
?>