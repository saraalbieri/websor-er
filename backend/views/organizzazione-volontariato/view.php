<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;


use yii\data\ActiveDataProvider;
use common\models\organizzazione\ConOrganizzazioneContatto;
/* @var $this yii\web\View */
/* @var $model common\models\VolOrganizzazione */

$this->title = 'Organizzazione Volontariato ' . $model->denominazione;
$this->params['breadcrumbs'][] = ['label' => 'Lista organizzazioni', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vol-organizzazione-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('updateOrganizzazione')) echo Html::a('Modifica', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if (Yii::$app->user->can('deleteOrganizzazione') && empty($model->id_sync)) echo Html::a('Cancella', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Sicuro di voler eliminare questo elemento?',
                'method' => 'post',
            ],
        ]) ?>

        <?php
        // Manage convenzione
        if (Yii::$app->FilteredActions->type == 'comunale' && Yii::$app->user->can('viewOrganizzazione')) {

            if (!empty($model->convenzione)) {
                $url = ['delete-convenzione', 'id' => $model->id];
                echo Html::a('<span class="fa fa-trash color-white"></span>&nbsp;&nbsp;Elimina convenzione', $url, [
                    'class' => 'btn btn-danger m5w m5h',
                    'title' => Yii::t('app', 'Elimina convenzione'),
                    'data-toggle' => 'tooltip',
                    'data' => [
                        'confirm' => 'Sei sicuro di voler eliminare questa convenzione?',
                        'method' => 'post',
                    ],
                ]);
            } else {
                $url = ['add-convenzione', 'id' => $model->id];
                echo Html::a('<span class="fa fa-plus color-white"></span>&nbsp;&nbsp;Attiva convenzione', $url, [
                    'class' => 'btn btn-success m5w m5h',
                    'title' => Yii::t('app', 'Aggiungi convenzione'),
                    'data-toggle' => 'tooltip',
                    'data' => [
                        'confirm' => 'Sei sicuro di voler attivare una convenzione per questa organizzazione?',
                        'method' => 'post',
                    ],
                ]);
            }
        }
        ?>

    </p>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'Convenzione',
                'attribute' => 'convenzione',
                'format' => 'raw',
                'value' => !empty($model->convenzione) ? '<span class="text-success"><b>Attiva</b></span>' : '<span class="text-danger"><b>Non Attiva</b></span>',
                'visible' => Yii::$app->FilteredActions->type == 'comunale' ? true : false
            ],
            [
                'attribute' => 'ref_id',
                'label' => 'Numero elenco territoriale'
            ],
            [
                'attribute' => 'num_comunale',
                'label' => 'Numero comunale'
            ],
            [
                'label' => 'Tipo',
                'attribute' => 'tipo',
                'value' => !empty($model->tipoOrganizzazione->tipologia) ? $model->tipoOrganizzazione->tipologia : ''
            ],
            [
                'label' => 'Iscrizione',
                'attribute' => 'stato_iscrizione',
                'format' => 'raw',
                'value' => ($model->stato_iscrizione == 3) ? '<span class="text-success"><b>Accreditata</b></span>' : '<span class="text-danger"><b>Sospesa</b></span>'
            ],
            'denominazione',
            'codicefiscale',
            'partita_iva',
            'tipo_albo_regionale',
            'num_albo_regionale',
            'data_albo_regionale',
            'data_costituzione:date',
            'note',
            [
                'label' => 'Strategia di aggiornamento',
                'attribute' => 'update_zona_allerta_strategy',
                'value' => \common\models\ZonaAllertaStrategy::getStrategyLabel($model->update_zona_allerta_strategy)
            ],
            [
                'label' => 'Zone di allerta',
                'attribute' => 'zone_allerta'
            ],
            [
                'label' => 'Specializzazione dell\'associazione: sezione_specialistica',
                'attribute' => 'sezione_specialistica',
                'value' => 'DA SISTEMARE la selecte l\'update'//\common\models\VolOrganizzazione::getSezioneSpecialistica($model)
            ],
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive' => true,
        'hover' => true,
        'export' => Yii::$app->user->can('exportData') ? [] : false,
        'exportConfig' => ['csv' => true, 'xls' => true, 'pdf' => true],
        'panel' => [
            'heading' => '<h2 class="panel-title">Sedi</h2>',

            'before' => (Yii::$app->user->can('createSede') && empty($model->id_sync)) ? Html::a('Crea Nuova Sede', ['/organizzazione-volontariato/create-sede/?id=' . $model->id], ['class' => 'btn btn-success']) : "",

        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'indirizzo',
            [
                'label' => 'Comune',
                'attribute' => 'nome_comune',
                'value' => function ($model, $key, $index, $column) {
                    return $model->locComune->comune;
                }
            ],
            'tipo',
            'email',
            'email_pec',
            'telefono',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'update' && Yii::$app->user->can('updateSede') && empty($model->id_sync)) {
                        $url = Url::to(['sede/update', 'id' => $model->id]);
                        return $url;
                    }

                    if ($action === 'view' && Yii::$app->user->can('viewSede')) {
                        $url = Url::to(['sede/view', 'id' => $model->id]);
                        return $url;
                    }

                    if ($action === 'delete' && Yii::$app->user->can('deleteSede') && empty($model->id_sync)) {
                        $url = Url::to(['sede/delete', 'id' => $model->id]);
                        return $url;
                    }
                }
            ],
        ],
    ]); ?>

    <?php

    echo $this->render('_form-contatto', [
        'model' => $model
    ]);
    ?>

    <?php

    $contattiDataProvider = new ActiveDataProvider([
        'query' => ConOrganizzazioneContatto::find()->where(['id_organizzazione' => $model->id]),
        'pagination' => [
            'pageSize' => 50,
        ],
    ]);
    echo GridView::widget([
        'dataProvider' => $contattiDataProvider,
        'responsive' => true,
        'hover' => true,
        'export' => Yii::$app->user->can('exportData') ? [] : false,
        'exportConfig' => ['csv' => true, 'xls' => true, 'pdf' => true],
        'panel' => [
            'heading' => '<h2 class="panel-title">Recapiti</h2>',

        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Recapito',
                'attribute' => 'id',
                'value' => function ($model, $key, $index, $column) {
                    return $model->contatto ? $model->contatto->contatto : null;
                }
            ],
            'note',
            [
                'label' => 'Tipo',
                'attribute' => 'use_type',
                'value' => function ($model, $key, $index, $column) {
                    $use = 'Recapito generico';
                    switch ($model->use_type) {
                        case 0:
                            return "Recapito per messaggistica";
                            break;
                        case 1:
                            return "Recapito per ingaggio";
                            break;
                        case 2:
                            return "Recapito per allertamento";
                            break;
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {

                        if (Yii::$app->user->can('manageRecapitiOrgs') && (empty($model->id_sync) || $model->id_sync == '')) {
                            $url = Url::to(['organizzazione-volontariato/delete-contatto-rubrica', 'id' => $model->id]);
                            return Html::a('<span class="fa fa-trash"></span>&nbsp;&nbsp;', $url, [
                                'title' => Yii::t('app', 'Rimuovi'),
                                'data-toggle' => 'tooltip'
                            ]);
                        } else {
                            return '';
                        }
                    },
                ]
            ],
        ],
    ]); ?>

    <?php

    echo $this->render('/everbridge/index', ['model' => $model]);

    ?>

</div>