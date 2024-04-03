<?php

namespace app\controllers;

use app\models\Choices;
use app\models\ChoicesSearch;
use app\models\Questionnaire;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\Model;
use yii\web\Response;
use Yii;

/**
 * ChoicesController implements the CRUD actions for Choices model.
 */
class ChoicesController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Choices models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ChoicesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Choices model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Choices();
        $options = [new Choices()];

        $errors = $model->getErrors();
        var_dump($errors);


        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            var_dump($model);
            die;
            if ($request->isPost) { // Check if it's a POST request

                if ($model->load(Yii::$app->request->post())) {

                    $options = Model::createMultiple(Choices::classname());
                    Model::loadMultiple($options, Yii::$app->request->post());
                    // validate all models
                    $valid = $model->validate();
                    $valid = Model::validateMultiple($options);

                    // Validate the CarbonCopy models with built-in Yii2 rules
                    if ($valid) {
                        $transaction = \Yii::$app->db->beginTransaction();
                        try {
                            $questionId = $model->questionnaire_id;
                            if ($model->save()) { // Save the main model record
                                foreach ($options as $option) {
                                    $option->questionnaire_id = $questionId;
                                    if ($option->questionnaire_id != '') {
                                        if ($flag = $model->save(false)) {
                                            foreach ($options as $option) {
                                                $option->questionnaire_id = $model->questionnaire_id;
                                                if (!($flag = $option->save(false))) {
                                                    $transaction->rollBack();
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }


                            }
                        } catch (\Exception $e) {
                            $transaction->rollBack();
                            throw new \Exception($e);
                        }
                    }
                    // If validation fails, return the form with validation errors
                    return [
                        'title' => "Compose Email",
                        'content' => $this->renderAjax('create', [
                            'model' => $model,
                            'options' => (empty($options)) ? [new Choices()] : $options,
                        ]),
                        'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                            Html::button('Submit', ['class' => 'btn btn-primary', 'type' => "submit"])
                    ];
                }
            } else {
                return [
                    'title' => "Create Questions",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'options' => (empty($options)) ? [new Choices()] : $options,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Submit', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'options' => (empty($options)) ? [new Choices()] : $options,
                ]);
            }
        }
    }

    /**
     * Updates an existing Choices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Choices model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Choices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Choices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Choices::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
