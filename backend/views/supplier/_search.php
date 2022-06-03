<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SupplierSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-search">

    <?php
    $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'row',
            'data-pjax' => 0
        ],
        'fieldConfig' => [
            'template' => '{label}{input}{hint}{error}',
            //'template' => '<div class="col-xs-2">{label}</div><div class="col-xs-4">{input}</div><div class="col-xs-6">{hint}{error}</div><div class="clearfix"></div>',
        ],
    ]);
    ?>
    <div class="col-lg-2">
        <?= $form->field($model, 'condition')
            ->label(false)
            ->dropDownList([
                //第二个参数为“默认选择项”，比如可以设置值为“le”，则le会被选中
                'gt' => 'ID > ',    // greater than
                'lt' => 'ID < ',    // less than
                'ge' => 'ID >= ',   // greater than or equal
                'le' => 'ID <= ',   // less than or equal
                'eq' => 'ID = ',    // equal
                'ne' => 'ID != ',   // not equal
            ],[
                //'id' => 'suppliersearch-condition',
                'class' => 'form-control',
                'prompt'=>[
                    // 设置下拉列表的默认请选择选项
                    'text' => 'Condition',
                    'options' => [
                        'class' => 'prompt'
                    ]
                ]
            ])?>
    </div>
    <div class="col-lg-2">
        <?= $form->field($model, 'value')
            ->label(false)
            ->textInput([
                    //'id' => 'suppliersearch-value',
                    'type' => 'number',
                    'placeholder' => $model->getAttributeLabel('Supplier name'),
                    'maxlength' => 30
            ]) ?>
    </div>
    <div class="col-lg-2">
        <?= $form->field($model, 'name')
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('Supplier name'), 'maxlength' => 30]) ?>
    </div>
    <div class="col-lg-2">
        <?= $form->field($model, 'code')
            ->label(false)
            ->textInput([
                'placeholder' => $model->getAttributeLabel('Supplier code'),
                'maxlength' => 3,
                'type' => 'number',
            ]) ?>
    </div>
    <div class="col-lg-2">
        <?= $form->field($model, 't_status')
            ->label(false)
            ->dropDownList([
                'ok' => 'ok',
                'hold' => 'hold'
            ],[
                'prompt'=>[
                    // 设置下拉列表的默认请选择选项
                    'text' => 'Supplier status',
                    'options' => [
                        'class' => 'prompt'
                    ]
                ]
            ])?>
    </div>
    <div class="col-lg-2">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <!--?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-success']) ?-->
        <?= Html::Button(Yii::t('app', 'Export'), ['class' => 'btn btn-success export', 'id' => 'export']) ?>
    </div>
    <div class="col-lg-12" id="warn-body" style="display:none">
        <?= Html::hiddenInput('SupplierSearch[ids]', '', ['id' => 'suppliersearch-ids'])?>
        <?= Html::hiddenInput('SupplierSearch[all_type]', '0', ['id' => 'suppliersearch-all-type'])?>
        <div class="text-center" id="warn-1" style="display:none">
            <span class="font-weight-bold">All <span id="warn-total">10</span></span> conversations on this page hava been selected.
            <?= Html::a(Yii::t('app', 'Select all conversations that match this search.'), ['#'], ['id' => 'warn-select-all']) ?>
        </div>
        <div class="text-center" id="warn-2" style="display:none">
            All conversations in this search hava been selected.
            <?= Html::a(Yii::t('app', 'Clear selection.'), ['#'], ['id' => 'warn-select-clear']) ?>
        </div>
    </div>

    <div class="clearfix"></div>
    <?php ActiveForm::end(); ?>

</div>
