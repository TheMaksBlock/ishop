<?php

namespace app\models;

use ishop\App;

class BreadCrumbs
{
    public static function getBreadCrumbs($categoryId, $name = '') {
        $cats = App::$app->getProperty('cats');
        $breadCrumbsArray = static::getParts($cats, $categoryId);
        $breadCrumbs = "<li><a href='" . PATH . "'>Главная</a> </li>";
        if ($breadCrumbsArray) {
            foreach ($breadCrumbsArray as $alias=>$title) {
                $breadCrumbs .= "<li><a href='" . PATH . "/category/{$alias}'>$title</a> </li>";
            }
        }
        if($name){
            $breadCrumbs .= "<li>{$name}</li>";
        }
        return $breadCrumbs;
    }

    public static function getParts($cats, $categoryId): false|array {
        if (!$categoryId)
            return false;
        $breadCrumbs = [];
        while (isset($cats[$categoryId])) {
            $breadCrumbs[$cats[$categoryId]['alias']] = $cats[$categoryId]['title'];
            $categoryId = $cats[$categoryId]['parent_id'];

        }
        return array_reverse($breadCrumbs);
    }
}