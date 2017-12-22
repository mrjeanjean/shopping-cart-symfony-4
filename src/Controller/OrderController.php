<?php
/**
 * Created by PhpStorm.
 * User: Gaëtan
 * Date: 11/07/2017
 * Time: 12:06
 */

namespace App\Controller;


use App\Form\OrderType;
use App\Service\CartService;
use App\Service\OrderService;
use App\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Validator\Constraints as Assert;

class OrderController extends Controller
{
    protected $cartService;
    protected $userService;

    public function __construct(CartService $cartService, UserService $userService)
    {
        $this->cartService = $cartService;
        $this->userService = $userService;
    }

    /**
     * @Route("/order", name="order")
     */
    public function showOrder(Request $request, FlashBagInterface $flashbag, FormFactoryInterface $formFactory, OrderService $orderService)
    {
        if ($this->cartService->isEmpty()) {
            $flashbag->add('message', 'Votre panier est vide');
            return $this->redirectToRoute('homepage');
        }

        $form = $formFactory->create(OrderType::class);

        if ($form->handleRequest($request)->isValid()) {
            $data = $form->getData();

            try {
                $user_id = $this->userService->saveUser(array(
                    'firstname' => $data['firstname'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'password' => $data['password'],
                    'address' => $data['address'] . " " . $data['address_add'],
                    'city' => $data['city'],
                    'zip' => $data['zip']
                ));

                $orderService->saveOrder($user_id);

                return $this->redirect("order/success");

            }catch(Exception $exception){
                $form->addError(new FormError($exception->getMessage()));
            }

        }

        return $this->render('order.html.twig', array(
                "title" => "Commande",
                "meals" => $this->cartService->getCartContent(),
                "total" => $this->cartService->getTotal(),
                "tax" => $this->cartService->getTax(),
                "form" => $form->createView()
            )
        );
    }

    /**
     * @Route("/order/success")
     */
    public function successOrder()
    {
        $this->cartService->emptyCart();
        return $this->render('success.html.twig', array("title" => "Confirmation commande"));
    }
}