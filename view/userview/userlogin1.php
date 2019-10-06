<?php 
    if(isset($_SESSION['response'])){
        $response=$_SESSION['response'];
        $_SESSION['response']=null;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hệ thống quản lý xăng dầu | Cảng Đà Nẵng</title>
    <!-- Required meta tags -->

    <meta name='description' content='Hệ thống quản lý xăng dầu, Cảng Đà Nẵng' />
    <meta http-equiv=”content-language” content=”vi” />
    <meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″ />
    <!-- Meta SEO tags -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css"
        integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../../public/assets/styles/css.css">
</head>

<body>
    <header>
        <div class="container-fluid blue-background-color text-white">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-2 p-1">
                        <a href="https://danangport.com/" class="">
                            <img src="../../public/assets/images/background/new-logo.png" alt="logoDaNangport" class="logo">
                        </a>
                    </div>
                    <div class="col-md-10">
                        <p class="mb-0 text-congty">
                            HỆ THỐNG QUẢN LÝ XĂNG DẦU - CÔNG TY CỔ PHẦN CẢNG ĐÀ NẴNG
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <section>
        <div class="container p-0">
            <div class="row mt-5 bg-light flex-column-reverse flex-md-row">
                <div class="col-md-5 col-lg-6 infor p-0 text-white">
                    <div class="black-background-color d-flex flex-column justify-content-center align-items-center">
                        <h3 class="new_header widht-fit-content my-3">THÔNG TIN LIÊN HỆ</h3>
                        <div>
                            <div class="info-text widht-fit-content">
                                <a href="https://danangport.com/" class="">
                                    <img src="../../public/assets/images/background/CaptureCDN.png" alt="logoDaNangport" class="logoNH">
                                </a>
                                <p> <i class="fas fa-map-marker-alt text-primary mr-2 mt-3"></i> 26 Bạch Đằng - Hải Châu
                                    -
                                    Đà Nẵng</p>
                                <p> <i class="fas fa-phone  text-primary mr-2"></i>Phòng kinh doanh: 02363. 822163</p>
                                <p> <i class="far fa-envelope   text-primary mr-2"></i> cangdn@danangport.com</p>
                            </div>
                            <div class="info-text widht-fit-content">
                                <a href="http://dientunguyenhien.vn/">
                                    <img src="../../public/assets/images/background/logoNH2.png" alt="logonGUYENHIEN" class="logoNH">
                                </a>
                                <p> <i class="fas fa-map-marker-alt text-primary mr-2 mt-3"></i> 24/2 Ngô Sĩ Liên - Liên
                                    Chiểu - Đà Nẵng</p>
                                <p> <i class="fas fa-phone  text-primary mr-2"></i> Phòng kinh doanh: 0987278350 </p>
                                <p> <i class="far fa-envelope  text-primary mr-2"></i>Email: dientunguyenhien@gmail.com
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-7 col-lg-6 d-flex flex-column justify-content-center align-items-center">
                    <form class="w-75 my-5" action="../../controller/UserController.php" method="post">
                        <h3 class="new_header widht-fit-content">ĐĂNG NHẬP</h3>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" required placeholder="Enter email">
                           
                            <?php 
                                if(isset($response['error']['email'])){
                            ?>
                                <div class="alert-danger mt-1 py-1 px-2 rounded "><small class="text-capitalize font-weight-bold text-danger">
                            <?php 
                                echo $response['error']['email'];
                            ?>
                                </small></div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" required
                                placeholder="Enter Password">
                            <?php 
                                if(isset($response['error']['password'])){
                            ?>
                                <div class="alert-danger mt-1 py-1 px-2 rounded"><small class="text-capitalize font-weight-bold text-danger">
                            <?php 
                                echo $response['error']['password'];
                            ?>
                                </small></div>
                            <?php
                                }
                            ?>
                        </div>
                        <input type="hidden" name="action" value="login">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                onclick="displaybutton()">
                            <label class="form-check-label" for="exampleCheck1">Quên mật khẩu</label>

                        </div>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary blue-background-color m-2">Đăng nhập</button>
                            <button type="button" class="btn btn-primary blue-background-color m-2" id="quenpass"
                                style="display: none">Quên mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <script src="../../public/assets/styles/js.js"></script>

</body>

</html>