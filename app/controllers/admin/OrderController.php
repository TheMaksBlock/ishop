<?php

namespace app\controllers\admin;

use app\controllers\admin\AppController;
use ishop\libs\Pagination;
use RedBeanPHP\R;

class OrderController extends AppController
{
    public function indexAction(){
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 2;

        $total = R::count('order');

        $pagination = new Pagination($page, $perpage, $total);

        $products = R::getAll("SELECT `order`.`id`,`order`.`user_id`,`order`.`status`,`order`.`date`,
        `order`.`update_at`,`order`.`currency`,`order`.`note`,`user`.`name`, ROUND(SUM(`orderproduct`.`price`),2) AS 'sum'
         FROM `order`
         LEFT JOIN `orderproduct` ON `orderproduct`.order_id = `order`.id
         LEFT JOIN `product` ON `product`.id = `orderproduct`.product_id
         LEFT JOIN `user` ON `user`.id = `order`.`user_id`
         GROUP BY `order`.`id`
         ORDER BY `order`.`id` DESC
         LIMIT {$pagination->getStart()},$perpage");

        $this->set(compact('products','pagination'));

        $this->setMeta("Список заказов");
    }
}