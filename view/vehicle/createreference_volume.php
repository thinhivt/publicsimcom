<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    include_once "{$base_dir}/layout/masteradmin.php";
    if(isset($_SESSION['response'])){
        $response=$_SESSION['response'];
        $_SESSION['response']=null;
    }
     if(isset($_SESSION['data_post'])){
        $data_post=$_SESSION['data_post'];
        $_SESSION['data_post']=null;
    }
   
?>
<div class="card vh-100 mb-0" style="height:600px;">
    <div class="card-title bg-info pb-2">
        <h3 class="text-center text-white mt-3">Create Reference Data</h3>
    </div>
    <div class="card-body">
        <form action="../../controller/VehicleController.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>Choose vehicle to add data</label>
                </div>
                <div class="col-md-8 form-group">
                    <select name="vehicle_id" class="form-control">
                        <option value="">------------ chọn phương tiện cần import file ------------</option>
                        <?php foreach ($vehiclelist as $vehicle) { ?>
                           <option value="<?php echo $vehicle->id; ?> "><?php echo $vehicle->name;  ?> </option>
                        <?php } ?>

                    </select>
                    <?php 
                        if(isset($response['error']['vehicle_id'])){
                    ?>
                        <div class="alert alert-danger mt-2" role="alert">
                    <?php 
                        echo $response['error']['vehicle_id'];
                    ?>
                        </div>
                    <?php
                        }
                    ?>
                </div>
                 <div class="col-md-4 form-group">
                    <label>Choose CSV File to import</label>
                </div>
                <div class="col-md-8 form-group">
                   <input type="file" name="csv">
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
            <div>
                <input type="hidden" name="action" value="create_ref">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-info">Add</button>
            </div>
        </form>
    </div>
</div>
<?php
    include_once "{$base_dir}/layout/footeradmin.php";
?>