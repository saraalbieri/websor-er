<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\tblSezioneSpecialistica */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tbl-sezione-specializzazione-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descrizione')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Aggiungi', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
