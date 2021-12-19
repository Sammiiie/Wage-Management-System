<?php

include("../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST['staff_id']) && isset($_POST['type'])) {
    // getting post values and 
    // initialize them
    $staffId = $_POST['staff_id'];
    $complaintType = $_POST['type'];
    $message = $_POST['message'];

    $complaintData = [
        'staff_id' => $staffId,
        'compliant_type' => $complaintType,
        'message' => $message,
    ];
    $createComplain = insert('compliant', $complaintData);
    if (!$createComplain) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not submit complaint! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../index.php?view=$bank&message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Complaint Successfuly submitted";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../index.php?view=$bank&message0=$randms");
        exit();
    }
} else {
    $_SESSION["feedback"] = "Fill in all necessary info";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../index.php?view=$bank&message1=$randms");
    exit();
}
