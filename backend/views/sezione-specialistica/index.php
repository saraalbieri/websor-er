<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Specializzazioni Organizzazioni';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-sezione-specialistica-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->user->can('createSezioneSpecialistica')) echo Html::a('Crea specializzazione per le organizzazioni', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => Yii::$app->user->can('exportData') ? [] : false,
        'exportConfig' => ['csv'=>true, 'xls'=>true, 'pdf'=>true],
        'perfectScrollbar' => true,
        'perfectScrollbarOptions' => [],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'descrizione',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => (Yii::$app->user->can('deleteSezioneSpecialistica')) ? '{view} {update} {delete}' : '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        if(Yii::$app->user->can('viewSezioneSpecialistica')){
                            return Html::a('<span class="fa fa-eye"></span>&nbsp;&nbsp;', $url, [
                                'title' => Yii::t('app', 'Dettaglio specializzazione organizzazione'),
                                'data-toggle'=>'tooltip'
                            ]) ;
                        }else{
                            return '';
                        }
                    },
                    'update' => function ($url, $model) {
                        if(Yii::$app->user->can('updateSezioneSpecialistica')){
                            return Html::a('<span class="fa fa-pencil"></span>&nbsp;&nbsp;', $url, [
                                'title' => Yii::t('app', 'Modifica specializzazione organizzazione'),
                                'data-toggle'=>'tooltip'
                            ]) ;
                        }else{
                            return '';
                        }
                    }
                ]
            ],
        ],
    ]); ?>
</div>
