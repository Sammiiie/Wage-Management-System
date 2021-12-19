<?php

include('header.php');

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">COMPLAIN</h1>

    <div class="row">

        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?php echo $_SESSION["fullname"] ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Topic</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>User</th>
                                    <th>Topic</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                if ($designation == "ADMIN") {
                                    $findTicket = selectAll('compliant');
                                } else {
                                    $findTicket = selectAll('compliant', ['staff_id' => $userId]);
                                }
                                foreach ($findTicket as $ticket) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php
                                            $clientId = $ticket['staff_id'];
                                            $findUser = selectOne('staff',  ['id' => $clientId]);
                                            echo $findUser['firstname'] ." ". $findUser['lastname'];
                                            ?>
                                        </td>
                                        <td><?php echo $ticket['compliant_type']; ?></td>
                                        <th>
                                            <a href="complain_view.php?view=<?php echo $ticket['id'] ?>&status=1" class="btn btn-info btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span class="text">View</span>
                                            </a>
                                        </th>

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


    </div>

</div>
<!-- /.container-fluid -->
<!-- <script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "lengthMenu": [
                [50, 100, 250, 500, -1],
                [50, 100, 250, 500, "All"]
            ],
            "iDisplayLength": 100,
        });
    });
</script> -->
<?php

include('footer.php');

?>