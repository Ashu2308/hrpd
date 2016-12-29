<?php
include_once('header.php');
include_once('DAO/AreaDAO.php');
include_once('DAO/ComplainDAO.php');

//Creating users
$ComplainDAO = new ComplainDAO();
$AreaDAO = new AreaDAO();

$result = $ComplainDAO->getAllPendingComplain();
$district = $AreaDAO->getAllActiveArea();

$disabled = "";
if($_SESSION['area_id']>0){
    $district_id = $_SESSION['area_id'];
    $disabled = "disabled = disabled";
}else{
    $district_id = 0;
}


?>
<div id="page-wrapper">
        <div class="container-fluid">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" style="display: inline-block"><img src="img/complaint.png"> Graphical representation of Complaint </h3>
                </div>
                <form>
                    <div class="form-group col-lg-2">
                        <label> Select Time Duration </label>
                        <select name="last-months" class="form-control" id="last-months">
                            <option >Select</option>
                            <option value="1">Current Month</option>
                            <option value="2">Last Month</option>
                            <option value="3">All</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-2">
                        <label>Select District</label>
                        <select name="district" class="form-control" id="district" <?=$disabled?>>
                            <option >Select</option>
                            <?php
                            foreach ($district as $district) { 
                                ?>
                                <option value="<?php echo $district['area_id'] ?>" <?php if($district['area_id'] == $district_id){ echo "selected"; } ?> ><?php echo $district['label'] ?></option>
                            <?php }?>
                        </select>
                    </div>
                </form>
                <div class="row" style="margin-top:10px">
                    <div class="col-lg-12">
                        <?php include_once('line.php'); ?>
                    </div>
                    <div class="col-lg-12">
                        <?php include_once('report.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->
<?php include_once('footer.php'); ?>