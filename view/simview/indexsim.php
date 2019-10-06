<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    include_once "{$base_dir}/layout/masteradmin.php";
?>
<div class="card-body private">
<h5 class="card-title">Sim table</h5>
	<div class="table-responsive">
	    <table id="zero_config" class="table table-striped table-bordered">
	        <thead>
	            <tr>
	                <th class="font-weight-bold text-center">No.</th>
	                <th class="font-weight-bold text-center">Phone Number</th>
	                <th class="font-weight-bold text-center">Network Operator</th>
	                <th class="font-weight-bold text-center">Vehicle</th>
	                <th class="font-weight-bold text-center">Action</th>
	            </tr>
	        </thead>
	        <tbody>
		        <?php foreach ($simlist as $sim): ?>
			        <tr>
			            <td class="text-center"><?php echo $sim->id; ?></td>
			            <td class="text-right"><?php echo $sim->phone_number; ?></td>
			            <td class='text-left'><?php echo $sim->network_operator; ?></td>
			            <td><a href="../../controller/VehicleController.php<?php echo '?action=show&id='.$sim->vehicle_id; ?>"><?php echo $sim->name;?></a></td>
			            <td class="text-center">
			                </button>
			                <button  class=" btn btn-warning btn-sm"><a href="../../controller/SimController.php<?php echo '?action=edit&id='.$sim->id; ?>" class="text-white" >edit</a>
			                </button>
			                <button  class=" btn btn-danger btn-sm"><a href="../../controller/SimController.php<?php echo '?action=delete&id='.$sim->id; ?>" class="text-white">delete</a>
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