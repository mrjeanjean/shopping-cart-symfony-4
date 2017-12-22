<?php


namespace App\Service;


use App\Model\Meal;
use Doctrine\DBAL\Connection;

class MealService
{
    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

    public function getAll()
    {
        return $this->database->fetchAll(
            "SELECT * FROM meal"
        );
    }

    public function getMeal($id)
    {
        $meal = $this->database->fetchAssoc(
            "SELECT * FROM meal WHERE id = ?",
            array($id)
        );

        return new Meal($meal['Id'], $meal['Name'], $meal['SalePrice'], $meal['Photo'], $meal['QuantityInStock'], $meal['Description']);
    }
}