<?php
include("../../connect.php");

if (isset($_POST['item'])) {
    $findItem = selectOne('items', ['code' => $_POST['item']]);

    // find the total wage
    // $totalAmount = $wage * $rate;
?>

    <div class="row">
        <div class="col-lg-8 form-group">
            <label for="">Item</label>
            <input type="text" name="item" id="item" class="form-control" value="<?php echo $findItem['name'] ?>" required readonly>
        </div>
        <div class="col-lg-4 form-group">
            <label for="">Available Quantity</label>
            <input type="text" name="quantity" id="quanity" class="form-control" value="<?php echo $findItem['quantity'] ?>" required readonly>
        </div>
        <div class="col-lg-4 form-group">
            <label for="">Unit Price</label>
            <input type="text" name="unit_price" id="unit_price" class="form-control" value="<?php echo $findItem['unitPrice'] ?>" required readonly>
        </div>
        <div class="col-lg-4 form-group">
            <label for="">Quantity to buy</label>
            <input type="number" class="form-control" name="buy_quantity" id="buy_quantity" min="1" required>
        </div>
    </div>

<?php
} else {
?>
    <p>
        Kindly input item code
    </p>
<?php
}
?>
<script>
    $('#unit_price, #buy_quantity').on("change keyup paste", function() {
        var unit_price = $('#unit_price').val();
        var buy_quantity = $('#buy_quantity').val();
        $.ajax({
            url: "functions/system/ajax_functions/item_calculation.php",
            method: "POST",
            data: {
                unit_price: unit_price,
                buy_quantity: buy_quantity,
            },
            success: function(data) {
                $('#total_amounts').html(data);
            }
        })
    });

    $('#total_amount, #amount_collected').on("change keyup paste", function() {
        var total_amount = $('#total_amount').val();
        var amount_collected = $('#amount_collected').val();
        $.ajax({
            url: "functions/system/ajax_functions/change_due.php",
            method: "POST",
            data: {
                total_amount: total_amount,
                amount_collected: amount_collected,
            },
            success: function(data) {
                $('#change_view').html(data);
            }
        })
    });
</script>