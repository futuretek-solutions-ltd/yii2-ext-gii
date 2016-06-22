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
//$this->subtitle = <?= $generator->generateString('') ?>; //todo: Add subtitle
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index crud-index">
    <div class="row">
        <div class="col-xs-12">
            <p>
                <!-- todo description -->
                <em><?= "<?= Yii::t('app', ''); ?>" ?></em>
            </p>
        </div>

        <div class="col-xs-12 spacer-top-10">
            <?= "<?php" ?> Box::begin([
                //'type' => Box::TYPE_PRIMARY,
                'bodyClass' => 'no-padding',
                'title' => $this->title,
                'custom_tools' => yii\helpers\Html::a(
                    FA::i(FA::_PLUS) . ' ' . <?= $generator->generateString('New ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>,
                    ['create'],
                    ['class' => 'btn btn-success btn-xs', 'title' => <?= $generator->generateString('New ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>]
                ),
            ]) ?>

            <?= "<?=" ?> GridView::widget([
                'dataProvider' => $dataProvider,
                <?= !empty($generator->searchModelClass) ? '\'filterModel\' => $searchModel,': ''; ?>
                'toolbar' => false,
                'export' => false,
                'layout' => '{items}<div class="row"><div class="col-md-6">{summary}</div><div class="col-md-6"><div class="pull-right">{pager}</div></div></div>',
                'pjax' => true,
                'columns'=>[
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
                ],
            ]); ?>

            <?= "<?php" ?> Box::end() ?>
        </div>
    </div>
</div>
