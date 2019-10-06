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
        <h4 class="text-white">Decentralization</h4>
    </div>
    <div class="card-body">
        <div class="card border rounded px-2 py-2">
            <div >
                <h5 class="">User Profile</h5>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-12 mr-10">
                    <figure>
                      <img src="<?php echo $userprofile->avatar;?>" alt="fails" class="w-100 mb-1">   
                      <figcaption class="text-center font-weight-bold"><?php echo $user->name; ?></figcaption>
                    </figure>
                </div>
                <div class="col-md-8 col-sm-12 pb-4">
                    <div>
                        <h5>Contact information</h5>
                    </div>
                    <ul>
                        <li>
                            <label class="mr-5">Name:</label><span class="font-weight-bold"><?php echo $user->name;  ?></span>
                        </li>
                         <li>
                            <label class="mr-5">Code:</label><span class="font-weight-bold"><?php echo $userprofile->user_code;  ?></span>
                        </li>
                         <li>
                            <label class="mr-5">Email:</label><span class="font-weight-bold"><?php echo $user->email;  ?></span>
                        </li>
                         <li>
                            <label class="mr-5">Phone:</label><span class="font-weight-bold"><?php echo $userprofile->phone;  ?></span>
                        </li>
                        <li>
                            <label class="mr-4">Address:</label><span class="font-weight-bold"><?php echo $userprofile->address;  ?></span>
                        </li>
                        <li>
                            <label class="mr-4">Position:</label><span class="font-weight-bold"><?php echo $userprofile->position;  ?></span>
                        </li>
                    </ul>
                </div>
        
            </div>
        </div>
        <!--  -->
        <div class="card border rounded px-2 py-2">
            <div >
                <h5 class="">Vehicle User</h5>
            </div>
            <form action="../../controller/UserController.php" method="post" enctype="multipart/form-data">
                <?php 
                    if(isset($response['error']['msg'])){
                ?>
                    <div class="alert alert-danger mt-2 text-center" role="alert">
                <?php 
                    echo $response['error']['msg'];
                ?>
                    </div>
                <?php
                    }
                ?>
            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vehicle_id">Choose Vehicle for User<span class="text-danger ml-1">&#42;</span></label>
                            <select id="vehicle_id" name="vehicle_id" class="form-control">
                                <option value="">--------------choose vehicle----------------</option>
                                <?php foreach ($vehiclelist as $vehicle): ?>
                                    <option value="<?php echo $vehicle->id;?>"><?php echo $vehicle->name;?></option>
                                <?php endforeach ?>    
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="vehicle_id">Current Time<span class="text-danger ml-1">&#42;</span></label>
                            <h4 class="text-center pt-1" id="current_time">kkk</h4>
                        </div>
                        <script type="text/javascript">
                            var time = setInterval(gettime, 500);
                            function gettime(){
                                var d = new Date();
                                var t = d.toLocaleTimeString();
                                document.getElementById("current_time").innerHTML = t;
                            }
                        </script>
                    </div>
                    <input type="hidden" name="action" value="setup">
                    <input type="hidden" name="user_id" value="<?php echo $user->id;?>">
                    <div class="col-12 text-center">
                        <button class="btn btn-secondary"><a href="../../controller/DashboardController.php?action=index" class="text-white">Go back</a></button>
                        <button class="btn btn-info">Create</button>
                    </div>
            </div>
        </form>
        </div>
        <!--  -->
    </div>  
</div>
<?php
    include_once "{$base_dir}/layout/footeradmin.php";
    ?>