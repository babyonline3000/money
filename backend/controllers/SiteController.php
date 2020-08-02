<?php
namespace backend\controllers;

use common\models\Balance;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'add', 'history'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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
        if (Yii::$app->user->isGuest){
            return $this->actionLogin();
        }

        /** @var \common\models\User $webUser */
        $webUser = Yii::$app->user->identity;

        if ($webUser->status == User::STATUS_ACTIVE && $webUser->role == User::ROLE_USER){
            $this->view->title = 'Мой баланс';
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => User::find()
                        ->select([
                            'users.id',
                            'users.username',
                            '(select sum(value) from balance where user_id = users.id) as sum'
                        ])
                        ->andWhere(['id' => $webUser->id]),
                'pagination' => false,
            ]);
        }else{
            $this->view->title = 'Баланс пользователей';
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => User::find()
                        ->select([
                            'users.id',
                            'users.username',
                            '(select sum(value) from balance where user_id = users.id) as sum'
                        ])
                        ->andWhere(['role' => User::ROLE_USER]),
                'pagination' => false,
            ]);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Add cash and display home.
     */
    public function actionAdd()
    {
        /** @var \common\models\User $webUser */
        $webUser = Yii::$app->user->identity;

        if ($webUser->status == User::STATUS_ACTIVE && $webUser->role == User::ROLE_ADMIN){
            $model = new Balance();
            if (($model->load(Yii::$app->request->post()) && $model->validate())){
                if (!$model->save()){
                    throw new \yii\base\Exception('Unable to save balance.');
                }
            }
        }

        return $this->redirect(['site/index']);
    }

    /**
     * Show history add cash.
     */
    public function actionHistory()
    {
        $this->view->title = 'История пополнений';
        $searchModel = new \backend\models\search\Balance();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


}
