<?php

namespace app\controllers\admin;

use ishop\Cache;

class CacheController extends AppController {
    public function indexAction() {
        $this->setMeta("Очистка кэша");
    }

    public function deleteAction(){
        $key = $_GET['key'] ?? null;
        $cache = Cache::instance();
        switch ($key) {
            case 'category':
                $cache->delete('admin_select');
                $cache->delete('admin_cat');
                $cache->delete('ishop_menu');
                $cache->delete('cats');
                break;
            case 'filter':
                $cache->delete('filter_groups');
                $cache->delete('filter_attrs');
                break;
        }
        $_SESSION['success'] = "Кэш удалён";
        redirect();
    }
}