<?php

include("../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST['day']) && isset($_POST['rate']) && isset($_POST['wage']) && isset($_POST['staff_id'])) {
    // intialize post values
    $staffId = $_POST['staff_id'];
    $wage = floatval(preg_replace('/[^\d.]/', '', $_POST['wage']));
    $hoursWorked = $_POST['rate'];
    $day = $_POST['day'];

    $paymentData = [
        'day_worked' => $day,
        'rate' => $wage,
        'hours_worked' => $hoursWorked,
        'pay' => $wage * $hoursWorked,
        'staff_id' => $staffId
    ];
    $addPayment = insert('wages', $paymentData);
    if (!$addPayment) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not add Payment! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../wage_view.php?view=$staffId&message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Payment added successfully";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../wage_view.php?view=$staffId&message0=$randms");
        exit();
    }
} else {
    // fill in all appropraite data
    $_SESSION["feedback"] = "Fill in all Neccessary Fields";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../wage_view.php?view=$staffId&message1=$randms");
    exit();
}
