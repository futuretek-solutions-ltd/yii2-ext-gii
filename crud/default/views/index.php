<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
    <div class="row">
    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " . ($generator->indexWidgetType === 'grid' || $generator->indexWidgetType === 'krajeegrid' ? '// ' : '') ?>echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

    <?php if($generator->indexWidgetType === 'krajeegrid') {?>
        <div class="col-xs-12">
            <p>
                <em><!-- todo description --></em>
            </p>
        </div>
    <?php } ?>


    <?php if($generator->indexWidgetType !== 'krajeegrid') {?>
    <p>
        <?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php } ?>

<?php if ($generator->indexWidgetType === 'grid') { ?>
    <?= "<?= " ?>GridView::widget([
        'dataProvider' => $dataProvider,
        <?= !empty($generator->searchModelClass) ? "'filterModel' => \$searchModel,\n        'columns' => [\n" : "'columns' => [\n"; ?>
            ['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php } else if ($generator->indexWidgetType === 'krajeegrid') { ?>
    <?= "<?= " ?>kartik\grid\GridView::widget([
        'dataProvider'=>$dataProvider,
        <?= !empty($generator->searchModelClass) ? '\'filterModel\'=>$searchModel,': ''; ?>
        'toolbar'=>[
            'content' => Html::a(
                '<i class="glyphicon glyphicon-plus"></i>' . <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, //todo: Edit new button name
                ['create'],
                ['class' => 'btn btn-success', 'title' => <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>] //todo: Edit new button name
            )
        ],
        'export' => false,
        'layout' => '<div class="col-md-4 pull-right text-right m-b-md">{toolbar}</div><div class="col-xs-12">{items}</div><div class="col-md-6">{summary}</div><div class="col-md-6"><div class="pull-right">{pager}</div></div>',
        'pjax'=>true,
        'columns'=>[
        <?php
        $count = 0;
        if (($tableSchema = $generator->getTableSchema()) === false) {
            foreach ($generator->getColumnNames() as $name) {
                if (++$count < 6) {
                    echo "            '" . $name . "',\n";
                } else {
                    echo "            //'" . $name . "',\n";
                }
            }
        } else {
            foreach ($tableSchema->columns as $column) {
                $format = $generator->generateColumnFormat($column);
                if (++$count < 6) {
                    echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                } else {
                    echo "            //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }
            }
        }
        ?>
            ['class' => 'kartik\grid\ActionColumn']
        ]
    ]); ?>
<?php } else { ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php } ?>
    </div>
</div>
