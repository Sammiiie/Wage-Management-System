<?php
include("../../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
$userID = $_SESSION['userid'];

if (isset($_POST['oldpassword']) && isset($_POST['newpassword'])) {
    $oldPassword =  $_POST['oldpassword'];
    $password =  $_POST['newpassword'];
    $passkey = password_hash($password, PASSWORD_DEFAULT);
    $findOldPassword = selectOne('staff', ['id' => $userID]);
    $oldPasskey = $findOldPassword['passkey'];

    if (password_verify($oldPassword, $oldPasskey)) {
        $changePassword = update('staff', $userID, 'id', ['password' => $passkey]);
        if (!$changePassword) {
            $error = "Error: \n" . mysqli_error($connection); //checking for errors
            $_SESSION["feedback"] = "Sorry something went wrong could not change password! - $error";
            $_SESSION["Lack_of_intfund_$randms"] = "10";
            echo header("Location: ../../../profile.php?message1=$randms");
            exit();
        } else {
            $_SESSION["feedback"] = "Password Successfuly changed";
            $_SESSION["Lack_of_intfund_$randms"] = "10";
            echo header("Location: ../../../profile.php?message0=$randms");
            exit();
        }
    } else {
        $_SESSION["feedback"] = "This is not your old password! Kindly check and try again";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../../profile.php?message1=$randms");
        exit();
    }
}
