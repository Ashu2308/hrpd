<?php 
include_once('DAO/ReportDAO.php');

//Creating objects
$ReportDAO = new ReportDAO();
$last_months = 1;
if(isset( $_SESSION['area_id'])){
	$district = $_SESSION['area_id'];
}else{
	$district = 0;
}
$data_1 = $ReportDAO->complainCloseInLessThanOneHour($last_months, $district);
$data_1_2 = $ReportDAO->complainCloseInBetweenOneAndTwoHour($last_months, $district);
$data_2_3 = $ReportDAO->complainCloseInBetweenTwoAndThreeHour($last_months, $district);
$data_3_4 = $ReportDAO->complainCloseInBetweenThreeAndFourHour($last_months, $district);
$data_4 = $ReportDAO->complainCloseInGreaterThanFourHour($last_months, $district);
$report_data = array_merge($data_1, $data_1_2, $data_2_3, $data_3_4, $data_4);
echo json_encode($report_data);
?>
<!DOCTYPE html>
<style>
	* {
		font-size: 12px;
		font-family: "Lucida Grande","DejaVu Sans","Bitstream Vera Sans",Verdana,Arial,sans-serif;
	}
	.legend rect {
		fill:white;
		opacity:0.4;
		position: absolute;;
		right: 0;
	}

	path.slice {
		transition: fill-opacity .4s ease;
	}

	.slice-label {
		cursor: pointer;
	}
</style>

<body>
	<div id="ChartAccessAgesByCountD3" style="height:220px; margin-top:30px" data-drilldown-destination="filelist_by_category" data-drilldown-key="atime" ></div>
</body>

<script src="js/chart/d3.legend.js"></script>
<script>
	var jsondata = '<?php echo json_encode($report_data) ?>';
	//alert(jsondata);
	$(document).ready(function(){
	$("#last-months, #district").on('change', function(){
			var months = $("#last-months option:selected").val();
		   	var district = $("#district option:selected").val();
		    var formURL = "ajax-process.php?action=refresh-graph&months="+months+"&district="+district;
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
                            if (result != ''){
                            	//Initialized Graph with current response
                            	jsondata = result;
								init(jsondata);                                
                            } else{
                                alert("Something going wrong");
                            }
                        }
                    });
		});
	});

	
	$(document).ready(function(){
		var jsondata = '<?php echo json_encode($report_data) ?>';
		init(jsondata);
	});

	function init(jsondata) {
		drawPieChartAccessAgesByCountD3(jsondata);
	}

	function drawPieChartAccessAgesByCountD3(jsondata) {
		var st = {};
		st.data = JSON.parse(jsondata);
		drawD3PieChart("#ChartAccessAgesByCountD3", st.data, [0, 1, 2, 3, 4, 5]);
	}

	function drawD3PieChart(sel, data, row_id_to_bucket_num) {
		// clear any previously rendered svg
		$(sel + " svg").remove();
		// compute total
		tot = 0;
		data.forEach(function(e) {
			tot += parseInt(e.value);
			//alert(tot);
		});
		var w = $(sel).width();
		var h = $(sel).height();
		var r = Math.min(w, h) / 2;
		var color = d3.scale.ordinal().range(["#168eea", "#d14628", "#f0b21a", "#79819a", "#6bb145"]);
		var vis = d3.select(sel).append("svg:svg").attr("data-chart-context", sel).data([data]).attr("width", w).attr("height", h).append("svg:g").attr("transform", "translate(" + (w / 3) + "," + r + ")");
		var svgParent = d3.select("svg[data-chart-context='" + sel + "']");
		var pie = d3.layout.pie().value(function(d) {
			return d.value;
		});
		var arc = d3.svg.arc().outerRadius(r);
		var arcs = vis.selectAll("g.slice").data(pie).enter().append("svg:g").attr("class", "slice");
		arcs.append("svg:path")
		.attr("fill", function(d, i) {
			return color(i);
		})
		.attr("stroke", "#fff")
		.attr("stroke-width", "1")
		.attr("d", function(d) {
				//console.log(arc(d));
				return arc(d);
			})
		.attr("data-legend", function(d) {
			return d.data.label;
		})
		.attr("data-legend-pos", function(d) {
			return d.data.pos;
		})
		.classed("slice", true)
		.on("click", function(e) {
				var chartDiv = $(sel); // retrieve id of chart container div
				var selectedValue = $(this).attr("data-legend-pos");
				var bucket = row_id_to_bucket_num[selectedValue];
				var dest = chartDiv.attr("data-drilldown-destination");
				var param = chartDiv.attr("data-drilldown-key");
				var baseURL = dest + "/?" + param + "=";
				//window.location = baseURL + bucket;
				//alert("drill down to " + baseURL + bucket);
			})
		.on("mouseover", function(e) {
			//$(this)
			$("#tooltip")
                      .html(d.data.label)
                      .show();
			
			
		})
		.on("mouseout", function(e) {
			$(this)
			.attr("fill-opacity", "1")
			.css({
				"stroke-width": "0px"
			});
		})
		.attr("style", "cursor:pointer;")
		.append("svg:title")
		.text(function(d) {
			return d.data.label;
		});

		arcs.append("svg:text").attr("transform", function(d) {
			d.innerRadius = 0;
			d.outerRadius = r;
			return "translate(" + arc.centroid(d) + ")";
		}).attr("text-anchor", "middle").text(function(d, i) {
			return (data[i].value / tot) * 100 > 10 ? ((data[i].value / tot) * 100).toFixed(1) + "%" + "\n" + data[i].value  : data[i].value;
		}).attr("fill", "#fff")
		.classed("slice-label", true);

		legend = svgParent.append("g")
		.attr("class", "legend")
		.attr("transform", "translate(600,20)")
		.style("font-size", "12px")
		.call(d3.legend);
	}
</script>
</html>