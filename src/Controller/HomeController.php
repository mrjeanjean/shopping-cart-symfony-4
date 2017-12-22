<?php

namespace App\Controller;

use App\Service\MealService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    private $mealService;
    public function __construct(MealService $mealService)
    {
        $this->mealService = $mealService;
    }

    /**
     * @Route("/", name="homepage")
     */
    function index(LoggerInterface $logger){
        $meals = $this->mealService->getAll();

        return $this->render("home.html.twig",
            [
                "title" => "Accueil",
                "meals" => $meals
            ]);
    }
}