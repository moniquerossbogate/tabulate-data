<?php

namespace app\controllers;

use app\models\Choices;
use app\models\Merge;
use app\models\Questionnaire;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Response;
use SebastianBergmann\Timer\Timer;

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
        $model = new Response();
        $titles = Choices::find()->all();
        $public = Choices::find()->where(['is_public' => 0])->all();
       
       
        $questionaires = Merge::find()->all();
        return $this->render(
            'index',
            [
                'model' => $model,
                'questionaires' => $questionaires,
                'titles' => $titles,
                'public' => $public
            ]
        );
    }

    public function actionCreate() {
        $model = new Response();
        $titles = Choices::find()->all();
        $public = Choices::find()->where(['is_public' => 0 ])->all();
        $questionaires = Merge::find()->all();
    

        $respondentsId = explode(',',$_POST['selected_values']);

        if($model->load(Yii::$app->request->post())) {
            $model->response_date = date('Y-m-d H:i:s');
            $respondentsId = array_filter($respondentsId);

            foreach($respondentsId as $id) {
                $chooseId = explode(':', $id);
                $merge = Merge::find()->where(['id' => $chooseId[0]])->one();
                $status = Choices::find()->where(['id' => $merge->choices_id])->one();
                $model->choices_id = $merge->choices_id;
                $model->merge_id = $merge->id;
                $model->questionnaire_id = $merge->choices->questionnaire_id;
            // $status->is_public = 1;
            // $status->save();
                $model->save();
              
               

            }
           
            Yii::$app->getSession()->setFlash('success', [
                'text' => 'Thank you for submitting!',
            ]);
            return $this->redirect('view');

        }

        return $this->render(
            'index',
            [
                'model' =>$model,
                'questionaires' => $questionaires,
                'titles' => $titles,
                'public' => $public,
            ]
            );
    }

    public function actionView() {
        
        return $this->render('view');

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
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

}
