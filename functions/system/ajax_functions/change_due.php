<?php

if (isset($_POST['total_amount']) && isset($_POST['amount_collected'])) {
    $wage = floatval(preg_replace('/[^\d.]/', '', $_POST['total_amount']));
    $rate = floatval(preg_replace('/[^\d.]/', '', $_POST['amount_collected']));

    // find the total wage
    $totalAmount = $rate - $wage;
?>

    <div class="col-lg-4 form-group">
        <label for="">Change Due</label>
        <input type="text" class="form-control form-control-user" id="change_due" name="change_due" value="<?php echo number_format($totalAmount, 2) ?>" readonly required>
    </div>
    
<?php
}else{
    ?>
    <p>
        Kindly Fill all required Fields
    </p>
    <?php
}
