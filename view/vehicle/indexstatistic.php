<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    include_once "{$base_dir}/layout/masteradmin.php";
?>

<div class="card-body private">
<h5 class="card-title">Basic Datatable</h5>
	<div class="table-responsive">
	    <table id="zero_config" class="table table-striped table-bordered">
	        <thead>
	            <tr>
	                <th class="font-weight-bold text-center">Id</th>
	                <th class="font-weight-bold text-center">Height</th>
	                <th class="font-weight-bold text-center">Volume</th>
	                <th class="font-weight-bold text-center">Vehicle Name</th>
	                <th class="font-weight-bold text-center">Recorded At</th>
	                <th class="font-weight-bold text-center">Action</th>
	            </tr>
	        </thead>
	        <tbody>
		        <?php foreach ($statisticlist as $statis): ?>
			        <tr>
			            <td class="text-center"><?php echo $statis->id; ?></td>
			            <td class="text-right"><?php echo $statis->height; ?></td>
			            <td class='text-right'><?php echo $statis->volume; ?></td>
			            <td><a href="../../controller/VehicleController.php<?php echo '?action=show&id='.$statis->vehicle_id;?>"><?php echo $statis->name;?></a></td>
			            <td><?php echo $statis->created_at;?></td>
			            <td class="text-center">
			                <button  class=" btn btn-danger btn-sm"><a href="../../controller/VehicleController.php<?php echo '?action=statisticdelete&id='.$statis->id; ?>" class="text-white">delete</a>
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