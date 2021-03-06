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
if ($_SESSION['area_id'] > 0) {
    $district_id = $_SESSION['area_id'];
    $disabled = "disabled = disabled";
} else {
    $district_id = 0;
}
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline-block"><img src="img/report.png"> Graphical Report </h3>
            </div>
            <form id="sel-form" class="form-group" method="post" style="margin-top:10px">
                <div class="form-group col-lg-2">
                    <label> Select Time Duration </label>
                    <select name="last-months" class="form-control" id="last-months">

                        <?php
                        for ($i = 0; $i < 12; $i++) {
                            echo '<option value="' . date('Y-m-d', strtotime("-$i month")) . '" data-month = "' . date('m', strtotime("-$i month")) . '" data-year = "' . date('Y', strtotime("-$i month")) . '">' . date('F-Y', strtotime("-$i month")) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group col-lg-2">
                    <label>Select District</label>
                    <select name="district" class="form-control" id="district" <?= $disabled ?>>
                        <option >All District</option>
                        <?php
                        foreach ($district as $district) {
                            ?>
                            <option value="<?php echo $district['area_id'] ?>" <?php if ($district['area_id'] == $district_id) {
                                echo "selected";
                            } ?> ><?php echo $district['label'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-lg-8">
                    <div class="btn btn-default pull-right" style="background: #d4d4d4" onclick="return printDiv('page-wrapper');"> Download Reports </div>
                </div>
            </form>

            <div id="print-area" class="row">
                <aside>
                    <h3>Haryana - Power Distribution Support Services</h3>
                    <div class="col-lg-12" id="selected-values" style="margin: 0 0 10px 20px;">
                        Selected Month: <b><span id="sel-month" style="margin:0 70px 0 0"></span></b>
                        Selected District: <b><span id="sel-district"></span></b>
                    </div>
                </aside>

                <div class="col-lg-12">
                    <div class="col-lg-12 print-head">
                        <h3 class="panel-title" style="display: inline-block"><img src="img/report.png"> Total Registered Complaint </h3>
                    </div>
                    <?php include_once('line-chart.php'); ?>
                </div>

                <div class="col-lg-12 row" style="margin:30px 0 0 0">
                    <div class="col-lg-12">
                        <h3 class="panel-title" style="display: inline-block"><img src="img/report.png"> Resolved Complaint </h3>
                    </div>
                    <?php include_once('new-pie.php'); ?>
                </div>
                
                <div class="col-lg-12 row" style="margin:0">
                    <div class="col-lg-12">
                        <h3 class="panel-title" style="display: inline-block"><img src="img/report.png"> Top 5 Complaint Categories</h3>
                    </div>
                    <?php include_once('bar-chart.php'); ?>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /#page-wrapper -->
<?php include_once('footer.php'); ?>

<script src="js/chart/jquery-2.1.1.min.js"></script>
<script>
    function printDiv(divName) {
        var listbox_mon = document.getElementById("last-months");
        var selectedMonth = $("#last-months option:selected").text();
        document.getElementById("sel-month").innerHTML = selectedMonth;

        var listbox_dis = document.getElementById("district");
        var selIndex_dis = listbox_dis.selectedIndex;
        var selText_dis = listbox_dis.options[selIndex_dis].text;
        document.getElementById("sel-district").innerHTML = selText_dis;
        document.title = selText_dis+"_"+selectedMonth;

        //var printContents = document.getElementById(divName).innerHTML;
        //document.body.innerHTML = printContents;
        window.print();
        window.close();
        prevent.default();
        return false;
    }
</script>