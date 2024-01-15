<?php

namespace app\controllers;



use app\models\Cart;
use app\models\Order;
use app\models\User;
use RedBeanPHP\R;

class CartController extends AppController
{
    public function addAction(){
        $id = !empty($_GET['id']) ? (int)$_GET['id'] :null;
        $qty = !empty($_GET['qty']) ? (int)$_GET['qty'] :null;
        $mod_id = !empty($_GET['mod']) ? (int)$_GET['mod'] :null;
        $mod = null;
        if($id){
            $product = R::findOne('product', 'id = ?', [$id]);

            if(!$product){
                return false;
            }

            if($mod_id){
                $mod = R::findOne('modification', 'id = ? AND product_id = ?', [$mod_id, $id]);
            }

        }

        $cart = new Cart();
        $cart->addToCart($product,$qty,$mod);
        if($this->isAjax()){
            $this->loadView('cart_model');
        }
        redirect();
    }

    public function showAction(){
        $this->loadView('cart_model');
        redirect();
    }

    public function deleteAction()
    {
        $id = !empty($_GET['id']) ? $_GET['id'] :null;

        if(isset($_SESSION['cart'][$id])){
            $cart = new Cart();
            $cart->deleteItem($id);
        }

        if($this->isAjax()){
            $this->loadView('cart_model');
        }
        redirect();
    }

    public function clearAction()
    {
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);

        $this->loadView('cart_model');
    }

    public function viewAction()
    {
        $this->setMeta("Оформление заказа");
    }

    public function checkoutAction()
    {
        if(!empty($_POST)){
            if(!User::checkAuth()){

                $user = new User();
                $data = $_POST;
                $user->load($data);
                if (!$user->validate() || !$user->checkUnique([
                        "login" => $user->attributes['login'],
                        "email" => $user->attributes['email']
                    ], "user")) {
                    $_SESSION['form_data'] = $data;
                    $user->getErrors();
                    redirect();
                } else {
                    $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);

                    if (!$user_id = $user->save('user')) {
                        $_SESSION['error'] = "Ошибка регистрации";
                        redirect();
                    }

                    $user = new User();
                    $user->login();
                }
            }
        }

        $data['user_id'] = $user_id ?? $_SESSION['user']['id'];
        $data['note'] = !empty($_POST['note']) ? h($_POST['note']) : '';
        $user_email = $_SESSION['user']['email'] ?? $_POST['email'];
        $order_id = Order::saveOrder($data);
        Order::saveOrderProduct($order_id);
        Order::mailOrder($order_id,$user_email);
        redirect();
    }

}