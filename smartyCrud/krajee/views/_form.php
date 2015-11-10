<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator futuretek\gii\generators\smartyCrud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

?>
{use class="yii\helpers\Html"}
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
    {use class='yii\bootstrap\ActiveForm' type='block'}
    {ActiveForm assign='form'
    layout= 'horizontal'
    fieldConfig = [
        'template' => '{label}{beginWrapper}{input}{hint}{error}{endWrapper}',
        'horizontalCssClasses' => [
            'label' => 'col-sm-4',
            'offset' => 'col-sm-offset-4',
            'wrapper' => 'col-sm-8',
            'error' => '',
            'hint' => ''
        ]
    ]
    }
    <?php foreach ($generator->getColumnNames() as $attribute) {
        if (in_array($attribute, $safeAttributes, false)) {
            echo '   {' . $generator->generateActiveField($attribute) . "}\n\n";
        }
    } ?>
    <div class="form-group">
        {if $model->isNewRecord}
        {Html::submitButton(<?= $generator->generateString('Create') ?>, ['class' => 'btn btn-success'])}
        {else}
        {Html::submitButton(<?= $generator->generateString('Update') ?>, ['class' => 'btn btn-primary'])}
        {/if}
    </div>
    {/ActiveForm}
</div>
