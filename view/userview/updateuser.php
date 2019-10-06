<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    include_once "{$base_dir}/layout/masteradmin.php";
    if(isset($_SESSION['response'])){
        $response=$_SESSION['response'];
        $_SESSION['response']=null;
    }
?>
<div class="card">
    <div class="card-title bg-info pb-2">
        <h3 class="text-center text-white mt-3"> Change User Information</h3>
    </div>
    <div class="card-body">
        <form action="../../controller/UserController.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-10 mx-auto">
                            <img src="<?php echo $userprofile->avatar; ?>" class="img-fluid img-thumbnail w-100" alt="Responsive image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label> Change Avatar<span class="text-danger ml-1">&#42;</span></label><br>
                        <input type="file" name="avatar">
                    </div>
                    
                </div>
                <div class="col-md-8">
                    <div class="form-group m-t-20">
                        <label for="name">Full name<span class="text-danger ml-1">&#42;</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Tạo tên người dùng" value="<?php echo $user->name; ?>">
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
                    <div class="form-group">
                        <label for="email">Email<span class="text-danger ml-1">&#42;</span></label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Nhập email người dùng" value="<?php echo $user->email; ?>">
                        <?php 
                            if(isset($response['error']['email'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['email'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number<span class="text-danger ml-1">&#42;</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại người dùng" value="<?php echo $userprofile->phone; ?>">
                    </div>
                        <?php 
                            if(isset($response['error']['phone'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['phone'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                    <div class="form-group">
                        <label for="position">Official position<span class="text-danger ml-1">&#42;</span></label>
                        <input type="text" class="form-control" id="position" name="position" placeholder="Nhập chức vụ mới" value="<?php echo $userprofile->position; ?>">
                    </div>
                        <?php 
                            if(isset($response['error']['position'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['position'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                    <div class="form-group">
                        <label>Gender<span class="text-danger ml-1">&#42;</span></label>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5 col-sm-12">
                            <label for="" class="text-muted mx-4">Male</label>
                            <input type="radio" name="gender" value="1" <?php echo ($userprofile->gender==1)? 'checked': null; ?>>
                        </div>
                        <div class="form-group col-md-5 col-sm-12">
                            <label for="" class="text-muted mx-4">Female</label>
                            <input type="radio" name="gender" value="2" <?php echo ($userprofile->gender==2)? 'checked': null; ?>>
                        </div>
                    </div>
                        <?php 
                            if(isset($response['error']['gender'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['gender'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                    <div class="form-group">
                        <label for="address">Address<span class="text-danger ml-1">&#42;</span></label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ liên hệ" value="<?php echo $userprofile->address; ?>">
                        <?php 
                            if(isset($response['error']['address'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['address'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="form-group">
                        <label>Set Role<span class="text-danger ml-1">&#42;</span><small class="text-muted">(Chọn quyền quản trị)</small></label>
                        <select class="form-control" name="role">
                            <option value="3" <?php echo ($userprofile->role==3)? 'selected':null; ?>>Cao</option>
                            <option value="2" <?php echo ($userprofile->role==2)? 'selected':null; ?>>Trung bình</option>
                            <option value="1" <?php echo ($userprofile->role==1)? 'selected':null; ?>>Thấp</option>
                        </select>
                    </div>
                        <?php 
                            if(isset($response['error']['role'])){
                        ?>
                            <div class="alert alert-danger mt-2" role="alert">
                        <?php 
                            echo $response['error']['role'];
                        ?>
                            </div>
                        <?php
                            }
                        ?>
                    
                </div>
                <div>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="user_code" value="<?php echo $userprofile->user_code;?>">
                    <input type="hidden" name="id" value="<?php echo $user->id; ?>">
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