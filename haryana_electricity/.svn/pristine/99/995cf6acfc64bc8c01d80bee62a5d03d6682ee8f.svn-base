<?php
include_once('header.php');
include_once('DAO/UserDAO.php');
include_once('DAO/SubdivisionDAO.php');
include_once('common/CommonFunctions.php');

//objects creations
$SubdivisionDAO = new SubdivisionDAO();
$CommonFunctions = new CommonFunctions();

if ($_SESSION['role'] == 1) {
    //$subdivisionArray = $SubdivisionDAO->getAllSubdivision();
    $subdivisionArray = $SubdivisionDAO->getAllSubdivisionAndLineman();
    $complaint_number = '';
} else {
    // $subdivisionArray = $SubdivisionDAO->getAllSubdivisionByArea($_SESSION['area_id']);
    $subdivisionArray = $SubdivisionDAO->getAllSubdivisionAndLinemanByArea($_SESSION['area_id']);
    $complaint_number = $CommonFunctions->generateComplaintNumber();
}

//get all lineman
//$UserDAO = new UserDAO;
//$linemanArray = $UserDAO->getAllLineman();
//print_r($linemanArray);
//exit;
?>
<link href="css/jquery.datepick.css" rel="stylesheet">
<script src="js/datepicker/jquery.plugin.js"></script>
<script src="js/datepicker/jquery.datepick.js"></script>
<script src="js/timepicker/jquery.plugin.js"></script>
<script src="js/timepicker/jquery.timeentry.js"></script>
<script src="js/timepicker/jquery.mousewheel.js"></script>
<script>
    $(function () {
        $('#complainDate').datepick({dateFormat: 'dd/mm/yyyy', maxDate: 'Today',
            onClose: function () {
                
                var complaint_date = $('#complainDate').val();
                var pre_date = new Date(new Date().setFullYear(new Date().getFullYear() - 1));
                pre_date = pre_date.getDate() + '/' + (pre_date.getMonth()) + '/' +  pre_date.getFullYear();
                if (new Date(complaint_date) > new Date(pre_date)) {
                $.ajax({
                    async: false,
                    url: "ajax-process.php?action=getComplaintNumberByDate",
                    type: "POST",
                    data: {complaint_date: complaint_date},
                    success: function (result) {
                        $('#auto_complaint_number').val(result);
                        $('#hidden_complaint_number').val(result);
                    },
                    error: function (error) {
                        //alert('error; ' + eval(error));
                    }
                });
                
            }else{
                alert("Date should not be less than an year");
                $("#complainDate").val('');
                $("#complainDate").focus();
            }
            
            }
        });
    });

//    function showDate(date) {
//        alert('The date chosen is ' + date);
//    }
</script>
<script>
    $(function () {
        $('#complaintTime').timeEntry({show24Hours: true});
    });
</script>
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
                <h3 class="panel-title" style="display: inline-block"><img src="img/complaint.png"> Register Complaint </h3>
            </div>
            <div class="row" style="margin-top:10px">
                <div class="col-lg-12">
                    <form name="registerNewComplain" id="registerNewComplain" method="post" action="ajax-process.php?action=registerNewComplain">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row col-lg-12">
                                    <div class="col-lg-6">
                                        <input type="hidden" value="<?php echo $complaint_number; ?>" id="hidden_complaint_number" name="hidden_complaint_number">
                                        <div class="row">
                                            <div class="form-group col-lg-4">
                                                <label>Complaint Date</label><span class="star">*</span>
                                                <!--<input type="datetime" class="form-control" name="phone" placeholder="Mobile Number">-->
                                                <input type="text" class="form-control" value="<?php echo date("d/m/Y"); ?>" name="complian_date" id="complainDate" placeholder="Complaint Date" required="required">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>Complaint Time</label><span class="star">*</span>
                                                <?php
                                                $t = time();
                                                ?>
                                                <!--<input type="datetime" class="form-control" name="phone" placeholder="Mobile Number">-->
                                                <input type="text" class="form-control"  value="<?php echo(date("H:i", $t)); ?>"  name="complian_time" id="complaintTime" size="10" placeholder="Complaint Time">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>Complaint Number<span class="star">*</span></label>
                                                <input type="text" value="<?php echo $complaint_number; ?>" class="form-control" id="auto_complaint_number" name="complaint_number" placeholder="Complaint Number">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-lg-8">
                                                <label>Subdivision / Complaint Center (Mobile No.)</label>
                                                <select name="subdivision_lineman" class="form-control" id="subdivision">
                                                    <option value="">Select</option>
                                                    <?php foreach ($subdivisionArray as $sda) { ?>
														<?php if ($_SESSION['subdivision_id'] != 0) { ?>
															<?php if ($_SESSION['subdivision_id'] == $sda['subdivision_id']) { ?>
																<option value="<?php echo $sda['subdivision_id'] . ',' . $sda['user_id'] . ',' . $sda['phone']; ?>"><?php echo $sda['subdivision_name'] . ' / ' . $sda['lineman_name'] . ' (' . $sda['phone'] . ')'; ?></option>
															<?php } ?>
														<?php } else { ?>
															<option value="<?php echo $sda['subdivision_id'] . ',' . $sda['user_id'] . ',' . $sda['phone']; ?>"><?php echo $sda['subdivision_name'] . ' / ' . $sda['lineman_name'] . ' (' . $sda['phone'] . ')'; ?></option>
														<?php } ?>
													<?php } ?>
                                                </select>
                                            </div>

                                            <div class="form-group col-lg-4">
                                                <label>Lineman Name</label>
                                                <input type="text" class="form-control" name="lineman_name" placeholder="Lineman Name">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Complaint Comment</label>
                                            <textarea class="form-control" name="comment" placeholder="comment"></textarea>
                                        </div>

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="form-group col-lg-6">
                                                <label>Customer Name</label><span class="star">*</span>
                                                <input type="text" class="form-control" name="name" placeholder="Customer Name">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Mobile Number</label>
                                                <input type="text" class="form-control" name="phone" placeholder="Mobile Number">
                                            </div>
                                        </div>	
                                        <div class="form-group">
                                            <label>Consumer Number</label>
                                            <input type="text" class="form-control" name="customer_id" placeholder="Consumer Number">
                                        </div>

                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" name="address" placeholder="Address"></textarea>
                                        </div>

                                    </div>
                                    <div class="form-group col-lg-12">
                                        <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-fw fa-check"></i> Register</button>
                                    </div>
                                </div>

                            </div>
                        </div>     
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->   
        <!-- /.container-fluid -->
    </div>
</div>
<!-- /#page-wrapper -->

<script>
//    $("#complainDate").on('keyup', function (e) {
//      alert('here');
//    });
</script>
<?php include_once('footer.php'); ?>