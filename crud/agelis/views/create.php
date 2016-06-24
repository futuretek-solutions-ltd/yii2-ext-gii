<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\crud\Generator */

echo "<?php\n";
?>

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model 
 */

$this->title = <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
//$this->params['subtitle'] = <?= $generator->generateString('') ?>; //todo: Add subtitle
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create crud-create spacer-top-20">
    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
