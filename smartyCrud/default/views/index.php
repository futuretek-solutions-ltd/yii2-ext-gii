<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\smartyCrud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
?>
{use class="yii\helpers\Html"}
{assign title=<?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>}
{set title=$title}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <h1>{Html::encode($title)}</h1>
<?php if(!empty($generator->searchModelClass)): ?>
<?= ($generator->indexWidgetType === 'grid' ? '' : '{include "_form.tpl"}') ?>
<?php endif; ?>

    <p>
        {Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success'])}
    </p>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    {use class='yii\grid\GridView' type='function'}
    {GridView dataProvider=$provider
    <?= !empty($generator->searchModelClass) ? 'filterModel=$searchModel columns=[': 'column=['; ?>
        ['class' => 'yii\grid\SerialColumn'],
<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            //echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            //echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

        ['class' => 'yii\grid\ActionColumn']
    ]}
<?php else: ?>
    {use class='@yii\widgets\ListView' type='function'}
    {ListView dataProvider=$dataProvider itemOptions=['class' => 'item']}
<?php endif; ?>

</div>
