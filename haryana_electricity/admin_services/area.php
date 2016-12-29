<?php
// Including required files
include_once('header.php');
include_once('DAO/SubdivisionDAO.php');
include_once('DAO/AreaDAO.php');

//Checking authentication

if ($_SESSION['isLogin'] == 0 OR $_SESSION['role'] != 1) {
    header("Location: login.php");
}

//getting subdivisions 
$SubdivisionDAO = new SubdivisionDAO();
if ($_SESSION['role'] == 1) {
    $subdivisionArray = $SubdivisionDAO->getAllSubdivision();
} else {
    $subdivisionArray = $SubdivisionDAO->getAllSubdivisionByArea($_SESSION['user_id']);
}

//Getting all areas
$AreaDAO = new AreaDAO();
$areaArray = $AreaDAO->getAllArea();
?>

<div id="page-wrapper"> 
    <div class="container-fluid">
        <!-- success section -->
        <div style="display:none;" class="alert alert-success">

        </div>
        <div style="display:none;" class="alert alert-danger">

            <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
        </div>
        <!-- success section end -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline-block"><img src="img/division.png"> Division List</h3>
                <button id="add-new-area" style="float:right; margin:-7px 0" class="btn btn-success"><i class="fa fa-fw fa-plus"></i>Add New Division</button>
            </div>
            <div class="row" id="user-list-area">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Division Name</th>
                                    <th>Division Code</th>
                                    <th>Status</th>
                                    <th class="center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="area-data-list">
                                <?php
                                foreach ($areaArray as $res) {
                                    ?>
                                    <tr>
                                        <td><?php echo $res['label']; ?></td>
                                        <td><?php echo $res['division_code']; ?></td>
                                        <?php if ($res['status'] == 1) { ?>
                                            <td>Active</td>
                                        <?php } else { ?>
                                            <td>Inactive</td>
                                        <?php } ?>
                                        <td style="width: 17%;">
                                            <button value="<?php echo $res['area_id']; ?>"  data-division-code="<?php echo $res['division_code']; ?>" data-area-id="<?php echo $res['area_id']; ?>" data-area-name="<?php echo $res['label']; ?>" data-status="<?php echo $res['status']; ?>" class="btn btn-primary edit-area center" type="button"><i class="fa fa-edit"></i> Edit</button>
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
        <!-- /.row -->   
        <!-- /.container-fluid -->
    </div>
</div>

<!-- add area Modal -->
<div id="AddAreaModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Division</h4>
            </div>
            <form name="addNewArea" id="addNewArea" method="post" action="ajax-process.php?action=addNewArea">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>Division Name</label><span class="star">*</span>
                            <input type="text" name="area_name" class="form-control" placeholder="Area Name">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Division Code</label><span class="star">*</span>
                            <input type="text" id="" value="" name="division_code" class="form-control" placeholder="Division Code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>Status</label><span class="star">*</span>
                            <select class="form-control" name="status" id="status">
                                <option value='1'>Active</option>
                                <option value='0'>Inactive</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add area Modal END -->

<!-- Edit Area Modal -->
<div id="EditAreaModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Division</h4>
            </div>
            <form name="editArea" id="editArea" method="post" action="ajax-process.php?action=editArea">
                <div class="modal-body">

                    <div class="row">
                        <input id="area-id" type="hidden" name="area_id" value="">
                        <div class="form-group col-lg-6">
                            <label>Division Name</label><span class="star">*</span>
                            <input type="text" id="updateName" value="" name="area_name" class="form-control" placeholder="Area Name">
                        </div>

                        <div class="form-group col-lg-6">
                            <label>Division Code</label><span class="star">*</span>
                            <input type="text" id="updateDivisionCode" value="" name="division_code" class="form-control" placeholder="Division Code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>Status</label><span class="star">*</span>
                            <select id="updateStatus" class="form-control" name="status" id="status">
                                <option value='1'>Active</option>
                                <option value='0'>Inactive</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" id="editFormSubmit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Area Modal END -->

<script>

    $(document).on("click", '.edit-area', function () {
        $('#updateName').val($(this).attr('data-area-name'));
        $('#area-id').val($(this).attr('data-area-id'));
        $("#updateStatus").val($(this).attr('data-status'));
        $("#updateDivisionCode").val($(this).attr('data-division-code'));

        // show model box
        $('#EditAreaModal').modal({backdrop: 'static', keyboard: false});
    });

    $('#add-new-area').click(function () {
        // show model box
        $('#AddAreaModal').modal({backdrop: 'static', keyboard: false});
    });

    function getAllArea() {
        $.ajax({
            url: 'ajax-process.php?action=getAllArea',
            type: "POST",
            success: function (result) {
                $('#area-data-list').html(result);
                return;
            },
            error: function (error) {
                alert('error; ' + eval(error));
                h
            }
        });
    }
</script>
<!-- /#page-wrapper -->
<?php include_once('footer.php'); ?>