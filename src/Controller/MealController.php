<?php

namespace App\Controller;

use App\Event\MealEvent;
use App\Service\CartService;
use App\Service\MealService;
use App\Form\MealType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class MealController extends Controller
{
    protected $mealService;
    protected $cartService;

    public function __construct(MealService $mealService, CartService $cartService)
    {
        $this->mealService = $mealService;
        $this->cartService = $cartService;
    }

    /**
     * @Route("/add-meal/{meal_id}/{quantity}", name="add-meal-fast")
     */
    public function addMeal(Request $request, EventDispatcherInterface $dispatcherInterface)
    {
        $meal = $this->mealService->getMeal($request->get('meal_id'));
        $this->cartService->addMeal($meal, $request->get('quantity'));

        $dispatcherInterface->dispatch(MealEvent::MEAL_ADDED, new MealEvent($meal, $request->get('quantity')));

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/meal/{id}", name="meal")
     */
    public function showMeal(Request $request, FormFactoryInterface $formFactory, EventDispatcherInterface $dispatcherInterface)
    {
        $meal = $this->mealService->getMeal($request->get('id'));

        $form = $formFactory->create(MealType::class, null, [
            "meal" => $meal
        ]);

        if ($form->handleRequest($request)->isValid()) {
            $data = $form->getData();

            $this->cartService->addMeal($meal, $data['quantity']);
            $dispatcherInterface->dispatch(MealEvent::MEAL_ADDED, new MealEvent($meal, $data['quantity']));

            return $this->redirectToRoute("homepage");
        }


        return $this->render('meal.html.twig', [
            "meal" => $meal,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("remove-meal/{meal_id}", name="remove-meal")
     */
    public function removeMeal(Request $request, EventDispatcherInterface $dispatcherInterface)
    {
        $meal = $this->cartService->getMeal($request->get('meal_id'));

        if($meal){
            $this->cartService->removeMeal($meal);
            $dispatcherInterface->dispatch(MealEvent::MEAL_DELETED, new MealEvent($meal));
        }

        return $this->redirectToRoute('cart');
    }
}
