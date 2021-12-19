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

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">USER MANAGEMENT</h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Create New User</h6>
                </div>
                <div class="card-body">
                    <form class="user" autocomplete="off" method="POST" action="functions/people/create_user.php">
                        <!-- <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="username" placeholder="username" required>
                        </div> -->
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="firstname" placeholder="Firstname" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="lastname" placeholder="Lastname" required>
                        </div>

                        <div class="form-group">
                            <label for="">Designation</label>
                            <select name="designation" id="" class="form-control" required>
                                <option value="ADMIN">ADMIN</option>
                                <option value="STAFF">STAFF</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" name="staff_id" placeholder="Staff Id..." required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="passkey" id="passkey" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" onclick="show()">
                                    Show Password
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <script>
                                function show() {
                                    var x = document.getElementById("passkey");
                                    if (x.type === "password") {
                                        x.type = "text";
                                    } else {
                                        x.type = "password";
                                    }
                                }
                            </script>
                        </div>


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
        <!-- lists of users -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Staff ID</th>
                                    <th>Designation</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Name</th>
                                    <th>Staff ID</th>
                                    <th>Designation</th>
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
                                        <td><?php echo $user['designation']; ?></td>
                                        <td>
                                            <a href="user_view.php?view=<?php echo $user['id'] ?>" class="btn btn-info btn-icon-split">
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

    </div>

</div>
<!-- /.container-fluid -->

<?php

include('footer.php');

?>