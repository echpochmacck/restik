<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prodcuct".
 *
 * @property int $id
 * @property int $callor
 * @property string $title
 * @property string $category
 * @property int $price-for-one
 * @property string $mesure
 *
 * @property MadeOf[] $madeOfs
 */
class Prodcuct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prodcuct';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['callor', 'title', 'category', 'price-for-one', 'mesure'], 'required'],
            [['callor', 'price-for-one'], 'integer'],
            [['title', 'category', 'mesure'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'callor' => 'Callor',
            'title' => 'Title',
            'category' => 'Category',
            'price-for-one' => 'Price For One',
            'mesure' => 'Mesure',
        ];
    }

    /**
     * Gets query for [[MadeOfs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMadeOfs()
    {
        return $this->hasMany(MadeOf::class, ['product_id' => 'id']);
    }
}
