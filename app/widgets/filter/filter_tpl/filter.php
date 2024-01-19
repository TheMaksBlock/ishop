<div class="w_sidebar">
    <?php foreach ($this->groups as $id => $item): ?>
    <section  class="sky-form">
        <h4><?= $item ?></h4>
        <div class="row1 scroll-pane">
            <div class="col col-4">
                <?php foreach ($this->attrs[$id] as $k => $v): ?>
                <label class="checkbox"><input type="checkbox" name="checkbox" value = "<?= $k ?>"
                    <?= !empty($filter) && in_array($k, $filter) ? "checked": ""?>><i></i><?= $v ?></label>
                <?php endforeach;?>
            </div>
        </div>
    </section>
    <?php endforeach; ?>
</div>