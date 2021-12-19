<?php

include("../../connect.php");
session_start();
$userId = $_SESSION['userid'];
$today = date('Y-m-d H:i s');

$supportId = $_POST['support'];
if (isset($_POST['support'])) {
    $commentData = [
        'message' => $_POST['chat'],
        'compliant_id' => $supportId,
        'staff_id' => $userId,
        'date_sent' => $today
    ];
    $storeComment = insert('comments', $commentData);
    if (!$storeComment) {
        printf('Error: %s\n', mysqli_error($connection)); //checking for errors
        exit();
    } else {

        $findComment = selectAll('comments', ['compliant_id' => $supportId]);
        foreach ($findComment as $comment) {
            $findUser = selectOne('staff', ['id' => $comment['staff_id']]);
            if($findUser['designation'] == "ADMIN"){
                $color = "success";
            } else {
                $color = "primary";
            }

?>
            <!-- <div class="card mb-4 py-3 border-left-warning"> -->
            <!-- <div class="card-body"> -->
            <div class="card mb-4 py-3 border-left-<?php echo $color ?>">
                <div class="card-body">
                    <p>
                        <b><?php echo $comment['message'] ?></b>
                    </p>
                    <p>
                        <b>User:</b> <?php

                                        $findUser = selectOne('staff', ['id' => $comment['staff_id']]);
                                        echo $findUser['firstname'];
                                        ?>
                    </p>
                    <hr>
                    <p>
                        <i>DATE: <?php echo $comment['date_sent'] ?></i>
                    </p>
                </div>
            </div>
            <!-- </div> -->
            <!-- </div> -->
<?php
        }
    }
}
