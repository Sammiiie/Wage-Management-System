<?php

include('header.php');

?>
<!-- map -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">
        <?php if ($designation == "ADMIN") { ?>
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Staff Wages</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Staff ID</th>
                                        <th>Total Hours</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>

                                    <tr>
                                        <th>Name</th>
                                        <th>Staff ID</th>
                                        <th>Total Hours</th>
                                        <th></th>
                                    </tr>

                                </tfoot>
                                <tbody>
                                    <?php
                                    $finduser = selectAll('staff');
                                    foreach ($finduser as $user) {
                                    ?>
                                        <tr>
                                            <td><?php echo $user['firstname'] . " " . $user['lastname'] ?></td>
                                            <td><?php echo $user['staff_id'] ?></td>
                                            <td>
                                                <?php
                                                echo $totalHours = sumRecordsWhere('hours_worked', 'wages', $user['id']);
                                                ?>
                                            </td>
                                            <td>
                                                <a href="wage_view.php?view=<?php echo $user['id'] ?>" class="btn btn-info btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                    <span class="text">View</span>
                                                </a>
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
        <?php } else { ?>
            <div class="col-lg-6">
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
                                <span class="text">Complain</span>
                            </a>
                        </div>
                        <!-- Modal -->
                        <form action="functions/business/create_complaint.php" method="post">
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Complain</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <input type="text" value="<?php echo $userId ?>" name="staff_id" hidden>
                                            <div class="form-group">
                                                <label for="">Complaint type</label>
                                                <input type="text" name="type" id="type" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Message</label>
                                                <textarea name="message" id="" cols="30" rows="10" class="form-control"></textarea>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Complain</button>
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
                                    </tr>
                                </thead>
                                <tfoot>

                                    <tr>
                                        <th>Day</th>
                                        <th>Hours Worked</th>
                                        <th>Rate</th>
                                        <th>Pay</th>
                                    </tr>

                                </tfoot>
                                <tbody>
                                    <?php
                                    $findWages = selectAll('wages', ['staff_id' => $userId]);
                                    foreach ($findWages as $wages) {
                                    ?>
                                        <tr>
                                            <td><?php echo $wages['day_worked'] ?></td>
                                            <td><?php echo $wages['hours_worked'] ?></td>
                                            <td><?php echo $wages['rate'] ?></td>
                                            <td><?php echo $wages['pay'] ?></td>
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