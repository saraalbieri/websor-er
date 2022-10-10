<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Enti task';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="utl-task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?php if(Yii::$app->user->can('createEnteTask')) echo Html::a('Aggiungi un ente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'perfectScrollbar' => true,
        'perfectScrollbarOptions' => [],
        'export' => Yii::$app->user->can('exportData') ? [] : false,
        'exportConfig' => ['csv'=>true, 'xls'=>true, 'pdf'=>true],
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => (Yii::$app->user->can('deleteEnteTask')) ? '{view} {update} {delete}' : '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        if(Yii::$app->user->can('viewEnteTask')){
                            return Html::a('<span class="fa fa-eye"></span>&nbsp;&nbsp;', $url, [
                                'title' => Yii::t('app', 'Dettaglio ente'),
                                'data-toggle'=>'tooltip'
                            ]) ;
                        }else{
                            return '';
                        }
                    },
                    'update' => function ($url, $model) {
                        if(Yii::$app->user->can('updateEnteTask')){
                            return Html::a('<span class="fa fa-pencil"></span>&nbsp;&nbsp;', $url, [
                                'title' => Yii::t('app', 'Modifica ente'),
                                'data-toggle'=>'tooltip'
                            ]) ;
                        }else{
                            return '';
                        }
                    },
                    'delete' => function ($url, $model) {
                        if(Yii::$app->user->can('deleteEnteTask')){
                            return Html::a('<span class="fa fa-trash"></span>&nbsp;&nbsp;', $url, [
                                'title' => Yii::t('app', 'Elimina ente'),
                                'data-toggle'=>'tooltip',
                                'data' => [
                                    'confirm' => "Sicuro di voler rimuovere questo elemento?",
                                    'method' => 'post',
                                    'params' => [
                                        'id' => $model->id
                                    ],
                                ]
                            ]) ;
                        }else{
                            return '';
                        }
                    }
                ]
            ],
            'id',
            'descrizione',
            
        ],
    ]); ?>
</div>
