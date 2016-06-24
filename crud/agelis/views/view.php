<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use futuretek\adminlte\widget\Box;
use rmrevin\yii\fontawesome\FA;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
*/

$this->title = $model-><?= $generator->getNameAttribute() ?>;
//$this->params['subtitle'] = <?= $generator->generateString('') ?>; //todo: Add subtitle
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view crud-view">
    <div class="row">
        <!-- SUMMARY -->
        <div class="col-xs-12">
            <?= "<?php" ?> Box::begin([
                'type' => Box::TYPE_INFO,
                'bodyClass' => 'no-padding',
                'title' => <?= $generator->generateString('Summary') ?>,
                'custom_tools' =>
                    Html::a(FA::i(FA::_PENCIL) . ' ' . <?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>], ['class' => 'btn btn-primary btn-xs']) . '&nbsp;&nbsp;&nbsp;' .
                    Html::a(FA::i(FA::_TIMES) . ' ' . <?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>], [
                        'class' => 'btn btn-danger btn-xs',
                        'data' => [
                            'confirm' => <?= $generator->generateString('Are you sure you want to delete this item?') ?>,
                            'method' => 'post',
                        ],
                    ]),
                    Html::a(
                        FA::i(FA::_QUESTION_CIRCLE),
                        ['/help/display/' . substr(Yii::$app->language, 0, 2) . '/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view'],
                        ['class' => 'btn btn-primary btn-xs', 'title' => Yii::t('app', 'Help'), 'target' => '_blank']
                    ),
            ]) ?>
            <?php
            $fields = [];
            if (($tableSchema = $generator->getTableSchema()) === false) {
                foreach ($generator->getColumnNames() as $name) {
                    $fields[] = "\t\t\t\t\t'" . $name . "',\n";
                }
            } else {
                foreach ($generator->getTableSchema()->columns as $column) {
                    $format = $generator->generateColumnFormat($column);
                    $fields[] = "\t\t\t\t\t'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                }
            }
            $len = count($fields);
            $col1 = array_slice($fields, 0, $len / 2);
            $col2 = array_slice($fields, $len / 2);
            ?>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?= "<?= " ?>DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            <?php foreach ($col1 as $val) { echo $val; } ?>
                        ],
                    ]) ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?= "<?= " ?>DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            <?php foreach ($col2 as $val) { echo $val; } ?>
                        ],
                    ]) ?>
                </div>
            </div>
            <?= "<?php" ?> Box::end() ?>
        </div>
    </div>
</div>
