<?php
include_once('header.php');
include_once('DAO/ComplainDAO.php');

//Creating users
$ComplainDAO = new ComplainDAO();
$result = $ComplainDAO->getAllPendingComplain();
?>
<div id="page-wrapper">
    
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="panel panel-primary">
		<!-- Page Heading -->
		<div class="panel-heading">
		    <h3 class="panel-title" style="display: inline-block"><i class="fa fa-fw fa-newspaper-o"></i> Pending Complains</h3>
		</div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
				    <th>Sr. No.</th>
                                    <th>Complain ID</th>
                                    <th>Customer Name</th>
                                    <th>Customer Mobile</th>
                                    <th>Assignee Name</th>
                                    <th>Complaint Date / Time</th>
                                    <th class="center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
				$i = 1;
				foreach($result as $res){ ?>
                                <tr>
				    <td><?php echo $i; ?></td>
                                    <td><?php echo $res['complain_id']; ?></td>
                                    <td><?php echo $res['customer_name']; ?></td>
                                    <td><?php echo $res['customer_mobile']; ?></td>
                                    <td><?php echo $res['assignee_name']; ?></td>
                                    <td><?php echo $res['complain_date']; ?></td>
                                    <td style="width: 18%;">            
                                            <button value="" data-category-id="" data-category="" data-status="" class="btn btn-primary edit-complain center" type="button"><i class="fa fa-edit"></i> Edit</button>
                                    </td>
                                </tr>
                                <?php $i++;} ?>
                            </tbody>
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
<?php include_once('footer.php'); ?>