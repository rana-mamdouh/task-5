<?php
// relative path -> read => not fixed 
// , absoult path -> read & write => fixed path
include_once __DIR__ . '\..\database\configuration.php';
include_once __DIR__ . '\..\database\operations.php';

class User extends configuration implements operations
{
    private $id,
        $first_name,
        $last_name,
        $phone,
        $email,
        $password,
        $gender,
        $email_verified_at,
        $code,
        $status,
        $image,
        $created_at,
        $updated_at;


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of first_name
     */
    public function getFirst_name()
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */
    public function setFirst_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */
    public function getLast_name()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */
    public function setLast_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of phone
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     *
     * @return  self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = sha1($password);

        return $this;
    }

    /**
     * Get the value of gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set the value of gender
     *
     * @return  self
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get the value of email_verified_at
     */
    public function getEmail_verified_at()
    {
        return $this->email_verified_at;
    }

    /**
     * Set the value of email_verified_at
     *
     * @return  self
     */
    public function setEmail_verified_at($email_verified_at)
    {
        $this->email_verified_at = $email_verified_at;

        return $this;
    }

    /**
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @return  self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdated_at()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */
    public function setUpdated_at($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function create()
    {
        $query = "INSERT INTO users (first_name,last_name,email,phone,password,gender,code) 
        VALUES ('$this->first_name','$this->last_name','$this->email','$this->phone',
        '$this->password','$this->gender',$this->code)";
        return $this->runDML($query);
    }
    public function read()
    {
        # code...
    }
    public function update()
    {
        $image = NULL;
        if (!empty($this->image)) {
            $image = " , image = '$this->image' ";
        }
        $query = "UPDATE users SET first_name = '$this->first_name' , last_name = '$this->last_name' ,
         phone = '$this->phone' , gender = '$this->gender' $image WHERE email = '$this->email'";
        return $this->runDML($query);
    }
    public function delete()
    {
        # code...
    }

    public function checkCode()
    {
        $query = "SELECT * FROM `users` WHERE email = '$this->email' AND code = $this->code";
        return $this->runDQL($query);
    }

    public function checkPhone()
    {
        $query = "SELECT * FROM `users` WHERE  `phone` = '$this->phone'";
        return $this->runDQL($query);
    }

    public function checkPassword()
    {
        $query = "SELECT * FROM `users` WHERE  email = '$this->email' AND password = '$this->password' ";
        return $this->runDQL($query);
    }
    
    public function makeUserVerified()
    {
        $query = "UPDATE `users` SET email_verified_at = '$this->email_verified_at',status = $this->status
        WHERE email = '$this->email' ";
        return $this->runDML($query);
    }

    public function login()
    {
        $query = "SELECT * FROM users WHERE email = '$this->email' AND password = '$this->password'";
        return $this->runDQL($query);
    }

    public function getUserByEmail()
    {
        $query = "SELECT * FROM users WHERE email = '$this->email' AND status in(0,1)";
        return $this->runDQL($query);
    }

    public function updateCodeByEmail()
    {
        $query = "UPDATE `users` SET code = $this->code WHERE email = '$this->email' ";
        return $this->runDML($query);
    }

    public function updatePasswordByEmail()
    {
        $query = "UPDATE `users` SET password = '$this->password' WHERE email = '$this->email' ";
        return $this->runDML($query);
    }
}
