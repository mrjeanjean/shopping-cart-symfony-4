<?php


namespace App\Service;

use App\Event\MealEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class NotificationService implements EventSubscriberInterface
{
    protected $flashbag;

    public function __construct(FlashBagInterface $flashbag)
    {
        $this->flashbag = $flashbag;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MealEvent::MEAL_ADDED => 'onMealAdded',
            MealEvent::MEAL_DELETED => 'onMealDeleted'
        );
    }

    public function onMealAdded(MealEvent $mealEvent)
    {
        $this->flashbag->add("message", $mealEvent->getQuantity() . ' "' . $mealEvent->getMeal()->getName() . '" ajouté(s) à votre panier');
    }

    public function onMealDeleted(MealEvent $mealEvent)
    {
        $this->flashbag->add("message", "Le produit \"{$mealEvent->getMeal()->getName()}\" a été supprimé avec succès");
    }
}