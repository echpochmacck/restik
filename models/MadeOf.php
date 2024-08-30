<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "madeOf".
 *
 * @property int $id
 * @property int $quantity
 * @property int $ochered
 * @property int $number-of-dish
 * @property string $processing
 * @property int $dish_id
 * @property int $product_id
 *
 * @property Dish $dish
 * @property Prodcuct $product
 */
class MadeOf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'madeOf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quantity', 'ochered', 'number-of-dish', 'processing', 'dish_id', 'product_id'], 'required'],
            [['quantity', 'ochered', 'number-of-dish', 'dish_id', 'product_id'], 'integer'],
            [['processing'], 'string', 'max' => 255],
            [['dish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dish::class, 'targetAttribute' => ['dish_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Prodcuct::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quantity' => 'Quantity',
            'ochered' => 'Ochered',
            'number-of-dish' => 'Number Of Dish',
            'processing' => 'Processing',
            'dish_id' => 'Dish ID',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * Gets query for [[Dish]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDish()
    {
        return $this->hasOne(Dish::class, ['id' => 'dish_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Prodcuct::class, ['id' => 'product_id']);
    }
}
