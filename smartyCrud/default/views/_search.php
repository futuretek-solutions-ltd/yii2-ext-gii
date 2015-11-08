<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\smartyCrud\Generator */

?>
{use class="yii\helpers\Html"}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

    {use class='yii\widgets\ActiveForm' type='block'}
    {ActiveForm assign='form' 'action' => ['index'] 'method' => 'get'}
    <?php
    $count = 0;
    foreach ($generator->getColumnNames() as $attribute) {
        if (++$count < 6) {
            echo '    { ' . $generator->generateActiveSearchField($attribute) . "}\n\n";
        } else {
            echo '    {// echo ' . $generator->generateActiveSearchField($attribute) . "}\n\n";
        }
    }
    ?>
    <div class="form-group">
        {Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary'])}
        {Html::resetButton(<?= $generator->generateString('Reset') ?>, ['class' => 'btn btn-default'])}
    </div>
    {/ActiveForm}
</div>
