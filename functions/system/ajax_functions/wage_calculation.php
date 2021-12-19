<?php

if (isset($_POST['wage']) && isset($_POST['rate'])) {
    $wage = floatval(preg_replace('/[^\d.]/', '', $_POST['wage']));
    $rate = floatval(preg_replace('/[^\d.]/', '', $_POST['rate']));

    // find the total wage
    $totalAmount = $wage * $rate;
?>

    <div class="form-group">
        <label for="">Total Wage</label>
        <input type="text" class="form-control form-control-user" name="total_wage" value="<?php echo number_format($totalAmount, 2) ?>" readonly required>
    </div>
    
<?php
}else{
    ?>
    <p>
        Kindly Fill all required Fields
    </p>
    <?php
}
