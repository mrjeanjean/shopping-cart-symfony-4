<?php

namespace App\Controller;

use App\Service\CartService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/cart", name="cart")
     */
    public function showCart(FlashBagInterface $flashbag){

        if ($this->cartService->isEmpty()) {
            $flashbag->add('message', 'Votre panier est vide');
            return $this->redirectToRoute('homepage');
        }


        return $this->render("cart.html.twig",[
            "meals" => $this->cartService->getCartContent(),
            "total" => $this->cartService->getTotal(),
            "tax" => $this->cartService->getTax()
        ]);
    }


    public function miniCart()
    {
        $products_number = $this->cartService->countProducts();
        $products = $this->cartService->getCartContent();
        $total = $this->cartService->getTotal();

        return $this->render('mini-cart.html.twig', array(
                "products_number" => $products_number,
                "products" => $products,
                "total" => $total
            )
        );
    }
}
