<h1>Todo list</h1>
<div class="btn-group">
    <a href="/todo/add" class="btn btn-primary">Add</a>
</div>

<div id="orderList">
    Order by <?php
    $orderSnippet = [
        \App\Models\Model::ORDER_ASC => '<span class="glyphicon glyphicon-chevron-down"></span>',
        \App\Models\Model::ORDER_DESC => '<span class="glyphicon glyphicon-chevron-up"></span>'
    ];
    foreach ($orderList as $field => $direction) {
        $class = isset($selectedOrder[$field])
            ? 'selected'
            : null;

        $newDirection = !isset($selectedOrder[$field])
            ? $direction
            : \App\Models\Model::getOppositeOrderDirection($direction);
        ?>
        <a href="/?order[<?= $field ?>]=<?= $newDirection ?>" class="order <?= $class ?>">
            <?= $field ?> <?=$orderSnippet[$direction]?>
        </a>
    <?php } ?>
</div>

<?php
/** @var \App\Models\Todo $item */
foreach ($todoList as $item) { ?>
    <div class="row">
        <div class="col-md-3">
            <img alt="Bootstrap Image Preview" src="<?= $item->getImage() ?>" class="img-thumbnail center-image" />
        </div>
        <div class="col-md-7">
            <h3>
                EMail: <?= $item->getEmail() ?>
            </h3>
            <h3>
                Name: <?= $item->getName() ?>
            </h3>
            <?php if ($item->isFinished()) { ?>
                <div class="label label-default">This task finished</div>
            <?php } ?>
            <dl>
                <dt>
                    Text
                </dt>
                <dd>

                    <?= $item->getText() ?>
                </dd>
            </dl>
        </div>
        <?php if (isset($user)) { ?>
            <div class="col-md-2">
                <div class="btn-group-vertical col-md-12">
                    <a href="/todo/edit/id=<?= $item->getId() ?>" class="btn btn-default">Edit</a>
                    <?php if (!$item->isFinished()) { ?>
                    <a href="/todo/finish/id=<?= $item->getId() ?>" class="btn btn-default">Mark as finished</a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

<?php } ?>

