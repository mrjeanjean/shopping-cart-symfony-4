<?php


namespace App\Model;


class Meal
{
    protected $name;
    protected $sale_price;
    protected $image;
    protected $quantity_in_stock;
    protected $description;
    protected $id;

    /**
     * Meal constructor.
     * @param $id
     * @param $name
     * @param $sale_price
     * @param $image
     * @param $quantity_in_stock
     * @param $description
     */
    public function __construct($id, $name, $sale_price, $image, $quantity_in_stock, $description)
    {
        $this->name = $name;
        $this->sale_price = $sale_price;
        $this->image = $image;
        $this->quantity_in_stock = $quantity_in_stock;
        $this->description = $description;
        $this->id = $id;
    }

    public function getPrice()
    {
        return $this->sale_price;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getQuantityInStock()
    {
        return $this->quantity_in_stock;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}