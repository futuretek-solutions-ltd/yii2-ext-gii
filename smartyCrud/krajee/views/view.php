<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\smartyCrud\Generator */

$urlParams = $generator->generateUrlParams();

?>

{assign var=title value=$model-><?= $generator->getNameAttribute() ?>}
{set title=$title}
{set layout="<?= $generator->layout ?>"}
{use class="yii\helpers\Html"}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view row crud-view">
    <div class="col-xs-12 col-sm-6">
        <h1>{Html::encode($title)}</h1>
    </div>

    <div class="col-xs-12 col-sm-6">
        {Html::a(<?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary'])}
        {Html::a(<?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                'method' => 'post'
            ]
        ])}
    </div>
    <div class="col-xs-12">
    {use class="yii\widgets\DetailView" type='function'}
    {DetailView
        model=$model
        attributes=[
<?php
$first = true;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if($first) {
            $first = false;
        } else {
            echo ",\n";
        }
        echo "            '" . $name;
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        if($first) {
            $first = false;
        } else {
            echo ",\n";
        }
        $format = $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? '' : ':' . $format) . '\'';
    }
}
?>
    ]}
    </div>
</div>
