<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\smartyCrud\Generator */
?>
{use class="yii\helpers\Html"}
{assign var=title value=<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>}
{set title=$title}
{set layout="<?= $generator->layout ?>"}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create row crud-create">
    <div class="col-xs-12">
        <h1>{Html::encode($title)}</h1>
    </div>
    {include "_form.tpl"}
</div>
