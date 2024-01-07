<?php

namespace app\widgets\menu;

use ishop\App;
use ishop\Cash;
use RedBeanPHP\R;

class Menu
{
    protected $data;
    protected $tree;
    protected $menuHtml;
    protected $tpl;
    protected $container = 'ul';
    protected $class = 'menu';
    protected $table = 'category';
    protected $cash = 3600;
    protected $cashkey = 'ishop_menu';
    protected $attrs = [];
    protected $prepend = '';

    public function __construct($options=[]) {
        $this->tpl = __DIR__.'/menu_tpl/menu.php';
        $this->getOptions($options);
        $this->run();

    }

    public function getOptions($options): void {
        foreach ($options as $key => $v){
            if(property_exists($this, $key)){
                $this->$key = $v;
            }
        }
    }

    public function run(){
        $cash = Cash::instance();
        $this->menuHtml = $cash->get($this->cashkey);
        if(!$this->menuHtml)
        {
            $this->data = App::$app->getProperty('cats');
            if(!$this->data)
            {
                $this->data = R::getAssoc("SELECT * FROM {$this->table}");
            }
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
            if($this->cash){
                $cash->set($this->cashkey, $this->menuHtml, $this->cash);
            }
        }

        $this->output();
    }

    public function output(){
        $attrs = '';
        if(!empty($this->attrs))
        {
           foreach ($this->attrs as $key => $v){
               $attrs.= " $key=$v";
           }
        }
        echo "<{$this->container} class='{$this->class}' $attrs>";?>
       <!-- <li>
            <a href=<?php /*=PATH*/?>>Home</a>
        </li>-->
        <?php
        echo  $this->prepend;
        echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    protected function getTree(){
        $tree = [];
        $data = $this->data;
        foreach ($data as $id=>&$node) {
            if (!$node['parent_id']){
                $tree[$id] = &$node;
            }else{
                $data[$node['parent_id']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = ''){
        $str = '';
        foreach($tree as $id => $category){
            $str .= $this->catToTemplate($category, $tab, $id);
        }
        return $str;
    }

    protected function catToTemplate($category, $tab, $id){
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }

}