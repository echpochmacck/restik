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
            [
                'value' => 'product',
                'label' => 'Продукт'
            ],
            [
                'value' => 'callor',
                'label' => 'каллории'
            ],
            [
                'label' => 'Общая каллоринйость',
                'value' => fn($model) => MadeOf::find()
                    ->where(['madeOf.dish_id' => $model['dish_id']])
                    ->innerJoin('prodcuct', 'madeOf.product_id = prodcuct.id')
                    ->sum('callor')
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

    <div>
        <?= Html::a('Экспорт', ['site/export-callor', 'download' => true], ['class' => 'btn btn-success']) ?>
    </div>
</div>