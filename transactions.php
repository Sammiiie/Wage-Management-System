<?php

include('header.php');
$findStaff = selectOne('staff', ['id' => $userId]);
?>
<!-- map -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">TRANSACTIONS</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <?php //if ($designation == "ADMIN") { 
        ?>
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
                    </div>
                    <div style="float:right">
                        <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#exampleModal">
                            <span class="icon text-white-50">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <span class="text">New Transaction</span>
                        </a>
                    </div>
                    <!-- Modal -->
                    <form action="functions/business/create_transaction.php" method="post">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">New Transaction</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <input type="text" value="<?php echo $userId ?>" name="staff_id" hidden>
                                        <div class="row">
                                            <!-- <div class="col-lg-4"> -->
                                            <div class="col-lg-4 form-group">
                                                <label for="">Item Code</label>
                                                <input type="text" name="item_code" id="item_code" class="form-control">
                                            </div>

                                            <!-- </div> -->
                                        </div>

                                        <div id="items_details"></div>
                                        <div id="total_amounts"></div>

                                        <div class="row">
                                            <!-- <div class="col-lg-4"> -->
                                            <div class="col-lg-4 form-group">
                                                <label for="">VAT %</label>
                                                <input type="text" name="vat" id="vat" class="form-control">
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <label for="">Mode of Payment</label>
                                                <select name="mod" id="mod" class="form-control">
                                                    <option value="">------</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="POS">POS</option>
                                                    <option value="Transafer">Transfer</option>
                                                    <option value="Cash and POS">Cash and POS</option>
                                                    <option value="Transfer and Cash">Transfer and Cash</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4 form-group">
                                                <label for="">Amount Collected</label>
                                                <input type="text" name="amount_collected" id="amount_collected" class="form-control">
                                            </div>
                                            <div id="change_view"></div>
                                            <!-- </div> -->
                                        </div>
                                        <div class="form-group">
                                            <label for="">Customer Name</label>
                                            <input type="text" name="customer_name" id="customer_name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Customer Phone</label>
                                            <input type="text" name="customer_phone" id="customer_phone" class="form-control">
                                        </div>
                                        <div id="totalWage"></div>
                                        <script>
                                            $(document).ready(function() {
                                                $('#wage').on("change blur", function() {
                                                    var amount = $(this).val();
                                                    $.ajax({
                                                        url: "functions/system/converter.php",
                                                        method: "POST",
                                                        data: {
                                                            amount: amount
                                                        },
                                                        success: function(data) {
                                                            $('#wage').val(data);
                                                        }
                                                    })
                                                });

                                                $('#item_code').on("change keyup paste", function() {
                                                    var item = $('#item_code').val();
                                                    $.ajax({
                                                        url: "functions/system/ajax_functions/items_details.php",
                                                        method: "POST",
                                                        data: {
                                                            item: item,
                                                        },
                                                        success: function(data) {
                                                            $('#items_details').html(data);
                                                        }
                                                    })
                                                });



                                            });
                                        </script>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Confirm Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /modal ends here -->

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Reciept No</th>
                                    <th>Total Items</th>
                                    <th>Total Amount</th>
                                    <th>Amount Tendered</th>
                                    <th>Change Due</th>
                                    <th>Mode of Payment</th>
                                    <th>Staff</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Reciept No</th>
                                    <th>Total Items</th>
                                    <th>Total Amount</th>
                                    <th>Amount Tendered</th>
                                    <th>Change Due</th>
                                    <th>Mode of Payment</th>
                                    <th>Staff</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                if ($designation == "ADMIN") {
                                    $findTransactions = selectAll('transactions');
                                } else {
                                    $findTransactions = selectAll('transactions', ['staffId' => $userId]);
                                }

                                foreach ($findTransactions as $transactions) {
                                ?>
                                    <tr>
                                        <td><?php echo $transactions['ref'] ?></td>
                                        <td><?php echo $transactions['quantity'] ?></td>
                                        <td><?php echo $transactions['totalPrice'] ?></td>
                                        <td><?php echo $transactions['amountTendered'] ?></td>
                                        <td><?php echo $transactions['changeDue'] ?></td>
                                        <td><?php echo $transactions['modeOfPayment'] ?></td>
                                        <td><?php
                                            $findStaff = selectOne('staff', ['id' => $transactions['staffId']]);
                                            echo  $findStaff['firstname'] . " " . $findStaff['lastname'];
                                            ?></td>
                                        <td><?php echo $transactions['cust_name'] ?></td>
                                        <td><?php echo $transactions['transDate'] ?></td>
                                        <td><?php echo "Successful" ?></td>
                                        <td>
                                            <!-- <a href="edit_payment.php?edit=<?php //echo $transactions['id'] 
                                                                                ?>" class="btn btn-info">Edit</a> -->
                                            <!-- <a href="functions/business/delete_payment.php?delete=<?php //echo $transactions['id'] 
                                                                                                        ?>" class="btn btn-danger">Delete</a> -->
                                        </td>

                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php //} 
        ?>
    </div>
    <!-- Content Row -->


</div>
<!-- /.container-fluid -->


<?php

include('footer.php');

?>