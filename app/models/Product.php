<?php
include_once __DIR__ . '\..\database\configuration.php';
include_once __DIR__ . '\..\database\operations.php';
class Product extends configuration implements operations
{
    private $id,
        $name_en,
        $name_ar,
        $price,
        $quantity,
        $desc_en,
        $desc_ar,
        $image,
        $code,
        $status,
        $brand_id,
        $subcategory_id,
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
     * Get the value of price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of desc_en
     */
    public function getDesc_en()
    {
        return $this->desc_en;
    }

    /**
     * Set the value of desc_en
     *
     * @return  self
     */
    public function setDesc_en($desc_en)
    {
        $this->desc_en = $desc_en;

        return $this;
    }

    /**
     * Get the value of desc_ar
     */
    public function getDesc_ar()
    {
        return $this->desc_ar;
    }

    /**
     * Set the value of desc_ar
     *
     * @return  self
     */
    public function setDesc_ar($desc_ar)
    {
        $this->desc_ar = $desc_ar;

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
     * Get the value of brand_id
     */
    public function getBrand_id()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @return  self
     */
    public function setBrand_id($brand_id)
    {
        $this->brand_id = $brand_id;

        return $this;
    }

    /**
     * Get the value of subcategory_id
     */
    public function getSubcategory_id()
    {
        return $this->subcategory_id;
    }

    /**
     * Set the value of subcategory_id
     *
     * @return  self
     */
    public function setSubcategory_id($subcategory_id)
    {
        $this->subcategory_id = $subcategory_id;

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
        $query = "SELECT `id` AS product_id ,`name_en`,`price`,`desc_en`,`image` FROM `products` WHERE status = $this->status ORDER BY `price` ASC ,`quantity` DESC,`name_en` ASC";
        return $this->runDQL($query);
    }
    public function update()
    {
        # code...
    }
    public function delete()
    {
        # code...
    }

    public function searchOnId()
    {
        $query = "SELECT
               `products`.`id` AS product_id,
               IF(
                   ROUND(AVG(`reviews`.`rate`)) IS NULL,
                   '0',
                   ROUND(AVG(`reviews`.`rate`))
               ) AS `average_rate`,
               COUNT(`reviews`.`product_id`) AS `count_reviews`,
               `categories`.`id` AS category_id,
               `categories`.`name_en` AS category_name,
               `subcategories`.`id` AS sub_id,
               `subcategories`.`name_en` AS sub_name,
               `brands`.`name_en` AS brand_name,
               `brands`.`id` AS brand_id,
               `subcategories`.`name_en`,
               `subcategories`.`image`,
               `products`.*
           FROM
               `products`
           JOIN `subcategories` ON `subcategories`.`id` = `products`.`subcategory_id`
           JOIN `categories` ON `categories`.`id` = `subcategories`.`category_id`
           JOIN `reviews` ON `reviews`.`product_id` = `products`.`id`
           JOIN `brands` ON `products`.`brand_id` = `brands`.`id`
           WHERE
               product_id = 1 AND `products`.`status` = 1";
        return $this->runDQL($query);
    }

    public function getSpecs()
    {
        $query = "SELECT 
                    `products_specs`.`product_id`,
                    CONCAT(`specs`.`name_en`, ' : ',`products_specs`.`value_en`) AS `spec_en`
                FROM `specs`
                JOIN `products_specs`
                ON `specs`.`id` = `products_specs`.`spec_id`
                WHERE  `products_specs`.`product_id` = $this->id";
        return $this->runDQL($query);
    }

    public function getReviews()
    {
    }

    public function getRecentProducts()
    {
        $query = "SELECT
            *
            FROM
                `products`
            WHERE
                `status` = 1
            ORDER BY
                created_at
            DESC
            LIMIT 4";
        return $this->runDQL($query);
    }

    public function getBrandById()
    {
        $query = "SELECT
             `brands`.`name_en`,
             `brands`.`id`,
             `products`.`id`
         FROM
             `products`
         JOIN `brands`
         ON
             `brands`.`id`= `products`.`brand_id`
         WHERE
             `products`.`id` = $this->id";
        return $this->runDQL($query);
    }
}
