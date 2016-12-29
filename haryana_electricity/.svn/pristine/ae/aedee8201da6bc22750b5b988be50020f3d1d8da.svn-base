<?php
include_once('header.php');
include_once('DAO/ComplainDAO.php');

//Getting the filter value
if(isset($_GET['filter']))
{
    $_SESSION['filter_value'] = $_GET['filter'];
    if($_GET['filter']=='today')
    {
         $filter_message = "resolved today";
    }
    elseif($_GET['filter']=='yesterday')
    {
         $filter_message = "resolved yesterday";
    }
    elseif($_GET['filter']=='week')
    {
         $filter_message = "resolved this week";
    }
    elseif($_GET['filter']=='month')
    {
         $filter_message = "resolved this month";
    }
   
}
else
{
    $_SESSION['filter_value'] = 'today';
    $filter_message = "resolved today";
}

//Creating users
$ComplainDAO = new ComplainDAO();
$result = $ComplainDAO->getAllResolveComplain();
$countComplaint = sizeof($result);
if($countComplaint<2){
    $compliantMessage = 'complaint';
}
else{
    $compliantMessage = 'complaints';
}
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
            <!-- Page Heading -->
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline-block"><img src="img/resolved-complaint.png"> Resolved Complaints</h3>
                <h3 class="panel-title" style="display: inline-block; width: 64%; text-align: center;"><span id="count-resolve-complaints"><?php echo $countComplaint; ?></span> <span style="font-weight: normal;" id="count-complaints-text"><?php echo $compliantMessage; ?></span> <span style="font-weight: normal;"><?php echo $filter_message;  ?></span></h3>
                <div style="float: right;">
                    <form name="filter-form" id="filter-form" method="get" action="">
                        <div class="form-group">
                        <select name="filter" id="search-filter" class="form-control">
                            <option value="today" <?php if($_SESSION['filter_value'] == 'today'){ echo 'selected'; } ?>>Today</option>
                            <option value="yesterday" <?php if($_SESSION['filter_value'] == 'yesterday'){ echo 'selected'; } ?>>Yesterday</option>
                            <option value="week" <?php if($_SESSION['filter_value'] == 'week'){ echo 'selected'; } ?>>One Week</option>
                            <option value="month" <?php if($_SESSION['filter_value'] == 'month'){ echo 'selected'; } ?>>One Month</option>
                        </select>
                        </div>
                    </form>
                </div>
                <!-- <a href="index.php"><button id="add-new-user" style="float:right; margin:-3px 0" class="btn btn-success">Pending Complaints</button></a>-->
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
                                    <th>Complaint Category</th>
                                    <th>Complaint Center </th>
                                    <th>Complaint Date/Time</th>
                                    <th>Resolve Date/Time</th>
                                </tr>
                            </thead>
                            <tbody id="resolve-data-list">
                                <?php
                                $i = 1;
                                foreach ($result as $res) {
                                    //Converting complain date

                                    $compDate = $res['complain_date'];
                                    $dt = new DateTime($compDate);
                                    $complainDate = $dt->format('d M Y');
                                    $complainTime = date("H:i", strtotime($compDate));

                                    //converting resolve date

                                    $resDate = $res['resolve_date'];
                                    $dt1 = new DateTime($resDate);
                                    $resolveDate = $dt1->format('d M Y');
                                    $resolveTime = date("H:i", strtotime($resDate));

                                    if ($res['manual_complaint_number'] != '') {
                                        $complaint_number = $res['manual_complaint_number'];
                                    } else {
                                        $complaint_number = $res['complain_number'];
                                    }
                                    ?>
                                    <tr style="cursor: pointer;" class="view-resolve-detail" data-assigned-person="<?php echo $res['lineman_name']; ?>" data-consumer-number="<?php echo $res['customer_id']; ?>" data-lineman-number="<?php echo $res['lineman_number']; ?>" data-lineman-name="<?php echo $res['assignee_name']; ?>" data-customer-address="<?php echo $res['customer_address']; ?>" data-subdivision-name="<?php echo $res['subdivision_name']; ?>" data-complain-id="<?php echo $res['complain_id']; ?>"  data-complain-number="<?php echo $complaint_number; ?>" data-customer-id="<?php echo $res['customer_id']; ?>" data-customer-name="<?php echo $res['customer_name']; ?>" data-customer-mobile="<?php echo $res['customer_mobile']; ?>" data-complaint-comment="<?php echo $res['complaint_comment']; ?>" data-resolution-comment="<?php echo $res['resolution_comment']; ?>" data-complain-category="<?php echo $res['description']; ?>">
                                        <td style="width:14%"><?php echo $complaint_number; ?></td>
                                        <td style="width:14%"><?php echo $res['customer_name']; ?></td>
                                        <td style="width:14%"><?php
                                            if ($res['customer_mobile'] == '') {
                                                echo 'N/A';
                                            } else {
                                                echo $res['customer_mobile'];
                                            }
                                            ?>
                                        </td>
                                        <td style="width:14%"><?php echo $res['description']; ?></td>
                                        <td style="width:14%"><?php
                                            if ($res['assignee_name'] == '') {
                                                echo 'N/A';
                                            } else {
                                                echo $res['assignee_name'];
                                            }
                                            ?></td>
                                        <td style="width:14%"><?php echo $complainDate . ', ' . $complainTime; ?></td>
                                        <td style="width:14%"><?php echo $resolveDate . ', ' . $resolveTime; ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                        </table>
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
<div id="resolveModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:65%">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Resolved Complaint Detail</h4>
            </div>
            <form name="reopenComplains" id="reopenComplains" method="post" action="ajax-process.php?action=reopenComplains">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row col-lg-12">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <input id="complainId" type="hidden" name="complain_id" value="">

                                        <div class="form-group col-lg-6">
                                            <label>Complaint Number</label>
                                            <input type="text" id="complainNumber" value="" name="complain_number" class="form-control" placeholder="Complain Number" readonly>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Subdivision Name</label>
                                            <input type="text" id="subdivisionName" value="" name="subdivision_name" class="form-control" placeholder="Subdivision Name" disabled>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>Complain Center</label>
                                            <input type="text" id="linemanName" value="" name="lineman_name" class="form-control" placeholder="Lineman Name" disabled>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Complain Center Mobile</label>
                                            <input type="text" id="linemanMobile" value="" name="lineman_mobile" class="form-control" placeholder="Lineman Mobile" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label>Lineman Name</label>
                                            <input type="text" id="assignedPerson" value="" name="lineman_name" class="form-control" placeholder="Lineman Name" disabled>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label>Complaint Category</label>
                                            <input type="text" id="complainCategory" value="" name="complain_category" class="form-control" placeholder="Complain Category" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label>Complaint Comment</label>
                                            <textarea id="complaintComment" value="" name="complaint_comment" class="form-control" placeholder="Complaint Comment" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="form-group col-lg-6">
                                            <label>Customer Name</label>
                                            <input type="text" id="customerName" value="" name="customer_name" class="form-control" placeholder="Customer Name" disabled>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label>Customer Mobile</label>
                                            <input type="text" id="customerMobile" value="" name="customer_mobile" class="form-control" placeholder="Customer Mobile" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-12">
                                            <label>Consumer Number</label>
                                            <input type="text" id="consumerNumber" value="" name="consumer_number" class="form-control" placeholder="Consumer Number" readonly>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="form-group col-lg-12">
                                            <label>Customer Address</label>
                                            <textarea id="customerAddress" value="" name="customer_address" class="form-control" placeholder="Customer Address" disabled></textarea>
                                        </div>
                                    </div>
                                    <div class="row">	
                                        <div class="form-group col-lg-12">
                                            <label>Resolution Comment</label>
                                            <textarea id="resolutionComment" value="" name="resolution_comment" class="form-control" placeholder="Resolution Comment" disabled></textarea>
                                        </div>
                                    </div>
                                </div>



                            </div>

                        </div></div></div>
                <div class="modal-footer">
                    <button type="submit" id="reopenComplainSubmit" class="btn btn-primary"><i class="fa fa-fw fa-check"></i> Reopen</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- resolve Modal END -->

<?php include_once('footer.php'); ?>

<script>
    //filter section
    $( "#search-filter" ).change(function() {  
        $("#filter-form").submit();
  });
    
    //Edit complains
    $(document).on("click", '.view-resolve-detail', function () {
        $("#complainId").val($(this).attr('data-complain-id'));
        $("#complainNumber").val($(this).attr('data-complain-number'));
        //$('#customerId').val($(this).attr('data-customer-id'));
        $('#customerName').val($(this).attr('data-customer-name'));
        $("#customerMobile").val($(this).attr('data-customer-mobile'));

        $("#subdivisionName").val($(this).attr('data-subdivision-name'));
        $('#customerAddress').val($(this).attr('data-customer-address'));
        $('#linemanMobile').val($(this).attr('data-lineman-number'));
        $("#linemanName").val($(this).attr('data-lineman-name'));
        $("#complaintComment").val($(this).attr('data-complaint-comment'));
        $("#resolutionComment").val($(this).attr('data-resolution-comment'));
        $("#complainCategory").val($(this).attr('data-complain-category'));
        $("#consumerNumber").val($(this).attr('data-consumer-number'));
        $("#assignedPerson").val($(this).attr('data-assigned-person'));

        // show model box
        $('#resolveModal').modal({backdrop: 'static', keyboard: false});
    });


    //get all resolve complain
    function getAllResolveComplain()
    {
        $.ajax(
                {
                    url: 'ajax-process.php?action=getAllResolveComplain',
                    type: "POST",
                    success: function (result)
                    {
                        $('#resolve-data-list').html(result);
                        return;
                    },
                    error: function (error)
                    {
                        alert('error; ' + eval(error));
                    }
                });
    }
    
    //get count resolve complain
    function getCountResolvedComplain()
    {
        $.ajax(
                {
                    url: 'ajax-process.php?action=getCountResolvedComplain',
                    type: "POST",
                    success: function (result)
                    {     
                        $('#count-resolve-complaints').text(result);
                        if(result<2)
                        {
                            $('#count-complaints-text').text('complaint');
                        }
                        else{
                            $('#count-complaints-text').text('complaints');
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