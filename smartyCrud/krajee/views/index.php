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
<div class="crud-index">
    <h1>{Html::encode($title)}</h1>

    {* todo: add description *}
    <p class="description">{Yii::t('<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>', 'Description')}</p>

    {$grid}
</div>
