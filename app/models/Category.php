<?php
include_once __DIR__ . '\..\database\configuration.php';
include_once __DIR__ . '\..\database\operations.php';
class Category extends configuration implements operations
{
    private $id,
        $name_en,
        $name_ar,
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
     * Get the value of name_en
     */
    public function getName_en()
    {
        return $this->name_en;
    }

    /**
     * Set the value of name_en
     *
     * @return  self
     */
    public function setName_en($name_en)
    {
        $this->name_en = $name_en;

        return $this;
    }

    /**
     * Get the value of name_ar
     */
    public function getName_ar()
    {
        return $this->name_ar;
    }

    /**
     * Set the value of name_ar
     *
     * @return  self
     */
    public function setName_ar($name_ar)
    {
        $this->name_ar = $name_ar;

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
    }
    public function read()
    {
        $query = "  SELECT
                        `categories`.`id`,
                        `categories`.`name_en`,
                        COUNT(`subcategories`.`id`) AS `subs_count`
                    FROM
                        `categories`
                    INNER JOIN `subcategories` ON `categories`.`id` = `subcategories`.`category_id`
                    WHERE
                        `categories`.`status` = $this->status
                    GROUP BY
                        `subcategories`.`category_id`
    ";
        return $this->runDQL($query);
    }
    public function update()
    {
    }

    public function delete()
    {
    }

    public function searchOnId()
    {
        $query = "SELECT id,name_en FROM categories WHERE id = $this->id AND status = $this->status";
        return $this->runDQL($query);
    }

    public function getProductsByCat()
    {
        $query = "SELECT
                `categories`.`id` AS category_id,
                `subcategories`.`id` AS sub_id,
                `products`.`id` AS product_id,
                `subcategories`.`name_en`,
                `subcategories`.`image`,
                `products`.*
            FROM
                `subcategories`
            JOIN `products` ON `subcategories`.`id` = `products`.`subcategory_id`
            JOIN `categories`
            ON `categories`.`id` = `subcategories`.`category_id`
            WHERE
                `categories`.`id` = $this->id";
        return $this->runDQL($query);
    }
}
