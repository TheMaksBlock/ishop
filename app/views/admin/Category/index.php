<?php

use app\widgets\menu\Menu;

?>
<!-- Content Header (Page header) -->
<div class="category-content">
    <section class="content-header">
        <h1>
            Список заказов
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?=ADMIN;?>"><div class="fa fa-navicon"></div> Главная</a></li>
            <li class="active">Список Категорий</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                       <?php new Menu([
                               'tpl' => WWW."/menu/category_admin.php",
                           'container' => 'div',
                           /*'cache' => 0,*/
                           'cachekey' => 'admin_cat',
                           'class' => 'list-group list-group-root well'
                       ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="preload"><img src="/public/images/ring.svg" alt=""></div>
</div>
<!-- /.content -->


