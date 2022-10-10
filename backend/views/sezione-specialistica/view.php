<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\tblSezioneSpecialistica */

$this->title = $model->descrizione;
$this->params['breadcrumbs'][] = ['label' => 'Specializzazioni organizzazione', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tbl-sezione-specialistica-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->user->can('updateSezioneSpecialistica')) echo Html::a('Aggiorna', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php if(Yii::$app->user->can('deleteSezioneSpecialistica')) echo Html::a('Elimina', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Sicuro di voler eliminare questo elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descrizione',
        ],
    ]) ?>

</div>
