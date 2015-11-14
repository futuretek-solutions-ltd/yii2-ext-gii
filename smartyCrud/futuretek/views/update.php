<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\smartyCrud\Generator */
$urlParams = $generator->generateUrlParams();
?>
{use class="yii\helpers\Html"}
{assign var=title value=Yii::t('<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>', 'Update <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>: {name}', ['name' => $model-><?= $generator->getNameAttribute() ?>])}
{set title=$title}
{set layout="<?= $generator->layout ?>"}
<div class="crud-update row">
    <div class="col-xs-12">
        <h1>{Html::encode($title)}</h1>
    </div>

    {include "_form.tpl"}
</div>
