<?php
include_once __DIR__ . '\..\database\configuration.php';
include_once __DIR__ . '\..\database\operations.php';
class Review extends configuration implements operations
{
    private $product_id,
        $user_id,
        $rate,
        $comment,
        $created_at,
        $updated_at;

    /**
     * Get the value of product_id
     */
    public function getProduct_id()
    {
        return $this->product_id;
    }

    /**
     * Set the value of product_id
     *
     * @return  self
     */
    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUser_id()
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of rate
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @return  self
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get the value of comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

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

    public function read()
    {
        $query = "SELECT
                 IF(
                     ROUND(AVG(`reviews`.`rate`)) IS NULL,
                     '0',
                     ROUND(AVG(`reviews`.`rate`))
                 ) AS `average_rate`,
                 COUNT(`reviews`.`product_id`) AS `count_reviews`,
                 `products`.*
             FROM
                 `reviews`
             RIGHT JOIN `products` ON `reviews`.`product_id` = `products`.`id`
             WHERE
                 `products`.`status` = 1
             GROUP BY
                 `products`.`id`
             ORDER BY
                 `count_reviews`
             DESC
                 ,
                 `average_rate`
             DESC
             LIMIT 4";
        return $this->runDQL($query);
    }

    public function create()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }

    public function getReviewById()
    {
        $query = "SELECT
                 IF(
                ROUND(AVG(`reviews`.`rate`)) IS NULL,
                 '0',
                 ROUND(AVG(`reviews`.`rate`))
                 ) AS `average_rate`,
                 `reviews`.*,
                 CONCAT(`users`.`first_name` ,' ', `users`.`last_name`) AS `full_name`
             FROM
                 `reviews`
             JOIN `users`
             ON `users`.`id` = `reviews`.`user_id`
             WHERE
                 `reviews`.`product_id` = $this->product_id
            GROUP BY
               `reviews`.`comment`";
        return $this->runDQL($query);
    }
}
