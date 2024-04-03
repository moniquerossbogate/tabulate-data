<?php

namespace app\controllers;

use app\models\Choices;
use app\models\ChoicesSearch;
use app\models\Merge;
use app\models\Options;
use app\models\Questionnaire;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Response;
use Yii;
use yii\helpers\ArrayHelper;
use app\models\Model;

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
        $model = $this->findModel($id);
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => 'Question',
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),

                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                //  . Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Choices();
        $options = [new Merge()];
        if ($request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isPost) { // Check if it's a POST request
                if ($model !== null) {

                    if ($model->load(Yii::$app->request->post()) && $model->save()) {

                        $options = Model::createMultiple(Merge::classname());
                        Model::loadMultiple($options, Yii::$app->request->post());
                        // validate all models
                        $valid = $model->validate();
                        $valid = Model::validateMultiple($options);

                        // Validate the CarbonCopy models with built-in Yii2 rules
                        if ($valid) {
                            $transaction = \Yii::$app->db->beginTransaction();
                            try {

                                if ($flag = $model->save(false)) {

                                    foreach ($options as $option) {

                                        $option->choices_id = $model->id;
                                        $option->questionnaire_id = $model->questionnaire_id;
                                        if (!($flag = $option->save(false))) {
                                            $transaction->rollBack();
                                            break;
                                        }
                                    }
                                }
                                if ($flag) {
                                    $transaction->commit();
                                    return [
                                        'forceReload' => '#crud-datatable-pjax',
                                        'title' => "Created Questions",
                                        'content' => '<span class="text-success">Created Questions Success!</span>',
                                        'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])

                                    ];

                                }

                            } catch (\Exception $e) {
                                $transaction->rollBack();
                                throw new \Exception($e);
                            }
                        }
                        return [
                            'forceReload' => '#crud-datatable-pjax',
                            'title' => "Invalid",
                            'content' => '<span class="text-danger">Invalid!</span>',
                            'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])

                        ];

                    }
                } else {
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => "Invalid",
                        'content' => '<span class="text-danger">Invalid!</span>',
                        'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])

                    ];
                }

            } else {
                return [
                    'title' => "Create Questions",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'options' => (empty($options)) ? [new Merge()] : $options,

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
                    'options' => (empty($options)) ? [new Merge()] : $options,

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
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $title = Questionnaire::find()->all();

        $options = $model->merges;
        if ($request->isAjax) {
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($request->isGet) {
                return [
                    'title' => "Update Training",
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'title' => $title,
                        'options' => (empty($options)) ? [new Merge] : $options,

                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else

                if ($model->load(Yii::$app->request->post())) {

                    $model->validate();
                    $oldIDsOptions = ArrayHelper::map($options, 'id', 'id');
                    $options = Model::createMultiple(Merge::classname(), $options);
                    Model::loadMultiple($options, Yii::$app->request->post());


                    $deletedIDsOptions = array_diff($oldIDsOptions, array_filter(ArrayHelper::map($options, 'id', 'id')));

                    // validate all models
                    $valid = $model->validate();
                    $valid = Model::validateMultiple($options) && $valid;
                    if ($valid) {
                        $transaction = \Yii::$app->db->beginTransaction();


                        try {
                            if ($flag = $model->save(false)) {
                                if (!empty($deletedIDsOptions)) {
                                    Merge::deleteAll(['id' => $deletedIDsOptions]);
                                }
                                foreach ($options as $option) {

                                    $option->choices_id = $model->id;
                                    $option->questionnaire_id = $model->questionnaire_id;
                                    if (!($flag = $option->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
                                }

                            }
                            if ($flag) {
                                $transaction->commit();

                                return [
                                    'forceReload' => '#crud-datatable-pjax',
                                    'title' => "Update Question",
                                    'content' => '<span class="text-success">Update Question Success</span>',
                                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                                    Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])

                                ];

                            }
                        } catch (\Exception $e) {
                            $transaction->rollBack();
                        }
                    }
                } else {
                    /*
                     *   Process for non-ajax request
                     */
                    if ($model->load($request->post()) && $model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        return $this->render('update', [
                            'model' => $model,
                            'title' => $title,
                            'options' => (empty($options)) ? [new Merge] : $options,

                        ]);
                    }
                }
        }
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