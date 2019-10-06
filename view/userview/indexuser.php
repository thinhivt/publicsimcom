<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    include_once "{$base_dir}/layout/masteradmin.php";
 ?>
<div class="card-body private">
<h5 class="card-title">User Table</h5>
	<div class="table-responsive">
	    <table id="zero_config" class="table table-striped table-bordered">
	        <thead>
	            <tr>
	                <th class="text-center font-weight-bold">Id</th>
	                <th class="text-center font-weight-bold">Name</th>
	                <th class="text-center font-weight-bold">Email</th>
	                <th class="text-center font-weight-bold">Action</th>
	            </tr>
	        </thead>
	        <tbody>
        <?php foreach ($userlist as $user): ?>
        <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->name; ?></td>
            <td><?php echo $user->email; ?></td>
            <td class="text-center">
                <?php if($_SESSION['author']->role>=2) {  ?>
                  <button  class=" btn btn-primary btn-sm"><a href="../../controller/UserController.php<?php echo '?action=setup&id='.$user->id; ?>" class="text-white">Setup</a>
                  </button>
                <?php  } if($_SESSION['author']->role>=3) { ?>

                <button  class=" btn btn-info btn-sm"><a href="../../controller/UserController.php<?php echo '?action=info&id='.$user->id; ?>" class="text-white">detail</a>
                </button>
                <button  class=" btn btn-warning btn-sm"><a href="../../controller/UserController.php<?php echo '?action=edit&id='.$user->id; ?>" class="text-white" >edit</a>
                </button>
                <button  class=" btn btn-danger btn-sm"><a href="../../controller/UserController.php<?php echo '?action=delete&id='.$user->id; ?>" class="text-white">delete</a>
                </button>
                <?php  } ?>
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