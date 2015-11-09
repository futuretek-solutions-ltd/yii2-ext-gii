<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\smartyCrud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
?>
{use class="yii\helpers\Html"}
{assign var=title value=<?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>}
{set title=$title}
{set layout="main.tpl"}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <h1>{Html::encode($title)}</h1>
<?php if(!empty($generator->searchModelClass)): ?>
<?= ($generator->indexWidgetType === 'grid' || $generator->indexWidgetType === 'krajeegrid' ? '' : '{include "_form.tpl"}') ?>
<?php endif; ?>

    <?php if($generator->indexWidgetType !=='krajeegrid')  { ?>
    <p>
        {Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success'])}
    </p>
    <?php } ?>

<?php if ($generator->indexWidgetType === 'grid') { ?>
    {use class='yii\grid\GridView' type='function'}
    {GridView dataProvider=$dataProvider
    <?= !empty($generator->searchModelClass) ? 'filterModel=$searchModel columns=[': 'column=['; ?>
        ['class' => 'yii\grid\SerialColumn'],
<?php
    $count = 0;
    if (($tableSchema = $generator->getTableSchema()) === false) {
        foreach ($generator->getColumnNames() as $name) {
            if (++$count < 6) {
                echo "            '" . $name . "',\n";
            }
        }
    } else {
        foreach ($tableSchema->columns as $column) {
            $format = $generator->generateColumnFormat($column);
            if (++$count < 6) {
                echo "            '" . $column->name . ($format === 'text' ? '' : ':' . $format) . "',\n";
            }
        }
    }
?>
        ['class' => 'yii\grid\ActionColumn']
    ]}
<?php } else if ($generator->indexWidgetType === 'krajeegrid') { ?>
    {use class='kartik\grid\GridView' type='function'}
    {GridView dataProvider=$dataProvider
    <?= !empty($generator->searchModelClass) ? 'filterModel=$searchModel': ''; ?>
    toolbar=[
        [
            'content'=> Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class'=>'btn btn-success'])
        ],
        '{export}',
        '{toggleData}'
    ]
    layout = '{summary}<div class="row"><div class="col-md-4 pull-right"><div class="pull-right">{toolbar}</div></div></div>{items}{pager}'
    pjax=true
    columns=[
        ['class' => 'kartik\grid\SerialColumn'],
    <?php
    $count = 0;
    if (($tableSchema = $generator->getTableSchema()) === false) {
        foreach ($generator->getColumnNames() as $name) {
            if (++$count < 6) {
                echo "            '" . $name . "',\n";
            }
        }
    } else {
        foreach ($tableSchema->columns as $column) {
            $format = $generator->generateColumnFormat($column);
            if (++$count < 6) {
                echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            }
        }
    }
    ?>
        ['class' => 'kartik\grid\ActionColumn']
    ]}
<?php } else { ?>
    {use class='@yii\widgets\ListView' type='function'}
    {ListView dataProvider=$dataProvider itemOptions=['class' => 'item']}
<?php } ?>

</div>
