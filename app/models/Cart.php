<?php

namespace app\models;

use ishop\App;

class Cart extends AppModel
{
    public function addToCart($product, $qty = 1, $mod = null) {

        $_SESSION['cart.currency'] = App::$app->getProperty('currency');

        if ($mod) {
            $ID = "{$product->id}-{$mod->id}";
            $title = "{$product->title} ({$mod->title})";
            $price = $mod->price;
        } else {
            $ID = $product->id;
            $title = "{$product->title}";
            $price = $product->price;
        }

        if (isset($_SESSION['cart'][$ID])) {
            $_SESSION['cart'][$ID]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$ID] = [
                'qty' => $qty,
                'title' => $title,
                'alias' => $product->alias,
                'price' => $price * $_SESSION['cart.currency']['value'],
                'img' => $product->img
            ];

        }

        $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
        $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * $price *
            $_SESSION['cart.currency']['value'] : $qty * $price * $_SESSION['cart.currency']['value'];
    }

    public function deleteItem($id)
    {
        $qtyMinus = $_SESSION['cart'][$id]['qty'];
        $sumMinus = $_SESSION['cart'][$id]['price']*$qtyMinus;
        $_SESSION['cart.qty']-=$qtyMinus;
        $_SESSION['cart.sum']-=$sumMinus;

        unset($_SESSION['cart'][$id]);
    }

    public static function recalc($curr){
        if(isset($_SESSION['cart.currency'])) {
            $_SESSION['cart.sum'] = $_SESSION['cart.sum'] / $_SESSION['cart.currency']['value'] * $curr['value'];

            foreach ($_SESSION['cart'] as $k => $v){
                $_SESSION['cart'][$k]['price'] = $_SESSION['cart'][$k]['price']/ $_SESSION['cart.currency']['value'] * $curr['value'];
            }

            $_SESSION['cart.currency'] = $curr;
        }
    }

    public  static function clear(){
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
    }

}