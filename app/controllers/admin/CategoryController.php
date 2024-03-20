<?php

namespace app\controllers\admin;

use app\controllers\admin\AppController;
use app\models\AppModel;
use app\models\Category;
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

        $products = R::count('product', 'category_id = ?',[$id]);

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

    public function addAction(){
        if(!empty($_POST))
        {
            $categrory = new Category();
            $data = $_POST;
            $categrory->load($data);

            if(!$categrory->validate($data)){
                $categrory->getErrors();
                redirect();
            }
            if($id = $categrory->save('category')){
                $alias = AppModel::createAlias('category', 'alias', $data['title'], $id);
                $cat = R::load('category', $id);
                $cat->alias = $alias;
                R::store($cat);
                $_SESSION['success'] = 'Категория добавлена';

            }
            redirect();
        }
        $this->setMeta("Новая категорий");
    }

    public function editAction(){
        $id = $this->getID();
        $category = R::load('category', $id);
        $this->setMeta("Редактирование категории {$category->title}");

        $this->set(compact('category'));
    }
}