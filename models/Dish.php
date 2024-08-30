<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dish".
 *
 * @property int $id
 * @property string $category
 * @property string $title
 * @property string $recipe
 * @property int $weigth
 *
 * @property MadeOf[] $madeOfs
 */
class Dish extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dish';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'title', 'recipe', 'weigth'], 'required'],
            [['recipe'], 'string'],
            [['weigth'], 'integer'],
            [['category', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'title' => 'Title',
            'recipe' => 'Recipe',
            'weigth' => 'Weigth',
        ];
    }

    /**
     * Gets query for [[MadeOfs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMadeOfs()
    {
        return $this->hasMany(MadeOf::class, ['dish_id' => 'id']);
    }
}
