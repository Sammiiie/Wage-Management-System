<?php

include('header.php');
$staffId = $_GET["view"];
$findStaff = selectOne('staff', ['id' => $staffId]);
?>
<!-- map -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Wages - <?php echo $findStaff['firstname'] . " " . $findStaff['lastname'] ?></h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <?php if ($designation == "ADMIN") { ?>
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div style="float:left">
                            <h6 class="m-0 font-weight-bold text-primary">Wages</h6>
                        </div>
                        <div style="float:right">
                            <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#exampleModal">
                                <span class="icon text-white-50">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <span class="text">Add New Payment</span>
                            </a>
                        </div>
                        <!-- Modal -->
                        <form action="functions/business/create_payment.php" method="post">
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add New Payment - <?php echo $findStaff['staff_id'] ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <input type="text" value="<?php echo $staffId ?>" name="staff_id" hidden>
                                            <div class="form-group">
                                                <label>Day</label>
                                                <input type="date" name="day" id="day" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Hours Worked</label>
                                                <input type="text" name="rate" id="rate" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Wage</label>
                                                <input type="text" name="wage" id="wage" class="form-control">
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

                                                    $('#rate, #wage').on("change keyup paste click", function() {
                                                        var rate = $('#rate').val();
                                                        var wage = $('#wage').val();
                                                        $.ajax({
                                                            url: "functions/system/ajax_functions/wage_calculation.php",
                                                            method: "POST",
                                                            data: {
                                                                rate: rate,
                                                                wage: wage,
                                                            },
                                                            success: function(data) {
                                                                $('#totalWage').html(data);
                                                            }
                                                        })
                                                    });
                                                });
                                            </script>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add Payment</button>
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
                                        <th>Day</th>
                                        <th>Hours Worked</th>
                                        <th>Rate</th>
                                        <th>Pay</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>

                                    <tr>
                                        <th>Day</th>
                                        <th>Hours Worked</th>
                                        <th>Rate</th>
                                        <th>Pay</th>
                                        <th></th>
                                    </tr>

                                </tfoot>
                                <tbody>
                                    <?php
                                    $findWages = selectAll('wages', ['staff_id' => $staffId]);
                                    foreach ($findWages as $wages) {
                                    ?>
                                        <tr>
                                            <td><?php echo $wages['day_worked'] ?></td>
                                            <td><?php echo $wages['hours_worked'] ?></td>
                                            <td><?php echo $wages['rate'] ?></td>
                                            <td><?php echo $wages['pay'] ?></td>
                                            <td>
                                                <a href="edit_payment.php?edit=<?php echo $wages['id'] ?>&staff_id=<?php echo $staffId ?>" class="btn btn-info">Edit</a>
                                                <a href="functions/business/delete_payment.php?delete=<?php echo $wages['id'] ?>&staff_id=<?php echo $staffId ?>" class="btn btn-danger">Delete</a>
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
        <?php } ?>
    </div>
    <!-- Content Row -->


</div>
<!-- /.container-fluid -->


<?php

include('footer.php');

?>