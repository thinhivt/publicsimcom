<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    include_once "{$base_dir}/layout/masteradmin.php";
    if(isset($_SESSION['response'])){
        $response=$_SESSION['response'];
        $_SESSION['response']=null;
    }
?>
<div class="card vh-100 mb-0" style="height:600px;">
    <div class="card-title bg-info pb-2">
        <h3 class="text-center text-white mt-3">Change Vehicle Information</h3>
    </div>
    <div class="card-body">
        <form action="../../controller/VehicleController.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group m-t-20">
                        <label for="name">Vehicle Name<span class="text-danger ml-1">&#42;</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Tạo tên phương tiện" value="<?php echo $vehicle->name; ?>">
                        <?php 
                            if(isset($response['error']['name'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['name'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                   <div class="form-group">
                        <label for="rfid">RFID Code<span class="text-danger ml-1">&#42;</span></label>
                        <input type="text" class="form-control" id="rfid" name="rfid" placeholder="Nhập mã thẻ rfid phương tiện" value="<?php echo $vehicle->rfid; ?>">
                    </div>
                     <?php 
                            if(isset($response['error']['rfid'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['rfid'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                </div>
                <div>
                    <input type="hidden" name="action" value="save">
                    <input type="hidden" name="id" value="<?php echo $vehicle->id; ?>">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-info">Update</button>
            </div>
        </form>
    </div>
    
</div>
<?php
    include_once "{$base_dir}/layout/footeradmin.php";
?>