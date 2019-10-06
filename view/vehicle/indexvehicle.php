    <?php
	    $ds = DIRECTORY_SEPARATOR;
	    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
	    include_once "{$base_dir}/layout/masteradmin.php";
    ?>
	<div class="card-body">
		<h5 class="card-title">Vehicle Table</h5>
			<div class="table-responsive">
			    <table id="zero_config" class="table table-striped table-bordered">
			        <thead>
			            <tr>
			                <th class="font-weight-bold text-center">Id</th>
			                <th class="font-weight-bold text-center">RFID Code</th>
			                <th class="font-weight-bold text-center">Name</th>
			                <th class="font-weight-bold text-center">Action</th>
			            </tr>
			        </thead>
			         <tbody>
		        <?php foreach ($vehiclelist as $vehicle): ?>
	    	<tr>
	    		<td class="text-center"><?php echo $vehicle->id; ?></td>
	    		<td class="text-center"><?php echo $vehicle->rfid; ?></td>
	    		<td><a href="../../controller/VehicleController.php<?php echo '?action=show&id='.$vehicle->id; ?>"><?php echo $vehicle->name; ?></a></td>
	    		<td class="text-center">
	    			<button  class=" btn btn-info btn-sm"><a href="../../controller/VehicleController.php<?php echo '?action=detail&id='.$vehicle->id; ?>" class="text-white">detail</a>
	    			</button>
	    			<button  class=" btn btn-warning btn-sm"><a href="../../controller/VehicleController.php<?php echo '?action=edit&id='.$vehicle->id; ?>" class="text-white" >edit</a>
	    			</button>
	    			<button  class=" btn btn-danger btn-sm"><a href="../../controller/VehicleController.php<?php echo '?action=delete&id='.$vehicle->id; ?>" class="text-white">delete</a>
	    			</button>
	    		</td>
	    	</tr>
	    <?php endforeach ?>
		    </tbody>
			    </table>
			</div>
		</div>
	<?php
    		include_once "{$base_dir}/layout/footeradmin.php";
	?>