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
    	<h4 class="text-white">User Profile</h4>
	</div>
	<div class="card-body">
		<div class="card border rounded px-2 py-2">
			<div >
		    	<h5 class="my-2">Basic information</h5>
		    </div>
		    <div class="row pl-2">
			    <div class="col-md-3 col-sm-12 row mr-3 mb-3">
			    	<img src="<?php echo $userprofile->avatar;  ?>" class="img-fluid" alt="Responsive image">
			    </div>
			    <div class="col-md-6 col-sm-12 row  mr-3 ">
			    	<div class="col-md-4">
			    		<label>Name:</label>
			    	</div>
			    	<div class="col-md-6">
			    		<label><?php echo $user->name;  ?></label>
			    	</div>
			    	<div class="col-md-4">
			    		<label>Email:</label>
			    	</div>
			    	<div class="col-md-6">
			    		<label><?php echo $user->email;  ?></label>
			    	</div>
			    	<div class="col-md-4">
			    		<label>Phone:</label>
			    	</div>
			    	<div class="col-md-6">
			    		<label><?php echo $userprofile->phone;  ?></label>
			    	</div>
			    	<div class="col-md-4">
			    		<label>Address:</label>
			    	</div>
			    	<div class="col-md-6">
			    		<label><?php echo $userprofile->address;  ?></label>
			    	</div>
			    	<div class="col-md-4">
			    		<label>Position:</label>
			    	</div>
			    	<div class="col-md-6">
			    		<label><?php echo 'employee';  ?></label>
			    	</div>
			    	<div class="col-md-4">
			    		<label>Created at:</label>
			    	</div>
			    	<div class="col-md-6">
			    		<label><?php echo $user->created_at;  ?></label>
			    	</div>
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
	    <div class="card border">
	    	<div class="pt-2 pl-2">
		    	<h5>Consumption history</h5>
		    </div>
		    <div class="table-responsive">
		        <table id="zero_config" class="table table-striped table-sm">
		            <thead>
		                <tr>
		                    <th class="font-weight-bold text-center">No</th>
		                    <th class="font-weight-bold text-center">Volume (lit)</th>
		                    <th class="font-weight-bold text-center">Time at</th>
		                </tr>
		            </thead>
		            <tbody>
		                <tr>
		                    <td class="text-center"></td>
		                    <td class="text-center"></td>
		                    <td class="text-center"></td>
		                </tr>
		            </tbody>
		        </table>
		    </div>
	    </div>
	    
	</div>
</div>
<?php
    include_once "{$base_dir}/layout/footeradmin.php";
?>