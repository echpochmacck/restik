<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\MadeOf;
use GuzzleHttp\Psr7\Query;
use yii\data\ActiveDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index-blog');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (Yii::$app->session->get('check') >= 3) {
            Yii::$app->session->setFlash('error', 'Кончились попытки авторизацияя');
            return $this->goHome();
        }

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if (Yii::$app->request->isPost) {
            if (!Yii::$app->session->has('check')) {
                Yii::$app->session->set('check', 1);
            } else {
                Yii::$app->session->set('check', Yii::$app->session->get('check') + 1);
            }
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegister()
    {
        $model = new \app\models\User();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->register();
                Yii::$app->user->login($model);
                return $this->goHome();
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionCheckPass()
    {
        if (!Yii::$app->user->isGuest) {
            $dataprovider = new ActiveDataProvider([
                'query' => madeOf::queryPass(),

            ]);
            return $this->render('check-pass', [
                'dataProvider' => $dataprovider
            ]);
        }
    }

    public function actionExportPass()
    {
        $data = madeOf::queryPass()
            ->all();
        $str = "Блюдо;Продукт;Процесс\r\n";
        foreach ($data as $row) {
            $str .= $row['dish'] . ';'
                . $row['product'] . ';'
                . $row['processing'] . "\r\n";
        }
        $str =  iconv('UTF-8', 'windows-1251', $str);
        Yii::$app->response->sendContentAsFile($str, 'пассировка.csv');
    }


    public function actionCallor()
    {
        // var_dump('dsd');die;
        if (!Yii::$app->user->isGuest) {
            $dataprovider = new ActiveDataProvider([
                'query' => madeOf::queryCallor(),

            ]);
            return $this->render('callor', [
                'dataProvider' => $dataprovider
            ]);
        }
    }

    public function actionExportCallor()
    {
        $data = madeOf::queryCallor()
            ->all();
        $str = "Блюдо;Продукт;Каллории;Общая каллорийность\r\n";
        foreach ($data as $row) {
            $str .= $row['dish'] . ';'
                . $row['product'] . ';'
                . $row['callor'] . ';'
                . MadeOf::find()
                ->where(['madeOf.dish_id' => $row['dish_id']])
                ->innerJoin('prodcuct', 'madeOf.product_id = prodcuct.id')
                ->sum('callor') . "\r\n";
        }
        $str =  iconv('UTF-8', 'windows-1251', $str);
        Yii::$app->response->sendContentAsFile($str, 'каллории.csv');
    }

    public function actionMax()
    {
        if (!Yii::$app->user->isGuest) {
            $dataprovider = new ActiveDataProvider([
                'query' => madeOf::queryMax(),
                'pagination' => false,
            ]);
            return $this->render('max', [
                'dataProvider' => $dataprovider
            ]);
        }
    }

    public function actionExportMax()
    {
        $data = madeOf::queryMax()
            ->all();
        $str = "Блюдо;КОличество продуктов\r\n";
        foreach ($data as $row) {
            $str .= $row['dish'] . ';'
                . $row['quantity'] . "\r\n";
        }
        $str =  iconv('UTF-8', 'windows-1251', $str);
        Yii::$app->response->sendContentAsFile($str, 'кол-во.csv');
    }

    public function actionCheck()
    {
        if (!Yii::$app->user->isGuest) {
            $dataprovider = new ActiveDataProvider([
                'query' => madeOf::queryCheckPerv(),
                'pagination' => false,
            ]);
            return $this->render('check', [
                'dataProvider' => $dataprovider
            ]);
        }
    }

    public function actionExportCheck()
    {
        $data = madeOf::queryCheckPerv()
            ->all();
        $str = "Блюдо;Пролукт очередь\r\n";
        foreach ($data as $row) {
            $str .= $row['dish'] . ';'
                . $row['product'] . ';'

                . $row['ochered'] . "\r\n";
        }
        $str =  iconv('UTF-8', 'windows-1251', $str);
        Yii::$app->response->sendContentAsFile($str, 'кол-во.csv');
    }

}
