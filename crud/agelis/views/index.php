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
use futuretek\adminlte\widget\Box;
use rmrevin\yii\fontawesome\FA;
use futuretek\grid\GridView;

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
                            if (++$count < 6) {
                                echo "\t\t\t\t\t'" . $name . "',\n";
                            } else {
                                echo "\t\t\t\t\t//'" . $name . "',\n";
                            }
                        }
                    } else {
                        foreach ($tableSchema->columns as $column) {
                            $format = $generator->generateColumnFormat($column);
                            if (++$count < 6) {
                                echo "\t\t\t\t\t'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                            } else {
                                echo "\t\t\t\t\t//'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                            }
                        }
                    }
                    ?>
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'viewOptions' => ['class' => 'btn btn-success btn-xs', 'label' => FA::i(FA::_EYE),],
                        'updateOptions' => ['class' => 'btn btn-primary btn-xs', 'label' => FA::i(FA::_PENCIL),],
                        'deleteOptions' => ['class' => 'btn btn-danger btn-xs', 'label' => FA::i(FA::_TIMES),],
                        'template' => '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}',
                        'width' => '110px',
                    ],
                ]
            ); ?>
        </div>
    </div>
</div>
