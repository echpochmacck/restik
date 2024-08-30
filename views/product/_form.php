<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Prodcuct $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="prodcuct-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'callor')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price-for-one')->textInput() ?>

    <?= $form->field($model, 'mesure')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
