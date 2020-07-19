<html>
<head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="initial-scale=1,maximum-scale=1,user-scalable=no"
    />
    <title>Flood Early Warning System</title>
    <link rel="stylesheet" href="https://js.arcgis.com/4.13/esri/themes/dark-red/main.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
    body {
        color: #566787;
        background: #f5f5f5;
		font-family: 'Roboto', sans-serif;
	}
	.table-wrapper {
        background: #fff;
        padding: 20px;
        margin: 30px 0;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
	.table-title {
		font-size: 15px;
        padding-bottom: 10px;
        margin: 0 0 10px;
		min-height: 45px;
    }
    .table-title h2 {
        margin: 5px 0 0;
        font-size: 24px;
    }
	.table-title select {
		border-color: #ddd;
		border-width: 0 0 1px 0;
		padding: 3px 10px 3px 5px;
		margin: 0 5px;
	}
	.table-title .show-entries {
		margin-top: 7px;
	}
	
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
    }
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }
    table.table td:last-child {
        width: 130px;
    }
    table.table td a {
        color: #a0a5b1;
        display: inline-block;
        margin: 0 5px;
    }
	table.table td a.view {
        color: #03A9F4;
    }
    table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.delete {
        color: #E34724;
    }
    table.table td i {
        font-size: 19px;
    }    
    .pagination {
        float: right;
        margin: 0 0 5px;
    }
    .pagination li a {
        border: none;
        font-size: 13px;
        min-width: 30px;
        min-height: 30px;
		padding: 0 10px;
        color: #999;
        margin: 0 2px;
        line-height: 30px;
        border-radius: 30px !important;
        text-align: center;
    }
    .pagination li a:hover {
        color: #666;
    }	
    .pagination li.active a {
        background: #03A9F4;
    }
    .pagination li.active a:hover {        
        background: #0397d6;
    }
	.pagination li.disabled i {
        color: #ccc;
    }
    .pagination li i {
        font-size: 16px;
        padding-top: 6px
    }
    .hint-text {
        float: left;
        margin-top: 10px;
        font-size: 13px;
    }
</style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Flood Early Warning System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="index.php">Home </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href=#>Chart <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
        
            <ul class="nav navbar-nav navbar-right">
      <li class="btn-group dropleft">
       <a href="#" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="badge badge-pill badge-danger count" style="border-radius:10px;">!</span><img src="gambar/warning.svg"  width="25" height="25" alt=""></a>
       <ul class="dropdown-menu">
       <a class="dropdown-item"></a>
       </ul>
      </li>
     </ul>
    </nav>

    <script>
    
$(document).ready(function(){
 
 function load_unseen_notification(view = '')
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   data:{view:view},
   dataType:"json",
   success:function(data)
   {
    $('.dropdown-item').html(data.notification);
    if(data.unseen_notification > 0)
    {
     $('.count').html(data.unseen_notification);
    }
    
   }
   
  });
 }
 
 load_unseen_notification();
 

 
 $(document).on('click', '.dropdown-toggle', function(){
  $('.count').html('');
  load_unseen_notification('yes');
 });
 
 setInterval(function(){ 
  load_unseen_notification();; 
 }, 5000);
 
});
</script>



    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script type="text/javascript">
    window.onload = function () {
    	var chart = new CanvasJS.Chart("chartContainer",{
    		title:{
    			text:"Live Data Sensor"
    		},
      	axisX: {						
      		title: "Waktu"
      	},
      	axisY: {						
      		title: "Ketinggian (cm)"
      	},
    		data: [{
    			type: "line",
    			dataPoints : [],
    		},
    		{
    			type: "line",
    			showInLegend: true, 
            legendText: "SensorA1",
    			dataPoints : [],
    		}]
    	});
    	chart.render();
    
    	var chart1 = new CanvasJS.Chart("chartContainer2",{
    		title:{
    			text:"Live Data Sensor"
    		},
      	axisX: {						
      		title: "Waktu"
      	},
      	axisY: {						
      		title: "Ketinggian (cm)"
      	},
    		data: [{
    			type: "line",
    			dataPoints : [],
    		},
    		{
    			type: "line",
    			showInLegend: true, 
            legendText: "SensorA2",
    			dataPoints : [],
    		}]
    	});
    	chart1.render();
    		
    	$.getJSON("service.php", function(data) {  
    		$.each((data), function(key, value){
    			chart.options.data[0].dataPoints.push({label: value[3], y: parseInt(value[1])});
    			chart.options.data[1].dataPoints.push({label: value[3], y: parseInt(value[2])});		
    		});
    		chart.render();
    		updateChart();
    	});
    
    	$.getJSON("service2.php", function(data) {  
    		$.each((data), function(key, value){
    			chart1.options.data[0].dataPoints.push({label: value[3], y: parseInt(value[1])});
    			chart1.options.data[1].dataPoints.push({label: value[3], y: parseInt(value[2])});		
    		});
    		chart1.render();
    		updateChart1();
    	});
    
    	function updateChart() {
    		$.getJSON("service.php", function(data) {		
    			chart.options.data[0].dataPoints = [];
    			chart.options.data[1].dataPoints = [];
    			$.each((data), function(key, value){
    				chart.options.data[0].dataPoints.push({label: value[3], y: parseInt(value[1])});
    				chart.options.data[1].dataPoints.push({label: value[3], y: parseInt(value[2])});		
    			});
    			chart.render();
    		});
    	}
    	
    	function updateChart1() {
    		$.getJSON("service2.php", function(data) {		
    			chart1.options.data[0].dataPoints = [];
    			chart1.options.data[1].dataPoints = [];
    			$.each((data), function(key, value){
    				chart1.options.data[0].dataPoints.push({label: value[3], y: parseInt(value[1])});
    				chart1.options.data[1].dataPoints.push({label: value[3], y: parseInt(value[2])});		
    			});
    			chart1.render();
    		});
    	}
    	setInterval(function(){updateChart(),updateChart1()}, 1000);
    }
    </script>
    
    <div class="text-center">
    <?php 
    require('dbConnect.php');
                
                $sql = 'SELECT data_sensor.no, data_sensor.id_alat, id_alat.nama_alat, data_sensor.ketinggian, id_lokasi.longitude, id_lokasi.latitude, id_lokasi.alamat, data_sensor.status, data_sensor.reading_time FROM data_sensor, id_alat, id_lokasi WHERE no IN (SELECT MAX(data_sensor.no) FROM `data_sensor` GROUP BY data_sensor.id_alat) AND data_sensor.id_alat=id_alat.id_alat AND id_alat.id_lokasi=id_lokasi.id_lokasi';
                
                ?>
	</div>
	
     <div class="container">
        <div class="table-wrapper">			
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-4">
									
					</div>
					<div class="col-sm-4">
						<h2 class="text-center">Sensor <b>Details</b></h2>
					</div>
                    
                </div>
            </div>
            <table class="table table-bordered" style="center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID Alat </th>
                        <th>Nama Alat</th>
                        <th>Alamat </th>
                        <th>Longitude</th>
                        <th>Latitude </th>
                        <th>Grafik</th>
                    </tr>
                </thead>
                <?php 
                
                $no = 1;
				$rs = mysqli_query($con,$sql);
				while($d = mysqli_fetch_array($rs)){
                ?>
                <tbody>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><img src="gambar/nodemcu.jpg" width="30" height="30" alt=""><?php echo $d['id_alat']; ?></td>
                        <td><?php echo $d['nama_alat']; ?></td>
                        <td><?php echo $d['alamat']; ?></td>
                        <td><?php echo $d['longitude']; ?></td>
                        <td><?php echo $d['latitude']; ?></td>
                        <td>
							<a onclick="scrollWin(0, 500)"  title="Graphics" data-toggle="tooltip">
									
										
										<img src="gambar/line_graph.svg" width="25" height="25" alt="">
								
								</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <script>
function scrollWin(x, y) {
  window.scrollBy(x, y);
}
</script>

            <div class="clearfix">
                
                <ul class="pagination">
                    <li class="page-item disabled"><a href=>Previous</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item disabled"><a href="#" >Next</a></li>
                </ul>
            </div>
        </div>
    </div>     
  <table>
    <tr>
<th><div id="chartContainer" style="height: 400px; width: 650px;"></div></th>
<th><div id="chartContainer2" style="height: 400px; width: 650px;"></div></th>
</tr></table>

</body>
</html>