<?php

namespace app\controllers\admin;

use app\controllers\admin\AppController;
use RedBeanPHP\R;

class CategoryController extends AppController
{
    public function indexAction(){
        $this->setMeta("Список категорий");
    }


    public function deleteAction()
    {
        $id = $this->getID();

        $childs = R::count('category', 'parent_id = ?',[$id]);

        $errors = '';

        if($childs){
            $errors .= '<li>Вы не можете удалить категорию, которая содержит другие категории</li>';
        }

        $products = R::count('category', 'id = ?',[$id]);

        if($products){
            $errors .= '<li>Вы не можете удалить категорию, которая содержит товары</li>';
        }

        if($errors){
            $_SESSION['error'] = "<ul>".$errors."</ul>";
            redirect();
        }

        $category = R::load('category', $id);
        R::trash($category);

        $_SESSION['success'] = 'Категория удалена';
        redirect();
    }
}