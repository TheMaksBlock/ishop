<?php

namespace app\controllers\admin;

use app\controllers\admin\AppController;
use Exception;
use ishop\libs\Pagination;
use RedBeanPHP\R;

class OrderController extends AppController
{
    public function indexAction(){
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 10;


        if(!empty($_POST['confirmed_orders']))
        {
            $_SESSION["confirmed_orders"] = $_POST['confirmed_orders'];
        }

        $sql = '';
        if(isset($_SESSION["confirmed_orders"])){
            if($_SESSION["confirmed_orders"]=="false") {
                $sql = "WHERE status = '0'";
            }
        }

        $total = R::count('order',$sql);

        $pagination = new Pagination($page, $perpage, $total);

        if($sql)
            $sql = "WHERE `order`.`status` = '0'";

        $products = R::getAll("SELECT `order`.`id`,`order`.`user_id`,`order`.`status`,`order`.`date`,
        `order`.`update_at`,`order`.`currency`,`order`.`note`,`user`.`name`, ROUND(SUM(`orderproduct`.`price`),2) AS 'sum'
         FROM `order`
         LEFT JOIN `orderproduct` ON `orderproduct`.order_id = `order`.id
         LEFT JOIN `product` ON `product`.id = `orderproduct`.product_id
         LEFT JOIN `user` ON `user`.id = `order`.`user_id`
         {$sql}
         GROUP BY `order`.`id`
         ORDER BY `order`.`id` 
         LIMIT {$pagination->getStart()},$perpage");

        if($this->isAjax()){
            $this->loadView('index', compact('products','pagination'));
            die();
        }

        $this->set(compact('products','pagination'));

        $this->setMeta("Список заказов");
    }

    public function viewAction()
    {
        $order_id = $this->getID();
        $order = R::getRow("SELECT `order`.*,`user`.`name`, ROUND(SUM(`orderproduct`.`price`),2) AS 'sum'
         FROM `order`
         LEFT JOIN `orderproduct` ON `orderproduct`.order_id = `order`.id
         LEFT JOIN `product` ON `product`.id = `orderproduct`.product_id
         LEFT JOIN `user` ON `user`.id = `order`.`user_id`
         WHERE `order`.`id` = ?
         GROUP BY `order`.`id`
         ORDER BY `order`.`id`
         LIMIT 1", [$order_id]);

        if(!$order){
            throw new Exception('Страница не найдена', 404);
        }

        $products = R::findAll('orderproduct', "order_id = ?", [$order_id]);
        $this->setMeta("Заказ №{$order_id}");
        $this->set(compact('order', 'products'));
    }

    public function changeAction(){
        $order_id = $this->getID();
        $status = !empty($_GET['status']) ? '1' : '0';
        $result = R::exec("UPDATE ishop.`order` t
                                SET t.status = '{$status}', t.update_at = ?
                                WHERE t.id = ?;",
            [date("Y-m-d H:i:s"),$order_id]);

        if ($result === false) {
            throw new \Exception('Страница не найдена', 404);
        }

        $_SESSION['success'] = 'Изменения сохранены';
        redirect();
    }
    public function deleteAction(){
        $order_id = $this->getID();
        $result = R::trash('order',$order_id);

        if (!$result) {
            $_SESSION['error'] = 'Ошибка при удалении';
            redirect();
        } else{
            $_SESSION['success'] = 'Заказ удален';
            redirect(ADMIN."/order");
        }
    }
}