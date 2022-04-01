<?php

include("../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);

if (isset($_POST['name']) && isset($_POST['inventory'])) {
    // getting post values and 
    // initialize them
    $item = $_POST['inventory'];
    $name = $_POST['name'];
    $unit_price = floatval(preg_replace('/[^\d.]/', '', $_POST['price']));
    $quantity = $_POST['qty'];
    $code = $_POST['code'];

    $itemData = [
        'code' => $code,
        'name' => $name,
        'unitPrice' => $unit_price,
        'quantity' => $quantity,
        'description' => $_POST['description'],
    ];


    $updateItem = update('items', $item, 'id', $itemData);
    if (!$updateItem) {
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not update Item! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../inventory.php?message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Item Successfuly updated";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../inventory.php?message0=$randms");
        exit();
    }
}
