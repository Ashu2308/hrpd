<?php
// Including required files
include_once('header.php');
include_once('DAO/ComplainDAO.php');

//Checking authentication

if ($_SESSION['isLogin'] == 0 OR $_SESSION['role'] != 1) {
    header("Location: login.php");
}


//Getting complain category
$ComplainDAO = new ComplainDAO();
$result = $ComplainDAO->getAllComplainCategory();
?>
<div id="page-wrapper"> 
    <div class="container-fluid">
        <!-- Page Heading -->
        <!-- success section -->
        <div style="display:none;" class="alert alert-success">

        </div>
        <div style="display:none;" class="alert alert-danger">

        </div>
        <!-- success end -- >
        <!-- /user list .row Start -->
        <div class="row" id="user-list-area">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title" style="display: inline-block"><img src="img/category.png"> Category List </h3>
                        <button id="add-new-category" style="float:right; margin:-7px 0" class="btn btn-success"><i class="fa fa-fw fa-plus"></i>Add New Complaint Category</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Complaint Code</th>
                                    <th>Complaint Category</th>
                                    <th>Status</th> 
                                    <th class="center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="complain-data-list">
                                <?php
                                $i = 1;
                                foreach ($result as $res) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $res['desciption']; ?></td>
                                        <td><?php
                                            if ($res['status'] == 1) {
                                                echo "Active";
                                            } else {
                                                echo "Inactive";
                                            }
                                            ?></td>
                                        <td style="width: 17%;">            
                                            <button value="<?php echo $res['complain_category_id']; ?>" data-category-id="<?php echo $res['complain_category_id']; ?>" data-category="<?php echo $res['desciption']; ?>" data-status="<?php echo $res['status']; ?>" class="btn btn-primary edit-complain center" type="button"><i class="fa fa-edit"></i> Edit</button></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /user list .row End -->
    </div>
</div>

<!-- Edit Category Modal -->
<div id="complainModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Complaint Category</h4>
            </div>
            <form name="editCategory" id="editCategoryForm" method="post" action="ajax-process.php?action=editComplainCategory">
                <div class="modal-body">

                    <div class="row">
                        <input id="category-id" type="hidden" name="category-id" value="">
                        <div class="form-group col-lg-6">
                            <label>Category Name</label><span class="star">*</span>
                            <input type="text" id="updateName" value="" name="name" class="form-control" placeholder="Category Name">
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Status</label><span class="star">*</span>
                            <select id="updateStatus" class="form-control" name="status" id="status">
                                <option value=''>Select</option>
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
<!-- Edit Category Modal END -->

<!-- add Category Modal -->
<div id="complainCategoryAddModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Complaint Category</h4>
            </div>
            <form name="addNewCategory" id="addNewCategory" method="post" action="ajax-process.php?action=addNewComplainCategory">
                <div class="modal-body">

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>Category Name</label><span class="star">*</span>
                            <input type="text" name="name" class="form-control" placeholder="Category Name">
                        </div>
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
<!-- add Category Modal END -->

<?php include_once('footer.php'); ?>
<script>

    // Edit complain category
    // $('.edit-complain').click(function () {
    $(document).on("click", '.edit-complain', function () {
        $('#updateName').val($(this).attr('data-category'));
        $('#category-id').val($(this).attr('data-category-id'));
        $("#updateStatus").val($(this).attr('data-status'));

        // show model box
        $('#complainModal').modal({backdrop: 'static', keyboard: false});
    });

    // Add complain category

    $('#add-new-category').click(function () {
        // show model box
        $('#complainCategoryAddModal').modal({backdrop: 'static', keyboard: false});
    });


    // function for add new category
//    function addNewCategoryForm(e) {
//        //callback handler for form submit
//        $('#addNewCategory').off('submit');
//        $("#addNewCategory").submit(function (e) {
//            var postData = $(this).serializeArray();
//            var formURL = $(this).attr("action");
//            $.ajax({
//                url: formURL,
//                type: "POST",
//                data: postData,
//                success: function (result) {
//                    if (result == 'true') {
//                        $('#complainCategoryAddModal').modal('hide');
//                        var msg = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> A new complain category added successfully.';
//                        $('.alert-success').html(msg);
//                        $('.alert-success').slideDown();
//                        getAllComplainCategory();
//                    } else {
//                        $('#complainCategoryAddModal').modal('hide');
//                        var msg = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Category not added. Something goes wrong';
//                        $('.alert-danger').html(msg);
//                        $('.alert-danger').slideDown();
//                    }
//                },
//                error: function (error) {
//                    alert('error; ' + eval(error));
//                }
//            });
//            e.preventDefault(); //STOP default action
//        });
//    }

    // function for edit category
//    function editComplainCategory(e) {
//        //callback handler for form submit
//        $('#editCategoryForm').off('submit');
//        $("#editCategoryForm").submit(function (e) {
//            var postData = $(this).serializeArray();
//            var formURL = $(this).attr("action");
//            $.ajax({
//                url: formURL,
//                type: "POST",
//                data: postData,
//                success: function (result) {
//                    if (result == 'true') {
//                        $('#complainModal').modal('hide');
//                        var msg = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Complain category updated successfully.';
//                        $('.alert-success').html(msg);
//                        $('.alert-success').slideDown();
//                        getAllComplainCategory();
//                    } else {
//                        $('#complainModal').modal('hide');
//                        var msg = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Category not updated. Something goes wrong';
//                        $('.alert-danger').html(msg);
//                        $('.alert-danger').slideDown();
//                    }
//                },
//                error: function (error) {
//                    alert('error; ' + eval(error));
//                }
//            });
//            e.preventDefault(); //STOP default action
//        });
//    }

    // Get all complain category
    function getAllComplainCategory() {
        $.ajax({
            url: 'ajax-process.php?action=getAllComplainCategory',
            type: "POST",
            success: function (result) {
                $('#complain-data-list').html(result);
                return;
            },
            error: function (error) {
                alert('error; ' + eval(error));
                h
            }
        });
    }
</script>