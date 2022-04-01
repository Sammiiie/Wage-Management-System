<?php

include("../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_GET['delete'])) {
    // $staffId = $_GET['staff_id'];
    $deletePayment = delete('items', $_GET['delete'], 'id');
    if($deletePayment){
        $_SESSION["feedback"] = "Item Successfuly deleted";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../inventory.php?message0=$randms");
        exit();
    }else{
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not delete Item! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../inventory.php?message1=$randms");
        exit();
    }
}