<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\tblSezioneSpecialistica */

$this->title = 'Aggiorna specializzazione organizzazione: '.$model->descrizione;
$this->params['breadcrumbs'][] = ['label' => 'Specializzazioni organizzazione', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Aggiorna';
?>
<div class="tbl-sezione-specializzazione-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
