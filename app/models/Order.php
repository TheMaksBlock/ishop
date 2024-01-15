<?php

namespace app\models;

use app\models\AppModel;
use ishop\App;
use RedBeanPHP\R;

class Order extends AppModel
{
    public static function saveOrder($data)
    {
        $order = R::dispense('order');
        $order->user_id = $data['user_id'];
        $order->note = $data['note'];
        $order->currency = $_SESSION['cart.currency']['code'];
        $order_id = R::store($order);
        self::saveOrderProduct($order_id);
        return $order_id;
    }

    public static function saveOrderProduct($order_id)
    {
        foreach ($_SESSION['cart'] as $product_id => $product) {
            $order_product = R::dispense('orderproduct');
            $order_product->order_id = $order_id;
            $order_product->product_id = (int)$product_id;
            $order_product->qty = $product['qty'];
            $order_product->title = $product['title'];
            $order_product->price = $product['price'];
            R::store($order_product);
        }
    }

    public static function mailOrder($order_id, $email)
    {

    }
}