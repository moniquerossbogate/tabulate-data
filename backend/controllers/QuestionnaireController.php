<?php

namespace app\controllers;

use app\models\Questionnaire;
use app\models\QuestionnaireSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Response;
use Yii;

/**
 * QuestionnaireController implements the CRUD actions for Questionnaire model.
 */
class QuestionnaireController extends Controller
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
     * Lists all Questionnaire models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new QuestionnaireSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Title #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
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
        $model = new Questionnaire();

        if ($request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Input Title",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,

                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                    . Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];

            } else {
                if ($model->load($request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
            }
        }
    }



    public function actionUpdate($id)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update Title #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                    .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($this->request->post())) {


                $model->save();

                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Title #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,

                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];

                // return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return [
                    'title' => "Update Title #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,

                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                    .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
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

                ]);
            }
        }
    }


    /**
     * Deletes an existing Questionnaire model.
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
     * Finds the Questionnaire model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Questionnaire the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Questionnaire::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSubmit()
    {
        $model = new Questionnaire();
        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data saved successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Error saving data.');
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model,

        ]);
    }

}