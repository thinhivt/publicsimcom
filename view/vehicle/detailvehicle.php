<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    include_once "{$base_dir}/layout/masteradmin.php";
    if(isset($_SESSION['response'])){
        $response=$_SESSION['response'];
        $_SESSION['response']=null;
    }
    ?>
<div class="card bg-white">
	<div class="card-title bg-info py-3 text-center">
    	<h4 class="text-white"><?php echo $vehicle->name; ?></h4>
	</div>
	<div class="card-body">
		<div class="card border rounded px-2 py-2">
			<div >
		    	<h5 class="">Basic information</h5>
		    </div>
		    <div class="row pl-2">
		    	<div class="col-4">
		    		<label>Name:</label>	
		    	</div>
		    	<div class="col-6">
		    		<label><?php echo $vehicle->name;  ?></label>
		    	</div>
		    	<div class="col-4">
		    		<label>RFID Code:</label>	
		    	</div>
		    	<div class="col-6">
		    		<label><?php echo $vehicle->rfid;  ?></label>
		    	</div>
		    	<div class="col-4">
		    		<label>Attached Sim:</label>	
		    	</div>
		    	<div class="col-6">
		    		<label><?php echo $vehicle->phone;  ?></label>
		    	</div>
		    	<div class="col-4">
		    		<label>Created at:</label>	
		    	</div>
		    	<div class="col-6">
		    		<label><?php echo $vehicle->created_at;  ?></label>
		    	</div>
		    	<div class="col-4">
		    		<label>Update CSV file:</label>	
		    	</div>
		    	<div class="col-6">
		    		<form action="../../controller/VehicleController.php" method="post" enctype="multipart/form-data">
		    			<input type="file" name="csv" title="choose CSV file to update!" >
		    			<input type="hidden" id="vehicle_id" id="<?php echo $vehicle->id;?>" name="vehicle_id" value="<?php echo $vehicle->id; ?>">
		    			<input type="hidden" name="action" value="update_ref">
		    			<input type="submit" name="update" value="Upload" class="bg-info text-white my-2">
		    		</form>
		    	</div>

		    </div>
		    <div class="col-md-12 form-group">
                    <?php 
                        if(isset($response['error']['csv'])){
                    ?>
                        <div class="alert alert-danger mt-2" role="alert">
                    <?php 
                        echo $response['error']['csv'];
                    ?>
                         </div>
                    <?php
                        }
                    ?>
            </div>
		</div>
		<!--  -->
		<div class="card border rounded px-2 py-2">
			<div >
		    	<h5 class="">Parameter Vehicle</h5>
		    </div>
			<div class="row pl-2">
		    	<div class="col-4">
		    		<label>Max height:</label>	
		    	</div>
		    	<div class="col-6">
		    		<label id="max_height"></label>
		    	</div>
		    	<div class="col-4">
		    		<label>Current height:</label>	
		    	</div>
		    	<div class="col-6">
		    		<label id="current_height"></label>
		    	</div>
		    	<div class="col-4">
		    		<label>Max Volume:</label>	
		    	</div>
		    	<div class="col-6">
		    		<label id="max_volume"></label>
		    	</div>
		    	<div class="col-4">
		    		<label>Current Volume:</label>	
		    	</div>
		    	<div class="col-6">
		    		<label id="current_volume"></label>
		    	</div>
		    </div>
			
		    <div class="progress" style="height: 40px;">
			  <div class="progress-bar progress-bar-striped progress-bar-animated py-4" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="animation">
			  	<h3 id="percentage" class="text-center"></h3>
			  </div>
			</div>
		    <script type="text/javascript">
		    	// var $("#vehicle_id").attr().value; 
		    	var id=document.getElementById("vehicle_id").value;
		    	var parameter = setInterval(getrequest, 1000);
				  	function getrequest(){
				    $.ajax({
					        url:'../../controller/VehicleController.php?action=interrupt&id='+id,
					        method:'GET',
					        data:JSON,
					        success:function(data){
					        	data=JSON.parse(data);
					            $("#current_volume").html(data.currentvolume);
					            $("#max_volume").html(data.maxvolume);
					            $("#current_height").html(data.currentheight);
					            $("#max_height").html(data.maxheight);
					            $("#percentage").html(data.percentage+"%");
					            $("#animation").css("width",data.percentage+'%');
					        }
			        	});
				    }
			</script>
		</div>
		<!--  -->
		<div class="card border rounded px-2 py-2">
			<div >
		    	<h5 class="">Timing Chart</h5>
		    </div>
		    <p id="timingchart"></p>
		    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
		    <script>
		    	var chart = setInterval(timingchart,1000);
		    	var id=document.getElementById("vehicle_id").value;
		    	var dataP=[];
				function timingchart(){
					var chart = new CanvasJS.Chart("chartContainer", {
					    animationEnabled: false,  
					    title:{
					        text: "Timing volume chart"

					    },
					    axisY: {
					        valueFormatString: "#",
					        suffix: "lit",
					    },
					    axisX:{
					    	valueFormatString:"#"
					    },
					    data: [{
					        type: "splineArea",
					        color: "rgb(158, 213, 175)",
					        markerSize: 5,
					        xValueFormatString: "#",
					        yValueFormatString: "#",
					        dataPoints:dataP
					    }]
					});
					chart.render();
					$.ajax({
					    url:'../../controller/VehicleController.php?action=timing&id='+id,
					    method:'GET',
					    data:JSON,
					    success:function(data){
					        data=JSON.parse(data);
					        $("#timingchart").html(data[1]);
					        console.log(data[1].height);
					        dataP=[];
					     	for (var i =1; i <= data.length ; i++) {
								dataP.push({
									x: i,
									y: parseInt(data[data.length-i].volume)
								});
							}
					    }
			        });
				}
			</script>
		</div>
		<!--  -->
		<div class="card border rounded px-2 py-2">
			<div >
		    	<h5 class="">Detail statistic</h5>
		    </div>
			<div class="row pl-2">
		    	<div class="col-4">
		    		<label>Max height:</label>	
		    	</div>
		    	<div class="col-6">
		    		<label >Hello</label>
		    	</div>
		    </div>
		</div>
		<!--  -->
	    <div class="card border">
	    	<div class="pt-2 pl-2">
		    	<h5>Volume reference</h5>
		    </div>
		    <div class="table-responsive">
		        <table id="zero_config" class="table table-striped table-sm">
		            <thead>
		                <tr>
		                    <th class="font-weight-bold text-center">Id</th>
		                    <th class="font-weight-bold text-center">Height (mm)</th>
		                    <th class="font-weight-bold text-center">Volume (lit)</th>
		                </tr>
		            </thead>
		            <tbody>
		                <?php $i=1; foreach ($reference_volumes as $parameter): ?>
		                <tr>
		                    <td class="text-center"><?php echo $i; ?></td>
		                    <td class="text-center"><?php echo $parameter->height; ?></td>
		                    <td class="text-center"><?php echo $parameter->volume; ?></td>
		                </tr>
		                <?php $i++; ?>
		                <?php endforeach ?>
		            </tbody>
		        </table>
		    </div>
	    </div>
	    
	</div>
</div>
<?php
    include_once "{$base_dir}/layout/footeradmin.php";
    ?>