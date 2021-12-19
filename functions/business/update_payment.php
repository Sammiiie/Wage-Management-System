<?php

include("../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST['day']) && isset($_POST['wages'])) {
    // getting post values and 
    // initialize them
    $staffId = $_POST['staff_id'];
    $wages = $_POST['wages'];
    $wage = floatval(preg_replace('/[^\d.]/', '', $_POST['wage']));
    $hoursWorked = $_POST['rate'];
    $day = $_POST['day'];

    $paymentData = [
        'day_worked' => $day,
        'rate' => $wage,
        'hours_worked' => $hoursWorked,
        'pay' => $wage * $hoursWorked
    ];


    $updateWages = update('wages', $wages, 'id', $paymentData);
    if (!$updateWages) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not update Payment! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../wage_view.php?view=$staffId&message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Payment Successfuly updated";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../wage_view.php?view=$staffId&message0=$randms");
        exit();
    }
}
