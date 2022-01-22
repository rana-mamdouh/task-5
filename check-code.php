<?php
$title = "Check Code";
include_once "layouts/header.php";
include_once "app/middleware/guest.php";
if(empty($_SESSION['user-email'])){
    header('location:login.php');die;
}
include_once "app/models/User.php";

$availablePages = ['register','forget'];

if($_GET){
    if(isset($_GET['page'])){
        if(!in_array($_GET['page'],$availablePages)){
            header('location:layouts/errors/404.php');die;
        }
    }else{
        header('location:layouts/errors/404.php');die;
    }
}else{
    header('location:layouts/errors/404.php');die;
}

if($_POST){
    $errors = [];
    if(empty($_POST['code'])){
        $errors['required'] = "<div class='alert alert-danger'> Code is required </div>";
    }else{
        if(strlen($_POST['code']) != 5){
            $errors['digits'] = "<div class='alert alert-danger'> Code must be 5 digits </div>";
        }
    }

    if(empty($errors)){
        $userobject = new User;
        $userobject->setCode($_POST['code']);
        $userobject->setEmail($_SESSION['user-email']);
        $result = $userobject->checkCode();
        if($result){
            $userobject->setStatus(1);
            date_default_timezone_set('Africa/Cairo');
            $userobject->setEmail_verified_at(date('Y-m-d H:i:s'));
            $updateResult = $userobject->makeUserVerified();

            if($updateResult){
                if($_GET['page'] == 'register'){
                    unset($_SESSION['user-email']);
                    $page = "login.php";
                }elseif($_GET['page']== 'forget'){
                    $page = "reset-password.php";
                }   
                header("location:$page");die;
            }else{
                $errors['something'] = "<div class='alert alert-danger'> Something went wrong </div>";
            }
        }else{
            $errors['wrong'] = "<div class='alert alert-danger'> wrong code </div>";
        }
    }

}
?>
    <div class="login-register-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                    <div class="login-register-wrapper">
                        <div class="login-register-tab-list nav">
                            <a class="active" data-toggle="tab" href="#lg1">
                                <h4> <?= $title ?> </h4>
                            </a>
                        </div>
                        <div class="tab-content">
                            <div id="lg1" class="tab-pane active">
                                <div class="login-form-container">
                                    <div class="login-register-form">
                                        <form  method="post">
                                            <input type="number" min="10000" max="99999" name="code" placeholder="Enter Your Verification Code ">
                                            <?php
                                                if(!empty($errors)){
                                                    foreach ($errors as $key => $value) {
                                                        echo $value;
                                                    }
                                                }
                                            ?>
                                            <div class="button-box">
                                                <button type="submit"><span><?= $title ?></span></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php 
include_once "layouts/footer-scripts.php";
?>
       