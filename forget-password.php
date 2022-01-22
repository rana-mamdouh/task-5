<?php
$title = "Forget Password";
include_once "layouts/header.php";
include_once "app/middleware/guest.php";
include_once "app/models/User.php";
include_once "app/requests/Validation.php";
include_once "app/services/mail.php";
if ($_POST) {
    $emailPattern = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
    $email = new Validation('email', $_POST['email']);
    $check = $email->checkIfSuccessForLogin($emailPattern);
    $errors['email'] = $check['errors'];
    $checkSuccess['email'] = $check['success'];

    if ($checkSuccess['email'] == 1) {
        $userObject = new user;
        $userObject->setEmail($_POST['email']);
        $result = $userObject->getUserByEmail();
        if ($result) {

            $user = $result->fetch_object();
            $code = rand(10000, 99999);
            $userObject->setCode($code);
            $updateResult = $userObject->updateCodeByEmail();

            if ($updateResult) {

                $subject = "Verifcation Code";
                $body = "Your verification code to reset your password is:<br>$code</br>";

                $mail = new mail($_POST['email'], $subject, $body);

                $mailResult = $mail->send();
                if ($mailResult) {

                    $_SESSION['user-email'] = $_POST['email'];
                    header('location:check-code.php?page=forget');
                    die;
                } else {
                    $error['email']['code'] = "<div class='alert alert-danger'> Try Again Later </div>";
                }
            } else {
                $error = "<div class='alert alert-danger'> Try Again Later </div>";
            }
        } else {
            $errors['email']['wrong'] = "This email dosen't exist";
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
                                    <form method="post">
                                        <input type="email" name="email" placeholder="Enter Your Email Address">
                                        <?php
                                        if (!empty($errors['email'])) {
                                            foreach ($errors['email'] as $key => $value) {
                                                if (!empty($value))
                                                    echo "<div class='alert alert-danger'>$value</div>";
                                            }
                                        }
                                        ?>
                                        <div class="button-box">
                                            <button type="submit"><span>Verify Email Address</span></button>
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