<?php

namespace app\controllers;

use app\models\BreadCrumbs;
use app\models\Product;
use RedBeanPHP\R;

class ProductController extends AppController
{
    public function viewAction() {
        $alias = $this->route['alias'];
        $product = R::findOne('product', 'alias = ? AND status = \'1\'', [$alias]);
        if (!$product) {
            throw new \Exception("Продукт {$alias} не найден", 404);
        }
        $this->setMeta($product['title'], $product['description'], $product['keywords']);

        //хлебные крошки
        $breadCrumbs = Breadcrumbs::getBreadCrumbs($product->categoryId,$product->title);
        //связанные товары
        $related = R::getAll("SELECT * FROM related_product R JOIN product P ON P.id = R.related_id WHERE R.product_id = ?", [$product->id]);

        //просмотренные товары из куки
        $p_model = new Product();
        $rViewed = $p_model->getRecentlyViewed();
        $recentlyViewed = null;
        if ($rViewed) {
            $recentlyViewed = R::find('product', 'id IN ('.R::genSlots($rViewed).')', $rViewed);
        }

        //запись в куки запрошенного товара
        $p_model->setRecentlyViewed($product->id);

        //галерея
        $gallery = R::findAll('gallery', 'product_id = ?', [$product->id]);

        //модификации
        $mods = R::findAll('modification', 'product_id = ?', [$product->id]);
        $this->set(compact('product', 'related', 'gallery', 'recentlyViewed', 'breadCrumbs', 'mods'));
    }
}