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
        <h3 class="text-center text-white mt-3">Register Sim</h3>
    </div>
    <div class="card-body">
        <form action="../../controller/SimController.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group m-t-20">
                        <label for="phone_number">Phone Number<span class="text-danger ml-1">&#42;</span></label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Nhập số thuê bao" value="<?php if(isset($response)&&empty($response['error']['phone_number'])) echo $data_post['phone_number'] ; else echo null; ?>">
                        <?php 
                            if(isset($response['error']['phone_number'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['phone_number'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="network_operator">Select NetWork Operator<span class="text-danger ml-1">&#42;</span><small class="text-muted">(Chọn nhà Mạng)</small></label>
                        <select class="form-control" name="network_operator" id="network_operator">
                            <option value="">-----------------------------------</option>
                            <option value="Mobifone">Mobifone</option>
                            <option value="Viettel">Viettel</option>
                            <option value="VietnamMobile">VietnameMobile</option>
                            <option value="Vinafone">Vinafone</option>
                        </select>
                        <?php 
                            if(isset($response['error']['network_operator'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['network_operator'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="code">Phone Code<span class="text-danger ml-1">&#42;</span></label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Nhập mã dữ liệu cho thuê bao" value="<?php if(isset($response)&&empty($response['error']['code'])) echo $data_post['code'] ; else echo null; ?>">
                        <?php 
                            if(isset($response['error']['code'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['code'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="vehicle_id">Select Vehicle<span class="text-danger ml-1">&#42;</span><small class="text-muted">(Chọn xe gắn thiết bị)</small></label>
                        <select class="form-control" name="vehicle_id" id="vehicle_id">
                            <option value="">------------------------------------------</option>
                            <?php foreach ($vehiclelist as $vehicle ) { ?>
                            <option value="<?php echo $vehicle->id;?>"><?php echo $vehicle->name; ?></option>
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
                </div>
                <div>
                    <input type="hidden" name="action" value="store">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-info">Create</button>
            </div>
        </form>
    </div>
</div>
<?php
    include_once "{$base_dir}/layout/footeradmin.php";
    ?>