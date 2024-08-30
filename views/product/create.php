<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Prodcuct $model */

$this->title = 'Create Prodcuct';
$this->params['breadcrumbs'][] = ['label' => 'Prodcucts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prodcuct-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
