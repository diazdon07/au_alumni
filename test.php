<?php

function generateUid($email) {
    // Get the current timestamp
    $timestamp = time();

    // Combine timestamp and email
    $combinedData = $timestamp . $email;

    // Generate a unique hash based on the combined data
    $uid = sha1($combinedData);

    // Limit the length to 40 characters
    $uid = substr($uid, 0, 40);

    return $uid;
}

// Example of using the function with an email address
$email = "user@example.com";
$generatedUid = generateUid($email);
echo "Generated UID: $generatedUid";

?>