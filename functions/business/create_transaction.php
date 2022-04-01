<?php

include("../connect.php");
session_start();
$digits = 7;
$randms = str_pad(rand(0, pow(10, $digits) - 1), $digits, '0', STR_PAD_LEFT);
$today = date('Y-m-d H:i:s');

if (isset($_POST['item']) && isset($_POST['buy_quantity']) && isset($_POST['unit_price']) && isset($_POST['item_code'])) {
    // intialize post values
    $name = $_POST['item_code'];
    $unit_price = floatval(preg_replace('/[^\d.]/', '', $_POST['unit_price']));
    $quantity = $_POST['buy_quantity'];
    $code = $_POST['item_code'];
    $totalAmount = $quantity * $unit_price;
    $findItem = selectOne('items', ['code' => $code]);
    if($findItem['quantity'] >= $quantity){
        // take item out of inventory record
        $newQuantity = $findItem['quantity'] - $quantity;
        $updateQuanity = update('items', $code, 'code', ['quantity' => $newQuantity]);
        // dd($updateQuanity);
    }else{
        $_SESSION["feedback"] = "Not enough Transactions!";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../transactions.php?message1=$randms");
        exit();
    }

    $transactionsData = [
        'ref' => $randms,
        'itemName' => $name,
        'itemCode' => $code,
        'description' => "Item Sold",
        'quantity' => $quantity,
        'unitPrice' => $unit_price,
        'totalPrice' => $totalAmount,
        'totalMoneySpent' => $_POST['amount_collected'] - $totalAmount,
        'amountTendered' => $_POST['amount_collected'],
        'discount_percentage' => 0,
        'discount_amount' => 0.00,
        'vatAmount' => 0.00,
        'vatPercentage' => 0.00,
        'changeDue' => $_POST['change_due'],
        'modeOfPayment' => $_POST['mod'],
        'cust_name' => $_POST['customer_name'],
        'cust_phone' => $_POST['customer_phone'],
        'transType' => 1,
        'staffId' => $_POST['staff_id'],
        'transDate' => $today,
    ];
    $addTransactions = insert('transactions', $transactionsData);
    if (!$addTransactions) {
        // update the item quantity because transaction failed
        $updateQuanity = update('items', 'code', $code, ['quantity' => $$findItem['quantity']]);
        $error = "Error: \n" . mysqli_error($connection); //checking for errors
        $_SESSION["feedback"] = "Sorry could not recordd Transaction! - $error";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../transactions.php?message1=$randms");
        exit();
    } else {
        $_SESSION["feedback"] = "Transaction recorded successfully";
        $_SESSION["Lack_of_intfund_$randms"] = "10";
        echo header("Location: ../../transactions.php?message0=$randms");
        exit();
    }
} else {
    // fill in all appropraite data
    $_SESSION["feedback"] = "Fill in all Neccessary Fields";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    echo header("Location: ../../transactions.php?message1=$randms");
    exit();
}
