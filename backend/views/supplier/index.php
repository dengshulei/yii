<?php

use backend\models\Supplier;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Suppliers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--p>
        <?= Html::a(Yii::t('app', 'Create Supplier'), ['create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        //'layout'=> '{items}<div class="text-right tooltip-demo">{pager}</div>',
        'pager'=>[
            //'options' => ['class' => 'supplier-pager'],
            'firstPageLabel' => "首页",
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'lastPageLabel' => '未页',
        ],
        'options' => ['class' => 'grid-view','style'=>'overflow:auto', 'id' => 'grid'],
        'showFooter' => true, //设置显示最下面的footer
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'class' => CheckboxColumn::className(),
                'name' =>'id',
                'headerOptions' => ['width' => '30'],
                //'checkboxOptions' => ['style' => ''],
                'footer' => '<button href="#" rel="external nofollow" class="btn btn-default btn-xs btn-delete hide" url="'. Url::toRoute('admin/delete') .'">Delete</button>' .
                            '<button href="#" rel="external nofollow" class="btn btn-default btn-xs btn-delete hide" onclick="showIds();">Select All</button>',
                'footerOptions' => ['colspan' => 5],
            ],
            ['attribute' => 'id', 'footerOptions' => ['class'=>'hide']],
            ['attribute' => 'name', 'footerOptions' => ['class'=>'hide']],
            ['attribute' => 'code', 'footerOptions' => ['class'=>'hide']],
            [
                'attribute' => 't_status',
                'value' => function ($model) {
                    $state = [
                        'ok' => 'ok',
                        'hold' => 'hold',
                    ];
                    return $state[$model->t_status];
                },
                'contentOptions' => function($model)
                {
                    return ['style' => 'color:' . ($model->t_status == 'hold' ? '#f00' : '')];
                },
                'footerOptions' => ['class'=>'hide']
            ],

        ],
    ]); ?>

    <?php
$this->registerJs('

    $( "input[name$=\'id[]\']" ).on("click", function () {
        setTimeout("id_click();check_all_click();", 100);
    });
    $(".select-on-check-all").on("click", function () {
        setTimeout("id_click();check_all_click();", 100);
    });
    $("#export").on("click", function(){
        setTimeout("export_click()", 100);
    });
    $("#warn-select-all").on("click", function(){
        setTimeout("warn_select_all()", 100);
        return false;
    });
    $("#warn-select-clear").on("click", function(){
        setTimeout("warn_select_clear()", 100);
        return false;
    });
');

    Pjax::end();
    ?>

</div>

