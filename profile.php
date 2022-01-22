<?php
$title = "My Account";
include_once "layouts/header.php";
include_once "app/middleware/authorized.php";
include_once "app/models/User.php";
include_once "app/requests/Validation.php";

$userObject = new user;
$userObject->setEmail($_SESSION['user']->email);
$success = "";

if (isset($_POST['update-profile'])) {
    $errors = [];
    $firstName = new Validation('first name', $_POST['first_name']);
    $check = $firstName->checkIfSuccess();
    $errors['first_name'] = $check['errors'];
    $checkSuccess['first_name'] = $check['success'];

    $lastName = new Validation('last name', $_POST['last_name']);
    $check = $lastName->checkIfSuccess();
    $errors['last_name'] = $check['errors'];
    $checkSuccess['last_name'] = $check['success'];


    $gender = new Validation('gender', $_POST['gender']);
    $check = $gender->checkIfSuccessForGender();
    $errors['gender'] = $check['errors'];
    $checkSuccess['gender'] = $check['success'];

    $userObject->setFirst_name($_POST['first_name']);
    $userObject->setLast_name($_POST['last_name']);
    $userObject->setPhone($_POST['phone']);
    $userObject->setGender($_POST['gender']);


    if ($_POST['phone'] != $_SESSION['user']->phone) {
        $result = $userObject->checkPhone();

        if ($result) {
            $errors['phone']['exists'] = "This phone already exists";
        } else
            $checkSuccess['phone'] = 1;
    }

    if ($_FILES['image']['error'] == 0) {

        $maxUploadSize = 10 ** 6;
        $megaBytes = $maxUploadSize / (10 ** 6);
        if ($_FILES['image']['size'] > $maxUploadSize) {
            $error['image-size'] = "<div class='alert alert-danger'> Max upload size of image is $megaBytes bytes </div>";
        }

        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $availableExtensions = ['jpg', 'png', 'jpeg', 'gif'];
        if (!in_array($extension, $availableExtensions)) {
            $error['image-extension'] = "<div class='alert alert-danger'> Allowed exentsions are " . implode(",", $availableExtensions) . " </div>";
        }

        if (empty($error)) {
            $photoName = uniqid() . '.' . $extension;
            $photoPath = "assets/img/users/$photoName";
            move_uploaded_file($_FILES['image']['tmp_name'], $photoPath);

            $userObject->setImage($photoName);
            $_SESSION['user']->image = $photoName;
        }
    }

    if (reset($checkSuccess) == 1 && count(array_unique($checkSuccess)) == 1 && empty($error)) {
        $result = $userObject->update();

        $_SESSION['user']->first_name = $userObject->getFirst_name();
        $_SESSION['user']->last_name = $userObject->getLast_name();
        $_SESSION['user']->phone = $userObject->getPhone();
        $_SESSION['user']->gender = $userObject->getGender();

        if ($result) {
            $success = "<div class='alert alert-success'> Updated Successfully </div>";
        } else {
            $errors['all'] = "<div class='alert alert-danger'> Something Went Wrong </div>";
        }
    }
}

if (isset($_POST['update-password'])) {
    $userObject->setPassword($_POST['old_password']);

    $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
    $password = new Validation('password', $_POST['old_password']);
    $check = $password->checkIfSuccessForLogin($passwordPattern);
    $errors['password'] = $check['errors'];
    $checkSuccess['password'] = $check['success'];

    if ($checkSuccess['password'] == 1) {
        $result = $userObject->checkPassword();
        if ($result) {
            $password = new Validation('password', $_POST['new_password']);
            $check = $password->checkIfSuccessForPasswords($passwordPattern);
            $errors['new_password'] = $check['errors'];
            $checkSuccess['new_password'] = $check['success'];

            if ($checkSuccess['new_password'] == 1) {
                $userObject->setPassword($_POST['new_password']);
                $userObject->updatePasswordByEmail();
                $success = "<div class='alert alert-success'> Updated Successfully </div>";

            }
        } else {
            $errors['password']['fail'] = "Incorrect password";
        }
    }
}


$result = $userObject->getUserByEmail();
$user = $result->fetch_object();
include_once "layouts/nav.php";
include_once "layouts/breadcrumb.php";
?>

<div class="checkout-area pb-80 pt-100">
    <div class="container">
        <div class="row">
            <div class="ml-auto mr-auto col-lg-9">
                <div class="panel-heading">
                    <h5 class="panel-title"><span>1</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-1">Edit your account information </a></h5>
                </div>
                <div id="my-account-1" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="billing-information-wrapper">
                            <div class="account-info-wrapper">
                                <h4>My Account Information</h4>
                                <h5>Your Personal Details</h5>
                                <h5 class="text-center">
                                    <?php
                                        echo $success;
                                    ?>
                                </h5>
                            </div>
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 ">
                                        <div class="row">
                                            <div class="col-4 offset-4">
                                                <img src="assets/img/users/<?= $user->image ?>" alt="" id="image" class="w-100 rounded-circle" style="cursor: pointer;">
                                                <input type="file" name="image" id="file" class="d-none">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 mt-5">
                                        <div class="billing-info">
                                            <label>First Name</label>
                                            <input type="text" name="first_name" value="<?= $user->first_name ?>">
                                            <?php
                                            if (!empty($errors['first_name'])) {
                                                foreach ($errors['first_name'] as $key => $value) {
                                                    if (!empty($value))
                                                        echo "<div class='alert alert-danger'>$value</div>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 mt-5">
                                        <div class="billing-info">
                                            <label>Last Name</label>
                                            <input type="text" name="last_name" value="<?= $user->last_name ?>">
                                            <?php
                                            if (!empty($errors['last_name'])) {
                                                foreach ($errors['last_name'] as $key => $value) {
                                                    if (!empty($value))
                                                        echo "<div class='alert alert-danger'>$value</div>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info">
                                            <label>Phone</label>
                                            <input type="number" name="phone" value="<?= $user->phone ?>">
                                            <?php
                                            if (!empty($errors['phone'])) {
                                                foreach ($errors['phone'] as $key => $value) {
                                                    if (!empty($value))
                                                        echo "<div class='alert alert-danger'>$value</div>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="billing-info">
                                            <label for="Gender"> Gender </label>
                                            <select name="gender" id="Gender" class="form-control">
                                                <option <?= $user->gender == 'm' ? 'selected' : '' ?> value="m">Male</option>
                                                <option <?= $user->gender == 'f' ? 'selected' : '' ?> value="f">Female</option>
                                            </select>
                                            <?php
                                            if (!empty($errors['gender'])) {
                                                foreach ($errors['gender'] as $key => $value) {
                                                    if (!empty($value))
                                                        echo "<div class='alert alert-danger'>$value</div>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="billing-back-btn">
                                    <div class="billing-btn">
                                        <button type="submit" name="update-profile">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel-heading">
                    <h5 class="panel-title"><span>2</span> <a data-toggle="collapse" data-parent="#faq" href="#my-account-2">Change your password </a></h5>
                </div>
                <div id="my-account-2" class="panel-collapse collapse show">
                    <div class="panel-body">
                        <div class="billing-information-wrapper">
                            <div class="account-info-wrapper">
                                <h4>Change Password</h4>
                                <h5>Your Password</h5>
                            </div>
                            <form method="post">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="billing-info">
                                            <label>Old Password</label>
                                            <input type="password" name="old_password">
                                            <?php
                                            if (!empty($errors['password'])) {
                                                foreach ($errors['password'] as $key => $value) {
                                                    if (!empty($value))
                                                        echo "<div class='alert alert-danger'>$value</div>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="billing-info">
                                            <label>New Password</label>
                                            <input type="password" name="new_password">
                                            <?php
                                            if (!empty($errors['new_password'])) {
                                                foreach ($errors['new_password'] as $key => $value) {
                                                    if (!empty($value))
                                                        echo "<div class='alert alert-danger'>$value</div>";
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="billing-info">
                                            <label>Password Confirm</label>
                                            <input type="password" name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                                <div class="billing-back-btn">
                                    <div class="billing-btn">
                                        <button type="submit" name="update-password">Update Password</button>
                                    </div>
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

<!-- my account end -->

<?php
include_once "layouts/footer.php";
include_once "layouts/footer-scripts.php";
?>
<script>
    $('#image').on('click', function() {
        $('#file').click();
    });
</script>