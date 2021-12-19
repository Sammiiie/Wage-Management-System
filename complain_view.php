<?php

include('header.php');

$supportId = $_GET["view"];
$findSupport = selectOne('compliant', ['id' => $supportId]);


?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?php echo $findSupport['compliant_type'] ?></h1>

    <div class="row">

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Compliant Resolutions</h6>
                </div>
                <div class="card-body">

                    <div id="display_support"></div>
                    <!-- <form action=""> -->
                    <input type="text" id="support-id" value="<?php echo $supportId ?>" hidden>
                    <div class="form-group">
                        <textarea name="chat" id="chat" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                    <button class="btn btn-info" id="submitchat">Submit</button>
                    <!-- </form> -->
                    <script>
                        $(document).ready(function() {
                            $('#support-id').ready(function() {
                                var support = $('#support-id').val();
                                $.ajax({
                                    url: "functions/system/ajax_functions/comments.php",
                                    method: "POST",
                                    data: {
                                        support: support
                                    },
                                    success: function(data) {
                                        $('#display_support').html(data);
                                    }
                                })
                            });

                            //    complete comment section
                            $('#submitchat').on("click", function() {
                                var support = $('#support-id').val();
                                var chat = $('#chat').val();
                                var ticket = $('#ticket').val();

                                $.ajax({
                                    url: "functions/system/ajax_functions/create_comment_admin.php",
                                    method: "POST",
                                    data: {
                                        support: support,
                                        chat: chat,
                                    },
                                    success: function(data) {
                                        $('#display_support').html(data);
                                        $('#chat').val("");
                                    }
                                })
                            });
                        });
                    </script>

                </div>
            </div>
        </div>

        <!-- loan info -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div style="float:left">
                        <h6 class="m-0 font-weight-bold text-primary">Support Details</h6>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Complaint Type</label>
                        <input type="text" class="form-control form-control-user" value="<?php echo $findSupport['compliant_type'] ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Message</label>
                        <textarea readonly class="form-control form-control-user" cols="30" rows="10"><?php echo $findSupport['message'] ?></textarea>
                    </div>


                </div>
            </div>
        </div>
        <!-- /loan info -->


    </div>

</div>
<!-- /.container-fluid -->

<?php

include('footer.php');

?>