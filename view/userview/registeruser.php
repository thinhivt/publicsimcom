<?php
    $ds = DIRECTORY_SEPARATOR;
    $base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;
    include_once "{$base_dir}/layout/masteradmin.php";
?>
<div class="card">
    <div class="card-title bg-info pb-2">
        <h3 class="text-center text-white mt-3">Create User Account</h3>
    </div>
    <div class="card-body">
    	<form action="../../controller/UserController.php" method="post" enctype="multipart/form-data">
	        <div class="row">
		            <div class="col-md-6">
		                <div class="form-group m-t-20">
		                    <label for="name">Full name<span class="text-danger ml-1">&#42;</span></label>
		                    <input type="text" class="form-control" id="name" name="name" placeholder="Tạo tên người dùng" value="<?php if(isset($response)&&empty($response['error']['name'])) echo $data_post['name'] ; else echo null; ?>">
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
		                    <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email người dùng" value="<?php if(isset($response)&&empty($response['error']['email'])) echo $data_post['email'] ; else echo null; ?>">
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
		                    <label for="password">Password<span class="text-danger ml-1">&#42;</span></label>
		                    <input type="password" class="form-control" name="password" id="password" placeholder="Tạo mật khẩu cho tài khoản" value="<?php if(isset($response)&&empty($response['error']['password'])) echo $data_post['password'] ; else echo null; ?>">
		                    <?php 
		                    	if(isset($response['error']['password'])){
		                    ?>
		                    <div class="alert alert-danger mt-2" role="alert">
							  <?php 
		                    	echo $response['error']['password'];
		                       ?>
							</div>
		                    <?php
		                    	}
		                    ?>
		                </div>
		                <div class="form-group">
		                    <label for="confirmpassword">Cofirm password<span class="text-danger ml-1">&#42;</span></label>
		                    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Nhập lại mật khẩu" value="<?php if(isset($response)&&empty($response['error']['confirmpassword'])) echo $data_post['confirmpassword'] ; else echo null; ?>">
		                    <?php 
		                    	if(isset($response['error']['confirmpassword'])){
		                    ?>
		                    <div class="alert alert-danger mt-2" role="alert">
							  <?php 
		                    	echo $response['error']['confirmpassword'];
		                       ?>
							</div>
		                    <?php
		                    	}
		                    ?>
		                </div>
		                <div class="form-group">
		                    <label for="phone" >Phone number<span class="text-danger ml-1">&#42;</span></label>
		                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại người dùng" value="<?php if(isset($response)&&empty($response['error']['phone'])) echo $data_post['phone'] ; else echo null; ?>" >
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
		                </div>
		                <div class="form-group">
		                    <label for="user_code" >User code</label>
		                    <input type="text" class="form-control" id="user_code" name="user_code" placeholder="Tạo mã số nhân viên" value="<?php if(isset($response)&&empty($response['error']['user_code'])) echo $data_post['user_code'] ; else echo null; ?>" >
		                    <?php 
		                    	if(isset($response['error']['user_code'])){
		                    ?>
		                    <div class="alert alert-danger mt-2" role="alert">
							  <?php 
		                    	echo $response['error']['user_code'];
		                       ?>
							</div>
		                    <?php
		                    	}
		                    ?>
		                </div>
		            </div>
		            <div class="col-md-6">
		            	<div class="form-group">
		                    <label for="position" >Official Position<span class="text-danger ml-1">&#42;</span></label>
		                    <input type="text" class="form-control" id="position" name="position" placeholder="Nhập chức vụ nhân viên" value="<?php if(isset($response)&&empty($response['error']['position'])) echo $data_post['position'] ; else echo null; ?>" >
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
		                </div>
		                <div class="form-group">
		                    <label>Gender<span class="text-danger ml-1">&#42;</span><small class="text-muted">(Chọn giới tính)</small></label>
		                </div>
		                <div class="row">
		                    <div class="form-group col-md-5 col-sm-12">
		                        <label for="male" class="text-muted mx-4">Male</label>
		                        <input type="radio" name="gender" value="1" id="male" checked>
		                        <span class="text-warning font-weight-bold text-capatalizer"></span>
		                    </div>
		                    <div class="form-group col-md-5 col-sm-12">
		                        <label for="female" class="text-muted mx-4">Female</label>
		                        <input type="radio" name="gender" value="2" id="female">
		                        <span class="text-warning font-weight-bold text-capatalizer"></span>
		                    </div>
		                </div>
		                <div class="form-group">
		                    <label for="address">Address<span class="text-danger ml-1">&#42;</span></label>
		                    <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ liên hệ" value="<?php if(isset($response)&&empty($response['error']['address'])) echo $data_post['address'] ; else echo null; ?>">
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
		                        <option value="3">Cao</option>
		                        <option value="2">Trung bình</option>
		                        <option value="1" selected>Thấp</option>
		                    </select>
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
		                <div class="form-group">
		                    <label>Avatar<span class="text-danger ml-1">&#42;</span></label><br>
		                    <input type="file" name="avatar">
		                    <?php 
		                    	if(isset($response['error']['avatar'])){
		                    ?>
		                    <div class="alert alert-danger mt-2" role="alert">
							  <?php 
		                    	echo $response['error']['avatar'];
		                       ?>
							</div>
		                    <?php
		                    	}
		                    ?>
		                </div>
		            </div>
		            <input type="hidden" name="action" value="create">
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