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

$wages = selectOne('wages', ['id' => $_GET['edit']])
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">EDIT PAYMENT</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Create New User</h6>
                </div>
                <div class="card-body">
                    <form class="user" autocomplete="off" method="POST" action="functions/business/update_payment.php">

                        <input type="text" value="<?php echo $wages['id'] ?>" name="wages" hidden>
                        <input type="text" value="<?php echo $_GET['staff_id'] ?>" name="staff_id" hidden>
                        <div class="form-group">
                            <label>Day</label>
                            <input type="date" name="day" id="day2" value="<?php echo $wages['day_worked'] ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Hours Worked</label>
                            <input type="text" name="rate" value="<?php echo $wages['hours_worked'] ?>" id="hours" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Wage</label>
                            <input type="text" name="wage" value="<?php echo $wages['rate'] ?>" id="wage2" class="form-control">
                        </div>
                        <div id="totalWage2"></div>
                        <script>
                            $(document).ready(function() {
                                $('#wage2').on("change blur", function() {
                                    var amount = $(this).val();
                                    $.ajax({
                                        url: "functions/system/converter.php",
                                        method: "POST",
                                        data: {
                                            amount: amount
                                        },
                                        success: function(data) {
                                            $('#wage2').val(data);
                                        }
                                    })
                                });

                                $('#hours, #wage2').on("change keyup paste click", function() {
                                    var rate = $('#hours').val();
                                    var wage = $('#wage2').val();
                                    $.ajax({
                                        url: "functions/system/ajax_functions/wage_calculation.php",
                                        method: "POST",
                                        data: {
                                            rate: rate,
                                            wage: wage,
                                        },
                                        success: function(data) {
                                            $('#totalWage2').html(data);
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