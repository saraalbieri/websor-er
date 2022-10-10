<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\tblSezioneSpecialistica */

$this->title = 'Crea specializzazione organizzazione';
$this->params['breadcrumbs'][] = ['label' => 'Specializzazioni organizzazioni', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tbl-sezione-specializzazione-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
