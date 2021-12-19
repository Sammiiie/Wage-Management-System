<?php
include("../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if(isset($_POST['staff_id']) && isset($_POST['firstname'])){
    // initiialize post data
    $firstname = $_POST['firstname'];
    $lastname =  $_POST['lastname'];
    $password = $_POST['passkey'];
    $staffId = $_POST['staff_id'];
    $findStaff = selectAll('staff', ['staff_id' => $staffId]);
    if($findStaff){
        $_SESSION["feedback"] = "Staff Id is in use by another user!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../users.php?message1=$randms");
        exit();
    }
    $designation = $_POST['designation'];

    $passkey = password_hash($password, PASSWORD_DEFAULT);

    $userData = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'password' => $passkey,
        'staff_id' => $staffId,
        'designation' => $designation
    ];
    $createUser =  insert('staff', $userData);
    if (!$createUser) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not create User! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../users.php?message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "User Successfuly created";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../users.php?message0=$randms");
        exit();
    }
}