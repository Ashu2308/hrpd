<?php
// Including required files
include_once('header.php');
include_once('DAO/SubdivisionDAO.php');
include_once('DAO/AreaDAO.php');

if ($_SESSION['isLogin'] == 0 OR $_SESSION['role'] != 1) {
    header("Location: login.php");
}

//getting subdivisions 
$SubdivisionDAO = new SubdivisionDAO();

$subdivisionArray = $SubdivisionDAO->getAllSubdivisionWithArea();

//if ($_SESSION['role'] == 1) {
//    $subdivisionArray = $SubdivisionDAO->getAllActiveSubdivision();
//} else {
//    $subdivisionArray = $SubdivisionDAO->getAllSubdivisionByArea($_SESSION['user_id']);
//}
//
//
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
                <h3 class="panel-title" style="display: inline-block"><img src="img/subdivision.png"> Subdivision List</h3>
                <button id="add-new-subdivision" style="float:right; margin:-7px 0" class="btn btn-success"><i class="fa fa-fw fa-plus"></i>Add New Subdivision</button>
            </div>
            <div class="row" id="user-list-area">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Subdivision Name</th>
                                    <th>Division Name</th>
                                    <th>Status</th>
                                    <th class="center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="subdivision-data-list">
                                <?php
                                foreach ($subdivisionArray as $res) {
                                    ?>
                                    <tr>
                                        <td><?php echo $res['subdivision_name']; ?></td>
                                        <td><?php echo $res['area_name']; ?></td>
                                        <?php if ($res['status'] == 1) { ?>
                                            <td>Active</td>
                                        <?php } else { ?>
                                            <td>Inactive</td>
                                        <?php } ?>
                                        <td style="width: 17%;">
                                            <button value="<?php echo $res['subdivision_id']; ?>" data-area-name="<?php echo $res['area_name']; ?>" data-subdivision-id="<?php echo $res['subdivision_id']; ?>" data-area-id="<?php echo $res['area_id']; ?>" data-subdivision-name="<?php echo $res['subdivision_name']; ?>" data-status="<?php echo $res['status']; ?>" class="btn btn-primary edit-subdivision center" type="button"><i class="fa fa-edit"></i> Edit</button>
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

<!-- add subdivision Modal -->
<div id="AddSubdivisionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Subdivision</h4>
            </div>
            <form name="addNewSubdivision" id="addNewSubdivision" method="post" action="ajax-process.php?action=addNewSubdivision">
                <div class="modal-body">

                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label>Subdivision Name</label><span class="star">*</span>
                            <input type="text" name="subdivision_name" class="form-control" placeholder="Subdivision Name">
                        </div>
                        <?php if ($_SESSION['role'] == 2) { ?>
                            <div style="display:none;" class="form-group col-lg-6">
                                <label>Choose Division</label><span class="star">*</span>
                                <select class="form-control" name="area_id" id="area_id" readonly>
                                    <option value="<?php echo $_SESSION['area_id']; ?>"><?php echo $_SESSION['area_id']; ?></option>
                                </select>
                            </div>
                        <?php } else { ?>

                            <div class="form-group col-lg-6">
                                <label>Choose Division</label><span class="star">*</span>
                                <select class="form-control" name="area_id" id="area_id">
                                    <option value=''>Select</option>
                                    <?php foreach ($areaArray as $res) { ?>
                                        <option value="<?php echo $res['area_id'] ?>"><?php echo $res['label'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
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
<!-- add subdivision Modal END -->

<!-- Edit Subdivision Modal -->
<div id="EditSubdivisionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Subdivision</h4>
            </div>
            <form name="editSubdivision" id="editSubdivision" method="post" action="ajax-process.php?action=editSubdivision">
                <div class="modal-body">

                    <div class="row">
                        <input id="subdivision-id" type="hidden" name="subdivision_id" value="">
                        <div class="form-group col-lg-6">
                            <label>Subdivision Name</label><span class="star">*</span>
                            <input type="text" id="updateName" value="" name="subdivision_name" class="form-control" placeholder="Subdivision Name">
                        </div>

                        <?php if ($_SESSION['role'] == 2) { ?>
                            <div style="display:none;" class="form-group col-lg-6">
                                <label>Choose Division</label><span class="star">*</span>
                                <select class="form-control" name="area_id" id="area_id" readonly>
                                    <option value="<?php echo $_SESSION['area_id']; ?>"></option>
                                </select>
                            </div>
                        <?php } else { ?>

                            <div class="form-group col-lg-6">
                                <label>Choose Division</label><span class="star">*</span>
                                <select class="form-control" name="area_id" id="areaId">
                                    <!--<option id="first_Area"></option>-->
                                    <?php foreach ($areaArray as $res) { ?>
                                        <option value="<?php echo $res['area_id'] ?>"><?php echo $res['label'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>   
                    </div>
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label>Status</label><span class="star">*</span>
                            <select id="updateStatus" class="form-control" name="status" id="status">
                                <option value='0'>Inactive</option>
                                <option value='1'>Active</option>
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
<!-- Edit Subdivision Modal END -->

<script>

    $(document).on("click", '.edit-subdivision', function () {
        $('#updateName').val($(this).attr('data-subdivision-name'));
        //$('#area-id').val($(this).attr('data-area-id'));
       // $('#first_Area').text($(this).attr('data-area-name'));
       // $('#first_Area').val($(this).attr('data-area-id'));
        //$('#edit_area_id').children('option[value="'+ $(this).attr('data-area-id') +'"]').text($(this).attr('data-area-name'));
        $('#subdivision-id').val($(this).attr('data-subdivision-id'));
        $("#updateStatus").val($(this).attr('data-status'));
        $("#areaId").val($(this).attr('data-area-id'));

        // show model box
        $('#EditSubdivisionModal').modal({backdrop: 'static', keyboard: false});
    });

    $('#add-new-subdivision').click(function () {
        // show model box
        $('#AddSubdivisionModal').modal({backdrop: 'static', keyboard: false});
    });

    function getAllSubdivisionWithArea() {
        $.ajax({
            url: 'ajax-process.php?action=getAllSubdivisionWithArea',
            type: "POST",
            success: function (result) {
                $('#subdivision-data-list').html(result);
                return;
            },
            error: function (error) {
                alert('error; ' + eval(error));
            }
        });
    }
</script>
<!-- /#page-wrapper -->
<?php include_once('footer.php'); ?>