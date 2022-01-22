<?php
include_once __DIR__ . '\..\database\configuration.php';
include_once __DIR__ . '\..\database\operations.php';
class OrderProduct extends configuration implements operations
{
    private $product_id,
        $order_id,
        $quantity,
        $price;

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
     * Get the value of order_id
     */
    public function getOrder_id()
    {
        return $this->order_id;
    }

    /**
     * Set the value of order_id
     *
     * @return  self
     */
    public function setOrder_id($order_id)
    {
        $this->order_id = $order_id;

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

    public function read()
    {
        $query = "SELECT
                COUNT(`orders_products`.`product_id`) AS count_products,
                `products`.*
            FROM
                `orders_products`
            RIGHT JOIN `products` ON `orders_products`.`product_id` = `products`.`id`
            WHERE
                `products`.`status` = 1
            GROUP BY
                `products`.`id`
            ORDER BY
                count_products
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
}
