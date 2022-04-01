<?php

include('header.php');

if ($designation != "ADMIN") {
    $_SESSION["feedback"] = "You do not have permission to access this page!";
    $_SESSION["Lack_of_intfund_$randms"] = "10";
    // using js so as to aviod header error
?>
    <script>
        location.replace("index.php?message1=<?php echo $randms ?>");
    </script>
<?php
    exit();
}

$inventory = selectOne('inventory', ['id' => $_GET['edit']])
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">EDIT ITEM</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit New Item</h6>
                </div>
                <div class="card-body">
                    <form class="user" autocomplete="off" method="POST" action="functions/business/update_payment.php">

                        <input type="text" value="<?php echo $inventory['id'] ?>" name="inventory" hidden>
                        
                        <div class="form-group">
                            <label>Item Code</label>
                            <input type="code" name="code" id="code" class="form-control" readonly value="<?php echo $inventory['code'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Item Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $inventory['name'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="number" name="qty" min="1" class="form-control" value="<?php echo $inventory['quantity'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Unit Price</label>
                            <input type="text" name="price" id="price" class="form-control" value="<?php echo $inventory['unitPrice'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <textarea name="description" id="descriprion" class="form-control" cols="30" rows="10"><?php echo $inventory['description'] ?></textarea>
                        </div>
                        <div id="totalWage2"></div>
                        <script>
                            $(document).ready(function() {
                                $('#price').on("change blur", function() {
                                    var amount = $(this).val();
                                    $.ajax({
                                        url: "functions/system/converter.php",
                                        method: "POST",
                                        data: {
                                            amount: amount
                                        },
                                        success: function(data) {
                                            $('#price').val(data);
                                        }
                                    })
                                });

                                
                            });
                        </script>



                        <button type="reset" class="btn btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-flag"></i>
                            </span>
                            <span class="text">Reset</span>
                        </button>
                        <button type="submit" class="btn btn-success btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="text">Submit</span>
                        </button>

                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

<?php

include('footer.php');

?>