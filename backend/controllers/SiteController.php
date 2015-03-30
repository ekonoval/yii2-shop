<?php
namespace backend\controllers;

use backend\ext\User\UserRbac;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['test'],
                        'allow' => true,
                        'roles' => [UserRbac::ROLE_OPER]
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionLogin()
    {
//        $user = new User();
//        $user->username = "sunsey";
//        $user->setPassword(1);
//        $user->save();
//        exit;

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionTest()
    {
        $user = Yii::$app->user;
        if (!$user->isGuest) {
            //$roleInt =
            $res = $user->can(UserRbac::ROLE_OPER);
            $res = $user->can(UserRbac::ROLE_ADMIN);
            $res = $user->can(UserRbac::ROLE_ADMIN_SUPER);
            var_dump($res);
        }
//        session_start();
//        var_dump($_SESSION);exit;
    }
}
