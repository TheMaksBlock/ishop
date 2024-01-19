<?php use ishop\App;

if ($products): ?>
    <div class="product-one">
        <?php
        $curr = App::$app->getProperty('currency');
        foreach ($products as $product): ?>
            <div class="col-md-4 product-left p-left">
                <div class="product-main simpleCart_shelfItem">
                    <a href="/product/<?= $product->alias; ?>" class="mask"><img class="img-responsive zoom-img"
                                                                                 src="/images/<?= $product->img ?>"
                                                                                 alt=""/></a>
                    <div class="product-bottom">
                        <h3><?= $product->title ?></h3>
                        <p>Explore Now</p>
                        <h4><a data-id ="<?=$product->id?>" class="add-to-cart-link" href="/cart/add?id=<?= $product->id ?>"><i></i></a> <span
                                class=" item_price"><?=$curr['symbol_left']?><?=$product->price*$curr['value']?><?=$curr['symbol_right']?></span>
                            <?php if ($product->old_price): ?>
                                <small><del><?=$curr['symbol_left']?><?=$product->old_price*$curr['value']?><?=$curr['symbol_right']?></del></small>
                            <?php endif?>
                        </h4>
                    </div>
                    <?php if ($product->old_price): ?>
                        <div class="srch">
                            <span>-<?= round((1- $product->price/$product->old_price)*100) ?>%</span>
                        </div>
                    <?php endif;?>
                </div>

            </div>
        <?php
        endforeach; ?>

        <div class="text-center">
            <?php if($pagination->countPages > 1): ?>
                <?= $pagination; ?>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <h3>В этой категории товаров пока нет...</h3>
<?php endif; ?>