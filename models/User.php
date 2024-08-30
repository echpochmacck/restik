<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $login
 * @property string $email
 * @property string $password
 * @property string $authKey
 * @property string $phone
 * @property string $patronymic
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_repeat;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'login', 'email', 'password', 'phone', 'patronymic'], 'required'],
            [['name', 'surname', 'login', 'email', 'password', 'authKey', 'phone', 'patronymic'], 'string', 'max' => 255],
            ['email', 'email'],
            ['login', 'unique'],
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            ['password', 'match', 'pattern' => '/^(?=.*[0-9])(?=.*[a-z[A-Z]).+$/', 'message' => 'Минимум одна цифра и латиница дэб'],
            ['phone', 'match', 'pattern' => '/^\+7\([0-9]{3}\)-[0-9]{3}-[0-9]{2}-[0-9]{2}/', 'message' => 'В норм формате пшиши']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'имя',
            'surname' => 'фамилия',
            'login' => 'Логин',
            'email' => 'ПОчта',
            'password' => 'Пароль',
            'authKey' => 'Auth Key',
            'phone' => 'Фон',
            'patronymic' => 'Отчество',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }


    public static function findByUsername($login)
    {

        return self::findOne(['login' => $login]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }


    public function setAuth($save = false)
    {
        $this->authKey = Yii::$app->security->generateRandomString();
        $save && $this->save(false);
    }

    public function register()
    {
        $this->password = Yii::$app->security->generatePasswordHash($this->password);
        $this->setAuth();
        return $this->save(false);
    }
}

//dssddsdsdsdd