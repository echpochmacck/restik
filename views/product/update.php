<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Prodcuct $model */

$this->title = 'Update Prodcuct: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Prodcucts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prodcuct-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
