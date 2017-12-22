<?php


namespace App\Service;


use App\Model\Meal;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    protected $session;
    protected $taxRate = 20;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;

        if ($this->session->get('cart') === null) {
            $this->session->set('cart', array());
        }
    }

    public function addMeal(Meal $meal, $quantity = 1)
    {
        $cart = $this->session->get('cart');

        $product = array(
            'meal' => $meal,
            'quantity' => $quantity,
            'price' => $meal->getPrice()
        );

        if(array_key_exists($meal->getId(), $cart)){
            $product['quantity'] +=  $cart[$meal->getId()]['quantity'];
        }

        $cart[$meal->getId()] = $product;

        $this->session->set('cart', $cart);
    }

    public function getCartContent(){
        return $this->session->get('cart');
    }

    public function getTotal(){
        $cart = $this->session->get('cart');
        $total = 0;
        foreach ($cart as $meal) {
            $total += $meal['meal']->getPrice() * $meal['quantity'];
        };
        return $total;
    }

    public function emptyCart(){
        $this->session->set('cart', array());
    }

    public function isEmpty(){
        if(empty($this->session->get('cart'))){
            return true;
        }

        return false;
    }

    public function removeMeal(Meal $meal){
        $cart = $this->session->get('cart');

        if($this->getMeal($meal->getId())){

            unset($cart[$meal->getId()]);
            $this->session->set('cart', $cart);

        }
    }

    public function getMeal($id){
        $cart = $this->session->get('cart');

        if(array_key_exists($id, $cart)){
            return $cart[$id]['meal'];
        }else{
            return null;
        }
    }

    public function getTax()
    {
        return $this->getTotal() * $this->taxRate / 100;
    }

    public function countProducts()
    {
        $cart = $this->session->get('cart');
        $count = 0;
        foreach ($cart as $meal) {
            $count += $meal['quantity'];
        };
        return $count;
    }
}