<?php

use app\models\MadeOf;
use app\models\Prodcuct;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Продукты с пассировкой';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prodcuct-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Prodcuct', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'value' => 'dish',
                'label' => 'Блюдо'
            ],
            // [
            //     'value' => 'product',
            //     'label' => 'Продукт'
            // ],
            // [
            //     'value' => 'category',
            //     'label' => 'категория'
            // ],
            [
                'value' => 'quantity',
                'label' => 'колличество'
            ],
           
        ],
    ]); ?>

    <?php Pjax::end(); ?>

    <div>
        <?= Html::a('Экспорт', ['site/export-max', 'download' => true], ['class' => 'btn btn-success']) ?>
    </div>
</div>