<?php
include_once('DAO/ReportDAO.php');

//Creating objects
$ReportDAO = new ReportDAO();
$last_months = date('m');
$year = date('Y');
if (isset($_SESSION['area_id'])) {
    $district = $_SESSION['area_id'];
} else {
    $district = 0;
}
$data_1 = $ReportDAO->complainCloseInLessThanOneHour($last_months, $year, $district);
$data_1_2 = $ReportDAO->complainCloseInBetweenOneAndTwoHour($last_months, $year, $district);
$data_2_3 = $ReportDAO->complainCloseInBetweenTwoAndThreeHour($last_months, $year, $district);
$data_3_4 = $ReportDAO->complainCloseInBetweenThreeAndFourHour($last_months, $year, $district);
$data_4 = $ReportDAO->complainCloseInGreaterThanFourHour($last_months, $year, $district);
$report_data = array_merge($data_1, $data_1_2, $data_2_3, $data_3_4, $data_4);

//echo '<pre>';
//print_r($report_data);
?>
<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            #pie svg{
                width: 700px !important;
                padding-left: 100px;
                font-size: 12px;
                display: inline-block;
                float: left;
            }
            .p1_segmentMainLabel-outer{
                font-size: 12px !important;
            }
        </style>
    </head>

    <body>

        <div id="pie"></div>
        <div id="complaint-legends">
            <h3 class="panel-title">
            <?php
            $totComplaint=0;
            foreach($report_data as $key=>$val){
                //echo "<tr><td>". $val['label'] .'</td><td>'. $val['value'] .'</td></tr>';
                $totComplaint = $totComplaint+$val['value'];
            }
            echo "Total Resolved Complaints : ". $totComplaint .'';
            ?>
            </h3>
            <table>
                <tbody>
            <?php
            foreach($report_data as $key=>$val){
                echo "<tr><td>". $val['label'] .'</td><td>'. $val['value'] .'</td></tr>';
                $totComplaint = $totComplaint+$val['value'];
            }
            ?>
                </tbody>
            </table>
        </div>

        <script src="js/chart/d3.min.js"></script>
        <script src="js/chart/d3pie.js"></script>
        <script>
            $(document).ready(function () {
                $("#last-months, #district").on('change', function () {
                    var months = $("#last-months option:selected").attr('data-month');
                    var year = $("#last-months option:selected").attr('data-year');
                    var district = $("#district option:selected").val();
                    var formURL = "ajax-process.php?action=refresh-graph&months=" + months + "&year=" + year + "&district=" + district;
                    $.ajax({
                        url: formURL,
                        type: "POST",
                        async: false,
                        cache: false,
                        //dataType: "json",
                        //data: postData,
                        error: function () {
                            //return true;
                        },
                        success: function (result)
                        {
                            if (result != '') {
                                $("#pie").html('');
                                //Initialized Graph with current response
                                var jsondata = result;
                                create_pie_graph(jsondata);
                                var data =  jQuery.parseJSON(result);//jsondata;
                                var totComplaint = 0;
                                $.each(data, function(i, item) {
                                    totComplaint = totComplaint + parseInt(data[i].value);
                                });
                                legends = '<h3 class="panel-title"> Total Resolved Complaints : </td><td>'+ totComplaint +'</h3>';
                                var legends = legends + '<table><tbody>';
                                $.each(data, function(i, item) {
                                    legends = legends + "<tr><td>" +data[i].label+"</td><td>"+ data[i].value+"</td></tr>";
                                });
                                legends = legends+"</tbody></table>";
                                $("#complaint-legends").html(legends);
                            } else {
                                alert("Something going wrong");
                            }
                        }
                    });
                });
            });
            //var data = '<?php echo json_encode($report_data) ?>';
            $(document).ready(function () {
                var data = '<?php echo json_encode($report_data) ?>';
                create_pie_graph(data);
            });

            function create_pie_graph(data) {
                data = JSON.parse(data);
                var arrData = [];
                var objData = {};

                for (i in data) {
                    var tempObj = data[i];
                    var value = parseInt(tempObj.value);
                    value = isNaN(value) ? 0 : value;

                    objData = {
                        label: tempObj.label,
                        value: value
                    }
                    arrData.push(objData);
                }
                //var static_data = [{"label":"Complaints closed in < 1 hrs","value":0},{"label":"Complaints closed between 1-2 hrs","value":0},{"label":"Complaints closed between 2-3 hrs","value":60},{"label":"Complaints closed between 3-4 hrs","value":40},{"label":"Complaints closed in >4 hrs","value":10}];
                //console.log(arrData);

                var pie = new d3pie("pie", {
                    data: {
                        //content: [{"label":"Complaints closed in < 1 hrs","value":427},{"label":"Complaints closed between 1-2 hrs","value":187},{"label":"Complaints closed between 2-3 hrs","value":2},{"label":"Complaints closed between 3-4 hrs","value":1},{"label":"Complaints closed in >4 hrs","value":6}]
                        content: arrData
                    },
                });
            }

        </script>
    </body>
</html>