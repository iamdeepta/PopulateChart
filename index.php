<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title></title>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script type="text/javascript">
	$(document).ready(function () {
			var dataPoints = [];
			var chart = new CanvasJS.Chart("chartContainer",
			{
				title: {
					text: "Select Year From Dropdown",
					verticalAlign: "center"
				},
				axisX: {
					valueFormatString: "D MMM YYYY",
				},
				data: [{
				//showInLegend: true,
				type: 'column',
				xValueType: "dateTime",
				xValueFormatString:"D MMM YYYY",
				
				name: "series1",
				dataPoints: dataPoints 

				}]
			});
			chart.render()
			
			 $.getJSON("getYear.php", function(result){
				$.each(result, function(i, field){
					$(".dropdown").append("<option value='"+field+"'>"+field+"</option>");
				});
			 });
			 
			 
			 $( ".dropdown" ).change(function() {
				chart.options.data[0].dataPoints = [];
				var e = document.getElementById("dd");
				var selectedYear = e.options[e.selectedIndex].value;
				if( !isNaN(Number(selectedYear)) ) {
					chart.options.title.text = "Year: " + selectedYear;
					chart.options.title.verticalAlign = "top";
					var data = { "year" : selectedYear }
					$.getJSON("getData.php", data, function(result){
						chart.options.data[0].dataPoints = result;
						chart.render();
					})
				} else {
					chart.options.title.text = "Select Year From Dropdown";
					chart.options.title.verticalAlign = "center";
				}
				chart.render()
			});
	});
        
    </script>
</head>
<body>
<select class="dropdown" id="dd">
	<option selected value="none">Select Year</option>
</select>
<div id="chartContainer" style="height: 360px; width: 100%;"></div>
</body>
</html>