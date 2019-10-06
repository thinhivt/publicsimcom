<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    include_once "{$base_dir}/layout/masteradmin.php";
    if(isset($_SESSION['msg'])){
        $response=$_SESSION['msg'];
        $_SESSION['msg']=null;
    }
    ?>
<div class="card-title pl-2 pt-2">
    <h4>Bảng điều khiển</h4>
</div>
<div class="container-fluid">
    <div class="card border rounded px-2 py-2">
        <div >
            <h5 class="">Tổng quan</h5>
        </div>
        <div class="row">
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-cyan text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h1>
                        <h6 class="text-white">Trang chủ</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-4 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-success text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h1>
                        <h6 class="text-white">Thống kê</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-warning text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-collage"></i></h1>
                        <h6 class="text-white">Công cụ</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-danger text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h1>
                        <h6 class="text-white">Bảng quản lý</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-2 col-xlg-3">
                <div class="card card-hover">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white"><i class="mdi mdi-arrow-all"></i></h1>
                        <h6 class="text-white">Mở rộng</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
    </div>
    <div class="card border rounded px-2 py-2">
        <div >
            <h5 class="">Thông số xe</h5>
        </div>
        <div class="row">
            <?php foreach ($combinestatus as $para): ?>
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-sm-12">
                <div class="card card-hover">
                    <div class="text-center text-info border alert-info font-weight-bold">
                        <a href="../../controller/VehicleController.php<?php echo '?action=detail&id='.$para->id; ?>"><?php echo $para->name; ?></a>
                    </div>
                    <div class="row" id="<?php echo $para->id;?>">
                        <div class="col-8 pl-4">
                            <div>
                                <small>Chiều cao (mm): <b class="text-info" id="<?php echo 'height'.$para->id; ?>"><?php echo $para->height; ?></b></small>
                            </div>
                            <div>
                                <small>Thể tích (lit): <b class="text-info" id="<?php echo 'volume'.$para->id; ?>"><?php echo $para->volume; ?></b></small>
                            </div>
                            <div>
                                <small>Trạng thái: <b class="text-info" >Full</b></small>
                            </div>
                            <div>
                                <small>Cảnh báo: <b class="text-info">null</b></small>
                            </div>
                            <div>
                                <small>Ghi tại:<small id="<?php echo 'time'.$para->id;?>" ><b class="text-info" id="<?php echo 'volume'.$para->id; ?>"><?php echo $para->created_at; ?></b></small></small>
                            </div>
                        </div>
                        <div class="col-4 row">
                            <div class="containers col-12 text-center pb-3">
                                <div class="progress progress-bar-vertical">
                                    <div id="<?php echo 'color'.$para->id; ?>" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="height:<?php echo $para->pecentage;
                                        ?>%; background-color:<?php echo $para->color; ?>">
                                        <small id="<?php echo 'percentage'.$para->id; ?>"><?php echo $para->pecentage;?>%</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
            <!-- Column -->
        </div>
        <script type="text/javascript">
            var updatevehicle = setInterval(update, 1000);
                    function update(){
                    $.ajax({
                            url:'../../controller/DashboardController.php?action=interrupt',
                            method:'GET',
                            data:{},
                            success:function(data){
                                data=JSON.parse(data);
                                for (var i =0; i <data.length; i++) {
                                    $("#volume"+data[i].id).html(data[i].volume);
                                    $("#height"+data[i].id).html(data[i].height);
                                    $("#time"+data[i].id).html(data[i].created_at);
                                    $("#percentage"+data[i].id).html(data[i].pecentage+'%');
                                    $("#color"+data[i].id).css("height",data[i].pecentage+'%');
                                    $("#color"+data[i].id).css("background-color",data[i].color);
                                }
                            }
                        });
                    }
        </script>
    </div>
    <div class="card border rounded px-2 py-2">
        <div >
            <h5 class="">Ca làm việc</h5>
        
        </div>
        <?php 
            if(isset($response)){
            ?>
            <div class="alert <?php echo $response['attr']; ?> mt-2 text-center" role="alert">
        <?php 
            echo $response['cnt'];
        ?>
        </div>
        <?php
            }
        ?>
        <div  class="table-responsive">
            <table id="zero_config" class="table table-striped table-bordered">
                <thead>
                    <tr class="bg-info text-white">
                        <th class="font-weight-bold text-center">STT</th>
                        <th class="font-weight-bold text-center">Xe</th>
                        <th class="font-weight-bold text-center">Người dùng</th>
                        <th class="font-weight-bold text-center">Nhiên liệu thêm</th>
                        <th class="font-weight-bold text-center">Nhiên liệu giảm</th>
                        <th class="font-weight-bold text-center">Thời gian làm việc</th>
                        <th class="font-weight-bold text-center">Kết thúc ca</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=1; foreach ($parameterlist as $parameter): ?>
                    <tr>
                        <td class="text-center"><?php echo $i;  ?></td>
                        <td class="text-left"><?php echo $parameter->vehicle_name;?></td>
                        <td class="text-left"><?php echo $parameter->driver;?></td>
                         <td class="text-right" id="<?php echo 'fuel_add'.$i; ?>" ><?php echo 0;?></td>
                        <td class="text-right" id="<?php echo 'fuel'.$i; ?>"><?php echo $parameter->fuel;?></td>
                        <td class="text-right" id="<?php echo 'duration'.$i; ?>"><?php echo $parameter->duration;?></td>
                        <td class="text-center">
                            <form action="../../controller/UserController.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $parameter->id;?>">
                                <input type="hidden" name="action" value="workshift">
                                <button class="btn btn-danger btn-sm" type="submit">Kết thúc</button>
                            </form>
                        </td>
                    </tr>
                    <?php $i++;  ?>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <!--  -->
        <script type="text/javascript">
            var updatevehicleuser= setInterval(update, 1000);
                    function update(){
                    $.ajax({
                            url:'../../controller/DashboardController.php?action=workshift',
                            method:'GET',
                            data:{},
                            success:function(info){
                                // $("#ajax_workshift").html(info);
                                info =JSON.parse(info);
                                for (var j =1; j <=info.length; j++) {
                                    $("#fuel"+j.toString()).html(info[j-1].fuel);
                                    $("#fuel_add"+j.toString()).html(info[j-1].fuel_add);
                                    $("#duration"+j.toString()).html(info[j-1].duration);
                                }
                            }
                        });
                    }
        </script>
        <!--  -->
    </div>
</div>
<?php
    include_once "{$base_dir}/layout/footeradmin.php";
    ?>