<?php
include("../../connect.php");

$supportId = $_POST['support'];
if (isset($_POST['support'])) {

    $findComment = selectAll('comments', ['compliant_id' => $supportId]);
    foreach ($findComment as $comment) {
        $findUser = selectOne('staff', ['id' => $comment['staff_id']]);
            if($findUser['designation'] == "ADMIN"){
                $color = "danger";
            }else{
                $color = "primary";
            }

?>
        <div class="card mb-4 py-3 border-left-<?php echo $color ?>">
            <div class="card-body">
                <p>
                    <b><?php echo $comment['message'] ?></b>
                </p>
                <p>
                    <b>User:</b> <?php 
                    
                    // $findUser = selectOne('users', ['id' => $comment['userid']]);
                    echo $findUser['firstname'];
                    ?>
                </p>
                <hr>
                <p>
                    <i>DATE: <?php echo $comment['date_sent'] ?></i>
                </p>
            </div>
        </div>
<?php
    }
}

?>