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
$report_data = $ReportDAO->highestComplaintCategory($last_months, $year, $district);

//echo json_encode($report_data);
?>
<!DOCTYPE html>
<meta charset="utf-8">
<head>
    <style>
        .bar{
            fill: #168eea;
        }
        .text-bar{
            position: absolute;
            left:50px;
        }
        .bar:hover{
            fill: #168eaa;
        }

        .axis {
            font: 12px sans-serif;
        }

        .axis path,
        .axis line {
            fill: none;
            stroke: #000;
            shape-rendering: crispEdges;
        }

    </style>
</head>

<body>
    <div id="bar-graph" style="margin-top:0px" data-drilldown-destination="filelist_by_category" data-drilldown-key="atime" ></div>

    <script>

        $(document).ready(function () {
            $("#last-months, #district").on('change', function () {
                var months = $("#last-months option:selected").attr('data-month');
                var year = $("#last-months option:selected").attr('data-year');
                var district = $("#district option:selected").val();
                var formURL = "ajax-process.php?action=refresh-bar-graph&months=" + months + "&year=" + year+"&district=" + district;
                //alert(formURL);
                $.ajax({
                    url: formURL,
                    type: "POST",
                    async: false,
                    cache: false,
                    //data: postData,
                    error: function () {
                        //return true;
                    },
                    success: function (result)
                    {
                        if (result != '') {
                            //remove previous graph
                            $("#bar-graph").html('');

                            //Initialized Graph with current response
                            data = result;
                            //data = [{"complaint_category":"d","total_complaint":"16"},{"complaint_category":"ef","total_complaint":"21"},{"complaint_category":"efd","total_complaint":"6"}];
                            bar_graph(data);
                        } else {
                            alert("Something going wrong");
                        }
                    }
                });
            });
            var data = {};
        });

        $(document).ready(function () {
            data = '<?php echo json_encode($report_data) ?>';
            bar_graph(data);
        })

        function bar_graph(data) {
            var data = data;

// set the dimensions of the canvas
            var margin = {top: 20, right: 20, bottom: 180, left: 250},
                    width = 800 - margin.left - margin.right,
                    height = 370 - margin.top - margin.bottom;


// set the ranges
            var x = d3.scale.ordinal().rangeRoundBands([0, width], 0.5);

            var y = d3.scale.linear().range([height, 0]);

// define the axis
            var xAxis = d3.svg.axis()
                    .scale(x)
                    .orient("bottom")


            var yAxis = d3.svg.axis()
                    .scale(y)
                    .orient("left")
                    .ticks(10);


// add the SVG element
            var svg = d3.select("#bar-graph").append("svg")
                    .attr("width", width + margin.left + margin.right)
                    .attr("height", height + margin.top + margin.bottom)
                    .append("g")
                    .attr("transform",
                            "translate(" + margin.left + "," + margin.top + ")");


// load the data
//d3.json("data.json", function(error, data) {
            data = JSON.parse(data);
            data.forEach(function (d) {
                d.complaint_category = d.complaint_category;
                d.total_complaint = +d.total_complaint;
            });

            // scale the range of the data
            x.domain(data.map(function (d) {
                return d.complaint_category;
            }));
            y.domain([0, d3.max(data, function (d) {
                    return d.total_complaint;
                })]);

            // add axis
            svg.append("g")
                    .attr("class", "x axis")
                    .attr("transform", "translate(0," + height + ")")
                    .call(xAxis)
                    .selectAll("text")
                    .style("text-anchor", "end")
                    .attr("dx", "-1em")
                    .attr("dy", "1em")
                    .style("word-wrap", "break-word")
                    .style("width", "10px")
                    .attr("transform", "rotate(-45)");

            svg.append("g")
                    .attr("class", "y axis")
                    .call(yAxis)
                    .append("text")
                    .attr("transform", "rotate(-90)")
                    .attr("y", 5)
                    .attr("dy", ".71em")
                    .style("text-anchor", "end")
                    .text("No. of Complaints");


            // Create bar chart
            svg.selectAll("bar")
                    .data(data)
                    .enter().append("rect")
                    .attr("class", "bar")
                    .attr("text-anchor", "middle")
                    .attr("x", function (d) {
                        return x(d.complaint_category);
                    })
                    .attr("width", x.rangeBand())
                    .attr("y", function (d) {
                        return y(d.total_complaint);
                    })
                    .attr("height", function (d) {
                        return height - y(d.total_complaint);
                    })
                    .text(function (d) {
                        return d.total_complaint;
                    });

            // Add number of complaints count in bar chart
            svg.selectAll("text-bar")
                    .data(data)
                    .enter().append("text")
                    .attr("class", "text-bar")
                    .attr("transform", "translate(10,-10)")
                    .attr("text-anchor", "start")
                    .attr("x", function (d) {
                        return x(d.complaint_category);
                    })
                    .attr("width", x.rangeBand())
                    .attr("y", function (d) {
                        return y(d.total_complaint);
                    })
                    .attr("height", function (d) {
                        return height - y(d.total_complaint);
                    })
                    .text(function (d) {
                        return d.total_complaint;
                    });
//});
        }

    </script>

</body>
</html>