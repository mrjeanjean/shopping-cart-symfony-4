<?php

namespace App\Event;


use App\Model\Meal;
use Symfony\Component\EventDispatcher\Event;

class MealEvent extends Event
{
    const MEAL_ADDED = "meal.added";
    const MEAL_DELETED = "meal.deleted";

    private $meal;
    private $quantity;

    public function __construct(Meal $meal, $quantity = 0)
    {
        $this->meal = $meal;
        $this->quantity = $quantity;
    }

    public function getMeal()
    {
        return $this->meal;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}