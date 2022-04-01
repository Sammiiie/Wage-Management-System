<?php

if (isset($_POST['unit_price']) && isset($_POST['buy_quantity'])) {
    $wage = floatval(preg_replace('/[^\d.]/', '', $_POST['unit_price']));
    $rate = floatval(preg_replace('/[^\d.]/', '', $_POST['buy_quantity']));

    // find the total wage
    $totalAmount = $wage * $rate;
?>

    <div class="col-lg-4 form-group">
        <label for="">Total Amount</label>
        <input type="text" class="form-control form-control-user" id="total_amount" name="total_amount" value="<?php echo number_format($totalAmount, 2) ?>" readonly required>
    </div>
    
<?php
}else{
    ?>
    <p>
        Kindly Fill all required Fields
    </p>
    <?php
}
