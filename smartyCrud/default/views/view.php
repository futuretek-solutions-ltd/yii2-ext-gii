<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\smartyCrud\Generator */

$urlParams = $generator->generateUrlParams();

?>

{assign title=$model-><?= $generator->getNameAttribute() ?>}
{set title=$title}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    {use class="yii\helpers\Html"}
    <h1>{Html::encode($title)}</h1>

    <p>
        {Html::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary'])}
        {Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                'method' => 'post',
            ],
        ])}
    </p>
    {use class="yii\widgets\DetailView" type='function'}
    {DetailView
        model=$model
        attributes=[
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
    ]}

</div>
