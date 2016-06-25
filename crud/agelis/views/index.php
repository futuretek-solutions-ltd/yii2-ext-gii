<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use rmrevin\yii\fontawesome\FA;

/** 
 * @var yii\web\View $this
<?= !empty($generator->searchModelClass) ? " * @var " . ltrim($generator->searchModelClass, '\\') . ' $searchModel' . "\n" : '' ?>
 * @var yii\data\ActiveDataProvider $dataProvider 
 */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
//$this->params['subtitle'] = <?= $generator->generateString('') ?>; //todo: Add subtitle
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index crud-index">
    <div class="row">
        <div class="col-xs-12 spacer-top-10">
            <?= '<?php' ?> \app\classes\FtsWidget::dynaGrid(
                'grid-<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index',
                $dataProvider,
                $searchModel,
                [
                    'exportFileName' => <?= $generator->generateString(Inflector::camel2id(StringHelper::basename($generator->modelClass))) ?>,
                    'newButtonLabel' => <?= $generator->generateString('New ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>,
                    'description' => <?= $generator->generateString('') ?>, //todo: add description
                    'helpUrl' => '/help/display/' . substr(Yii::$app->language, 0, 2) . '/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index'
                ],
                [
                    <?php
                    $count = 0;
                    if (($tableSchema = $generator->getTableSchema()) === false) {
                        foreach ($generator->getColumnNames() as $name) {
                            if ($name == 'id') {
                                echo "\t\t\t\t\t[\n\t\t\t\t\t\t'attribute' => '" . $name . "',\n\t\t\t\t\t\t'width' => '100px',\n\t\t\t\t\t],";
                            } elseif ($name == 'created_at' || $name == 'updated_at') {
                                echo "\t\t\t\t\t[\n\t\t\t\t\t\t'attribute' => '" . $name . "',\n\t\t\t\t\t\t'format' => 'datetime',\n\t\t\t\t\t\t'filterType' => \\kartik\\grid\\GridView::FILTER_DATETIME,\n\t\t\t\t\t\t'width' => '250px',\n\t\t\t\t\t],";
                            } else {
                                echo "\t\t\t\t\t'" . $name . "',\n";
                            }
                        }
                    } else {
                        foreach ($tableSchema->columns as $column) {
                            $format = $generator->generateColumnFormat($column);
                            if ($column->name === 'id') {
                                echo "\t\t\t\t\t[\n\t\t\t\t\t\t'attribute' => '" . $column->name . "',\n\t\t\t\t\t\t'width' => '100px',\n\t\t\t\t\t],\n";
                            } elseif ($format === 'datetime') {
                                echo "\t\t\t\t\t[\n\t\t\t\t\t\t'attribute' => '" . $column->name . "',\n\t\t\t\t\t\t'format' => 'datetime',\n\t\t\t\t\t\t'filterType' => \\kartik\\grid\\GridView::FILTER_DATETIME,\n\t\t\t\t\t\t'width' => '250px',\n\t\t\t\t\t],\n";
                            } elseif ($format === 'date') {
                                echo "\t\t\t\t\t[\n\t\t\t\t\t\t'attribute' => '" . $column->name . "',\n\t\t\t\t\t\t'format' => 'date',\n\t\t\t\t\t\t'filterType' => \\kartik\\grid\\GridView::FILTER_DATE,\n\t\t\t\t\t\t'width' => '250px',\n\t\t\t\t\t],\n";
                            } elseif ($format === 'time') {
                                echo "\t\t\t\t\t[\n\t\t\t\t\t\t'attribute' => '" . $column->name . "',\n\t\t\t\t\t\t'format' => 'time',\n\t\t\t\t\t\t'filterType' => \\kartik\\grid\\GridView::FILTER_TIME,\n\t\t\t\t\t\t'width' => '250px',\n\t\t\t\t\t],\n";
                            } elseif ($format === 'boolean') {
                                echo "\t\t\t\t\t[\n\t\t\t\t\t\t'attribute' => '" . $column->name . "',\n\t\t\t\t\t\t'format' => 'boolean',\n\t\t\t\t\t\t'filterType' => \\kartik\\grid\\GridView::FILTER_SWITCH,\n\t\t\t\t\t\t'hAlign' => 'center',\n\t\t\t\t\t],\n";
                            } elseif (strpos($column->name, 'price') !== false) {
                                echo "\t\t\t\t\t[\n\t\t\t\t\t\t'attribute' => '" . $column->name . "',\n\t\t\t\t\t\t'format' => 'currency',\n\t\t\t\t\t\t'filterType' => \\kartik\\grid\\GridView::FILTER_MONEY,\n\t\t\t\t\t],\n";
                            } else {
                                echo "\t\t\t\t\t'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                            }
                        }
                    }
                    ?>
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'viewOptions' => ['class' => 'btn btn-success btn-xs view-button', 'label' => FA::i(FA::_EYE),],
                        'updateOptions' => ['class' => 'btn btn-primary btn-xs update-button', 'label' => FA::i(FA::_PENCIL),],
                        'deleteOptions' => ['class' => 'btn btn-danger btn-xs delete-button', 'label' => FA::i(FA::_TIMES),],
                        'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                        'width' => '110px',
                    ],
                ]
            ); ?>
        </div>
    </div>
</div>
