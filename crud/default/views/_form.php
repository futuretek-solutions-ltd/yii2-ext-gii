<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use futuretek\adminlte\widget\Box;
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form crud-form">
    <div class="row">
        <div class="col-xs-12">
            <?= "<?php " ?>$form = ActiveForm::begin([
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => '{label}{beginWrapper}{input}{hint}{error}{endWrapper}',
                    'horizontalCssClasses' => [
                        'label' => 'col-xs-12 col-sm-3',
                        'offset' => 'col-sm-offset-2',
                        'wrapper' => 'col-xs-12 col-sm-4',
                        'error' => '',
                        'hint' => ''
                    ]
                ]
            ]); ?>

            <?= "<?php" ?> Box::begin([
                //'type' => Box::TYPE_PRIMARY,
                //'bodyClass' => 'no-padding',
                'title' => $this->title,
                'footer' => '<div class="pull-left"><?= "<?= " ?>Html::a(FA::i(FA::_TIMES) . ' ' . <?= $generator->generateString('Cancel') ?>, Yii::$app->request->referrer, ['class' => 'btn btn-warning']) ?></div><div class="pull-right"><?= "<?= " ?>Html::submitButton(FA::i(FA::_CHECK) . ' ' . ($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Update') ?>), ['class' => 'btn btn-success']) ?></div>',
            ]) ?>

            <?php foreach ($generator->getColumnNames() as $attribute) {
                if (in_array($attribute, $safeAttributes)) {
                    echo "\t\t\t<?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
                }
            } ?>

            <?= "<?php" ?> Box::end() ?>

            <?= "<?php " ?>ActiveForm::end(); ?>
        </div>
    </div>
</div>
