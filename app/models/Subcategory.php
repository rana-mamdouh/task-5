<?php
include_once __DIR__ . '\..\database\configuration.php';
include_once __DIR__ . '\..\database\operations.php';
class Subcategory extends configuration implements operations
{
    private $id,
        $name_en,
        $name_ar,
        $status,
        $image,
        $category_id,
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
     * Get the value of category_id
     */
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

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
    }
    public function update()
    {
    }

    public function delete()
    {
    }

    public function getSubsByCat()
    {
        $query = "SELECT id,name_en FROM subcategories WHERE category_id = $this->category_id AND status = $this->status";
        return $this->runDQL($query);
    }
    public function searchOnId()
    {
        $query = "SELECT id,name_en FROM subcategories WHERE id = $this->id AND status = $this->status";
        return $this->runDQL($query);
    }

    public function getProductsBySub()
    {

        $query = "SELECT
                `subcategories`.`id`,
                `subcategories`.`name_en`,
                `subcategories`.`image`,
                `products`.`id` AS product_id ,
                `products`.*
            FROM
                `subcategories`
            JOIN `products` ON `subcategories`.`id` = `products`.`subcategory_id`
            WHERE `subcategories`.`id` = $this->id";
        return $this->runDQL($query);
    }
}
