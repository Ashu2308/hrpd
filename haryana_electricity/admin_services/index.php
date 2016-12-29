<?php
include_once('header.php');
include_once('DAO/ComplainDAO.php');
include_once('DAO/SubdivisionDAO.php');
require('common/CommonFunctions.php');

//coommon function object
$CommonFunctions = new CommonFunctions();

//Getting al comlian category
$ComplainDAO = new ComplainDAO();
$complainCatArray = $ComplainDAO->getAllActiveComplainCategory();

//getting subdivisions 
$SubdivisionDAO = new SubdivisionDAO();

if ($_SESSION['role'] == 1) {
    $subdivisionArray = $SubdivisionDAO->getAllActiveSubdivision();
    $subdivisionData = $SubdivisionDAO->getAllSubdivisionAndLineman();
} else {
    $subdivisionArray = $SubdivisionDAO->getAllSubdivisionByArea();
    $subdivisionData = $SubdivisionDAO->getAllSubdivisionAndLinemanByArea($_SESSION['area_id']);
}


//Getting pending complains
$ComplainDAO = new ComplainDAO();
$result = $ComplainDAO->getAllPendingComplain();
$countComplaint = sizeof($result);
if($countComplaint<2){
    $compliantMessage = 'Pending Complaint';
}
else{
    $compliantMessage = 'Pending Complaints';
}
?>
<link href="css/jquery.datepick.css" rel="stylesheet">
<script src="js/datepicker/jquery.plugin.js"></script>
<script src="js/datepicker/jquery.datepick.js"></script>
<script src="js/timepicker/jquery.plugin.js"></script>
<script src="js/timepicker/jquery.timeentry.js"></script>
<script src="js/timepicker/jquery.mousewheel.js"></script>
<script>
    $(function () {
        $('#complainDate').datepick({dateFormat: 'dd/mm/yyyy', maxDate: 'Today'});
        //$(selector).datepick({dateFormat: 'yyyy-mm-dd'});
        //$('#inlineDatepicker').datepick({onSelect: showDate});
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
<script>
    $(function () {
        $('#complainDate1').datepick({dateFormat: 'dd/mm/yyyy', maxDate: 'Today'});
        //$(selector).datepick({dateFormat: 'yyyy-mm-dd'});
        //$('#inlineDatepicker').datepick({onSelect: showDate});
    });

//    function showDate(date) {
//        alert('The date chosen is ' + date);
//    }
</script>
<script>
    $(function () {
        $('#complainTime1').timeEntry({show24Hours: true});
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
        <!-- Page Heading -->
        <div class="panel panel-primary">
            <!-- Page Heading -->
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline-block;"><img src="img/pending-complaint.png"> Pending Complaints</h3>
                <h3 class="panel-title" style="display: inline-block; width: 64%; text-align: center;"><span id="count-complaints"><?php echo $countComplaint; ?></span> <span  style="font-weight: normal;" id="count-complaints-text"><?php echo $compliantMessage; ?></span></h3>
                <!--<a href="resolve-complain.php"><button id="add-new-user" style="float:right; margin:-3px 0" class="btn btn-success">Resolved Complaints</button></a>-->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Complaint Number</th>                                   
                                    <th>Customer Name</th>
                                    <th>Customer Mobile</th>
                                    <th>Complaint Center</th>
                                    <th>Complaint Center Mobile (Lineman)</th>

                                    <th>Subdivision</th>
                                    <th>Complaint Time</th>
                                    <th class="" >Action</th>
                                </tr>
                            </thead>
                            <tbody id="pending-data-list">
                                <?php
                                $current_time = date("Y-m-d H:i:s", time());
                                foreach ($result as $res) {
                                    $date = $res['complain_date'];

                                    //finding complaint time difference
                                    $to_time = strtotime($res['complain_date']);
                                    $from_time = strtotime($current_time);
                                    $time_diff = round(abs($to_time - $from_time) / 60, 2);
                                    // echo gettype($time_diff);exit;
                                    $critical_time = (int) CRITICAL_COMPLAIN_TIME;
                                    //--------------------------------//

                                    $dt = new DateTime($date);
                                    $finalDate = $dt->format('d/m/Y');
                                    $finalTime = date("H:i", strtotime($date));

                                    //checking for showable complaint number
                                    if ($res['manual_complaint_number'] != '') {
                                        $complaint_number = $res['manual_complaint_number'];
                                    } else {
                                        $complaint_number = $res['complain_number'];
                                    }

                                    //getting complain register time
                                    $complain_register_time = $CommonFunctions->time_elapsed_string($res['complain_date'], $current_time);
                                    ?>
                                    <tr>
                                        <td style="width:14%"><?php echo $complaint_number; ?></td>                                        
                                        <td style="width:14%"><?php echo $res['customer_name']; ?></td>
                                        <td style="width:14%"><?php
                                            if ($res['customer_mobile'] == '') {
                                                echo 'N/A';
                                            } else {
                                                echo $res['customer_mobile'];
                                            }
                                            ?></td>
                                        <td style="width:14%"><?php
                                            if ($res['assignee_name'] == '') {
                                                echo 'N/A';
                                            } else {
                                                echo $res['assignee_name'];
                                            }
                                            ?></td>
                                        <td style="width:14%"><?php
                                            if ($res['lineman_number'] == '') {
                                                echo 'N/A';
                                                if ($res['lineman_name'] == '') {
                                                    echo ' (N/A)';
                                                } else {
                                                    echo ' (' . $res['lineman_name'] . ')';
                                                }
                                            } else {
                                                echo $res['lineman_number'];
                                                if ($res['lineman_name'] == '') {
                                                    echo ' (N/A)';
                                                } else {
                                                    echo ' (' . $res['lineman_name'] . ')';
                                                }
                                            }
                                            ?></td>
                                        <td style="width:14%"><?php
                                            if ($res['subdivision_name'] == '') {
                                                echo 'N/A';
                                            } else {
                                                echo $res['subdivision_name'];
                                            }
                                            ?></td>

                                        <td <?php if ($time_diff > $critical_time) { ?> class="urgent-comp" <?php } ?> data-toggle="tooltip" data-placement="bottom" title="<?php echo $finalDate . ', ' . $finalTime; ?>" style="width:14%;"><?php echo $complain_register_time; ?></td>
                                        <td style="width: 10%;">            
                                            <button value="<?php echo $res['complain_id']; ?>" data-complain-category="<?php echo $res['complain_category_id']; ?>" data-lineman-name="<?php echo $res['lineman_name']; ?>" data-complaint-date="<?php echo $finalDate ?>" data-complaint-time="<?php echo $finalTime ?>" data-subdivision-id="<?php echo $res['subdivision_id']; ?>" data-assignee-id="<?php echo $res['assignee_id']; ?>" data-lineman-number="<?php echo $res['lineman_number']; ?>" data-lineman-name="<?php echo $res['assignee_name']; ?>" data-customer-address="<?php echo $res['customer_address']; ?>" data-subdivision-name="<?php echo $res['subdivision_name']; ?>" data-complain-id="<?php echo $res['complain_id']; ?>"  data-complain-number="<?php echo $complaint_number; ?>" data-customer-id="<?php echo $res['customer_id']; ?>" data-customer-name="<?php echo $res['customer_name']; ?>" data-customer-mobile="<?php echo $res['customer_mobile']; ?>" data-resolution-comment="<?php echo $res['resolution_comment']; ?>"  data-complaint-comment="<?php echo $res['complaint_comment']; ?>" class="btn btn-primary edit-complain center" type="button"><i class="fa fa-edit"></i> Edit</button>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                        <?php if ($countComplaint == '0') {
                            ?>
                            <h4 id="no-complaints" style="text-align: center;">No Pending Complaints</h4>
                        <?php }else{ ?>
                            <h4 id="no-complaints" style="text-align: center;display:none;">No Pending Complaints</h4>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<!-- resolve Modal -->
<div id="complainModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:75%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Complaint</h4>
            </div>
            <form name="editComplains" id="editComplains" method="post" action="ajax-process.php?action=editComplains">
                <div class="modal-body">

                    <div class="row">

                        <input id="complainId" type="hidden" name="complain_id" value="">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>Complaint Date</label><span class="star">*</span>
                                            <!--<input type="datetime" class="form-control" name="phone" placeholder="Mobile Number">-->
                                    <input type="text" class="form-control" value="" name="complian_date1" id="complainDate1" placeholder="Complaint Date">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Complaint Time</label><span class="star">*</span>
                                            <!--<input type="datetime" class="form-control" name="phone" placeholder="Mobile Number">-->
                                    <input type="text" class="form-control" value="" name="complian_time1" id="complainTime1" placeholder="Complaint Date">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Complaint Number</label>
                                    <input type="text" id="complainNumber" value="" name="complain_number" class="form-control" placeholder="Complaint Number"  readonly="readonly">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-8">
                                    <label>Subdivision / Complaint Center (Mobile No.)</label>
                                    <select id="subdivisionLineman" name="subdivision_lineman" class="form-control" id="subdivision">
                                        <option value="">Select</option>
                                        <?php foreach ($subdivisionData as $sda) { ?>
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
                                    <input type="text" class="form-control" id ="linemanName" name="lineman_name" placeholder="Lineman Name">
                                </div>
                                <!--<div class="form-group col-lg-6">
                                    <label>Complaint Center Mobile</label>
                                    <input type="text" id="linemanMobile" value="" name="lineman_mobile" class="form-control" placeholder="Lineman Mobile" disabled>
                                </div>-->
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12" style="
                                     margin-top: 20px;
                                     ">
                                    <label>Complaint Category</label>
                                    <select id="complainCategory" class="form-control" name="complain_category" id="status">
                                        <option value=''>Select</option>
                                        <?php foreach ($complainCatArray as $cca) { ?>
                                            <option value="<?php echo $cca['complain_category_id']; ?>"><?php echo $cca['complain_category_id'] . ' - ' . $cca['desciption']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label>Complaint Comment</label>
                                    <textarea id="complaintComment" value="" name="complaint_comment" class="form-control" placeholder="Complaint Comment"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <div class="form-group col-lg-4">
                                    <label>Customer Name</label><span class="star">*</span>
                                    <input type="text" id="customerName" value="" name="customer_name" class="form-control" placeholder="Customer Name">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Customer Mobile</label>
                                    <input type="text" id="customerMobile" value="" name="customer_mobile" class="form-control" placeholder="Customer Mobile">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>Consumer Number</label>
                                    <input type="text" id="consumerNumber" value="" name="consumer_number" class="form-control" placeholder="Consumer No.">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label>Customer Address</label>
                                    <textarea id="customerAddress" value="" name="customer_address" class="form-control" placeholder="Customer Address"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Resolved Date</label>
                                    <!--<input type="datetime" class="form-control" name="phone" placeholder="Mobile Number">-->
                                    <input type="text" class="form-control" value="<?php echo date("d/m/Y"); ?>" name="complian_date" id="complainDate" placeholder="Complaint Date">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Resolved Time</label>
                                    <?php
                                    $t = time();
                                    ?>
                                    <!--<input type="datetime" class="form-control" name="phone" placeholder="Mobile Number">-->
                                    <input type="text" class="form-control"  value="<?php echo(date("H:i", $t)); ?>" name="complian_time" id="complaintTime" size="10" placeholder="Complaint Time">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label>Resolution Comment</label>
                                    <textarea id="res-comment" value="" name="resolution_comment" class="form-control" placeholder="Resolution Comment"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="resolveComplainSubmit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> Resolve</button>
                    <button type="submit" id="editComplainSubmit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- resolve Modal END -->

<?php include_once('footer.php'); ?>

<script>
    //Edit complains
    $(document).on("click", '.edit-complain', function () {
        //assigning value
        $("#complainId").val($(this).attr('data-complain-id'));
        $("#linemanName").val($(this).attr('data-lineman-name'));
        $("#complainNumber").val($(this).attr('data-complain-number'));
        $("#consumerNumber").val($(this).attr('data-customer-id'));

        $('#customerName').val($(this).attr('data-customer-name'));
        $("#customerMobile").val($(this).attr('data-customer-mobile'));

        $("#subdivisionName").val($(this).attr('data-subdivision-name'));
        $('#customerAddress').val($(this).attr('data-customer-address'));
        $('#linemanMobile').val($(this).attr('data-lineman-number'));
        $("#linemanName").val($(this).attr('data-lineman-name'));
        $("#complaintComment").val($(this).attr('data-complaint-comment'));
        $("#complainDate1").val($(this).attr('data-complaint-date'));
        $("#complainTime1").val($(this).attr('data-complaint-time'));
        $("#res-comment").val($(this).attr('data-resolution-comment'));
        if ($(this).attr('data-complain-category') != '0' && $(this).attr('data-complain-category') != '') {
            $("#complainCategory").val($(this).attr('data-complain-category'));
        } else {
            $("#complainCategory").val('')
        }
        //$("#subdivisionLineman").val($(this).attr('data-lineman-name'));
        jQuery("#subdivisionLineman option:contains(' /  ()')").remove();
        //alert($(this).attr('data-subdivision-id'));
        if ($(this).attr('data-subdivision-id') != '0' && $(this).attr('data-subdivision-id') != '') {
            // $("#subdivisionLineman").prepend("<option value='"+$(this).attr('data-subdivision-id')+','+$(this).attr('data-assignee-id')+ ',' + $(this).attr('data-lineman-number') +"'  selected='selected'>"+$(this).attr('data-subdivision-name')+' / '+$(this).attr('data-lineman-name')+ ' (' + $(this).attr('data-lineman-number')+ ')'+"</option>");
            //$("#subdivisionLineman select").val($(this).attr('data-subdivision-id')+','+$(this).attr('data-assignee-id')+ ',' + $(this).attr('data-lineman-number'));
            //$('#subdivisionLineman option:contains("'+$(this).attr('data-subdivision-name')+' / '+$(this).attr('data-lineman-name')+ ' (' + $(this).attr('data-lineman-number')+ ')').prop('selected', true);
            //alert($(this).attr('data-subdivision-id'));
            $("#subdivisionLineman").val($(this).attr('data-subdivision-id') + ',' + $(this).attr('data-assignee-id') + ',' + $(this).attr('data-lineman-number'));
        } else
        {
            $("#subdivisionLineman").val('')
        }
        // show model box
        $('#complainModal').modal({backdrop: 'static', keyboard: false});
    });

    function getAllPendingComplain()
    {
        $.ajax(
                {
                    url: 'ajax-process.php?action=getAllPendingComplain',
                    type: "POST",
                    success: function (result)
                    {
                        $('#pending-data-list').html(result);
                        return;
                    },
                    error: function (error)
                    {
                        alert('error; ' + eval(error));
                    }
                });
    }

    function getCountPendingComplain()
    {
        $.ajax(
                {
                    url: 'ajax-process.php?action=getCountPendingComplain',
                    type: "POST",
                    success: function (result)
                    {
                        if(result == '0'){
                        $('#no-complaints').show();
                    }
                        $('#count-complaints').text(result);
                        if(result<2){
                            $('#count-complaints-text').text('Pending Complaint');
                        }else{
                            $('#count-complaints-text').text('Pending Complaints');
                        }
                        return;
                    },
                    error: function (error)
                    {
                        alert('error; ' + eval(error));
                    }
                });
    }
</script>
