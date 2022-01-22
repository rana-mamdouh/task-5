<?php
include_once __DIR__ . "\..\database\configuration.php";
class Validation
{
    private $name;
    private $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function string(): string
    {
        return (is_numeric($this->value) || ctype_space($this->value)) ? ucfirst($this->name) . " is invalid" : "";
    }

    public function required(): string
    {
        return (empty($this->value)) ?  ucfirst($this->name) . " is required" : "";
    }

    public function regex($pattern): string
    {
        return (preg_match($pattern, $this->value)) ? "" : ucfirst($this->name) . " is invalid";
    }

    public function unique($table): string
    {
        $query = "SELECT * FROM `$table` WHERE `$this->name` = '$this->value'";

        $configuration = new configuration;
        $result = $configuration->runDQL($query);
        return (empty($result)) ? "" : ucfirst($this->name) . " already exists";
    }

    public function confirmed($valueConfirmation): string
    {
        return ($this->value == $valueConfirmation) ? "" :  ucfirst($this->name) . " is not confirmed";
    }

    public function gender(): string
    {
        return ($this->value == 'm' || $this->value == 'f') ? "" : ucfirst($this->name) . " must be a female or male";
    }

    public function checkIfSuccess()
    {
        $requiredResult = $stringResult = "";
        $success = 0;

        $requiredResult = self::required();

        if (empty($requiredResult)) {
            $stringResult =  self::string();
            if (empty($stringResult)) {
                $success =  1;
            }
        }

        return array(
            'errors' => array(
                "requiredResult" =>  $requiredResult,
                "stringResult" => $stringResult
            ),
            'success' => $success
        );
    }

    public function checkIfSuccessForUniques($pattern)
    {

        $requiredResult = $regexResult = $uniqueResult = "";
        $success = 0;

        $requiredResult = self::required();

        if (empty($requiredResult)) {
            $regexResult = self::regex($pattern);
            if (empty($regexResult)) {
                $uniqueResult = self::unique('users');
                if (empty($uniqueResult)) {
                    $success =  1;
                }
            }
        }

        return array(
            'errors' => array(
                "requiredResult" =>  $requiredResult,
                "regexResult" => $regexResult,
                "uniqueResult" => $uniqueResult
            ),
            'success' => $success
        );
    }

    public function checkIfSuccessForPasswords($pattern)
    {
        $passwordRequiredResult = $passwordRegexResult = $passwordConfirmationResult = "";
        $success = 0;

        $passwordRequiredResult = self::required();

        if (empty($passwordRequiredResult)) {
            $passwordRegexResult = self::regex($pattern);
            if (empty($passwordRegexResult)) {
                $passwordConfirmationResult = self::confirmed($_POST['password_confirmation']);
                if (empty($passwordConfirmationResult)) {
                    $success =  1;
                }
            }
        }
        return array(
            'errors' => array(
                "passwordRequiredResult" =>  $passwordRequiredResult,
                "passwordRegexResult" => $passwordRegexResult,
                "confirmationResult" => $passwordConfirmationResult
            ),
            'success' => $success
        );
    }

    public function checkIfSuccessForGender()
    {
        $requiredResult = $genderResult = "";
        $success = 0;

        $requiredResult = self::required();

        if (empty($requiredResult)) {
            $genderResult = self::gender();
            if (empty($genderResult)) {
                $success =  1;
            }
        }

        return array(
            'errors' => array(
                "requiredResult" =>  $requiredResult,
                "genderResult" => $genderResult
            ),
            'success' => $success
        );
    }

    public static function checkIfSuccessForAllAndSendEmail($checkSuccess)
    {
        if (reset($checkSuccess) == 1 && count(array_unique($checkSuccess)) == 1) {
            $userObject = new User;

            $userObject->setFirst_name($_POST['first_name']);
            $userObject->setLast_name($_POST['last_name']);
            $userObject->setEmail($_POST['email']);
            $userObject->setPhone($_POST['phone']);
            $userObject->setGender($_POST['gender']);
            $userObject->setPassword($_POST['password']);
            $code = rand(10000, 99999);
            $userObject->setCode($code);

            $result = $userObject->create();

            if ($result) {

                $subject = "Verifcation Code";
                $body = "Welcome {$_POST['first_name']} {$_POST['last_name']}, <br> Your verification code is:<br>$code</br> Thank you for your registeration.";

                $mail = new mail($_POST['email'], $subject, $body);

                $mailResult = $mail->send();
                if ($mailResult) {

                    $_SESSION['user-email'] = $_POST['email'];
                    header('location:check-code.php?page=register');
                    die;
                } else {
                    $error = "<div class='alert alert-danger'> Try again later </div>";
                }
            } else {
                $error = "<div class='alert alert-danger'> Try again later </div>";
            }
        }
    }

    public function checkIfSuccessForLogin($pattern)
    {
        $requiredResult = $regexResult = "";
        $success = 0;

        $requiredResult = self::required();

        if (empty($requiredResult)) {
            $regexResult = self::regex($pattern);
            if (empty($regexResult)) {
                $success =  1;
            }
        }

        return array(
            'errors' => array(
                "requiredResult" =>  $requiredResult,
                "regexResult" => $regexResult
            ),
            'success' => $success
        );
    }

    public static function checkIfSuccessForAllAndLogIn($checkSuccess)
    {
        if (reset($checkSuccess) == 1 && count(array_unique($checkSuccess)) == 1) {
            $userObject = new User;

            $userObject->setEmail($_POST['email']);
            $userObject->setPassword($_POST['password']);

            $result = $userObject->login();

            if ($result) {
                $user = $result->fetch_object();
                if ($user->status == 1) {

                    if (isset($_POST['remember_me'])) {
                        setcookie('remember_me', $_POST['email'], time() + (24 * 60 * 60) * 30 * 12, '/');
                    }
                    $_SESSION['user'] = $user;
                    header('location:../../index.php');
                    die;
                } elseif ($user->status == 0) {

                    $_SESSION['user-email'] = $_POST['email'];
                    header('location:../../check-code.php');
                    die;
                } else {
                    $_SESSION['errors']['email']['block'] = "Your account is blocked";
                }
            } else {
                $_SESSION['errors']['email']['wrong'] = "Failed attempt";
            }
        }
    }
}
