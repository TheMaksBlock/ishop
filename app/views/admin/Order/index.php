<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       Список заказов
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><div class="fa fa-shopping-cart"></div> Главная</a></li>
        <li class="active">Список заказов</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Покупатель</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>Дата создания</th>
                                    <th>Дата изменения</th>
                                    <th>Описание</th>
                                    <th>Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $product):?>
                                <tr class="<?= $product['status']?"success":'' ?>">
                                    <td><?=$product['id']; ?></td>
                                    <td><?=$product['name']; ?></td>
                                    <td><?=$product['status']?"Завершён":"Не завершён";?></td>
                                    <td><?=$product['sum']; ?></td>
                                    <td><?=$product['date']; ?></td>
                                    <td><?=$product['update_at']; ?></td>
                                    <td><?=$product['note']; ?></td>
                                    <td><a href="<?=ADMIN?>/order/view?id=1"><i class="fa fa-eye"></i></a></td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>

                        <div class="text-center">
                            <?php if($pagination->countPages > 1): ?>
                                <?= $pagination; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

