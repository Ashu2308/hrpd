<?php
include_once('header.php');
include_once('DAO/AreaDAO.php');
include_once('DAO/ComplainDAO.php');
include_once('DAO/ReportDAO.php');

//Creating users
$ComplainDAO = new ComplainDAO();
$AreaDAO = new AreaDAO();
$ReportDAO = new ReportDAO();

$district = $AreaDAO->getAllActiveArea();
$disabled = "";

$last_months = date('m');
$year = date('Y');

if ($_SESSION['area_id'] > 0) {
    $district_id = $_SESSION['area_id'];
    $disabled = "disabled = disabled";
} else {
    $district_id = 0;
}
?>
<style>
    .link-btn{
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border-radius: 4px;
    float: right;
    border: 1px solid;
    background: #d4d4d4;
    border-radius: 4px;
}
</style>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title" style="display: inline-block"><img src="img/report.png"> Excel Report </h3>
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
                            <option value="<?php echo $district['area_id'] ?>" <?php
                            if ($district['area_id'] == $district_id) {
                                echo "selected";
                            }
                            ?> ><?php echo $district['label'] ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-lg-8">
                    <a href="excel.php?month=<?php echo $last_months?>&year=<?php echo $year?>" target="_blank" class="link-btn"> Download Full Reports </a>
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
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>    
                                            <th>Complaint Category Name</th>                                   
                                            <th>Total No. of Complaints</th>
                                        </tr>
                                    </thead>
                                    <tbody id="excel-report">
                                        <?php
                                        $setRec = $ReportDAO->getComplaintCategory();
                                        foreach ($setRec as $key => $val) {

                                            $complain_category_id = $val['complain_category_id'];
                                            $total = 0;

                                            $results = $ReportDAO->getComplaintNumberByCategory($last_months, $year, $district_id, $complain_category_id);
                                            foreach ($results as $key => $result) {
                                                $total = $total + $result['counted'];
                                            }
                                            echo '<tr><td>' . $complain_category_id . '</td><td>' . $val['Category'] . ' </td><td>' . $total . '</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-wrapper -->
            <?php include_once('footer.php'); ?>

            <script src="js/chart/jquery-2.1.1.min.js"></script>
            <script>
            $(document).ready(function () {
                $("#last-months, #district").on('change', function () {
                    var months = $("#last-months option:selected").attr('data-month');
                    var year = $("#last-months option:selected").attr('data-year');
                    var district = $("#district option:selected").val();
                    var formURL = "ajax-process.php?action=refresh-excel&months=" + months + "&year=" + year + "&district_id=" + district;
                    $.ajax({
                        url: formURL,
                        type: "POST",
                        async: false,
                        cache: false,
                        error: function () {
                            //return true;
                        },
                        success: function (result)
                        {
                            if (result != '') {
                                $("#excel-report").html(result);
                                $(".link-btn").attr("href", "excel.php?month="+months+"&year="+year+"&district_id="+district);
                            } else {
                                alert("Something going wrong");
                            }
                        }
                    });
                });
            });
            </script>