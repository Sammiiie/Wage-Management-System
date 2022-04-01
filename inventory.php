<?php

include('header.php');
$findStaff = selectOne('staff', ['id' => $userId]);
?>
<!-- map -->

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">INVENTORY</h1>
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
                        <h6 class="m-0 font-weight-bold text-primary">Inventory</h6>
                    </div>
                    <div style="float:right">
                        <a href="#" class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#exampleModal">
                            <span class="icon text-white-50">
                                <i class="fas fa-info-circle"></i>
                            </span>
                            <span class="text">Add New Item</span>
                        </a>
                    </div>
                    <!-- Modal -->
                    <form action="functions/business/create_item.php" method="post">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add New Item</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <input type="text" value="<?php echo $userId ?>" name="staff_id" hidden>
                                        <div class="form-group">
                                            <label>Item Code</label>
                                            <input type="code" name="code" id="code" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Item Name</label>
                                            <input type="text" name="name" id="name" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Quantity</label>
                                            <input type="number" name="qty" min="1" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Unit Price</label>
                                            <input type="text" name="price" id="price" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea name="description" id="descriprion" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                        
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

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add Item</button>
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
                                    <th>Item Name</th>
                                    <th>Item Code</th>
                                    <th>Descriprion</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Sold</th>
                                    <th>Update Quantity</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>

                                <tr>
                                    <th>Item Name</th>
                                    <th>Item Code</th>
                                    <th>Descriprion</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Sold</th>
                                    <th>Update Quantity</th>
                                    <th></th>
                                </tr>

                            </tfoot>
                            <tbody>
                                <?php
                                $findInventory = selectAll('items');
                                foreach ($findInventory as $inventory) {
                                ?>
                                    <tr>
                                        <td><?php echo $inventory['name'] ?></td>
                                        <td><?php echo $inventory['code'] ?></td>
                                        <td><?php echo $inventory['description'] ?></td>
                                        <td><?php echo $inventory['quantity'] ?></td>
                                        <td><?php echo $inventory['unitPrice'] ?></td>
                                        <td><?php  ?></td>
                                        <td><?php  ?></td>
                                        <td>
                                            <a href="edit_item.php?edit=<?php echo $inventory['id'] ?>" class="btn btn-info">Edit</a>
                                            <a href="functions/business/delete_item.php?delete=<?php echo $inventory['id'] ?>" class="btn btn-danger">Delete</a>
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
        <?php // } 
        ?>
    </div>
    <!-- Content Row -->


</div>
<!-- /.container-fluid -->


<?php

include('footer.php');

?>