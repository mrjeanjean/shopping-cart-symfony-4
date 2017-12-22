<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

class OrderService
{
    protected $database;

    public function __construct(Connection $database, CartService $cart)
    {
        $this->database = $database;
        $this->cart = $cart;
    }

    public function saveOrder($user_id){
        $total = $this->cart->getTotal();

        $this->database->executeQuery(
            "INSERT INTO `order` (User_Id, TotalAmount, TaxRate) VALUES (?, ?, ?)",
            array((int) $user_id, $total, 20)
        );

        $order_id = $this->database->lastInsertId();

        $this->saveOrderLines($order_id);
    }

    private function saveOrderLines($order_id)
    {
        $products = $this->cart->getCartContent();

        foreach($products as $id => $item){
            $this->database->executeQuery(
                "INSERT INTO orderline (QuantityOrdered, Meal_Id, Order_Id, PriceEach) VALUES (?, ?, ?, ?)",
                array($item['quantity'], $id, $order_id, $item['price'])
            );
        }
    }
}