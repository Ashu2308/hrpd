<?php
// Including required files
include_once('header.php');
include_once('DAO/UserDAO.php');
include_once('DAO/SubdivisionDAO.php');
include_once('DAO/AreaDAO.php');

if ($_SESSION['isLogin'] == 0 OR $_SESSION['role'] != 1) {
    header("Location: login.php");
}

//Creating users
$UserDAO = new UserDAO();
$result = $UserDAO->getAllUsers();

//getting subdivisions 
$SubdivisionDAO = new SubdivisionDAO();
if ($_SESSION['role'] == 1) {
    $subdivisionArray = $SubdivisionDAO->getAllActiveSubdivision();
} else {
    $subdivisionArray = $SubdivisionDAO->getAllSubdivisionByArea();
}

//Getting all areas
$AreaDAO = new AreaDAO();
$areaArray = $AreaDAO->getAllActiveArea();
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
                <h3 class="panel-title" style="display: inline-block"><img src="img/user.png"> User List</h3>
                <button id="add-new-user" style="float:right; margin:-7px 0" class="btn btn-success"><i class="fa fa-fw fa-plus"></i>Add New User</button>
            </div>
            <div class="row" id="user-list-area">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Phone</th>
                                    <th>Role</th>
                                    <th>Division / Subdivision</th>
                                    <th class="center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="user-data-list">
                                <?php
                                $i = 1;
                                foreach ($result as $res) {
                                    ?>
                                    <tr>
                                        <td><?php echo $res['user_name']; ?></td>
                                        <td><?php echo $res['phone']; ?></td>
                                        <?php if ($res['role_id'] == 2) { ?>
                                            <td>Admin</td>
                                            <td><?php echo $res['area_name'] . " / " . $res['subdivision_name']; ?></td>
                                        <?php } else { ?>
                                            <td>Complaint Center</td>
                                            <td><?php echo $res['subdivision_name']; ?></td>
                                        <?php } ?>
                                        <td  style="text-align: center;margin: 0 auto;">  
                                            <?php if ($res['is_deactivated'] == 0) { ?>
                                                <button id="deactivate" value="<?php echo $res['user_id']; ?>" class="btn btn-warning" type="button">Deactivate</button>
                                            <?php } else { ?>
                                                <button id="delete" value="<?php echo $res['user_id']; ?>" class="btn btn-success" type="button">Activate</button>         
                                            <?php } ?>
                                            <button data-div-subdiv-id="<?php
                                            if ($res['role_id'] == 2) {
                                                echo $res['area_id'] . '" data-subdiv_id="' . $res["subdivision_id"];
                                            } else {
                                                echo $res['subdivision_id'];
                                            }
                                            ?>" data-user-id="<?php echo $res['user_id']; ?>" data-user-role="<?php echo $res['role_id']; ?>" data-user-name="<?php echo $res['user_name']; ?>" data-user-password="<?php echo $res['password']; ?>" type="button" class="btn btn-primary edit-user"><i class="fa fa-edit"></i> Edit</button>
                                        </td>
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
        <!-- /.row -->   
        <!-- /.container-fluid -->
    </div>
</div>

<!-- add new user Modal -->
<div id="AddUserModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New User</h4>
            </div>
            <div id="page-wrapper">
                <form name="addNewUserForm" id="addNewUserForm" method="post" action="ajax-process.php?action=addNewUserForm">
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group">
                                <label>Name</label><span class="star">*</span>
                                <input type="text" class="form-control" name="name" placeholder="Name">
                            </div>

                            <div class="form-group">
                                <label>Mobile Number</label><span class="star">*</span>
                                <input type="text" class="form-control" name="phone" placeholder="Mobile Number">
                            </div>

                            <div class="form-group">
                                <label>Role</label><span class="star">*</span>
                                <select name="role" class="form-control" id="role">
                                    <option <?php if ($_SESSION['role'] == 2) { ?> style="display:none;"<?php } ?> value="">Select</option>
                                    <option <?php if ($_SESSION['role'] == 2) { ?> style="display:none;"<?php } ?> value="2">Admin</option>
                                    <option value="3" <?php if ($_SESSION['role'] == 2) { ?> selected<?php } ?>>Complaint Center</option>
                                </select>
                            </div>

                            <div id="password" class="form-group">
                                <label>Password</label><span class="star">*</span>
                                <input id="password_val" type="Password" class="form-control" name="password" placeholder="Password">
                            </div>

                            <div style="display:none;" id="area" class="form-group">
                                <label>Division</label><span class="star">*</span>
                                <select name="area" class="form-control" id="division">
                                    <option value="">Select</option>
                                    <?php foreach ($areaArray as $aa) { ?>
                                        <option value="<?php echo $aa['area_id']; ?>"><?php echo $aa['label']; ?></option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div <?php if ($_SESSION['role'] != 2) { ?> style="display:none;" <?php } ?>id="subdivision" class="form-group">
                                <label>Subdivision</label><span class="star">*</span>
                                <select name="subdivision" class="form-control">
                                    <option value="">Select</option>
                                    <?php foreach ($subdivisionArray as $sda) { ?>

                                        <option value="<?php echo $sda['subdivision_id'] ?>"><?php echo $sda['label']; ?></option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div id="subdivision_super" style="display:none;" class="form-group">
                                <label>Subdivision</label><span class="star">*</span>
                                <select id="subdivision_super_select" name="subdivision_super" class="form-control">

                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" onclick="return submitAddNewUserForm(event);"><i class="fa fa-fw fa-check"></i> Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- add new user Modal END -->

<!-- edit user Modal -->
<div id="EditUserModel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit User</h4>
            </div>
            <div id="page-wrapper">
                <form name="editUser" id="editUser" method="post" action="ajax-process.php?action=editUser">
                    <div class="modal-body">
                        <input id="userId" type="hidden" name="user_id">
                        <input id="roleId" type="hidden" name="role_id">
                        <div class="row">
                            <div class="form-group">
                                <label>Name</label><span class="star">*</span>
                                <input id="userName" type="text" class="form-control" name="name" placeholder="Name">
                            </div>

                            <div id="password" class="form-group">
                                <label>Password</label><span class="star">*</span>
                                <input id="userPassword" type="password" class="form-control" name="password" placeholder="Password">
                            </div>

                            <div style="display:none" id="userDivisionBlock" class="form-group">
                                <label>Division</label><span class="star">*</span>
                                <select id="userDivision" name="division" class="form-control required">
                                    <option value="">Select</option>
                                    <?php foreach ($areaArray as $aa) { ?>
                                        <option value="<?php echo $aa['area_id']; ?>"><?php echo $aa['label']; ?></option>
                                    <?php } ?>

                                </select>
                            </div>

                            <div id="userSubDivisionBlock" class="form-group">
                                <label>Subdivision</label><span class="star">*</span>
                                <select id="userSubDivision" name="subdivision" class="form-control required">
                                    <option value="">Select</option>
                                    <?php foreach ($subdivisionArray as $sda) { ?>

                                        <option value="<?php echo $sda['subdivision_id'] ?>"><?php echo $sda['label']; ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                            
                            <div id="user_subdivision_super" style="display:none;" class="form-group">
                                <label>Subdivision</label><span class="star">*</span>
                                <select id="user_subdivision_super_select" name="subdivision" class="form-control">

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
</div>
<!-- edit user Modal END -->

<script>
    // AJAX call for autocomplete 
    $(document).ready(function () {
        $("#search-box").keyup(function () {
            $.ajax({
                type: "POST",
                url: "ajax-process.php?action=customerAutocomplete",
                data: 'keyword=' + $(this).val(),
                beforeSend: function () {
                    //$("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function (data) {
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#search-box").css("background", "#FFF");
                }
            });
        });

        $('#add-new-user').click(function () {
            // show model box
            $('#AddUserModal').modal({backdrop: 'static', keyboard: false});
            $("#area, #subdivision, #subdivision_super").hide();
        });
    });
    //To select country name
    function selectCountry(val) {
        $("#search-box").val(val);
        $("#suggesstion-box").hide();
    }

    // Action handling like view, delete, deactive the users.
    $(document).on("click", '#view, #deactivate, #delete, #add-new-user, #user-lists', function (event) {
        //$('#view, #deactivate, #delete, #add-new-user, #user-lists').click(function (event) {
        if ($(event.target).attr('id') == 'view') {
            $.ajax({
                type: "POST",
                url: "ajax-process.php?action=viewUserDetails",
                data: 'user_id=' + $(this).val(),
                beforeSend: function () {
                    // $("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function (data) {
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                }
            });
        } else if ($(event.target).attr('id') == 'deactivate') {
            var res = confirm('Are you sure want to deactivate this user?');

            if (res == false) {
                return
            }
            var status = checkSession();
            if (status) {
                $.ajax({
                    type: "POST",
                    url: "ajax-process.php?action=deactivateUser",
                    data: 'user_id=' + $(this).val(),
                    beforeSend: function () {
                        // $("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
                    },
                    success: function (data) {
                        if (data)
                        {
                            var msg = '<a href="#" class="close" aria-label="close">&times;</a><strong>Success!</strong> User deactivated successfully.';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').html(msg);
                            $('.alert-success').slideDown();
                            getAllUser();

                        } else {
                            var msg = '<a href="#" class="close" aria-label="close">&times;</a><strong>Error!</strong> Something goes wrong';
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    }
                });
            }
        } else if ($(event.target).attr('id') == 'delete') {

            var res = confirm('Are you sure want to Activate this user?');

            if (res == false) {
                return
            }
            var status = checkSession();
            if (status) {
                $.ajax({
                    type: "POST",
                    url: "ajax-process.php?action=activateUser",
                    data: 'user_id=' + $(this).val(),
                    beforeSend: function () {
                        // $("#search-box").css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
                    },
                    success: function (data) {
                        if (data)
                        {
                            var msg = '<a href="#" class="close" aria-label="close">&times;</a><strong>Success!</strong> User Activated successfully.';
                            $("html, body").animate({scrollTop: 0}, "slow");
                            $('.alert-success').html(msg);
                            $('.alert-success').slideDown();
                            getAllUser();

                        } else {
                            var msg = '<a href="#" class="close" aria-label="close">&times;</a><strong>Error!</strong> Something goes wrong';
                            $('.alert-danger').html(msg);
                            $('.alert-danger').slideDown();
                        }
                    }
                });
            }
        } else if ($(event.target).attr('id') == 'add-new-user') {
//            $('#user-list-area').hide();
//            $('#add-new-user').hide();
//            $('#user-lists').show();
//            $('#add-user-form').show();
        } else if ($(event.target).attr('id') == 'user-lists') {
            getAllUser();
            $('#add-user-form').hide();
            $('#user-lists').hide();
            $('#add-new-user').show();
            $('#user-list-area').show();
        }
    });


// function for create user form 
//    function submitAddNewUserForm(e)
//    {
//        //callback handler for form submit
//        $('#addNewUserForm').off('submit');
//        $("#addNewUserForm").submit(function (e)
//        {
//            var postData = $(this).serializeArray();
//            var formURL = $(this).attr("action");
//            $.ajax(
//                    {
//                        url: formURL,
//                        type: "POST",
//                        cache: false,
//                        data: postData,
//                        success: function (result)
//                        {
//                            $('#AddUserModal').modal('hide');
//                            var msg = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> New user category added successfully.';
//                            $('.alert-success').html(msg);
//                            $('.alert-success').slideDown();
//                            getAllUser();
//
//                        },
//                        error: function (error)
//                        {
//                            $('#AddUserModal').modal('hide');
//                            var msg = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> User not added. Something goes wrong';
//                            $('.alert-danger').html(msg);
//                            $('.alert-danger').slideDown();
//                        }
//                    });
//            e.preventDefault(); //STOP default action
//        });
//    }

    function getAllUser()
    {
        $.ajax(
                {
                    url: 'ajax-process.php?action=getAllUser',
                    type: "POST",
                    success: function (result)
                    {

                        $('#user-data-list').html(result);
                        return;

                    },
                    error: function (error)
                    {
                        alert('error; ' + eval(error));
                    }
                });
    }

    function checkSession() {
        var succeed = false;
        $.ajax({
            async: false,
            url: "ajax-process.php?action=checkSession",
            type: "POST",
            data: {userIdString: $('#loggedInUserId').val()},
            success: function (result) {
                //alert(result);
                if (result != '1') {
                    window.location.href = "login.php";
                    // xhr.abort();
                    succeed = false;
                } else {
                    succeed = true;
                }
            },
            error: function (error) {
                //alert('error; ' + eval(error));
            }
        });
        return succeed;
    }

    function getSubdivision(division_id, type) {
        var succeed = false;
        $.ajax({
            async: false,
            url: "ajax-process.php?action=getSubdivision",
            type: "POST",
            data: {division_id: division_id},
            success: function (html) {
                //alert(html);
                if (type == 1) {
                    $("#subdivision_super").show();
                    $("#subdivision_super_select").html('');
                    $("#subdivision_super_select").html(html);
                }
                if (type == 2) {
                    $("#user_subdivision_super").show();
                    $("#userSubDivisionBlock").hide();
                    $("#user_subdivision_super_select").html('');
                    $("#user_subdivision_super_select").html(html);
                }
            },
            error: function (error) {
                //alert('error; ' + eval(error));
            }
        });
        return succeed;
    }

    $("#role").change(function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        if (valueSelected == 2)
        {
            $("#subdivision").hide();
            // $("#password").show();
            $("#area").show();
        } else if (valueSelected == 3)
        {
            $("#area").hide();
            // $("#password").hide();
            $("#subdivision").show();
            $("#subdivision_super").hide();
            $("#password_val").val('');
        }
    });

    $("#division").change(function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        getSubdivision(valueSelected, 1);
    });

    $("#userDivision").change(function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;
        getSubdivision(valueSelected, 2);
    });

    $('.alert').on('click', '.close', function () {
        $(this).closest('.alert').slideUp();
    });

    $(document).on("click", '.edit-user', function () {
        //assigning value
        getSubdivision($(this).attr('data-div-subdiv-id'), 2);
        $("#userName").val($(this).attr('data-user-name'));
        $("#userPassword").val($(this).attr('data-user-password'));
        $("#roleId").val($(this).attr('data-user-role'));
        if ($(this).attr('data-user-role') == '2')
        {
            $("#userDivisionBlock").show();
            //$("#userSubDivisionBlock").hide();
            $("#userDivision").val($(this).attr('data-div-subdiv-id'));
            $("#user_subdivision_super_select").val($(this).attr('data-subdiv_id'));
            // $("#subdivisionLineman").val('')
        } else
        {
            $("#userDivisionBlock").hide();
            $("#userSubDivisionBlock").show();
            $("#userSubDivision").val($(this).attr('data-div-subdiv-id'));
            //$("#subdivisionLineman").val('')
        }
        $("#userId").val($(this).attr('data-user-id'));

        //hiding model
        $('#EditUserModel').modal({backdrop: 'static', keyboard: false});
    });

</script>
<!-- /#page-wrapper -->
<?php include_once('footer.php'); ?>