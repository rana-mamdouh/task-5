<?php
$title = "Registeration";

include_once "layouts/header.php";
include_once "app/middleware/guest.php";
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
include_once "app/requests/Validation.php";
include_once "app/models/User.php";
include_once "app/services/mail.php";

if ($_POST) {
    $keys = array('first_name', 'last_name', 'gender', 'email', 'phone', 'password');;
    $checkSuccess = array_fill_keys($keys, 0);

    $firstName = new Validation('first name', $_POST['first_name']);
    $check = $firstName->checkIfSuccess();
    $errors['first_name'] = $check['errors'];
    $checkSuccess['first_name'] = $check['success'];

    $lastName = new Validation('last name', $_POST['last_name']);
    $check = $lastName->checkIfSuccess();
    $errors['last_name'] = $check['errors'];
    $checkSuccess['last_name'] = $check['success'];

    $emailPattern = "/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/";
    $email = new Validation('email', $_POST['email']);
    $check = $email->checkIfSuccessForUniques($emailPattern);
    $errors['email'] = $check['errors'];
    $checkSuccess['email'] = $check['success'];


    $phonePattern = "/^01[0-2,5,9]{1}[0-9]{8}$/";
    $phone = new Validation('phone', $_POST['phone'], $phonePattern);
    $check = $phone->checkIfSuccessForUniques($phonePattern);
    $errors['phone'] = $check['errors'];
    $checkSuccess['phone'] = $check['success'];


    $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
    $password = new Validation('password', $_POST['password']);
    $check = $password->checkIfSuccessForPasswords($passwordPattern);
    $errors['password'] = $check['errors'];
    $checkSuccess['password'] = $check['success'];


    $gender = new Validation('gender', $_POST['gender']);
    $check = $gender->checkIfSuccessForGender();
    $errors['gender'] = $check['errors'];
    $checkSuccess['gender'] = $check['success'];

    Validation::checkIfSuccessForAllAndSendEmail($checkSuccess);
}
?>

<div class="login-register-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-toggle="tab" href="#lg2">
                            <h4> register </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg2" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <?php if (isset($error)) {
                                        echo $error;
                                    } ?>
                                    <form method="post">
                                        <input type="text" name="first_name" placeholder="First Name" value="<?php if (isset($_POST['first_name'])) {
                                                                                                                    echo $_POST['first_name'];
                                                                                                                } ?>">

                                        <?php
                                        if (!empty($errors['first_name'])) {
                                            foreach ($errors['first_name'] as $key => $value) {
                                                if (!empty($value))
                                                    echo "<div class='alert alert-danger'>$value</div>";
                                            }
                                        }
                                        ?>

                                        <input type="text" name="last_name" placeholder="Last Name" value="<?php if (isset($_POST['last_name'])) {
                                                                                                                echo $_POST['last_name'];
                                                                                                            } ?>">
                                        <?php
                                        if (!empty($errors['last_name'])) {
                                            foreach ($errors['last_name'] as $key => $value) {
                                                if (!empty($value))
                                                    echo "<div class='alert alert-danger'>$value</div>";
                                            }
                                        }
                                        ?>
                                        <input name="email" placeholder="Email" type='text' value="<?php if (isset($_POST['email'])) {
                                                                                                        echo $_POST['email'];
                                                                                                    } ?>">
                                        <?php
                                        if (!empty($errors['email'])) {
                                            foreach ($errors['email'] as $key => $value) {
                                                if (!empty($value))
                                                    echo "<div class='alert alert-danger'>$value</div>";
                                            }
                                        }
                                        ?> <input name="phone" placeholder="phone" type="number" value="<?php if (isset($_POST['phone'])) {
                                                                                                            echo $_POST['phone'];
                                                                                                        } ?>">
                                        <?php
                                        if (!empty($errors['phone'])) {
                                            foreach ($errors['phone'] as $key => $value) {
                                                if (!empty($value))
                                                    echo "<div class='alert alert-danger'>$value</div>";
                                            }
                                        }
                                        ?>
                                        <input type="password" name="password" placeholder="Password">

                                        <?php
                                        if (!empty($errors['password'])) {
                                            foreach ($errors['password'] as $key => $value) {
                                                if (!empty($value))
                                                    echo "<div class='alert alert-danger'>$value</div>";
                                            }
                                        }
                                        ?>
                                        <input type="password" name="password_confirmation" placeholder="Confrim Password">

                                        <select name="gender" class="form-control">
                                            <option name="gender" <?= (isset($_POST['gender']) && $_POST['gender'] == 'm') ? 'selected' : '' ?> value="m">Male</option>
                                            <option name="gender" <?= (isset($_POST['gender']) && $_POST['gender'] == 'f') ? 'selected' : '' ?> value="f">Female</option>
                                        </select>

                                        <?php
                                        if (!empty($errors['gender'])) {
                                            foreach ($errors['gender'] as $key => $value) {
                                                if (!empty($value))
                                                    echo "<div class='alert alert-danger'>$value</div>";
                                            }
                                        }
                                        ?>
                                        <div class="button-box mt-5">
                                            <button type="submit"><span>Register</span></button>
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
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php";
?>