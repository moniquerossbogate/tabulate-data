<?php

namespace app\controllers;

use app\models\Choices;
use app\models\Merge;
use app\models\Questionnaire;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use mdm\admin\components\Helper;
use yii\helpers\Url;
use yii\helpers\Json;

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


        $mergeTableData = Merge::find()->all();

        $idToLetter = [];
        $idToQuestions = [];

        $letters = ['A', 'B', 'C', 'D'];

        // Fetch all unique questionnaire IDs from the Choices table
        $choicesIds = array_unique(array_column($mergeTableData, 'choices_id'));
        $choices = Choices::find()->where(['id' => $choicesIds])->indexBy('id')->all();

        //get the questions per title
        foreach ($mergeTableData as $row) {
            $idToLetter[$row['id']] = $letters[count($idToLetter) % 4];
            $choicesItem = $choices[$row['choices_id']];
            $questionnaireId = $choicesItem->questionnaire_id;
            $questionnaire = Questionnaire::findOne($questionnaireId);
            if ($questionnaire) {
                $title = $questionnaire->title;
                if (!isset($idToQuestions[$title])) {
                    $idToQuestions[$title] = [];
                }
                $idToQuestions[$title][] = $row['question_text'];
            }
        }



        // Counting responses per question as before
        $question1Counts = [];
        $question2Counts = [];
        $question3Counts = [];
        $question4Counts = [];

        foreach ($idToLetter as $id => $letter) {
            $responses = \app\models\Response::find()->where(['merge_id' => $id])->all();
            foreach ($responses as $response) {
                $questionnaireId = $response->questionnaire_id;
                $countVar = 'question' . $questionnaireId . 'Counts';
                if (!isset($$countVar[$letter])) {
                    $$countVar[$letter] = 1;
                } else {
                    $$countVar[$letter]++;
                }
            }
        }

        return $this->render('index', [
            'question1Counts' => $question1Counts,
            'question2Counts' => $question2Counts,
            'question3Counts' => $question3Counts,
            'question4Counts' => $question4Counts,
            'idToQuestions' => $idToQuestions,
        ]);


    }

    // New method to fetch questions based on selected title
    public function actionQuestions($titleId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Assuming Merge has a relationship with Choices and Choices has a relationship with Questionnaire
        $questions = Merge::find()
            ->joinWith(['choices.questionnaire'])
            ->where(['questionnaire.id' => $titleId])
            ->all();

        // Prepare the data to be sent as JSON
        $formattedQuestions = [];
        foreach ($questions as $question) {
            $formattedQuestions[] = [
                $question->question_text, // Adjust with the correct attribute name
            ];
        }

        return Json::encode($formattedQuestions);
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